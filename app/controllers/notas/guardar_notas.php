<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../config.php');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Leer los datos enviados desde el frontend
    $notas = json_decode(file_get_contents('php://input'), true);
    if (!$notas) {
        throw new Exception('No se recibieron datos válidos.');
    }

    //error_log('Datos recibidos: ' . print_r($notas, true));

    $asignacion=[];
    $i = 1;
    $result=[];
    $estado = isset($notas['estado']) ? $notas['estado'] : [];
    foreach ($notas as $nota) {
        array_push($result, $nota);
     }
    //error_log('Inicio del procesamiento de notas');
    foreach ($notas["notas"] as $nota) {
        //error_log('Procesando nota: ' . print_r($nota, true));
        $nota_1 = isset($nota['nota_1-'.$i]) ? (float)$nota['nota_1-'.$i] : null;
        $nota_2 = isset($nota['nota_2-'.$i]) ? (float)$nota['nota_2-'.$i] : null;
        $nota_3 = isset($nota['nota_3-'.$i]) ? (float)$nota['nota_3-'.$i] : null;

        // Validar solo las notas activas
        if ($nota_1 !== null && (!is_numeric($nota_1) || $nota_1 < 0 || $nota_1 > 20)) {
            throw new Exception("La nota 1 debe ser un número válido entre 0 y 20.");
        }
        if ($nota_2 !== null && (!is_numeric($nota_2) || $nota_2 < 0 || $nota_2 > 20)) {
            throw new Exception("La nota 2 debe ser un número válido entre 0 y 20.");
        }
        if ($nota_3 !== null && (!is_numeric($nota_3) || $nota_3 < 0 || $nota_3 > 20)) {
            throw new Exception("La nota 3 debe ser un número válido entre 0 y 20.");
        }

        // Calcular la nota final solo con las notas activas
        $notasActivas = array_filter([$nota_1, $nota_2, $nota_3], function ($value) {
            return $value !== null;
        });
        $nota_final = count($notasActivas) > 0 ? array_sum($notasActivas) / count($notasActivas) : 0;
        $nota_final = max($nota_final, 1); // Asegurar que la nota final no sea menor a 1

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
            SELECT id_nota
            FROM notas
            WHERE asignacion_id = :asignacion_id AND estudiante_id = :estudiante_id
        ";
#        error_log('Consulta SQL: ' . $sqlVerificarNota . ' con parámetros: ' . print_r([
#            ':asignacion_id' => $asignacion['id_asignacion'],
#            ':estudiante_id' => $nota['id_estudiante-'.$i]
#        ], true));
        $queryVerificarNota = $pdo->prepare($sqlVerificarNota);
        $queryVerificarNota->execute([
            ':asignacion_id' => $asignacion['id_asignacion'],
            ':estudiante_id' => $nota['id_estudiante-'.$i]
        ]);
        $notaExistente = $queryVerificarNota->fetch(PDO::FETCH_ASSOC);
        if ($notaExistente) {
            // Actualizar la nota existente
            $sqlActualizarNota = "
                UPDATE notas
                SET nota_1 = :nota_1, nota_2 = :nota_2, nota_3 = :nota_3, nota_final = :nota_final
                WHERE id_nota = :id_nota
            ";
            $queryActualizarNota = $pdo->prepare($sqlActualizarNota);
            $queryActualizarNota->execute([
                ':nota_1' => $nota_1,
                ':nota_2' => $nota_2,
                ':nota_3' => $nota_3,
                ':nota_final' => $nota_final,
                ':id_nota' => $notaExistente['id_nota']
            ]);
        }

        $i++; // Incrementar el índice aquí
    }
   // error_log('Fin del procesamiento de notas');
//    $usuario_id = $_SESSION['session_user'];
//    $descripcion = 'Actualizacion de notas de la seccion:' + $asignacion['curso'] + '-' + $asignacion['paralelo'] + ' Materia:' + $asignacion['nombre_materia'] + ' Estudiante:' + $asignacion['nombre'] + ' ' + $asignacion['apellido'];
//     Log the action
//        $sql = "INSERT INTO bitacora (usuario_id, descripcion, fecha_hora)
//        VALUES (:usuario_id, :descripcion, :fecha_hora)";
//        $sentencia = $pdo->prepare($sql);
//        $sentencia->bindParam(':usuario_id',$usuario_id);
//        $sentencia->bindParam(':descripcion',$descripcion);
//        $sentencia->bindParam(':fecha_hora',$fechaHora);
//        $sentencia->execute();
    

    // Respuesta exitosa
    // echo json_encode($result);
    echo json_encode(['success' => true, 'message' => 'Notas guardadas correctamente.']);
} catch (Exception $e) {
    error_log('Error en guardar_notas.php: ' . $e->getMessage() . ' en el archivo ' . $e->getFile() . ' en la línea ' . $e->getLine());
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
