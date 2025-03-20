<?php
include ('../../config.php');
$nombre_rol = strtoupper($_POST['nombre_rol']); // Convertir a mayúsculas
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($nombre_rol == ''){
    $_SESSION['error_message'] = "El nombre del rol es requerido";
    header('Location: ' . APP_URL . 'admin/roles/create.php');
    exit();
} else {
    // Verificar si el nombre del rol ya existe en la base de datos (insensible a mayúsculas y minúsculas)
    $sql = "SELECT estado FROM roles WHERE UPPER(nombre_rol) = UPPER(:nombre_rol)";
    $query = $pdo->prepare($sql);
    $query->execute([':nombre_rol' => $nombre_rol]);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['estado'] == '1') {
            $_SESSION['error_message'] = "El rol ingresado ya existe";
        } else {
            $_SESSION['error_message'] = "El rol ingresado está desactivado. Actívelo o comuníquese con un administrador";
        }
        $_SESSION['nombre_rol'] = $nombre_rol; // Guardar el valor en la sesión
        header('Location: ' . APP_URL . 'admin/roles/create.php');
        exit();
    } else {
        $sentencia = $pdo->prepare("INSERT INTO roles (nombre_rol, fecha_registro , estado) 
        VALUES (:nombre_rol, :fecha_registro, :estado)");

        $sentencia->bindParam(':nombre_rol', $nombre_rol);
        $sentencia->bindParam(':fecha_registro', $fechahora);
        $sentencia->bindParam(':estado', $estado_de_registro);

        $sentencia->execute();

        $_SESSION['success_message'] = "El rol fue creado de manera exitosa";
        header('Location: ' . APP_URL . 'admin/roles/index.php');
        exit();
    }
}
?>