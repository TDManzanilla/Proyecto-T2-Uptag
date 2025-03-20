<?php
// filepath: c:\xampp\htdocs\proyecto\login\logout.php
include ('../app/config.php');

session_start();
session_unset();
session_destroy();

// Iniciar una nueva sesión para almacenar el mensaje de despedida
session_start();
$_SESSION['info_message'] = 'Se cerró sesión de manera satisfactoria. Gracias por usar el sistema.';

header('Location: ' . APP_URL . 'login/index.php');
exit();
?>