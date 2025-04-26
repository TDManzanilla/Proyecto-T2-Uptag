<?php

include('../../config.php');

// Decodificar los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);
$seccion = $data['seccion'];
$materia = $data['materia'];

try {
    // Obtener el ID de la asignación correspondiente a la sección y materia
    $sql = "
        SELECT a.id_asignacion
        FROM asignacion AS a
        INNER JOIN grados AS g ON a.grado_id = g.id_grado
        INNER JOIN materias AS m ON a.materia_id = m.id_materia
        WHERE CONCAT(g.curso, ' - ', g.paralelo) = :seccion
        AND m.nombre_materia = :materia
        LIMIT 1
    ";
    $query = $pdo->prepare($sql);
    $query->bindParam(':seccion', $seccion);
    $query->bindParam(':materia', $materia);
    $query->execute();
    $asignacion = $query->fetch(PDO::FETCH_ASSOC);

    if ($asignacion) {
        // Eliminar la asignación de la base de datos
        $sqlDelete = "DELETE FROM asignacion WHERE id_asignacion = :id_asignacion";
        $queryDelete = $pdo->prepare($sqlDelete);
        $queryDelete->bindParam(':id_asignacion', $asignacion['id_asignacion']);
        $queryDelete->execute();

        // Respuesta exitosa
        echo json_encode(['success' => true, 'message' => 'Asignación eliminada correctamente.']);
    } else {
        // Respuesta en caso de que no se encuentre la asignación
        echo json_encode(['success' => false, 'message' => 'Asignación no encontrada.']);
    }
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['success' => false, 'message' => 'Error al eliminar la asignación: ' . $e->getMessage()]);
}