<?php
include('../../../config.php');

try {
    $seccion = $_GET['seccion'] ?? '';

    // Evitar cualquier salida previa
    ob_start();

    // Obtener todas las secciones
    $sqlSecciones = "
        SELECT DISTINCT CONCAT(g.curso, ' - ', g.paralelo) AS seccion
        FROM grados AS g
        WHERE g.estado = '1'
        ORDER BY g.curso, g.paralelo
    ";
    $querySecciones = $pdo->prepare($sqlSecciones);
    $querySecciones->execute();
    $secciones = $querySecciones->fetchAll(PDO::FETCH_ASSOC);

    // Obtener las materias asignadas para la sección seleccionada
    $materias = [];
    if (!empty($seccion)) {
        $sqlMaterias = "
            SELECT 
                m.nombre_materia AS materia,
                IFNULL(CONCAT(p.nombres, ' ', p.apellidos), 'Sin asignar') AS docente
            FROM asignacion AS a
            INNER JOIN materias AS m ON a.materia_id = m.id_materia
            LEFT JOIN docentes AS d ON a.docente_id = d.id_docente
            LEFT JOIN personas AS p ON d.persona_id = p.id_persona
            INNER JOIN grados AS g ON a.grado_id = g.id_grado
            WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
            AND g.estado = '1'
            ORDER BY m.nombre_materia
        ";
        $queryMaterias = $pdo->prepare($sqlMaterias);
        $queryMaterias->bindParam(':seccion', $seccion);
        $queryMaterias->execute();
        $materias = $queryMaterias->fetchAll(PDO::FETCH_ASSOC);
    }

    // Limpiar cualquier salida previa
    ob_clean();

    // Devolver los datos como JSON
    header('Content-Type: application/json');
    echo json_encode(['secciones' => $secciones, 'materias' => $materias]);
} catch (Exception $e) {
    // Limpiar cualquier salida previa
    ob_clean();

    // Manejo de errores
    http_response_code(500);
    echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
}