<?php

include ('../../../app/config.php');

$nombres = mb_strtoupper($_POST['nombres'],'UTF-8');
$apellidos = mb_strtoupper($_POST['apellidos'],'UTF-8');
$ci = $_POST['ci'];
$rol_id = $_POST['rol_id'];
$email = $_POST['email'];
$profesion = mb_strtoupper($_POST['profesion'],'UTF-8');
$direccion = mb_strtoupper($_POST['direccion'],'UTF-8');
$celular = $_POST['celular'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

// Validar campos opcionales
$patologia = isset($_POST['patologia']) ? $_POST['patologia'] : '';
$alergia = isset($_POST['alergia']) ? $_POST['alergia'] : '';
$condicion = isset($_POST['condicion']) ? $_POST['condicion'] : '';
$tipo_sangre = isset($_POST['tipo_sangre']) ? $_POST['tipo_sangre'] : '';
$talla_zapatos = isset($_POST['talla_zapatos']) ? $_POST['talla_zapatos'] : '';
$talla_camisa = isset($_POST['talla_camisa']) ? $_POST['talla_camisa'] : '';
$talla_pantalon = isset($_POST['talla_pantalon']) ? $_POST['talla_pantalon'] : '';
$discapacidad = isset($_POST['discapacidad']) ? $_POST['discapacidad'] : '';
$descripcion_disc = isset($_POST['descripcion_disc']) ? $_POST['descripcion_disc'] : '';
$fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';

$pdo->beginTransaction();
//Insertar en usuarios
$password = password_hash($ci, PASSWORD_DEFAULT);

$sentencia = $pdo->prepare('INSERT INTO usuarios 
(rol_id,email,password, fyh_creacion, estado)
VALUES (:rol_id,:email,:password,:fyh_creacion,:estado)');

$sentencia->bindParam(':rol_id',$rol_id);
$sentencia->bindParam(':email',$email);
$sentencia->bindParam(':fyh_creacion',$fechaHora);
$sentencia->bindParam(':estado',$estado_de_registro);
$sentencia->bindParam(':password',$password);
$sentencia->execute();

$id_usuario = $pdo->lastInsertId();

//Insertar en Personas
$sentencia = $pdo->prepare('INSERT INTO personas
(usuario_id, nombres, apellidos, ci, fecha_nacimiento, celular, profesion, direccion, patologia, alergia, condicion, tipo_sangre, talla_zapatos, talla_camisa, talla_pantalon, discapacidad, descripcion_disc, fyh_creacion, estado, fecha_ingreso_ins)
VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :celular, :profesion, :direccion, :patologia, :alergia, :condicion, :tipo_sangre, :talla_zapatos, :talla_camisa, :talla_pantalon, :discapacidad, :descripcion_disc, :fyh_creacion, :estado, :fecha_ingreso_ins)');
$sentencia->bindParam(':usuario_id', $id_usuario);
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
$sentencia->bindParam(':fyh_creacion', $fechaHora);
$sentencia->bindParam(':estado', $estado_de_registro);
$sentencia->bindParam(':fecha_ingreso_ins', $fecha_ingreso);
$sentencia->execute();

$id_personas = $pdo->lastInsertId();

//Insertar en Docentes
$sentencia = $pdo->prepare('INSERT INTO docentes
(persona_id,fyh_creacion,estado) VALUES (:persona_id,:fyh_creacion,:estado)');
$sentencia->bindParam(':persona_id',$id_personas);
$sentencia->bindParam(':fyh_creacion',$fechaHora);
$sentencia->bindParam(':estado',$estado_de_registro);

try {
    if($sentencia->execute()){
        $pdo->commit();
        session_start();
        $_SESSION['mensaje'] = "Se registró el docente de la manera correcta en la base de datos";
        $_SESSION['icono'] = "success";
        header('Location:'.APP_URL."/admin/docentes");
    } else {
        $pdo->rollBack();
        session_start();
        $_SESSION['mensaje'] = "Error al registrar en la base datos, comuníquese con el administrador";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
    }
} catch (Exception $exception) {
    session_start();
    $_SESSION['mensaje'] = "El email de esta persona ya existe en la base de datos";
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}
?>

