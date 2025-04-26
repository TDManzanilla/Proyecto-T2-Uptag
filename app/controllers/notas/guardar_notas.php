<?php
include('../../config.php');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['notas'])) {
        throw new Exception('No se recibieron datos para actualizar.');
    }

    $pdo->beginTransaction();

    foreach ($data['notas'] as $nota) {
        // Actualizar las notas solo si han sido modificadas
        $sql = "
            UPDATE notas
            SET nota_1 = :nota_1,
                nota_2 = :nota_2,
                nota_3 = :nota_3,
                nota_final = :nota_final,
                estado = :estado
            WHERE id_nota = :id_nota
            AND (nota_1 != :nota_1 OR nota_2 != :nota_2 OR nota_3 != :nota_3)
        ";
        $query = $pdo->prepare($sql);
        $query->bindParam(':nota_1', $nota['nota_1']);
        $query->bindParam(':nota_2', $nota['nota_2']);
        $query->bindParam(':nota_3', $nota['nota_3']);
        $query->bindParam(':nota_final', $nota['nota_final']);
        $query->bindParam(':estado', $nota['estado']);
        $query->bindParam(':id_nota', $nota['id_nota']);
        $query->execute();
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Notas actualizadas correctamente.']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar las notas: ' . $e->getMessage()]);
}
