<?php
include('../../config.php');

try {

    // Obtener los secciones
    $sql = "
        SELECT 
            *
        FROM grados WHERE estado = '1'
    ";
    $query = $pdo->prepare($sql);
    $query->execute();
    $secciones = $query->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['secciones' => $secciones]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener los datos: ' . $e->getMessage()]);
}
