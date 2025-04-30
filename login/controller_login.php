<?php
include ('../app/config.php');
session_start();
$email_log = $_POST['email'];
$password = $_POST['password'];

// Guardar los valores del formulario en la sesión
$_SESSION['form_email'] = $email_log;

$sql = "SELECT * FROM usuarios WHERE email = :email";
$query = $pdo->prepare($sql);
$query->execute([':email' => $email_log]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['mensaje'] = 'El correo electrónico no se encuentra en el sistema.';
    $_SESSION['icono'] = 'error';
    ?><script>window.history.back();</script><?php
    exit();
} else {
    if ($user['estado'] != '1') {
        $_SESSION['mensaje'] = 'Su cuenta ha sido desactivada. Comuníquese con un administrador.';
        $_SESSION['icono'] = 'error';
        header('Location: ' . APP_URL . 'login/index.php');
        exit();
    }elseif (password_verify($password, $user['password'])) {
        // Limpiar los valores del formulario de la sesión
        unset($_SESSION['form_email']);
        //$_SESSION['mensaje'] = 'Bienvenido al sistema!';
        //$_SESSION['icono'] = 'success';
        $_SESSION['sesion_email'] = $email_log;
        $_SESSION['session_user'] = $user['id_usuario'];
        header('Location:../admin/index.php');
        exit();
    } else {
        $_SESSION['mensaje'] = 'La contraseña ingresada es incorrecta.';
        $_SESSION['icono'] = 'error';
        ?><script>window.history.back();</script><?php
        exit();
    }
}
?>