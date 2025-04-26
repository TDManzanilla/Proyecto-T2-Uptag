<?php

include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $grados = $data['grados'];
    $materias = $data['materias'];
    $docente_id = 1; // Docente por defecto

    try {
        $pdo->beginTransaction();

        $materiasDuplicadas = [];
        $materiasAsignadas = [];

        foreach ($grados as $grado_id) {
            foreach ($materias as $materia_id) {
                // Verificar si ya existe la asignación
                $sql_check = "
                    SELECT COUNT(*) 
                    FROM asignacion 
                    WHERE grado_id = :grado_id AND materia_id = :materia_id AND estado = '1'
                ";
                $query_check = $pdo->prepare($sql_check);
                $query_check->bindParam(':grado_id', $grado_id);
                $query_check->bindParam(':materia_id', $materia_id);
                $query_check->execute();
                $exists = $query_check->fetchColumn();

                if ($exists) {
                    // Si ya existe, agregar a la lista de duplicados
                    $sql_materia = "SELECT nombre_materia FROM materias WHERE id_materia = :materia_id";
                    $query_materia = $pdo->prepare($sql_materia);
                    $query_materia->bindParam(':materia_id', $materia_id);
                    $query_materia->execute();
                    $materia_nombre = $query_materia->fetchColumn();

                    $materiasDuplicadas[] = $materia_nombre;
                } else {
                    // Insertar nueva asignación
                    $sql_insert = "
                        INSERT INTO asignacion (grado_id, materia_id, docente_id, fyh_creacion, estado)
                        VALUES (:grado_id, :materia_id, :docente_id, NOW(), '1')
                    ";
                    $query_insert = $pdo->prepare($sql_insert);
                    $query_insert->bindParam(':grado_id', $grado_id);
                    $query_insert->bindParam(':materia_id', $materia_id);
                    $query_insert->bindParam(':docente_id', $docente_id);
                    $query_insert->execute();

                    // Agregar a la lista de asignadas
                    $sql_materia = "SELECT nombre_materia FROM materias WHERE id_materia = :materia_id";
                    $query_materia = $pdo->prepare($sql_materia);
                    $query_materia->bindParam(':materia_id', $materia_id);
                    $query_materia->execute();
                    $materia_nombre = $query_materia->fetchColumn();

                    $materiasAsignadas[] = $materia_nombre;
                }
            }
        }

        $pdo->commit();

        // Construir el mensaje de respuesta
        if (empty($materiasAsignadas) && !empty($materiasDuplicadas)) {
            // Todas las materias ya estaban asignadas
            echo json_encode([
                'success' => false,
                'type' => 'warning',
                'message' => 'La(s) materia(s) seleccionada(s) ya está(n) asignada(s) a esta(s) sección(es).',
                'duplicadas' => $materiasDuplicadas
            ]);
        } elseif (!empty($materiasAsignadas) && !empty($materiasDuplicadas)) {
            // Algunas materias fueron asignadas, otras ya existían
            echo json_encode([
                'success' => true,
                'type' => 'info',
                'message' => 'Las materias se asignaron correctamente, pero algunas ya estaban asignadas.',
                'asignadas' => $materiasAsignadas,
                'duplicadas' => $materiasDuplicadas
            ]);
        } else {
            // Todas las materias fueron asignadas correctamente
            echo json_encode([
                'success' => true,
                'type' => 'success',
                'message' => 'Todas las materias se asignaron correctamente.',
                'asignadas' => $materiasAsignadas
            ]);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'type' => 'error',
            'message' => 'Hubo un error al guardar las asignaciones: ' . $e->getMessage()
        ]);
    }
}