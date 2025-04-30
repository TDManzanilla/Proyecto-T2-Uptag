<?php

include ('../../../app/config.php');

try {
    // Recibir datos del formulario
    $rol_id = $_POST['rol_id'] ?? null;
    $nombres = mb_strtoupper($_POST['nombres'] ?? '', 'UTF-8');
    $apellidos = mb_strtoupper($_POST['apellidos'] ?? '', 'UTF-8');
    $ci = $_POST['ci'] ?? null;
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
    $celular = $_POST['celular'] ?? null;
    $profesion = mb_strtoupper($_POST['profesion'] ?? '', 'UTF-8');
    $sexo = mb_strtoupper($_POST['sexo'] ?? '', 'UTF-8');
    $direccion = mb_strtoupper($_POST['direccion'] ?? '', 'UTF-8');
    $email = $_POST['email'] ?? null;
    $grado_id = $_POST['grado_id'] ?? null;
    $plantel_procedencia = mb_strtoupper($_POST['plantel_procedencia'] ?? 'UEN PESTALOZZI', 'UTF-8'); // Optional field
    $fecha_ingreso_ins = $_POST['fecha_ingreso_ins'] ?? null;
    $cedula_hermano = $_POST['cedula_hermano'] ?? null;
    $nombres_apellidos_padre = $_POST['nombres_apellidos_padre'] ?? null;
    $ci_padre = $_POST['ci_padre'] ?? null;
    $celular_padre = $_POST['celular_padre'] ?? null;
    $direccion_padre = $_POST['direccion_padre'] ?? null;
    $profesion_padre = $_POST['profesion_padre'] ?? null;
    $nombres_apellidos_madre = $_POST['nombres_apellidos_madre'] ?? null;
    $ci_madre = $_POST['ci_madre'] ?? null;
    $celular_madre = $_POST['celular_madre'] ?? null;
    $direccion_madre = $_POST['direccion_madre'] ?? null;
    $profesion_madre = $_POST['profesion_madre'] ?? null;
    $nombres_apellido_otros = $_POST['nombres_apellido_otros'] ?? null;
    $ci_otros = $_POST['ci_otros'] ?? null;
    $celular_otros = $_POST['celular_otros'] ?? null;
    $direccion_otros = $_POST['direccion_otros'] ?? null;
    $profesion_otros = $_POST['profesion_otros'] ?? null;
    $parentesco_otros = $_POST['parentesco_otros']  === 'Otro' ? ($_POST['parentesco_especificar'] ?? '') : ($_POST['parentesco_otros'] ?? '');
    $representante = $_POST['representante_institucion'] ?? null;
    $patologia = $_POST['patologia'] === 'Otra' ? ($_POST['otra_patologia'] ?? '') : ($_POST['patologia'] ?? '');
    $alergia = $_POST['alergia'] === 'Otra' ? ($_POST['otra_alergia'] ?? '') : ($_POST['alergia'] ?? '');
    $tipo_sangre = $_POST['tipo_sangre'] ?? null;
    $talla_zapatos = $_POST['talla_zapatos'] ?? null;
    $talla_camisa = $_POST['talla_camisa'] ?? null;
    $talla_pantalon = $_POST['talla_pantalon'] ?? null;
    $estatura = $_POST['estatura'] ?? null;
    $peso = $_POST['peso'] ?? null;
    $discapacidad = $_POST['discapacidad'] === 'Otra' ? ($_POST['descripcion_disc'] ?? '') : ($_POST['discapacidad'] ?? '');
    $condicion = $_POST['condicion'] === 'Otra' ? ($_POST['descripcion_condicion'] ?? '') : ($_POST['condicion'] ?? '');

    // Campos obligatorios
    $required_fields = [
        'rol_id' => $rol_id,
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'ci' => $ci,
        'fecha_nacimiento' => $fecha_nacimiento,
        'email' => $email,
        'grado_id' => $grado_id,
        'fecha_ingreso_ins' => $fecha_ingreso_ins,
        'sexo' => $sexo,
        'direccion' => $direccion,
        'tipo_sangre' => $tipo_sangre,
        'representante' => $representante,
    ];

    // Validar campos adicionales según el representante
    if ($cedula_hermano){
        $representante = 'Hermano';
    } elseif ($representante === 'Madre') {
        $required_fields = array_merge($required_fields, [
            'nombres_apellidos_madre' => $nombres_apellidos_madre,
            'ci_madre' => $ci_madre,
            'celular_madre' => $celular_madre,
            'direccion_madre' => $direccion_madre,
            'profesion_madre' => $profesion_madre,
        ]);
    } elseif ($representante === 'Padre') {
        $required_fields = array_merge($required_fields, [
            'nombres_apellidos_padre' => $nombres_apellidos_padre,
            'ci_padre' => $ci_padre,
            'celular_padre' => $celular_padre,
            'direccion_padre' => $direccion_padre,
            'profesion_padre' => $profesion_padre,
        ]);
    } elseif ($representante === 'Otro') {
        $required_fields = array_merge($required_fields, [
            'nombres_apellido_otros' => $nombres_apellido_otros,
            'ci_otros' => $ci_otros,
            'celular_otros' => $celular_otros,
            'direccion_otros' => $direccion_otros,
            'profesion_otros' => $profesion_otros,
            'parentesco_otros' => $parentesco_otros,
        ]);
    }

    // Validar campos obligatorios
    $missing_fields = [];
    foreach ($required_fields as $field_name => $field_value) {
        if (!$field_value) {
            $missing_fields[] = $field_name;
        }
    }

    if (!empty($missing_fields)) {
        session_start();
        $_SESSION['mensaje'] = "Los siguientes campos son obligatorios: " . implode(', ', $missing_fields) . ".";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }

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

    // Validar existencia del grado_id
    $sentencia = $pdo->prepare('SELECT COUNT(*) FROM grados WHERE id_grado = :grado_id');
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->execute();
    if ($sentencia->fetchColumn() === 0) {
        session_start();
        $_SESSION['mensaje'] = "El grado seleccionado no existe.";
        $_SESSION['icono'] = "error";
        ?><script>window.history.back();</script><?php
        exit;
    }
// Validar existencia de asignaciones
    $sentencia = $pdo->prepare('SELECT id_asignacion FROM asignacion WHERE grado_id = :grado_id');
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->execute();
    $asignacion_id = $sentencia->fetchAll(PDO::FETCH_COLUMN); // Fetch the IDs as an array

    // Iniciar transacción
    $pdo->beginTransaction();

    // Insertar en la tabla usuarios
    $password = password_hash($ci, PASSWORD_DEFAULT);
    $sentencia = $pdo->prepare('INSERT INTO usuarios (rol_id, email, password, fyh_creacion, estado) 
                                VALUES (:rol_id, :email, :password, :fyh_creacion, :estado)');
    $sentencia->bindParam(':rol_id', $rol_id);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->execute();
    $id_usuario = $pdo->lastInsertId();

    // Insertar en la tabla personas
    $sentencia = $pdo->prepare('INSERT INTO personas (usuario_id, nombres, apellidos, ci, fecha_nacimiento, fecha_ingreso_ins, celular, direccion, fyh_creacion, estado, profesion, patologia, alergia, tipo_sangre, talla_zapatos, talla_camisa, talla_pantalon, discapacidad, condicion) 
                                VALUES (:usuario_id, :nombres, :apellidos, :ci, :fecha_nacimiento, :fecha_ingreso, :celular, :direccion, :fyh_creacion, :estado, :profesion, :patologia, :alergia, :tipo_sangre, :talla_zapatos, :talla_camisa, :talla_pantalon, :discapacidad, :condicion)');
    $sentencia->bindParam(':usuario_id', $id_usuario);
    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':apellidos', $apellidos);
    $sentencia->bindParam(':ci', $ci);
    $sentencia->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $sentencia->bindParam(':fecha_ingreso', $fecha_ingreso_ins); // Correct column name
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);
    $sentencia->bindParam(':profesion', $profesion);
    $sentencia->bindParam(':patologia', $patologia);
    $sentencia->bindParam(':alergia', $alergia);
    $sentencia->bindParam(':tipo_sangre', $tipo_sangre);
    $sentencia->bindParam(':talla_zapatos', $talla_zapatos);
    $sentencia->bindParam(':talla_camisa', $talla_camisa);
    $sentencia->bindParam(':talla_pantalon', $talla_pantalon);
    $sentencia->bindParam(':discapacidad', $discapacidad);
    $sentencia->bindParam(':condicion', $condicion);

    if (!$sentencia->execute()) {
        throw new Exception("Error al insertar en la tabla personas: " . implode(", ", $sentencia->errorInfo()));
    }
    $id_persona = $pdo->lastInsertId();

    if ($representante === 'Hermano') {
        // Buscar nucleo familiar donde el hermano pertenece
        $sentencia = $pdo->prepare('SELECT n.id_nucleo_familiar 
                                FROM nucleo_familiar AS n
                                INNER JOIN estudiantes AS e ON n.id_nucleo_familiar = e.nucleo_familiar_id
                                INNER JOIN personas AS p ON e.persona_id = p.id_persona
                                WHERE p.ci = :cedula_hermano');
        $sentencia->bindParam(':cedula_hermano', $cedula_hermano);
        if (!$sentencia->execute()) {
            throw new Exception("Error al buscar el núcleo familiar del hermano: " . implode(", ", $sentencia->errorInfo()));
        }
        $id_nucleo = $sentencia->fetchColumn(); // Obtener el ID del núcleo familiar
    } else{
    // Insertar en la tabla de núcleo familiar
    $sentencia = $pdo->prepare('INSERT INTO nucleo_familiar (representante, nombres_apellidos_padre, ci_padre, celular_padre, direccion_padre, profesion_padre, nombres_apellidos_madre, ci_madre, celular_madre, direccion_madre, profesion_madre, nombres_apellido_otros, ci_otros, celular_otros, direccion_otros, profesion_otros, parentesco_otros, fyh_creacion, estado) 
                                VALUES (:representante, :nombres_apellidos_padre, :ci_padre, :celular_padre, :direccion_padre, :profesion_padre, :nombres_apellidos_madre, :ci_madre, :celular_madre, :direccion_madre, :profesion_madre, :nombres_apellidos_otros, :ci_otros, :celular_otros, :direccion_otros, :profesion_otros, :parentesco_otros, :fyh_creacion, :estado)');
    $sentencia->bindParam(':representante', $representante);
    $sentencia->bindParam(':nombres_apellidos_padre', $nombres_apellidos_padre);
    $sentencia->bindParam(':ci_padre', $ci_padre);
    $sentencia->bindParam(':celular_padre', $celular_padre);
    $sentencia->bindParam(':direccion_padre', $direccion_padre);
    $sentencia->bindParam(':profesion_padre', $profesion_padre);
    $sentencia->bindParam(':nombres_apellidos_madre', $nombres_apellidos_madre);
    $sentencia->bindParam(':ci_madre', $ci_madre);
    $sentencia->bindParam(':celular_madre', $celular_madre);
    $sentencia->bindParam(':direccion_madre', $direccion_madre);
    $sentencia->bindParam(':profesion_madre', $profesion_madre);
    $sentencia->bindParam(':nombres_apellidos_otros', $nombres_apellido_otros);
    $sentencia->bindParam(':ci_otros', $ci_otros);
    $sentencia->bindParam(':celular_otros', $celular_otros);
    $sentencia->bindParam(':direccion_otros', $direccion_otros);
    $sentencia->bindParam(':profesion_otros', $profesion_otros);
    $sentencia->bindParam(':parentesco_otros', $parentesco_otros);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);

    if (!$sentencia->execute()) {
        throw new Exception("Error al insertar en la tabla de núcleo familiar: " . implode(", ", $sentencia->errorInfo()));
    }

    $id_nucleo = $pdo->lastInsertId(); // Obtener el ID del núcleo familiar
    }

    // Insertar en la tabla estudiantes
    $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, grado_id, nucleo_familiar_id, plantel_procedencia, estatura, peso, sexo, fyh_creacion, estado) 
                                VALUES (:persona_id, :grado_id, :nucleo_familiar, :plantel_procedencia, :estatura, :peso, :sexo, :fyh_creacion, :estado)');
    $sentencia->bindParam(':persona_id', $id_persona);
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->bindParam(':nucleo_familiar', $id_nucleo);
    $sentencia->bindParam(':plantel_procedencia', $plantel_procedencia);
    $sentencia->bindParam(':estatura', $estatura);
    $sentencia->bindParam(':peso', $peso);
    $sentencia->bindParam(':sexo', $sexo);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);

    if (!$sentencia->execute()) {
        throw new Exception("Error al insertar en la tabla estudiantes: " . implode(", ", $sentencia->errorInfo()));
    }    
    
    $id_estudiante = $pdo->lastInsertId(); // Obtener el ID del estudiante

    if ($asignacion_id) {
        // Insertar una nueva nota

        foreach ($asignacion_id as $asignaciones){
        $sentencia = $pdo->prepare('INSERT INTO notas (estudiante_id, asignacion_id, fyh_creacion, estado) 
                                    VALUES (:estudiante_id, :asignacion_id, :fyh_creacion, :estado)');
        $sentencia->bindParam(':estudiante_id', $id_estudiante);
        $sentencia->bindParam(':asignacion_id', $asignaciones);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_notas); // Added missing semicolon;

        if (!$sentencia->execute()) {
            throw new Exception("Error al asignar las materias: " . implode(", ", $sentencia->errorInfo()));
        }}
    }    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $usuario_id = $_SESSION['id_usuario'];
    
    $descripcion = 'Registro de estudiante: ' . $nombres . ' ' . $apellidos; // Corregido el operador de concatenación
    // Log the action
        $sql = "INSERT INTO bitacora (usuario_id, descripcion, fecha_hora)
        VALUES (:usuario_id, :descripcion, :fecha_hora)";
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindParam(':usuario_id',$usuario_id);
        $sentencia->bindParam(':descripcion',$descripcion);
        $sentencia->bindParam(':fecha_hora',$fechaHora);
        if (!$sentencia->execute()) {
            throw new Exception("Error al designar el reporte: " . implode(", ", $sentencia->errorInfo()));
        }


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
    error_log("Error: " . $e->getMessage()); // Log the error
    session_start();
    $_SESSION['mensaje'] = "Error al registrar el estudiante: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}