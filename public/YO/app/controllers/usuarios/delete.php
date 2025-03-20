<?php
include ('../../../app/config.php');

$id_usuario = $_GET['id'];

// Definir la variable $fechahora si no está definida en config.php
if (!isset($fechahora)) {
    $fechahora = date('Y-m-d H:i:s');
}

$sentencia = $pdo->prepare("UPDATE usuarios SET estado = 0, fecha_actualizacion = :fecha_actualizacion WHERE id_usuario = :id_usuario");

$sentencia->bindParam(':id_usuario', $id_usuario);
$sentencia->bindParam(':fecha_actualizacion', $fechahora);

if ($sentencia->execute()) {
    session_start();
    $_SESSION['mensaje'] = "Se eliminó el usuario de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location: ' . APP_URL . "/admin/usuarios");
} else {
    session_start();
    $_SESSION['mensaje'] = "Error, no se pudo eliminar en la base de datos. Comuníquese con el administrador";
    $_SESSION['icono'] = "error";
    header('Location: ' . APP_URL . "/admin/usuarios");
}
?>