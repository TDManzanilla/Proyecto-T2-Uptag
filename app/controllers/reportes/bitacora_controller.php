<?php

function logAction($usuario_id,$descripcion) {
        $sql = "INSERT INTO bitacora (usuario_id, descripcion, fecha_hora)
        VALUES (:usuario_id, :descripcion, :fecha_hora)";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':usuario_id',$usuario_id);
        $sentencia->bindParam(':descripcion',$descripcion);
        $sentencia->bindParam(':fecha_hora',new date());
        $sentencia->execute();

    }


function getBitacora() {
        $sql = "SELECT b.descripcion, b.fecha_hora, u.email, p.ci 
                FROM bitacora b
                INNER JOIN usuarios u ON b.usuario_id = u.id_usuario
                INNER JOIN personas p ON u.id_usuario = p.usuario_id
                ORDER BY b.fecha_hora DESC";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


