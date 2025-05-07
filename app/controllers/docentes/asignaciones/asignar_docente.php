<?php
include('../../../config.php');

// Habilitar manejo de errores en PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = json_decode(file_get_contents('php://input'), true);
$docenteId = $data['docenteId'];
$materia = $data['materia'];
$seccion = $data['seccion'];

try {
    // Obtener el id_asignacion basado en la materia y sección
    $checkSql = "
        SELECT a.id_asignacion
        FROM asignacion AS a
        INNER JOIN materias AS m ON a.materia_id = m.id_materia
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        WHERE m.id_materia = :materia
        AND CONCAT(g.curso, ' - ', g.paralelo) = :seccion
    ";
    $checkQuery = $pdo->prepare($checkSql);
    $checkQuery->bindParam(':materia', $materia);
    $checkQuery->bindParam(':seccion', $seccion);
    $checkQuery->execute();
    $result = $checkQuery->fetch(PDO::FETCH_ASSOC);

    // Depuración: Verificar el resultado del SELECT
    error_log("Resultado del SELECT: " . json_encode($result));

    // Verificar si se encontró el id_asignacion
    if (empty($result)) {
        echo json_encode(['success' => false, 'message' => 'No se encontró la asignación para la materia y sección especificadas.']);
        exit;
    }

    $idAsignacion = $result['id_asignacion'];

    // Actualizar la asignación usando el id_asignacion
    $sql = "
        UPDATE asignacion
        SET docente_id = :docenteId
        WHERE id_asignacion = :idAsignacion
    ";
    $query = $pdo->prepare($sql);
    $query->bindParam(':docenteId', $docenteId);
    $query->bindParam(':idAsignacion', $idAsignacion);
    $query->execute();

    // Verificar filas afectadas
    $rowsAffected = $query->rowCount();
    error_log("Docente ID: $docenteId, ID Asignación: $idAsignacion");
    error_log("Filas afectadas por el UPDATE: $rowsAffected");

    if ($rowsAffected > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se realizaron cambios en la base de datos.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}