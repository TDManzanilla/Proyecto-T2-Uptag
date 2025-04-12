<?php
include ('../../../app/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $pdo->beginTransaction();

    $nivel_id = $_SESSION['nivel_id'];
    $grado_id = $_SESSION['grado_id'];

    foreach ($_POST['students'] as $student) {
        // Validar duplicados: CI
        $sentencia = $pdo->prepare('SELECT COUNT(*) FROM personas WHERE ci = :ci');
        $sentencia->bindParam(':ci', $student['ci']);
        $sentencia->execute();
        if ($sentencia->fetchColumn() > 0) {
            throw new Exception("El número de cédula de identidad {$student['ci']} ya está registrado.");
        }

        // Validar duplicados: Email
        $sentencia = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
        $sentencia->bindParam(':email', $student['email']);
        $sentencia->execute();
        if ($sentencia->fetchColumn() > 0) {
            throw new Exception("El correo electrónico {$student['email']} ya está registrado.");
        }

        // Insertar en la tabla usuarios
        $password = password_hash($student['ci'], PASSWORD_DEFAULT);
        $sentencia = $pdo->prepare('INSERT INTO usuarios (rol_id, email, password, fyh_creacion, estado) 
                                    VALUES (:rol_id, :email, :password, :fyh_creacion, :estado)');
        $sentencia->bindParam(':rol_id', $student['rol_id']);
        $sentencia->bindParam(':email', $student['email']);
        $sentencia->bindParam(':password', $password);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
        $id_usuario = $pdo->lastInsertId();

        // Insertar en la tabla personas
        $sentencia = $pdo->prepare('INSERT INTO personas (usuario_id, nombres, apellidos, ci, fecha_nacimiento, celular, direccion, fyh_creacion, estado, profesion) 
                                    VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :celular, :direccion, :fyh_creacion, :estado, :profesion)');
        $sentencia->bindParam(':usuario_id', $id_usuario);
        $sentencia->bindParam(':nombres', $student['nombres']);
        $sentencia->bindParam(':apellidos', $student['apellidos']);
        $sentencia->bindParam(':ci', $student['ci']);
        $sentencia->bindParam(':fecha_nacimiento', $student['fecha_nacimiento']);
        $sentencia->bindParam(':celular', $student['celular']);
        $sentencia->bindParam(':direccion', $student['direccion']);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->bindParam(':profesion', $student['profesion']);
        $sentencia->execute();
        $id_persona = $pdo->lastInsertId();

        // Insertar en la tabla estudiantes
        $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, nivel_id, grado_id, fyh_creacion, estado) 
                                    VALUES (:persona_id, :nivel_id, :grado_id, :fyh_creacion, :estado)');
        $sentencia->bindParam(':persona_id', $id_persona);
        $sentencia->bindParam(':nivel_id', $nivel_id); // Nivel global
        $sentencia->bindParam(':grado_id', $grado_id); // Grado global
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
        $id_estudiante = $pdo->lastInsertId();

        // Validar que al menos uno de los conjuntos esté completo
        if (empty($student['nombres_apellidos_padre']) && empty($student['nombres_apellidos_madre']) && empty($student['nombres_apellido_otros'])) {
            throw new Exception("Debe llenar al menos uno de los conjuntos: Padre, Madre u Otro parentesco para el estudiante con CI {$student['ci']}.");
        }

        // Validar que el representante seleccionado tenga datos válidos
        $representante_institucion = $student['representante_institucion'];
        if ($representante_institucion === 'padre' && empty($student['nombres_apellidos_padre'])) {
            throw new Exception("El representante seleccionado (Padre) no tiene datos válidos para el estudiante con CI {$student['ci']}.");
        }
        if ($representante_institucion === 'madre' && empty($student['nombres_apellidos_madre'])) {
            throw new Exception("El representante seleccionado (Madre) no tiene datos válidos para el estudiante con CI {$student['ci']}.");
        }
        if ($representante_institucion === 'otro' && empty($student['nombres_apellido_otros'])) {
            throw new Exception("El representante seleccionado (Otro) no tiene datos válidos para el estudiante con CI {$student['ci']}.");
        }

        // Insertar en la tabla nucleo_familiar
        $sentencia = $pdo->prepare('INSERT INTO nucleo_familiar (
            nuclestudiante_id, nombres_apellidos_padre, ci_padre, celular_padre, direccion_padre, profesion_padre,
            nombres_apellidos_madre, ci_madre, celular_madre, direccion_madre, profesion_madre,
            nombres_apellido_otros, ci_otros, celular_otros, direccion_otros, profesion_otros, parentesco_otros, estado
        ) VALUES (
            :nuclestudiante_id, :nombres_apellidos_padre, :ci_padre, :celular_padre, :direccion_padre, :profesion_padre,
            :nombres_apellidos_madre, :ci_madre, :celular_madre, :direccion_madre, :profesion_madre,
            :nombres_apellido_otros, :ci_otros, :celular_otros, :direccion_otros, :profesion_otros, :parentesco_otros, :estado
        )');
        $sentencia->bindParam(':nuclestudiante_id', $id_estudiante);
        $sentencia->bindParam(':nombres_apellidos_padre', $student['nombres_apellidos_padre']);
        $sentencia->bindParam(':ci_padre', $student['ci_padre']);
        $sentencia->bindParam(':celular_padre', $student['celular_padre']);
        $sentencia->bindParam(':direccion_padre', $student['direccion_padre']);
        $sentencia->bindParam(':profesion_padre', $student['profesion_padre']);
        $sentencia->bindParam(':nombres_apellidos_madre', $student['nombres_apellidos_madre']);
        $sentencia->bindParam(':ci_madre', $student['ci_madre']);
        $sentencia->bindParam(':celular_madre', $student['celular_madre']);
        $sentencia->bindParam(':direccion_madre', $student['direccion_madre']);
        $sentencia->bindParam(':profesion_madre', $student['profesion_madre']);
        $sentencia->bindParam(':nombres_apellido_otros', $student['nombres_apellido_otros']);
        $sentencia->bindParam(':ci_otros', $student['ci_otros']);
        $sentencia->bindParam(':celular_otros', $student['celular_otros']);
        $sentencia->bindParam(':direccion_otros', $student['direccion_otros']);
        $sentencia->bindParam(':profesion_otros', $student['profesion_otros']);
        $sentencia->bindParam(':parentesco_otros', $student['parentesco_otros']);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
        $id_nucleo_familiar = $pdo->lastInsertId();

        // Determinar el representante
        $parentesco_nucleo = 0; // Por defecto, madre
        if ($student['representante_institucion'] === 'padre') {
            $parentesco_nucleo = 1;
        } elseif ($student['representante_institucion'] === 'otro') {
            $parentesco_nucleo = 2; // Otro
        }

        // Insertar en la tabla ppffs
        $sentencia = $pdo->prepare('INSERT INTO ppffs (estudiantes_id, nucleo_familiar_id, parentesco_nucleo, fyh_creacion, estado) 
                                    VALUES (:estudiantes_id, :nucleo_familiar_id, :parentesco_nucleo, :fyh_creacion, :estado)');
        $sentencia->bindParam(':estudiantes_id', $id_estudiante);
        $sentencia->bindParam(':nucleo_familiar_id', $id_nucleo_familiar);
        $sentencia->bindParam(':parentesco_nucleo', $parentesco_nucleo);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->execute();
    }

    $pdo->commit();

    $_SESSION['mensaje'] = "Estudiantes registrados correctamente.";
    $_SESSION['icono'] = "success";
    header('Location: ' . APP_URL . '/admin/inscripciones');
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['mensaje'] = "Error al registrar los estudiantes: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}