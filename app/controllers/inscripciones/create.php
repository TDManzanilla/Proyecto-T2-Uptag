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
    $direccion = mb_strtoupper($_POST['direccion'] ?? '', 'UTF-8');
    $email = $_POST['email'] ?? null;
    $grado_id = $_POST['grado_id'] ?? null;
    $plantel_procedencia = $_POST['plantel_procedencia'] ?? null; // Optional field
    $fecha_ingreso_ins = $_POST['fecha_ingreso_ins'] ?? null;
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
        'fecha_ingreso_ins' => $fecha_ingreso_ins
    ];

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
    $asignacion_id = $sentencia->execute();
    

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

    // Insertar en la tabla estudiantes
    $sentencia = $pdo->prepare('INSERT INTO estudiantes (persona_id, grado_id, plantel_procedencia, estatura, peso, fyh_creacion, estado) 
                                VALUES (:persona_id, :grado_id, :plantel_procedencia, :estatura, :peso, :fyh_creacion, :estado)');
    $sentencia->bindParam(':persona_id', $id_persona);
    $sentencia->bindParam(':grado_id', $grado_id);
    $sentencia->bindParam(':plantel_procedencia', $plantel_procedencia);
    $sentencia->bindParam(':estatura', $estatura);
    $sentencia->bindParam(':peso', $peso);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':estado', $estado_de_registro);

    if (!$sentencia->execute()) {
        throw new Exception("Error al insertar en la tabla estudiantes: " . implode(", ", $sentencia->errorInfo()));
    }

    if ($asignacion_id) {
        // Insertar una nueva nota

        foreach ($asignacion_id as $asignaciones){
        $sentencia = $pdo->prepare('INSERT INTO notas (estudiante_id, asignacion_id, fyh_creacion, estado) 
                                    VALUES (:estudiante_id, :asignacion_id, :fyh_creacion, :estado)');
        $sentencia->bindParam(':estudiante_id', $id_estudiante);
        $sentencia->bindParam(':asignacion_id', $asignaciones);
        $sentencia->bindParam(':fyh_creacion', $fechaHora);
        $sentencia->bindParam(':estado', $estado_notas)

        if (!$sentencia->execute()) {
            throw new Exception("Error al asignar las materias: " . implode(", ", $sentencia->errorInfo()));
        }}
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