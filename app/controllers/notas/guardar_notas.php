<?php
include('../../config.php');

try {
    // Leer los datos enviados desde el frontend
    $input = json_decode(file_get_contents('php://input'), true);
    $notas = $input['notas'] ?? [];

    if (empty($notas)) {
        throw new Exception('No se recibieron datos de notas.');
    }

    foreach ($notas as $nota) {
        // Validar que todos los campos necesarios estén presentes
        if (!isset($nota['id_nota'], $nota['materia_id'])) {
            throw new Exception('Faltan datos obligatorios en una o más notas.');
        }

        // Validar y asignar valores por defecto (0) si están vacíos
        $nota['nota_1'] = isset($nota['nota_1']) && is_numeric($nota['nota_1']) ? $nota['nota_1'] : 0;
        $nota['nota_2'] = isset($nota['nota_2']) && is_numeric($nota['nota_2']) ? $nota['nota_2'] : 0;
        $nota['nota_3'] = isset($nota['nota_3']) && is_numeric($nota['nota_3']) ? $nota['nota_3'] : 0;
        $nota['nota_final'] = isset($nota['nota_final']) && is_numeric($nota['nota_final']) ? $nota['nota_final'] : 0;

        // Asegurar que la nota final no sea menor a 1
        $nota['nota_final'] = max($nota['nota_final'], 1);

        // Validar que las notas estén en el rango permitido (0 a 20)
        foreach (['nota_1', 'nota_2', 'nota_3', 'nota_final'] as $key) {
            if ($nota[$key] < 0 || $nota[$key] > 20) {
                throw new Exception("El valor de {$key} debe estar entre 0 y 20.");
            }
        }

        // Verificar si existe una asignación válida para el estudiante y la materia
        $sqlAsignacion = "
            SELECT a.id_asignacion
            FROM asignacion AS a
            INNER JOIN grados AS g ON a.grado_id = g.id_grado
            INNER JOIN estudiantes AS e ON e.grado_id = g.id_grado
            WHERE e.id_estudiante = :estudiante_id
            AND a.materia_id = :materia_id
            LIMIT 1
        ";
        $queryAsignacion = $pdo->prepare($sqlAsignacion);
        $queryAsignacion->execute([
            ':estudiante_id' => $nota['id_nota'],
            ':materia_id' => $nota['materia_id']
        ]);
        $asignacion = $queryAsignacion->fetch(PDO::FETCH_ASSOC);

        if (!$asignacion) {
            throw new Exception("No se encontró una asignación válida para el estudiante con ID {$nota['id_nota']} y materia ID {$nota['materia_id']}.");
        }

        // Verificar si ya existe una nota para el estudiante y la asignación
        $sqlVerificarNota = "
            SELECT id_nota
            FROM notas
            WHERE estudiante_id = :estudiante_id AND asignacion_id = :asignacion_id
        ";
        $queryVerificarNota = $pdo->prepare($sqlVerificarNota);
        $queryVerificarNota->execute([
            ':estudiante_id' => $nota['id_nota'],
            ':asignacion_id' => $asignacion['id_asignacion']
        ]);
        $notaExistente = $queryVerificarNota->fetch(PDO::FETCH_ASSOC);

        if ($notaExistente) {
            // Actualizar la nota existente
            $sqlActualizarNota = "
                UPDATE notas
                SET nota_1 = :nota_1, nota_2 = :nota_2, nota_3 = :nota_3, nota_final = :nota_final, estado = :estado
                WHERE id_nota = :id_nota
            ";
            $queryActualizarNota = $pdo->prepare($sqlActualizarNota);
            $queryActualizarNota->execute([
                ':nota_1' => $nota['nota_1'],
                ':nota_2' => $nota['nota_2'],
                ':nota_3' => $nota['nota_3'],
                ':nota_final' => $nota['nota_final'],
                ':estado' => $nota['estado'],
                ':id_nota' => $notaExistente['id_nota']
            ]);
        } else {
            // Insertar una nueva nota
            $sqlInsertarNota = "
                INSERT INTO notas (estudiante_id, asignacion_id, nota_1, nota_2, nota_3, nota_final, estado)
                VALUES (:estudiante_id, :asignacion_id, :nota_1, :nota_2, :nota_3, :nota_final, :estado)
            ";
            $queryInsertarNota = $pdo->prepare($sqlInsertarNota);
            $queryInsertarNota->execute([
                ':estudiante_id' => $nota['id_nota'],
                ':asignacion_id' => $asignacion['id_asignacion'],
                ':nota_1' => $nota['nota_1'],
                ':nota_2' => $nota['nota_2'],
                ':nota_3' => $nota['nota_3'],
                ':nota_final' => $nota['nota_final'],
                ':estado' => $nota['estado']
            ]);
        }
    }

    // Respuesta exitosa
    echo json_encode(['success' => true, 'message' => 'Notas guardadas correctamente.']);
} catch (Exception $e) {
    // Respuesta de error con detalles
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
