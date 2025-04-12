<?php
session_start();
include ('../app/config.php'); // Usaremos la conexión de config.php

$email = $_POST['email'];

try {
    // Consulta para verificar si el email existe y obtener preguntas de seguridad
    $query = "SELECT * FROM usuarios WHERE email = :email AND estado = '1'";
    $statement = $pdo->prepare($query); // Utilizamos la conexión PDO definida en config.php
    $statement->bindParam(':email', $email);
    $statement->execute();

    if ($statement->rowCount() > 0) {
        // Extraemos las preguntas de seguridad
        $registro = $statement->fetch(PDO::FETCH_ASSOC);
        $_SESSION['preguntas'] = [
            $registro['pregunta_1'],
            $registro['pregunta_2'],
            $registro['pregunta_3']
        ];
        $_SESSION['id_usuario'] = $registro['id_usuario'];
        $_SESSION['email_validado'] = $email;
        $_SESSION['mensaje'] = "Responde a la pregunta de seguridad.";
        $_SESSION['icono'] = "success";
    } else {
        $_SESSION['mensaje'] = "Correo no encontrado. Intenta nuevamente.";
        $_SESSION['icono'] = "error";
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la conexión o consulta: " . $e->getMessage();
    $_SESSION['icono'] = "error";
}

header("Location: recuperar_contraseña.php");
exit();
?>
