<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function mostrarMensaje($tipo, $mensaje) {
    echo "<script>
        Swal.fire({
            position: 'center',
            icon: '$tipo',
            title: '$mensaje',
            showConfirmButton: false,
            timer: 5000
        });
    </script>";
}

if (isset($_SESSION['error_message'])) {
    mostrarMensaje('error', $_SESSION['error_message']);
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    mostrarMensaje('success', $_SESSION['success_message']);
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['info_message'])) {
    mostrarMensaje('info', $_SESSION['info_message']);
    unset($_SESSION['info_message']);
}

if( (isset($_SESSION['mensaje'])) && (isset($_SESSION['icono']) )){
    $mensaje = $_SESSION['mensaje'];
    $icono = $_SESSION['icono'];
    ?>
    <script>
        Swal.fire({
            position: "center",
            icon: "<?=$icono;?>",
            title: "<?=$mensaje;?>",
            showConfirmButton: false,
            timer: 5000
        });
    </script>
<?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['icono']);
}
?>