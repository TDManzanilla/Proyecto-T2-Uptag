<?php
include ('../../config.php');
$nombre_rol = strtoupper($_POST['nombre_rol']); // Convertir a mayúsculas
$id_rol = $_POST['id_rol'];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($nombre_rol == '') {
    $_SESSION['error_message'] = "El nombre del rol es requerido";
    header('Location: ' . APP_URL . 'admin/roles/edit.php?id=' . $id_rol);
    exit();
} else {
    // Verificar si el nombre del rol ya existe en la base de datos (insensible a mayúsculas y minúsculas)
    $sql = "SELECT estado FROM roles WHERE UPPER(nombre_rol) = UPPER(:nombre_rol) AND id_rol != :id_rol";
    $query = $pdo->prepare($sql);
    $query->execute([':nombre_rol' => $nombre_rol, ':id_rol' => $id_rol]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['estado'] == '1') {
            $_SESSION['error_message'] = "Este nombre de rol ya existe";
        } else {
            $_SESSION['error_message'] = "El nombre ingresado ya existe, pero está desactivado. Actívelo o comuníquese con un administrador";
        }
        $_SESSION['nombre_rol'] = $nombre_rol; // Guardar el valor en la sesión
        header('Location: ' . APP_URL . 'admin/roles/edit.php?id=' . $id_rol);
        exit();
    } else {
        $sentencia = $pdo->prepare("UPDATE roles SET nombre_rol = :nombre_rol, fecha_actualizacion = :fecha_actualizacion WHERE id_rol = :id_rol");

        $sentencia->bindParam(':nombre_rol', $nombre_rol);
        $sentencia->bindParam(':fecha_actualizacion', $fechahora);
        $sentencia->bindParam(':id_rol', $id_rol);

        $sentencia->execute();

        $_SESSION['success_message'] = "El rol fue actualizado de manera exitosa";
        header('Location: ' . APP_URL . 'admin/roles/index.php');
        exit();
    }
}
?>