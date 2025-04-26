<?php

$sql_administrativos = "SELECT * FROM usuarios as usu 
INNER JOIN roles as rol ON rol.id_rol = usu.rol_id  
INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
INNER JOIN administrativos as adm ON adm.persona_id = per.id_persona
where adm.estado = '1' AND adm.id_administrativo = :id_administrativo";

$query_administrativos = $pdo->prepare($sql_administrativos);
$query_administrativos->execute([':id_administrativo' => $id_administrativo]);
$administrativos = $query_administrativos->fetchAll(PDO::FETCH_ASSOC);

foreach ($administrativos as $administrativo) {
    $nombres = $administrativo['nombres'];
    $apellidos = $administrativo['apellidos'];
    $ci = $administrativo['ci'];
    $fecha_nacimiento = $administrativo['fecha_nacimiento'];
    $nombre_rol = $administrativo['nombre_rol'];
    $profesion = $administrativo['profesion'];
    $email = $administrativo['email'];
    $estado = $administrativo['estado'];
    $direccion = $administrativo['direccion'];
    $celular = $administrativo['celular'];
    $id_persona = $administrativo['id_persona'];
    $id_usuario = $administrativo['id_usuario'];
}
?>