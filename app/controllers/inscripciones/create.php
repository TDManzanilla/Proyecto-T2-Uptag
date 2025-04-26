<?php

include ('../../../app/config.php');

try {
    // Recibir datos del formulario
    $rol_id = $_POST['rol_id'];
    $nombres = mb_strtoupper($_POST['nombres'], 'UTF-8');
    $apellidos = mb_strtoupper($_POST['apellidos'], 'UTF-8');
    $ci = $_POST['ci'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $celular = $_POST['celular'];
    $profesion = mb_strtoupper($_POST['profesion'], 'UTF-8'); // Aseguramos que se incluya
    $direccion = mb_strtoupper($_POST['direccion'], 'UTF-8');
    $email = $_POST['email'];
    $nivel_id = $_POST['nivel_id'];
    $grado_id = $_POST['grado_id'];
    $cedula_hermano = $_POST['cedula_hermano'] ?? '';

    $plantel_procedencia = $_POST['plantel_procedencia'];
    $fecha_ingreso_ins = $_POST['fecha_ingreso_ins'];
    $patologia = $_POST['patologia'] === 'Otra' ? $_POST['otra_patologia'] : $_POST['patologia'];
    $alergia = $_POST['alergia'] === 'Otra' ? $_POST['otra_alergia'] : $_POST['alergia'];
    $tipo_sangre = $_POST['tipo_sangre'];
    $talla_zapatos = $_POST['talla_zapatos'];
    $talla_camisa = $_POST['talla_camisa'];
    $talla_pantalon = $_POST['talla_pantalon'];
    $estatura = $_POST['estatura'];
    $peso = $_POST['peso'];
    $discapacidad = $_POST['discapacidad'] === 'Otra' ? $_POST['descripcion_disc'] : $_POST['discapacidad'];
    $condicion = $_POST['condicion'] === 'Otra' ? $_POST['descripcion_condicion'] : $_POST['condicion'];

    // Datos del representante
    $nombres_apellidos_ppff = mb_strtoupper($_POST['nombres_apellidos_ppff'], 'UTF-8');
    $ci_ppff = $_POST['ci_ppff'];
    $celular_ppff = $_POST['celular_ppff'];
    $direccion_ppff = mb_strtoupper($_POST['direccion_ppff'], 'UTF-8');
    $parentesco_ppff = mb_strtoupper($_POST['parentesco_ppff'], 'UTF-8');

    // Datos de referencia
    $ref_nombre_apellido_ppff = mb_strtoupper($_POST['ref_nombre_apellido_ppff'], 'UTF-8');
    $ref_celular_ppff = $_POST['ref_celular_ppff'];
    $ref_parentesco_ppff = mb_strtoupper($_POST['ref_parentesco_ppff'], 'UTF-8');

    // Validar duplicados: CI
    $sentencia = $pdo->prepare('SELECT COUNT(*) FROM personas WHERE ci = :ci');
    $sentencia->bindParam(':ci', $ci);
    $sentencia->execute();
    if ($sentencia->fetchColumn() > 0) {
        session_start();
        $_SESSION['mensaje'] = "El número de cédula de identidad ya está registrado.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Validar duplicados: Email
    $sentencia = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE email = :email');
    $sentencia->bindParam(':email', $email);
    $sentencia->execute();
    if ($sentencia->fetchColumn() > 0) {
        session_start();
        $_SESSION['mensaje'] = "El correo electrónico ya está registrado.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Validar que al menos uno de los conjuntos esté completo
    if (empty($_POST['nombres_apellidos_padre']) && empty($_POST['nombres_apellidos_madre']) && empty($_POST['nombres_apellido_otros'])) {
        session_start();
        $_SESSION['mensaje'] = "Debe llenar al menos uno de los conjuntos: Padre, Madre u Otro parentesco.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Validar que el representante seleccionado tenga datos válidos
    $representante_institucion = $_POST['representante_institucion'];
    if ($representante_institucion === 'padre' && empty($_POST['nombres_apellidos_padre'])) {
        session_start();
        $_SESSION['mensaje'] = "El representante seleccionado (Padre) no tiene datos válidos.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }
    if ($representante_institucion === 'madre' && empty($_POST['nombres_apellidos_madre'])) {
        session_start();
        $_SESSION['mensaje'] = "El representante seleccionado (Madre) no tiene datos válidos.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }
    if ($representante_institucion === 'otro' && empty($_POST['nombres_apellido_otros'])) {
        session_start();
        $_SESSION['mensaje'] = "El representante seleccionado (Otro) no tiene datos válidos.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // Insertar en la tabla usuarios
    $password = password_hash($ci, PASSWORD_DEFAULT); // Contraseña encriptada
    $sentencia = $pdo->prepare('INSERT INTO usuarios (rol_id, email, password, fyh_creacion, estado) 
                                VALUES (:rol_id, :email, :password, :fyh_creacion, :estado)');
    $sentencia->bindParam(':rol_id', $rol_id); // Usar el valor enviado desde el formulario
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();
    $id_usuario = $pdo->lastInsertId();

    // Insertar en la tabla personas
    $sentencia = $pdo->prepare('INSERT INTO personas (usuario_id, nombres, apellidos, ci, fecha_nacimiento, celular, direccion, fyh_creacion, estado, profesion, patologia, alergia, tipo_sangre, talla_zapatos, talla_camisa, talla_pantalon, discapacidad, condicion) 
                                VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :celular, :direccion, :fyh_creacion, :estado, :profesion, :patologia, :alergia, :tipo_sangre, :talla_zapatos, :talla_camisa, :talla_pantalon, :discapacidad, :condicion)');
    $sentencia->bindParam(':usuario_id', $id_usuario);
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':apellidos', $apellidos);
    $sentencia->bindParam(':ci', $ci);
    $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->bindParam(':profesion', $profesion); // Incluimos la profesión
    $sentencia->bindParam(':patologia', $patologia);
    $sentencia->bindParam(':alergia', $alergia);
    $sentencia->bindParam(':tipo_sangre', $tipo_sangre);
    $sentencia->bindParam(':talla_zapatos', $talla_zapatos);
    $sentencia->bindParam(':talla_camisa', $talla_camisa);
    $sentencia->bindParam(':talla_pantalon', $talla_pantalon);
    $sentencia->bindParam(':discapacidad', $discapacidad);
    $sentencia->bindParam(':condicion', $condicion);
    $sentencia->execute();
    $id_persona = $pdo->lastInsertId();

    // Insertar en la tabla estudiantes
    $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, nivel_id, grado_id, plantel_procedencia, fecha_ingreso_ins, estatura, peso, fyh_creacion, estado) 
                                VALUES (:persona_id, :nivel_id, :grado_id, :plantel_procedencia, :fecha_ingreso_ins, :estatura, :peso, :fyh_creacion, :estado)');
    $sentencia->bindParam(':persona_id', $id_persona);
    $sentencia->bindParam(':nivel_id', $nivel_id);
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->bindParam(':plantel_procedencia', $plantel_procedencia);
    $sentencia->bindParam(':fecha_ingreso_ins', $fecha_ingreso_ins);
    $sentencia->bindParam(':estatura', $estatura);
    $sentencia->bindParam(':peso', $peso);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();
    $id_estudiante = $pdo->lastInsertId();

    if (!empty($cedula_hermano)) {
        // Buscar el nuclestudiante_id del hermano
        $sentencia = $pdo->prepare('
            SELECT nf.nuclestudiante_id 
            FROM nucleo_familiar nf
            INNER JOIN estudiantes e ON nf.nuclestudiante_id = e.id_estudiante
            INNER JOIN personas p ON e.persona_id = p.id_persona
            WHERE p.ci = :ci
        ');
        $sentencia->bindParam(':ci', $cedula_hermano);
        $sentencia->execute();
        $nuclestudiante_id = $sentencia->fetchColumn();

        if (!$nuclestudiante_id) {
            throw new Exception("No se encontró un núcleo familiar para la cédula proporcionada.");
        }

        // Buscar el ppffs del hermano
        $sentencia = $pdo->prepare('
            SELECT parentesco_nucleo 
            FROM ppffs 
            WHERE estudiantes_id = :estudiantes_id
        ');
        $sentencia->bindParam(':estudiantes_id', $nuclestudiante_id);
        $sentencia->execute();
        $parentesco_nucleo = $sentencia->fetchColumn();

        if (!$parentesco_nucleo) {
            throw new Exception("No se encontró un representante para el estudiante con la cédula proporcionada.");
        }
    } else {
        // Insertar en la tabla nucleo_familiar
        $sentencia = $pdo->prepare('INSERT INTO nucleo_familiar (
            nuclestudiante_id, nombres_apellidos_padre, ci_padre, celular_padre, direccion_padre, profesion_padre,
            nombres_apellidos_madre, ci_madre, celular_madre, direccion_madre, profesion_madre,
            nombres_apellido_otros, ci_otros, celular_otros, direccion_otros, profesion_otros, parentesco_otros, estado, fyh_creacion
        ) VALUES (
            :nuclestudiante_id, :nombres_apellidos_padre, :ci_padre, :celular_padre, :direccion_padre, :profesion_padre,
            :nombres_apellidos_madre, :ci_madre, :celular_madre, :direccion_madre, :profesion_madre,
            :nombres_apellido_otros, :ci_otros, :celular_otros, :direccion_otros, :profesion_otros, :parentesco_otros, :estado, :fyh_creacion
        )');
        $sentencia->bindParam(':nuclestudiante_id', $id_estudiante);
        $sentencia->bindParam(':nombres_apellidos_padre', $_POST['nombres_apellidos_padre']);
        $sentencia->bindParam(':ci_padre', $_POST['ci_padre']);
        $sentencia->bindParam(':celular_padre', $_POST['celular_padre']);
        $sentencia->bindParam(':direccion_padre', $_POST['direccion_padre']);
        $sentencia->bindParam(':profesion_padre', $_POST['profesion_padre']);
        $sentencia->bindParam(':nombres_apellidos_madre', $_POST['nombres_apellidos_madre']);
        $sentencia->bindParam(':ci_madre', $_POST['ci_madre']);
        $sentencia->bindParam(':celular_madre', $_POST['celular_madre']);
        $sentencia->bindParam(':direccion_madre', $_POST['direccion_madre']);
        $sentencia->bindParam(':profesion_madre', $_POST['profesion_madre']);
        $sentencia->bindParam(':nombres_apellido_otros', $_POST['nombres_apellido_otros']);
        $sentencia->bindParam(':ci_otros', $_POST['ci_otros']);
        $sentencia->bindParam(':celular_otros', $_POST['celular_otros']);
        $sentencia->bindParam(':direccion_otros', $_POST['direccion_otros']);
        $sentencia->bindParam(':profesion_otros', $_POST['profesion_otros']);
        $sentencia->bindParam(':parentesco_otros', $_POST['parentesco_otros']);
        $sentencia->bindParam(':estado', $estado_de_registro);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->execute();
        $nuclestudiante_id = $pdo->lastInsertId();

        // Determinar el representante
        $parentesco_nucleo = 0; // Por defecto, madre
        if ($_POST['representante_institucion'] === 'padre') {
            $parentesco_nucleo = 1;
        } elseif ($_POST['representante_institucion'] === 'otro') {
            $parentesco_nucleo = 2; // Otro
        }
    }

    // Insertar en la tabla ppffs
    $sentencia = $pdo->prepare('INSERT INTO ppffs (estudiantes_id, parentesco_nucleo, fyh_creacion, estado) 
                                VALUES (:estudiantes_id, :parentesco_nucleo, :fyh_creacion, :estado)');
    $sentencia->bindParam(':estudiantes_id', $id_estudiante);
    $sentencia->bindParam(':parentesco_nucleo', $parentesco_nucleo);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();

    // Confirmar transacción
    $pdo->commit();

    // Redirigir con mensaje de éxito
    session_start();
    $_SESSION['mensaje'] = "Estudiante registrado correctamente.";
    $_SESSION['icono'] = "success";
    header('Location: ' . APP_URL . '/admin/inscripciones');
} catch (Exception $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    session_start();
    $_SESSION['mensaje'] = "Error al registrar el estudiante: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}