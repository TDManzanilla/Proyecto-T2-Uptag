<?php
// Archivo de configuración para el proyecto

// Aquí puedes agregar tus configuraciones y variables globales
define('SERVIDOR','localhost');
define('USUARIO','root');
define('PASSWORD','');
define('BASEDATOS','proyecto');

define('APP_NAME','CONTROL DE ESTUDIO PESTALOZZI');
define('APP_URL','http://localhost/proyecto/');
define('APP_PATH','C:/xampp/htdocs/proyecto/');
define('KEY_API_MAPS','');

$servidor = "mysql:dbname=".BASEDATOS.";host=".SERVIDOR;
//try{
//    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo "Conexión exitosa";
//}catch(PDOException $e){
//    echo "Error de conexión: ".$e->getMessage();
//}

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexión exitosa"; // Mensaje temporal para verificar la conexión
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}

// Establecer la zona horaria de Venezuela
date_default_timezone_set('America/Caracas');

// Obtener la fecha y hora actual en la zona horaria de Venezuela
$fechahora = date("Y-m-d H:i:s");
$fechaHora = date("Y-m-d H:i:s");
// echo $fechahora;
$fecha_actual = date(format:'Y-m-d');
$dia_actual = date(format: 'd');
$mes_actual = date(format: 'm');
$anno_actual = date(format: 'Y');
// echo "En el dia de hoy: ".$dia_actual." del mes: ".$mes_actual."Del año: ".$anno_actual

$estado_de_registro = '1';

?>