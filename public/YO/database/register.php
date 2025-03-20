<?php
include ('../app/config.php');

$nombres = 'Admin';
$cargo = 1;
$email = 'admin@admin.com';
$password = password_hash('admin', PASSWORD_DEFAULT); // Encriptar la contraseña
$fecha_registro = $fechahora;
$estado = '1';

$sql = "INSERT INTO usuarios (nombres, rol_id, email, password, fecha_registro, estado) 
    VALUES (:nombres, :cargo, :email, :password, :fecha_registro, :estado)";
$query = $pdo->prepare($sql);
$result = $query->execute([
    ':nombres' => $nombres,
    ':cargo' => $cargo,
    ':email' => $email,
    ':password' => $password,
    ':fecha_registro' => $fecha_registro,
    ':estado' => $estado
]);

if ($result) {
    echo "Registro exitoso.";
} else {
    echo "Error al registrar.";
}
?>