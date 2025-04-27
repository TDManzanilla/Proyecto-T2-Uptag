<?php
include('../../config.php');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_nota = $input['id_nota'] ?? null;
    $estado = $input['estado'] ?? null;

    if (!$id_nota || !in_array($estado, ['0', '1'])) {
        throw new Exception('Datos inválidos.');
    }

    $sql = "UPDATE notas SET estado = :estado WHERE id_nota = :id_nota";
    $query = $pdo->prepare($sql);
    $query->execute([':estado' => $estado, ':id_nota' => $id_nota]);

    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente.']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
