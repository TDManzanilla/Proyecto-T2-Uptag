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

                    $id_asignacion = $pdo->lastInsertId();

                    // Agregar a la lista de asignadas
                    $sql_materia = "SELECT nombre_materia FROM materias WHERE id_materia = :materia_id";
                    $query_materia = $pdo->prepare($sql_materia);
                    $query_materia->bindParam(':materia_id', $materia_id);
                    $query_materia->execute();
                    $materia_nombre = $query_materia->fetchColumn();
                    
                    $materiasAsignadas[] = $materia_nombre;
                
                // Validar estudiantes de la seccion
                $sql_estudiantes = "
                    SELECT id_estudiante 
                    FROM estudiantes 
                    WHERE grado_id = :grado_id AND estado = '1'";
                $query_estudiantes = $pdo->prepare($sql_estudiantes);
                $query_estudiantes->bindParam(':grado_id', $grado_id);
                $query_estudiantes->execute();
                $estudiantes = $query_estudiantes->fetchAll(PDO::FETCH_COLUMN, 0);
                if (!empty($estudiantes)){
                    // Validar que no tengan notas los estudiantes
                    foreach ($estudiantes as $id_estudiante) {
                        $sql_notas = "
                            SELECT COUNT(*) 
                            FROM notas 
                            WHERE estudiante_id = :id_estudiante AND asignacion_id = LAST_INSERT_ID() AND estado = '1'";
                        $query_notas = $pdo->prepare($sql_notas);
                        $query_notas->bindParam(':id_estudiante', $id_estudiante); // Usar directamente $id_estudiante
                        $query_notas->execute();
                        $notas_existe = $query_notas->fetchColumn();
                        
                        if ($notas_existe > 0) {
                            // Si ya existen notas, no se insertan nuevas
                            continue;
                        } else 
                        {// Si no existen notas, se insertan nuevas
                        $sql_insert_notas = "INSERT INTO notas (estudiante_id, asignacion_id, nota_1, nota_2, nota_3, estado, fyh_creacion)
                            VALUES (:id_estudiante, :id_asignacion, '0', '0', '0', '100', NOW())";
                        $query_insert_notas = $pdo->prepare($sql_insert_notas);
                        foreach ($estudiantes as $id_estudiante) {
                            $query_insert_notas->bindParam(':id_asignacion', $id_asignacion);
                            $query_insert_notas->bindParam(':id_estudiante', $id_estudiante);
                            $query_insert_notas->execute();}
                        }
                    }   
                }
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