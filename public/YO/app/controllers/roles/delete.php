<?php
include ('../../config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_rol = $_GET['id'];

if (!isset($id_rol) || empty($id_rol)) {
    $_SESSION['error_message'] = "ID de rol no válido";
    header('Location: ' . APP_URL . 'admin/roles/index.php');
    exit();
}

try {
    // Verificar si hay usuarios activos con este rol
    $sql = "SELECT COUNT(*) as count FROM usuarios WHERE rol_id = :id_rol AND estado = 1";
    $query = $pdo->prepare($sql);
    $query->execute([':id_rol' => $id_rol]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $_SESSION['error_message'] = "No se puede eliminar el rol porque hay usuarios activos con este mismo.";
    } else {
        $sql = "UPDATE roles SET estado = 0, fecha_actualizacion = :fecha_actualizacion WHERE id_rol = :id_rol";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':id_rol' => $id_rol,
            ':fecha_actualizacion' => $fechahora
        ]);

        $_SESSION['success_message'] = "El rol ha sido eliminado exitosamente";
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = "Error al eliminar el rol: " . $e->getMessage();
}

header('Location: ' . APP_URL . 'admin/roles/index.php');
exit();
?>