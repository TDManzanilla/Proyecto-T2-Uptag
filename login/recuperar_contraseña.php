<?php
session_start();
include ('../app/config.php');

/* Depuración: Ver valores de la sesión
echo "<pre>";
print_r($_SESSION);
echo "</pre>"; */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=APP_NAME;?> - Recuperar Contraseña</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=APP_URL;?>/public/dist/css/adminlte.min.css">
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <h3><b><?=APP_NAME;?></b> - Recuperar Contraseña</h3>
    </div>
    <div class="card">
        <div class="card-body login-card-body">

            <p class="login-box-msg">Por favor, ingresa tu correo electrónico para continuar.</p>

            <!-- Formulario para email -->
            <form action="controller_pass.php" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Validar Correo</button>
                </div>
            </form>

            <?php
            // Verificar si ya se validó el email y se trajeron las preguntas
            if (!empty($_SESSION['preguntas']) && !empty($_SESSION['email_validado'])) {
                $preguntas = $_SESSION['preguntas'];
                $pregunta_aleatoria = $preguntas[array_rand($preguntas)]; // Elegir una pregunta aleatoria
            ?>
                <hr>
                <p class="login-box-msg">Responde la pregunta y cambia tu contraseña.</p>

                <!-- Formulario para preguntas y cambio de contraseña -->
                <form action="validador_contraseña.php" method="post">
                    <div class="form-group">
                        <label><?= $pregunta_aleatoria; ?></label>
                        <!-- Campo oculto para enviar la pregunta seleccionada -->
                        <input type="hidden" name="pregunta_seguridad" value="<?= array_search($pregunta_aleatoria, $preguntas); ?>">
                        <input type="text" name="respuesta_seguridad" class="form-control" placeholder="Respuesta" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="nueva_contraseña" class="form-control" placeholder="Nueva Contraseña" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="repetir_contraseña" class="form-control" placeholder="Repetir Contraseña" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
                    </div>
                </form>

            <?php
            }
            ?>
            <?php include('../layout/mensajes.php'); ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <a href="<?=APP_URL;?>login/logout.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?=APP_URL;?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=APP_URL;?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=APP_URL;?>/public/dist/js/adminlte.min.js"></script>
</body>
</html>
