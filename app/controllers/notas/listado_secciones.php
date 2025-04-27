<?php
include('../../config.php');

try {
    $action = $_GET['action'] ?? '';

    if ($action === 'getSections') {
        // Obtener todas las secciones activas
        $sqlSecciones = "
            SELECT DISTINCT CONCAT(g.curso, ' - ', g.paralelo) AS seccion
            FROM grados AS g
            WHERE g.estado = '1'
            ORDER BY 
                CASE 
                    WHEN g.curso = 'Primer año' THEN 1
                    WHEN g.curso = 'Segundo año' THEN 2
                    WHEN g.curso = 'Tercer año' THEN 3
                    WHEN g.curso = 'Cuarto año' THEN 4
                    WHEN g.curso = 'Quinto año' THEN 5
                    WHEN g.curso = 'Sexto año' THEN 6
                    ELSE 7
                END, g.paralelo
        ";
        $querySecciones = $pdo->prepare($sqlSecciones);
        $querySecciones->execute();
        $secciones = $querySecciones->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'secciones' => $secciones]);
    } elseif ($action === 'getSubjects') {
        $seccion = $_GET['seccion'] ?? '';
        $lapso = $_GET['lapso'] ?? ''; // Lapso seleccionado (1, 2 o 3)

        if (empty($seccion) || empty($lapso)) {
            throw new Exception('Sección o lapso no especificado.');
        }

        // Obtener materias y estados de edición de notas según el lapso seleccionado
        $sqlMaterias = "
            SELECT 
                m.id_materia,
                m.nombre_materia AS materia,
                IFNULL(CONCAT(p.nombres, ' ', p.apellidos), 'Sin asignar') AS docente,
                CASE 
                    WHEN :lapso = 1 THEN IF(SUBSTRING(MAX(n.estado), 1, 1) = '1', 'Habilitado', 'Deshabilitado')
                    WHEN :lapso = 2 THEN IF(SUBSTRING(MAX(n.estado), 2, 1) = '1', 'Habilitado', 'Deshabilitado')
                    WHEN :lapso = 3 THEN IF(SUBSTRING(MAX(n.estado), 3, 1) = '1', 'Habilitado', 'Deshabilitado')
                    ELSE 'Deshabilitado'
                END AS estado
            FROM asignacion AS a
            INNER JOIN materias AS m ON a.materia_id = m.id_materia
            LEFT JOIN docentes AS d ON a.docente_id = d.id_docente
            LEFT JOIN personas AS p ON d.persona_id = p.id_persona
            INNER JOIN grados AS g ON a.grado_id = g.id_grado
            LEFT JOIN notas AS n ON a.id_asignacion = n.asignacion_id
            WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
            AND g.estado = '1'
            AND a.estado = '1'
            GROUP BY m.id_materia, m.nombre_materia, p.nombres, p.apellidos
            ORDER BY m.nombre_materia
        ";
        $queryMaterias = $pdo->prepare($sqlMaterias);
        $queryMaterias->bindParam(':seccion', $seccion);
        $queryMaterias->bindParam(':lapso', $lapso, PDO::PARAM_INT);
        $queryMaterias->execute();
        $materias = $queryMaterias->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'materias' => $materias]);
    } elseif ($action === 'getStudents') {
        $seccion = $_GET['seccion'] ?? '';
        $materia_id = $_GET['materia_id'] ?? '';
        if (empty($seccion) || empty($materia_id)) {
            throw new Exception('Sección o materia no especificada.');
        }

        // Obtener estudiantes y sus notas
        $sqlEstudiantes = "
            SELECT 
                e.id_estudiante,
                CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
                p.ci AS cedula,
                n.nota_1,
                n.nota_2,
                n.nota_3
            FROM estudiantes AS e
            INNER JOIN personas AS p ON e.persona_id = p.id_persona
            INNER JOIN grados AS g ON e.grado_id = g.id_grado
            INNER JOIN asignacion AS a ON g.id_grado = a.grado_id
            LEFT JOIN notas AS n ON e.id_estudiante = n.estudiante_id AND a.id_asignacion = n.asignacion_id
            WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
            AND a.materia_id = :materia_id
            AND g.estado = '1'
            ORDER BY p.nombres, p.apellidos
        ";
        $queryEstudiantes = $pdo->prepare($sqlEstudiantes);
        $queryEstudiantes->bindParam(':seccion', $seccion);
        $queryEstudiantes->bindParam(':materia_id', $materia_id);
        $queryEstudiantes->execute();
        $estudiantes = $queryEstudiantes->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'estudiantes' => $estudiantes]);
    } elseif ($action === 'updateNoteState') {
        $input = json_decode(file_get_contents('php://input'), true);
        $materia_id = $input['materia_id'] ?? '';
        $lapso = $input['lapso'] ?? '';
        $estado = $input['estado'] ?? '';

        if (!$materia_id || !in_array($lapso, ['1', '2', '3']) || !in_array($estado, ['0', '1'])) {
            throw new Exception('Datos inválidos.');
        }

        // Obtener el estado actual
        $sqlGetEstado = "
            SELECT n.estado
            FROM notas AS n
            INNER JOIN asignacion AS a ON n.asignacion_id = a.id_asignacion
            WHERE a.materia_id = :materia_id
            LIMIT 1
        ";
        $queryGetEstado = $pdo->prepare($sqlGetEstado);
        $queryGetEstado->execute([':materia_id' => $materia_id]);
        $estadoActual = $queryGetEstado->fetchColumn();

        if ($estadoActual === false) {
            throw new Exception('No se encontró el estado actual.');
        }

        // Calcular el nuevo estado
        $estadoArray = str_split($estadoActual); // Convertir el estado actual en un array
        $estadoArray[$lapso - 1] = $estado; // Actualizar el lapso correspondiente
        $nuevoEstado = implode('', $estadoArray); // Convertir el array de vuelta a una cadena

        // Actualizar el estado en la base de datos
        $sqlUpdate = "
            UPDATE notas AS n
            INNER JOIN asignacion AS a ON n.asignacion_id = a.id_asignacion
            SET n.estado = :nuevo_estado
            WHERE a.materia_id = :materia_id
        ";
        $queryUpdate = $pdo->prepare($sqlUpdate);
        $queryUpdate->execute([
            ':nuevo_estado' => $nuevoEstado,
            ':materia_id' => $materia_id
        ]);

        echo json_encode(['success' => true, 'message' => 'Estado de la nota actualizado correctamente.']);
    } else {
        throw new Exception('Acción no válida.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
