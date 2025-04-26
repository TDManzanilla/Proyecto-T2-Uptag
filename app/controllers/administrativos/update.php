<?php

include ('../../../app/config.php');

$nombres = mb_strtoupper($_POST['nombres'], 'UTF-8');
$apellidos = mb_strtoupper($_POST['apellidos'], 'UTF-8');
$ci = $_POST['ci'];
$rol_id = $_POST['rol_id'];
$email = $_POST['email'];
$profesion = mb_strtoupper($_POST['profesion'], 'UTF-8');
$direccion = mb_strtoupper($_POST['direccion'], 'UTF-8');
$celular = $_POST['celular'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$id_persona = $_POST['id_persona'];
$id_usuario = $_POST['id_usuario'];
$id_administrativo = $_POST['id_administrativo']; // Asegúrate de recibir este valor


$pdo->beginTransaction();

try {
    // Actualizar en usuarios
    $sentencia = $pdo->prepare('UPDATE usuarios 
        SET rol_id = :rol_id, email = :email, 
        fyh_actualizacion = :fyh_actualizacion
        WHERE id_usuario = :id_usuario');
    $sentencia->bindParam(':rol_id', $rol_id);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_usuario', $id_usuario);
    $sentencia->execute();

    // Actualizar en personas
    $sentencia = $pdo->prepare('UPDATE personas
        SET nombres = :nombres, apellidos = :apellidos, ci = :ci,
        fecha_nacimiento = :fecha_nacimiento, celular = :celular, 
        profesion = :profesion, direccion = :direccion, fyh_actualizacion = :fyh_actualizacion
        WHERE id_persona = :id_persona');
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':apellidos', $apellidos);
    $sentencia->bindParam(':ci', $ci);
    $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':profesion', $profesion);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_persona', $id_persona);
    $sentencia->execute();

    // Actualizar en administrativos
    $sentencia = $pdo->prepare('UPDATE administrativos 
        SET fyh_actualizacion = :fyh_actualizacion
        WHERE id_administrativo = :id_administrativo');
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_administrativo', $id_administrativo);
    $sentencia->execute();

    // Confirmar transacción
    $pdo->commit();
    session_start();
    $_SESSION['mensaje'] = "Se actualizó al administrativo de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:' . APP_URL . "/admin/administrativos");
} catch (Exception $exception) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    session_start();
    $_SESSION['mensaje'] = "Error al actualizar en la base de datos: " . $exception->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}
