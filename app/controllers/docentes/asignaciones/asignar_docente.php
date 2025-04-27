<?php
include('../../../config.php');

$data = json_decode(file_get_contents('php://input'), true);
$docenteId = $data['docenteId'];
$materia = $data['materia'];
$seccion = $data['seccion'];

try {
    // Verificar si el docente ya está asignado
    $checkSql = "
        SELECT COUNT(*) AS count
        FROM asignacion AS a
        INNER JOIN materias AS m ON a.materia_id = m.id_materia
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        WHERE a.docente_id = :docenteId
        AND m.nombre_materia = :materia
        AND CONCAT(g.curso, ' - ', g.paralelo) = :seccion
        ORDER BY 
            CASE 
                WHEN g.curso = 'Primero' THEN 1
                WHEN g.curso = 'Segundo' THEN 2
                WHEN g.curso = 'Tercero' THEN 3
                WHEN g.curso = 'Cuarto' THEN 4
                WHEN g.curso = 'Quinto' THEN 5
                WHEN g.curso = 'Sexto' THEN 6
                ELSE 7
            END
    ";
    $checkQuery = $pdo->prepare($checkSql);
    $checkQuery->bindParam(':docenteId', $docenteId);
    $checkQuery->bindParam(':materia', $materia);
    $checkQuery->bindParam(':seccion', $seccion);
    $checkQuery->execute();
    $result = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'already_assigned']);
        exit;
    }

    // Actualizar la asignación
    $sql = "
        UPDATE asignacion AS a
        INNER JOIN materias AS m ON a.materia_id = m.id_materia
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        SET a.docente_id = :docenteId
        WHERE m.nombre_materia = :materia
        AND CONCAT(g.curso, ' - ', g.paralelo) = :seccion
    ";
    $query = $pdo->prepare($sql);
    $query->bindParam(':docenteId', $docenteId);
    $query->bindParam(':materia', $materia);
    $query->bindParam(':seccion', $seccion);
    $query->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$sql = "
    SELECT g.curso, g.paralelo, CONCAT(g.curso, ' - ', g.paralelo) AS seccion
    FROM grados AS g
    ORDER BY 
        CASE 
            WHEN g.curso = 'Primero' THEN 1
            WHEN g.curso = 'Segundo' THEN 2
            WHEN g.curso = 'Tercero' THEN 3
            WHEN g.curso = 'Cuarto' THEN 4
            WHEN g.curso = 'Quinto' THEN 5
            WHEN g.curso = 'Sexto' THEN 6
            ELSE 7
        END, g.paralelo
";
$query = $pdo->prepare($sql);
$query->execute();
$secciones = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['secciones' => $secciones]);