<?php
$sql_docentes = "SELECT * FROM usuarios as usu 
INNER JOIN roles as rol ON rol.id_rol = usu.rol_id  
INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
INNER JOIN docentes as doc ON doc.persona_id = per.id_persona
where doc.estado = '1' AND doc.id_docente = :id_docente";

$query_docentes = $pdo->prepare($sql_docentes);
$query_docentes->execute([':id_docente' => $id_docente]);
$docentes = $query_docentes->fetchAll(PDO::FETCH_ASSOC);

foreach ($docentes as $docente) {
    $nombres = $docente['nombres'];
    $apellidos = $docente['apellidos'];
    $ci = $docente['ci'];
    $fecha_nacimiento = $docente['fecha_nacimiento'];
    $nombre_rol = $docente['nombre_rol'];
    $profesion = $docente['profesion'];
    $email = $docente['email'];
    $estado = $docente['estado'];
    $direccion = $docente['direccion'];
    $celular = $docente['celular'];
    $id_persona = $docente['id_persona'];
    $id_usuario = $docente['id_usuario'];
}
?>