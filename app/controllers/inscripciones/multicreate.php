<?php
include ('../../../app/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $pdo->beginTransaction();

    $nivel_id = $_SESSION['nivel_id'];
    $grado_id = $_SESSION['grado_id'];

    foreach ($_POST['students'] as $student) {
        // Validar duplicados: CI
        $sentencia = $pdo->prepare('SELECT COUNT(*) FROM personas WHERE ci = :ci');
        $sentencia->bindParam(':ci', $student['ci']);
        $sentencia->execute();
        if ($sentencia->fetchColumn() > 0) {
            throw new Exception("El número de cédula de identidad {$student['ci']} ya está registrado.");
        }

        // Validar duplicados: Email
        $sentencia = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
        $sentencia->bindParam(':email', $student['email']);
        $sentencia->execute();
        if ($sentencia->fetchColumn() > 0) {
            throw new Exception("El correo electrónico {$student['email']} ya está registrado.");
        }

        // Insertar en la tabla usuarios
        $password = password_hash($student['ci'], PASSWORD_DEFAULT);
        $sentencia = $pdo->prepare('INSERT INTO usuarios (rol_id, email, password, fyh_creacion, estado) 
                                    VALUES (:rol_id, :email, :password, :fyh_creacion, :estado)');
        $sentencia->bindParam(':rol_id', $student['rol_id']);
        $sentencia->bindParam(':email', $student['email']);
        $sentencia->bindParam(':password', $password);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
        $id_usuario = $pdo->lastInsertId();

        // Insertar en la tabla personas
        $sentencia = $pdo->prepare('INSERT INTO personas (usuario_id, nombres, apellidos, ci, fecha_nacimiento, celular, direccion, fyh_creacion, estado, profesion) 
                                    VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :celular, :direccion, :fyh_creacion, :estado, :profesion)');
        $sentencia->bindParam(':usuario_id', $id_usuario);
        $sentencia->bindParam(':nombres', $student['nombres']);
        $sentencia->bindParam(':apellidos', $student['apellidos']);
        $sentencia->bindParam(':ci', $student['ci']);
        $sentencia->bindParam(':fecha_nacimiento', $student['fecha_nacimiento']);
        $sentencia->bindParam(':celular', $student['celular']);
        $sentencia->bindParam(':direccion', $student['direccion']);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->bindParam(':profesion', $student['profesion']);
        $sentencia->execute();
        $id_persona = $pdo->lastInsertId();

        // Insertar en la tabla estudiantes
        $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, nivel_id, grado_id, fyh_creacion, estado) 
                                    VALUES (:persona_id, :nivel_id, :grado_id, :fyh_creacion, :estado)');
        $sentencia->bindParam(':persona_id', $id_persona);
        $sentencia->bindParam(':nivel_id', $nivel_id); // Nivel global
        $sentencia->bindParam(':grado_id', $grado_id); // Grado global
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
    }

    $pdo->commit();

    $_SESSION['mensaje'] = "Estudiantes registrados correctamente.";
    $_SESSION['icono'] = "success";
    header('Location: ' . APP_URL . '/admin/inscripciones');
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al registrar los estudiantes: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}