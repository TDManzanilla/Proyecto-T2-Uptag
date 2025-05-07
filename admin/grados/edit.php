<?php

$id_grado = $_GET['id'];
$curso = $_GET['curso'];
$paralelo = $_GET['paralelo'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

include ('../../app/controllers/grados/datos_grados.php');
include ('../../app/controllers/niveles/listado_de_niveles.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Modificación del grado: <?=$curso;?></h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?=APP_URL;?>/app/controllers/grados/update.php" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nivel</label>
                                            <input type="text" name="id_grado" value="<?=$id_grado;?>" hidden>
                                            <select name="nivel_id" id="" class="form-control">
                                                <?php
                                                foreach ($niveles as $nivele){
                                                    ?>
                                                    <option value="<?=$nivele['id_nivel'];?>"<?=$nivel_id==$nivele['id_nivel'] ? 'selected' : ''?>><?=$nivele['nivel']." - ".$nivele['turno'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Curso</label>
                                            <select name="curso" id="" class="form-control">
                                                <option value="PRIMER AÑO"<?=$curso=='PRIMER AÑO' ? 'selected' : ''?>>1ER AÑO</option>
                                                <option value="SEGUNDO AÑO"<?=$curso=='SEGUNDO AÑO' ? 'selected' : ''?>>2DO AÑO</option>
                                                <option value="TERCER AÑO"<?=$curso=='TERCER AÑO' ? 'selected' : ''?>>3ER AÑO</option>
                                                <option value="CUARTO AÑO"<?=$curso=='CUARTO AÑO' ? 'selected' : ''?>>4TO AÑO</option>
                                                <option value="QUINTO AÑO"<?=$curso=='QUINTO AÑO' ? 'selected' : ''?>>5TO AÑO</option>
                                                <option value="SEXTO AÑO"<?=$curso=='SEXTO AÑO' ? 'selected' : ''?>>6TO AÑO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Turnos</label>
                                            <select name="paralelo" id="" class="form-control">
                                                <option value="A"<?=$paralelo=='A' ? 'selected' : ''?>>A</option>
                                                <option value="B"<?=$paralelo=='B' ? 'selected' : ''?>>B</option>
                                                <option value="C"<?=$paralelo=='C' ? 'selected' : ''?>>C</option>
                                                <option value="D"<?=$paralelo=='D' ? 'selected' : ''?>>D</option>
                                                <option value="E"<?=$paralelo=='E' ? 'selected' : ''?>>E</option>
                                                <option value="F"<?=$paralelo=='F' ? 'selected' : ''?>>F</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                            <a href="<?=APP_URL;?>/admin/grados" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
