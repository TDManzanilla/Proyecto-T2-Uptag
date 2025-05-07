<?php
include('../../../config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
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

    // Verificar si hay secciones disponibles
    if (empty($secciones)) {
        throw new Exception('No se encontraron secciones disponibles.');
    }

    // Devolver las secciones como JSON
    header('Content-Type: application/json');
    echo json_encode(['secciones' => $secciones]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Error al obtener las secciones: ' . $e->getMessage()]);
}
