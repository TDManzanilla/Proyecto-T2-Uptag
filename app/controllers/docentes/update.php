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
$id_docente = $_POST['id_docente']; // Asegúrate de recibir este valor
$patologia = $_POST['patologia'];
$alergia = $_POST['alergia'];
$condicion = $_POST['condicion'];
$tipo_sangre = $_POST['tipo_sangre'];
$talla_zapatos = $_POST['talla_zapatos'];
$talla_camisa = $_POST['talla_camisa'];
$talla_pantalon = $_POST['talla_pantalon'];
$discapacidad = $_POST['discapacidad'];
$descripcion_disc = $_POST['descripcion_disc'];

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
        profesion = :profesion, direccion = :direccion, patologia = :patologia, 
        alergia = :alergia, condicion = :condicion, tipo_sangre = :tipo_sangre, 
        talla_zapatos = :talla_zapatos, talla_camisa = :talla_camisa, 
        talla_pantalon = :talla_pantalon, discapacidad = :discapacidad, 
        descripcion_disc = :descripcion_disc, fyh_actualizacion = :fyh_actualizacion
        WHERE id_persona = :id_persona');
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':apellidos', $apellidos);
    $sentencia->bindParam(':ci', $ci);
    $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':profesion', $profesion);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':patologia', $patologia);
    $sentencia->bindParam(':alergia', $alergia);
    $sentencia->bindParam(':condicion', $condicion);
    $sentencia->bindParam(':tipo_sangre', $tipo_sangre);
    $sentencia->bindParam(':talla_zapatos', $talla_zapatos);
    $sentencia->bindParam(':talla_camisa', $talla_camisa);
    $sentencia->bindParam(':talla_pantalon', $talla_pantalon);
    $sentencia->bindParam(':discapacidad', $discapacidad);
    $sentencia->bindParam(':descripcion_disc', $descripcion_disc);
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_persona', $id_persona);
    $sentencia->execute();

    // Actualizar en docentes
    $sentencia = $pdo->prepare('UPDATE docentes 
        SET fyh_actualizacion = :fyh_actualizacion
        WHERE id_docente = :id_docente');
    $sentencia->bindParam(':fyh_actualizacion', $fechaHora);
    $sentencia->bindParam(':id_docente', $id_docente);
    $sentencia->execute();

    // Confirmar transacción
    $pdo->commit();
    session_start();
    $_SESSION['mensaje'] = "Se actualizó al docente de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:' . APP_URL . "/admin/docentes");
} catch (Exception $exception) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    session_start();
    $_SESSION['mensaje'] = "Error al actualizar en la base de datos: " . $exception->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}
