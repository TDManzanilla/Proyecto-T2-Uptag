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
(usuario_id,nombres,apellidos,ci,fecha_nacimiento,celular,profesion,direccion,fyh_creacion,estado)
VALUES 
(:usuario_id,:nombres,:apellidos,:ci,:fecha_nacimiento,:celular,:profesion,:direccion,:fyh_creacion,:estado)');
$sentencia->bindParam(':usuario_id',$id_usuario);
$sentencia->bindParam(':nombres',$nombres);
$sentencia->bindParam(':apellidos',$apellidos);
$sentencia->bindParam(':ci',$ci);
$sentencia->bindParam(':fecha_nacimiento',$fecha_nacimiento);
$sentencia->bindParam(':celular',$celular);
$sentencia->bindParam(':profesion',$profesion);
$sentencia->bindParam(':direccion',$direccion);
$sentencia->bindParam(':fyh_creacion',$fechaHora);
$sentencia->bindParam(':estado',$estado_de_registro);
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
