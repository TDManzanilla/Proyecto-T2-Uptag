<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Inscripciones: <?=$ano_actual?></h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="bi bi-person-video"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Inscripciones</b></span>
                            <a href="create.php" class="btn btn-primary btn-sm">Nuevo Estudiante</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="bi bi-people"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Importar Estudiantes</b></span>
                            <a href="importar/" class="btn btn-success btn-sm">Importar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>

