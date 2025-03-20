<?php
//include ('../../config.php');

$sql = "SELECT * FROM usuarios as usu INNER JOIN roles as rol 
                  ON rol.id_rol = usu.rol_id  where usu.estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
?>