<?php
session_start();
include ('../app/config.php');

// Obtener datos del formulario
$respuesta_seguridad = $_POST['respuesta_seguridad'] ?? null;
$pregunta_seguridad = $_POST['pregunta_seguridad']+1 ?? null;
$nueva_contraseña = $_POST['nueva_contraseña'] ?? null;
$repetir_contraseña = $_POST['repetir_contraseña'] ?? null;

// Validar email desde la sesión
$email = $_SESSION['email_validado'] ?? null;
if (is_null($email)) {
    $_SESSION['mensaje'] = "No se pudo determinar el usuario. Por favor, valida tu correo primero.";
    $_SESSION['icono'] = "error";
    header("Location: recuperar_contraseña.php");
    exit();
}

// Validar y transformar pregunta_seguridad
if (is_numeric($pregunta_seguridad)) {
    $pregunta_seguridad = 'pregunta_' . $pregunta_seguridad; // Convertir "1" en "pregunta_1"
}

$respuesta_correcta = str_replace('pregunta_', 'respuesta_', $pregunta_seguridad);

// Validar que la columna generada sea válida
$respuestas_validas = ['respuesta_1', 'respuesta_2', 'respuesta_3'];
if (!in_array($respuesta_correcta, $respuestas_validas)) {
    $_SESSION['mensaje'] = "La respuesta seleccionada no es válida.";
    $_SESSION['icono'] = "error";
    header("Location: recuperar_contraseña.php");
    exit();
}

try {
    // Validar respuesta de seguridad
    $query = "SELECT $respuesta_correcta FROM usuarios WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $registro = $statement->fetch(PDO::FETCH_ASSOC);

    // Validar si se obtuvo un registro válido
    if (!$registro || !isset($registro[$respuesta_correcta])) {
        $_SESSION['mensaje'] = "No se encontró un registro válido en la base de datos.";
        $_SESSION['icono'] = "error";
        header("Location: recuperar_contraseña.php");
        exit();
    }

    // Comparar respuesta ingresada y respuesta almacenada en la base de datos
    $respuesta_bd = trim(strtolower($registro[$respuesta_correcta])); // Limpieza de datos
    $respuesta_usuario = trim(strtolower($respuesta_seguridad)); // Limpieza de datos

    if ($respuesta_bd === $respuesta_usuario) {
        if ($nueva_contraseña === $repetir_contraseña) {
            // Actualizar contraseña
            $password_hash = password_hash($nueva_contraseña, PASSWORD_BCRYPT);
            $query_actualizar = "UPDATE usuarios SET password = :password WHERE email = :email";
            $statement_actualizar = $pdo->prepare($query_actualizar);
            $statement_actualizar->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $statement_actualizar->bindParam(':email', $email, PDO::PARAM_STR);
            $statement_actualizar->execute();

            session_destroy();
            session_start();
            $_SESSION['mensaje'] = "Contraseña actualizada correctamente.";
            $_SESSION['icono'] = "success";
            header("Location: ../login/index.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "Las contraseñas no coinciden.";
            $_SESSION['icono'] = "error";
        }
    } else {
        $_SESSION['mensaje'] = "Respuesta de seguridad incorrecta.";
        $_SESSION['icono'] = "error";
    }
} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la consulta: " . $e->getMessage();
    $_SESSION['icono'] = "error";
}

header("Location: recuperar_contraseña.php");
exit();
