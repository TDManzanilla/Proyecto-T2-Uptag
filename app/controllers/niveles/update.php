<?php

include ('../../../app/config.php');

$gestion_id = $_GET['id'];
$estado = $_GET['estado'];

$sentencia = $pdo->prepare('UPDATE niveles
 SET estado=:estado
, fyh_actualizacion=:fyh_actualizacion
 WHERE gestion_id=:gestion_id');

$sentencia->bindParam(':gestion_id',$gestion_id);
$sentencia->bindParam(':fyh_actualizacion',$fechaHora);
$sentencia->bindParam(':estado',$estado);

if($sentencia->execute()){
    echo 'success';
    session_start();
    $_SESSION['mensaje'] = "Se actualizó el nivel de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:'.APP_URL."/admin/configuraciones/gestion/");
//header('Location:' .$URL.'/');
}else{
    echo 'error al registrar a la base de datos';
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo actualizar en la base datos, comuniquese con el administrador";
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}