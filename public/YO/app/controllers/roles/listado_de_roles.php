<?php
// SQL query to select all information from the 'roles' table where 'estado' is 'Activo'
$sql_roles = "SELECT * FROM roles WHERE estado = '1'";
$query_roles = $pdo->prepare($sql_roles);
$query_roles->execute();
$roles = $query_roles->fetchAll(fetchstyle: PDO::FETCH_ASSOC);


?>