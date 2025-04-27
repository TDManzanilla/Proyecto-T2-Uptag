<?php
include('../../config.php');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $seccion = $input['seccion'] ?? '';
    $materia_id = $input['materia_id'] ?? '';
    $lapso = $input['lapso'] ?? '';
    $estado = $input['estado'] ?? '';

    if (!$seccion || !$materia_id || !$lapso || !in_array($estado, ['0', '1'])) {
        throw new Exception('Datos inválidos.');
    }

    // Insertar o actualizar el estado del lapso
    $sql = "
        INSERT INTO estado_lapsos (seccion, materia_id, lapso, estado)
        VALUES (:seccion, :materia_id, :lapso, :estado)
        ON DUPLICATE KEY UPDATE estado = :estado
    ";
    $query = $pdo->prepare($sql);
    $query->execute([
        ':seccion' => $seccion,
        ':materia_id' => $materia_id,
        ':lapso' => $lapso,
        ':estado' => $estado
    ]);

    echo json_encode(['success' => true, 'message' => 'Estado del lapso actualizado correctamente.']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
