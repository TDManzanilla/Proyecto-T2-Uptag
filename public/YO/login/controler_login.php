<?php
include ('../app/config.php');
session_start();
$email_log = $_POST['email'];
$password = $_POST['password'];

// Guardar los valores del formulario en la sesión
$_SESSION['form_email'] = $email_log;

$sql = "SELECT u.*, r.estado as rol_estado FROM usuarios u 
        JOIN roles r ON u.rol_id = r.id_rol 
        WHERE u.email = :email";
$query = $pdo->prepare($sql);
$query->execute([':email' => $email_log]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error_message'] = 'El correo electrónico no se encuentra en el sistema.';
    ?><script>window.history.back();</script><?php
    exit();
} else {
    if ($user['estado'] != '1') {
        $_SESSION['error_message'] = 'Su cuenta ha sido desactivada. Comuníquese con un administrador.';
        header('Location: ' . APP_URL . 'login/index.php');
        exit();
    } elseif ($user['rol_estado'] != '1') {
        $_SESSION['error_message'] = 'El cargo que ocupaba ha sido desactivado. Comuníquese con un administrador.';
        ?><script>window.history.back();</script><?php
        exit();
    } elseif (password_verify($password, $user['password'])) {
        // Limpiar los valores del formulario de la sesión
        unset($_SESSION['form_email']);
        $_SESSION['success_message'] = 'Bienvenido al sistema!';
        $_SESSION['session_email'] = $email_log;
        header('Location: ' . APP_URL . 'admin/index.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'La contraseña ingresada es incorrecta.';
        ?><script>window.history.back();</script><?php
        exit();
    }
}
?>
