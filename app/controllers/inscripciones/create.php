<?php

include ('../../../app/config.php');

try {
    // Recibir datos del formulario
    $rol_id = $_POST['rol_id'];
    $nombres = mb_strtoupper($_POST['nombres'], 'UTF-8');
    $apellidos = mb_strtoupper($_POST['apellidos'], 'UTF-8');
    $ci = $_POST['ci'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $celular = $_POST['celular'];
    $profesion = mb_strtoupper($_POST['profesion'], 'UTF-8'); // Aseguramos que se incluya
    $direccion = mb_strtoupper($_POST['direccion'], 'UTF-8');
    $email = $_POST['email'];
    $nivel_id = $_POST['nivel_id'];
    $grado_id = $_POST['grado_id'];

    // Datos del representante
    $nombres_apellidos_ppff = mb_strtoupper($_POST['nombres_apellidos_ppff'], 'UTF-8');
    $ci_ppff = $_POST['ci_ppff'];
    $celular_ppff = $_POST['celular_ppff'];
    $direccion_ppff = mb_strtoupper($_POST['direccion_ppff'], 'UTF-8');
    $parentesco_ppff = mb_strtoupper($_POST['parentesco_ppff'], 'UTF-8');

    // Datos de referencia
    $ref_nombre_apellido_ppff = mb_strtoupper($_POST['ref_nombre_apellido_ppff'], 'UTF-8');
    $ref_celular_ppff = $_POST['ref_celular_ppff'];
    $ref_parentesco_ppff = mb_strtoupper($_POST['ref_parentesco_ppff'], 'UTF-8');

    // Validar duplicados: CI
    $sentencia = $pdo->prepare('SELECT COUNT(*) FROM personas WHERE ci = :ci');
    $sentencia->bindParam(':ci', $ci);
    $sentencia->execute();
    if ($sentencia->fetchColumn() > 0) {
        session_start();
        $_SESSION['mensaje'] = "El número de cédula de identidad ya está registrado.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Validar duplicados: Email
    $sentencia = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
    $sentencia->bindParam(':email', $email);
    $sentencia->execute();
    if ($sentencia->fetchColumn() > 0) {
        session_start();
        $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // Insertar en la tabla usuarios
    $password = password_hash($ci, PASSWORD_DEFAULT); // Contraseña encriptada
    $sentencia = $pdo->prepare('INSERT INTO usuarios (rol_id, email, password, fyh_creacion, estado) 
                                VALUES (:rol_id, :email, :password, :fyh_creacion, :estado)');
    $sentencia->bindParam(':rol_id', $rol_id); // Usar el valor enviado desde el formulario
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();
    $id_usuario = $pdo->lastInsertId();

    // Insertar en la tabla personas
    $sentencia = $pdo->prepare('INSERT INTO personas (usuario_id, nombres, apellidos, ci, fecha_nacimiento, celular, direccion, fyh_creacion, estado, profesion) 
                                VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :celular, :direccion, :fyh_creacion, :estado, :profesion)');
    $sentencia->bindParam(':usuario_id', $id_usuario);
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':apellidos', $apellidos);
    $sentencia->bindParam(':ci', $ci);
    $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->bindParam(':profesion', $profesion); // Incluimos la profesión
    $sentencia->execute();
    $id_persona = $pdo->lastInsertId();

    // Insertar en la tabla estudiantes
    $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, nivel_id, grado_id, fyh_creacion, estado) 
                                VALUES (:persona_id, :nivel_id, :grado_id, :fyh_creacion, :estado)');
    $sentencia->bindParam(':persona_id', $id_persona);
    $sentencia->bindParam(':nivel_id', $nivel_id);
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();
    $id_estudiante = $pdo->lastInsertId();

    // Insertar en la tabla ppffs (representantes)
    $sentencia = $pdo->prepare('INSERT INTO ppffs (estudiantes_id, nombres_apellidos_ppff, ci_ppff, celular_ppff, direccion_ppff, parentesco_ppff, ref_nombre_apellido_ppff, ref_celular_ppff, ref_parentesco_ppff, fyh_creacion, estado) 
                                VALUES (:estudiantes_id, :nombres_apellidos_ppff, :ci_ppff, :celular_ppff, :direccion_ppff, :parentesco_ppff, :ref_nombre_apellido_ppff, :ref_celular_ppff, :ref_parentesco_ppff, :fyh_creacion, :estado)');
    $sentencia->bindParam(':estudiantes_id', $id_estudiante);
    $sentencia->bindParam(':nombres_apellidos_ppff', $nombres_apellidos_ppff);
    $sentencia->bindParam(':ci_ppff', $ci_ppff);
    $sentencia->bindParam(':celular_ppff', $celular_ppff);
    $sentencia->bindParam(':direccion_ppff', $direccion_ppff);
    $sentencia->bindParam(':parentesco_ppff', $parentesco_ppff);
    $sentencia->bindParam(':ref_nombre_apellido_ppff', $ref_nombre_apellido_ppff);
    $sentencia->bindParam(':ref_celular_ppff', $ref_celular_ppff);
    $sentencia->bindParam(':ref_parentesco_ppff', $ref_parentesco_ppff);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();

    // Confirmar transacción
    $pdo->commit();

    // Redirigir con mensaje de éxito
    session_start();
    $_SESSION['mensaje'] = "Estudiante registrado correctamente.";
    $_SESSION['icono'] = "success";
    header('Location: ' . APP_URL . '/admin/inscripciones');
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    session_start();
    $_SESSION['mensaje'] = "Error al registrar el estudiante: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}