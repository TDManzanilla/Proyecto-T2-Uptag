<?php
include('../../config.php');

try {
    // Leer los datos enviados desde el frontend
    $notas = json_decode(file_get_contents('php://input'),true);
    $asignacion=[];
    $i = 1;
    $result=[];
     foreach ($notas as $nota) {
        array_push($result, $nota);
     }
    foreach ($notas["notas"] as $nota) {
       

        // Calcular la nota final considerando solo las notas activas
        $notasActivas = array_filter([$nota['nota_1-'.$i], $nota['nota_2-'.$i], $nota['nota_3-'.$i]], function ($value, $index) use ($estado) {
            return $estado[$index] === '1';
        }, ARRAY_FILTER_USE_BOTH);

        $nota['nota_final-'.$i] = round(array_sum($notasActivas) / max(1, count($notasActivas)));
        $nota['nota_final-'.$i] = max($nota['nota_final-'.$i], 1); // Asegurar que la nota final no sea menor a 1

        // Verificar si existe una asignación válida para el estudiante y la materia
        $sqlAsignacion = "
            SELECT *
            FROM asignacion AS a
            INNER JOIN grados AS g ON a.grado_id = g.id_grado
            INNER JOIN estudiantes AS e ON e.grado_id = g.id_grado
            INNER JOIN materias AS m ON a.materia_id = m.id_materia
            WHERE a.materia_id = :materia_id
            LIMIT 1
        ";
        $queryAsignacion = $pdo->prepare($sqlAsignacion);
        $queryAsignacion->execute([
            ':materia_id' => $nota['materia_id']
        ]);
        $asignacion = $queryAsignacion->fetch(PDO::FETCH_ASSOC);

        if (!$asignacion) {
            throw new Exception("No se encontró una asignación válida para el estudiante con ID {$nota['id_nota-'.$i]} y materia ID {$nota['materia_id']}.");
        }

        // Verificar si ya existe una nota para el estudiante y la asignación
        $sqlVerificarNota = "
            SELECT id_nota, estado
            FROM notas
            WHERE asignacion_id = :asignacion_id
        ";
        $queryVerificarNota = $pdo->prepare($sqlVerificarNota);
        $queryVerificarNota->execute([
            ':asignacion_id' => $asignacion['id_asignacion']
        ]);
        $notaExistente = $queryVerificarNota->fetch(PDO::FETCH_ASSOC);
        if ($notaExistente) {
            // Actualizar el estado combinando el existente con el nuevo
            $estadoActual = str_split($notaExistente['estado-'.$i]);
            foreach ($estado as $index => $value) {
                if ($value === '1') {
                    $estadoActual[$index] = '1'; // Habilitar el lapso correspondiente
                }
            }
            $nuevoEstado = implode('', $estadoActual);
            // Actualizar la nota existente
            $sqlActualizarNota = "
                UPDATE notas
                SET nota_1 = :nota_1, nota_2 = :nota_2, nota_3 = :nota_3, nota_final = :nota_final
                WHERE id_nota = :id_nota
            ";
            $queryActualizarNota = $pdo->prepare($sqlActualizarNota);
            $queryActualizarNota->execute([
                ':nota_1' => $nota['nota_1-'.$i],
                ':nota_2' => $nota['nota_2-'.$i],
                ':nota_3' => $nota['nota_3-'.$i],
                ':nota_final' => round($nota['nota_final-'.$i]),
                ':id_nota' => $notaExistente['id_nota']
            ]);
        } 
        $i++;
    }
    $usuario_id = $_SESSION['session_user'];
    $descripcion = 'Actualizacion de notas de la seccion:' + $asignacion['curso'] + '-' + $asignacion['paralelo'] + ' Materia:' + $asignacion['nombre_materia'] + ' Estudiante:' + $asignacion['nombre'] + ' ' + $asignacion['apellido'];
    // Log the action
        $sql = "INSERT INTO bitacora (usuario_id, descripcion, fecha_hora)
        VALUES (:usuario_id, :descripcion, :fecha_hora)";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':usuario_id',$usuario_id);
        $sentencia->bindParam(':descripcion',$descripcion);
        $sentencia->bindParam(':fecha_hora',$fechaHora);
        $sentencia->execute();
    

    // Respuesta exitosa
    #echo json_encode($result);
    echo json_encode(['success' => true, 'message' => 'Notas guardadas correctamente.']);
} catch (Exception $e) {
    // Improved error logging
    error_log('Error en guardar_notas.php: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
