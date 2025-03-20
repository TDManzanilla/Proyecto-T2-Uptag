<?php
//include ('../../config.php');

$id_usuario = $_GET['id'];

$sql = "SELECT u.*, r.nombre_rol, r.estado as rol_estado FROM usuarios u 
        JOIN roles r ON u.rol_id = r.id_rol 
        WHERE u.id_usuario = :id_usuario";
$query = $pdo->prepare($sql);
$query->execute([':id_usuario' => $id_usuario]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['estado'] != '1' || $user['rol_estado'] != '1') {
    $_SESSION['error_message'] = 'El usuario no se encuentra o está desactivado.';
    header('Location: ' . APP_URL . 'admin/usuarios/index.php');
    exit();
}

$nombres = $user['nombres'];
$email = $user['email'];
$nombre_rol = $user['nombre_rol'];
$fyh_creacion = $user['fecha_registro'];
$estado = $user['estado'];
?>