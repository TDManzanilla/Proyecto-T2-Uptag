<?php

$sql_estudiantes = "SELECT * FROM usuarios as usu 
                INNER JOIN roles as rol ON rol.id_rol = usu.rol_id  
                INNER JOIN personas as per ON per.usuario_id = usu.id_usuario
                INNER JOIN estudiantes as est ON est.persona_id = per.id_persona
                INNER JOIN grados as gra ON gra.id_grado = est.grado_id
                INNER JOIN niveles as niv ON niv.id_nivel = gra.nivel_id
                INNER JOIN nucleo_familiar as nc ON nc.id_ncff = est.nucleo_familiar_id
                where est.estado = '1'";
$query_estudiantes = $pdo->prepare($sql_estudiantes);
$query_estudiantes->execute();
$estudiantes = $query_estudiantes->fetchAll(PDO::FETCH_ASSOC);