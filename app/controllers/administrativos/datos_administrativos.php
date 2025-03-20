<?php
$sql_usuarios = "SELECT * FROM usuarios as usu 
                INNER JOIN roles as rol ON rol.id_rol = usu.rol_id  
                INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
                where usu.estado = '1' AND usu.id_usuario = :id_usuario";
$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->execute([':id_usuario' => $id_usuario]);
$usuarios = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    $nombres = $usuario['nombres'];
    $nombre_rol = $usuario['nombre_rol'];
    $email = $usuario['email'];
    $password = $usuario['password'];
    $fyh_creacion = $usuario['fyh_creacion'];
    $estado = $usuario['estado'];
}
?>