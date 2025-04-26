<?php

include('../../config.php');

$seccion = $_GET['seccion'] ?? '';

$sql = "
    SELECT 
        CONCAT(g.curso, ' - ', g.paralelo) AS seccion,
        m.nombre_materia AS materia
    FROM asignacion AS a
    INNER JOIN materias AS m ON a.materia_id = m.id_materia
    INNER JOIN grados AS g ON a.grado_id = g.id_grado
";

if (!empty($seccion) && $seccion !== 'TODAS') {
    $sql .= " WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion";
}

$sql .= " ORDER BY g.curso, g.paralelo, m.nombre_materia";

$query = $pdo->prepare($sql);

if (!empty($seccion) && $seccion !== 'TODAS') {
    $query->bindParam(':seccion', $seccion);
}

$query->execute();
$asignaciones = $query->fetchAll(PDO::FETCH_ASSOC);

// Agrupar asignaciones por sección
$resultado = [];
foreach ($asignaciones as $asignacion) {
    $seccion = $asignacion['seccion'];
    $materia = $asignacion['materia'];

    if (!isset($resultado[$seccion])) {
        $resultado[$seccion] = [
            'seccion' => $seccion,
            'materias' => []
        ];
    }

    $resultado[$seccion]['materias'][] = $materia;
}

// Formatear el resultado para devolver un JSON
$resultado = array_values($resultado);

header('Content-Type: application/json');
echo json_encode($resultado);
?>
