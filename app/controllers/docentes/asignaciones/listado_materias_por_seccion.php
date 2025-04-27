<?php
include('../../../config.php');

try {
    $seccion = $_GET['seccion'] ?? '';

    if (empty($seccion)) {
        throw new Exception('Sección no especificada.');
    }

    // Obtener las materias asignadas para la sección seleccionada
    $sqlMaterias = "
        SELECT 
            m.id_materia,
            m.nombre_materia AS materia,
            IFNULL(CONCAT(p.nombres, ' ', p.apellidos), 'Sin asignar') AS docente
        FROM asignacion AS a
        INNER JOIN materias AS m ON a.materia_id = m.id_materia
        LEFT JOIN docentes AS d ON a.docente_id = d.id_docente
        LEFT JOIN personas AS p ON d.persona_id = p.id_persona
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
        AND g.estado = '1'
        AND a.estado = '1'
        ORDER BY m.nombre_materia
    ";
    $queryMaterias = $pdo->prepare($sqlMaterias);
    $queryMaterias->bindParam(':seccion', $seccion);
    $queryMaterias->execute();
    $materias = $queryMaterias->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode(['materias' => $materias]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
}