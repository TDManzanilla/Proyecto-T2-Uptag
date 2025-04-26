<?php

include ('../../../app/config.php');

$gestion_id = $_GET['id'];
$nivel = 'MEDIA GENERAL';
$turno = 'MAÑANA';

$sentencia = $pdo->prepare('INSERT INTO niveles
(gestion_id,nivel,turno, fyh_creacion, estado)
VALUES ( :gestion_id,:nivel,:turno,:fyh_creacion,:estado)');

$sentencia->bindParam(':gestion_id',$gestion_id);
$sentencia->bindParam(':nivel',$nivel);
$sentencia->bindParam(':turno',$turno);
$sentencia->bindParam('fyh_creacion',$fechaHora);
$sentencia->bindParam('estado',$estado_de_registro);

if($sentencia->execute()){
    //echo 'success';
    session_start();
    $_SESSION['mensaje'] = "Se creó de manera correcta el nuevo periodo escolar";
    $_SESSION['icono'] = "success";
    header('Location:'.APP_URL."/admin/configuraciones/gestion");
}else{
    echo 'error al registrar a la base de datos';
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo registrar en la base datos, comuniquese con el administrador";
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}