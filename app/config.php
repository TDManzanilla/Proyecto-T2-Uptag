<?php
define('SERVIDOR','localhost');
define('USUARIO','root');
define('PASSWORD','');
define('BD','proyecto');
define('BASEDATOS','proyecto');

define('APP_NAME','CONTROL DE ESTUDIO PESTALOZZI');
define('APP_URL','http://localhost/proyecto/');
define('APP_PATH','C:/xampp/htdocs/proyecto/');
define('KEY_API_MAPS','');

$servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

try{
    $pdo = new PDO($servidor,USUARIO,PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
    //echo "conexión existosa a la base de datos";
}catch (PDOException $e){
    print_r($e);
    echo "error no se pudo conectar a la base de datos";
}

date_default_timezone_set("America/Caracas");
$fechahora = date('Y-m-d H:i:s');
$fechaHora = date('Y-m-d H:i:s');

$fecha_actual = date('Y-m-d');
$dia_actual = date('d');
$mes_actual = date('m');
$ano_actual = date('Y');

$estado_de_registro = '1';
$estado_notas = '100';

//require APP_PATH.'vendor/autoload.php';
