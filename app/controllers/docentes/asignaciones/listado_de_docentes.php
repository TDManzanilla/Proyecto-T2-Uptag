<?php
include('../../../config.php');

try {
    $sqlDocentes = "
        SELECT 
            doc.id_docente, 
            CONCAT(per.nombres, ' ', per.apellidos) AS nombre_completo,
            per.ci AS cedula
        FROM docentes AS doc
        INNER JOIN personas AS per ON doc.persona_id = per.id_persona
        WHERE doc.estado = '1'
        ORDER BY per.nombres, per.apellidos
    ";
    $queryDocentes = $pdo->prepare($sqlDocentes);
    $queryDocentes->execute();
    $docentes = $queryDocentes->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($docentes);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener los docentes: ' . $e->getMessage()]);
}
