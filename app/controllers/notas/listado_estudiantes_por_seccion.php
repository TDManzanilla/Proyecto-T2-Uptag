<?php
include('../../config.php');

try {
    $seccion = $_GET['seccion'] ?? '';
    $materia_id = $_GET['materia_id'] ?? '';

    if (empty($seccion) || empty($materia_id)) {
        throw new Exception('Sección o materia no especificada.');
    }

    // Obtener los estudiantes y sus notas para la sección y materia seleccionadas
    $sql = "
        SELECT 
            e.id_estudiante,
            CONCAT(p.nombres, ' ', p.apellidos) AS nombre_completo,
            p.ci AS cedula,
            n.nota_1,
            n.nota_2,
            n.nota_3,
            n.nota_final,
            n.estado AS estado_nota
        FROM estudiantes AS e
        INNER JOIN personas AS p ON e.persona_id = p.id_persona
        INNER JOIN grados AS g ON e.grado_id = g.id_grado
        INNER JOIN asignacion AS a ON g.id_grado = a.grado_id
        LEFT JOIN notas AS n ON e.id_estudiante = n.estudiante_id AND a.id_asignacion = n.asignacion_id
        WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
        AND a.materia_id = :materia_id
        ORDER BY p.nombres, p.apellidos
    ";
    $query = $pdo->prepare($sql);
    $query->bindParam(':seccion', $seccion);
    $query->bindParam(':materia_id', $materia_id);
    $query->execute();
    $estudiantes = $query->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el docente asignado a la materia y sección
    $sqlDocente = "
        SELECT 
            CONCAT(p.nombres, ' ', p.apellidos) AS docente_nombre,
            p.ci AS docente_cedula
        FROM asignacion AS a
        INNER JOIN docentes AS d ON a.docente_id = d.id_docente
        INNER JOIN personas AS p ON d.persona_id = p.id_persona
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
        AND a.materia_id = :materia_id
    ";
    $queryDocente = $pdo->prepare($sqlDocente);
    $queryDocente->bindParam(':seccion', $seccion);
    $queryDocente->bindParam(':materia_id', $materia_id);
    $queryDocente->execute();
    $docente = $queryDocente->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['estudiantes' => $estudiantes, 'docente' => $docente]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener los datos: ' . $e->getMessage()]);
}
