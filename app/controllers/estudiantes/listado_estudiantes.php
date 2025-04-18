<?php

$sql_estudiantes = "SELECT * FROM usuarios as usu 
                INNER JOIN roles as rol ON rol.id_rol = usu.rol_id  
                INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
                INNER JOIN estudiantes as est ON est.persona_id = per.id_persona
                INNER JOIN niveles as niv ON niv.id_nivel = est.nivel_id
                INNER JOIN grados as gra ON gra.id_grado = est.grado_id
                INNER JOIN ppffs as ppff ON ppff.estudiantes_id = est.id_estudiante
                where est.estado = '1'";
$query_estudiantes = $pdo->prepare($sql_estudiantes);
$query_estudiantes->execute();
$estudiantes = $query_estudiantes->fetchAll(PDO::FETCH_ASSOC);