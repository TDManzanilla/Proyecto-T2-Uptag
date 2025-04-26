<?php
include('../../../config.php');

$data = json_decode(file_get_contents('php://input'), true);
$docenteId = $data['docenteId'];
$materia = $data['materia'];
$seccion = $data['seccion'];

try {
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