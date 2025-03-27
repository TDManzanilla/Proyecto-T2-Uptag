<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/listado_de_roles.php');
include ('../../app/controllers/grados/listado_de_grados.php')

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Crear un nuevo estudiante</h1>
            </div>
            <br>
            <form action="<?=APP_URL;?>/app/controllers/inscripciones/create.php" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Llene los datos del estudiante</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-3">
    <div class="form-group">
        <label for="">Nombre del rol</label>
        <div class="form-inline">
            <select name="rol_id_disabled" id="" class="form-control" disabled>
                <?php
                foreach ($roles as $role) { ?>
                    <option value="<?=$role['id_rol'];?>" <?=$role['nombre_rol']=="ESTUDIANTE" ? 'selected' : '';?>>
                        <?=$role['nombre_rol']?>
                    </option>
                <?php } ?>
            </select>
            <!-- Campo oculto para enviar el valor dinámico de rol_id -->
            <?php
            foreach ($roles as $role) {
                if ($role['nombre_rol'] == "ESTUDIANTE") { ?>
                    <input type="hidden" name="rol_id" value="<?=$role['id_rol'];?>">
                <?php }
            }
            ?>
            <a href="<?=APP_URL;?>/admin/roles/create.php" style="margin-left: 5px" class="btn btn-primary">
                <i class="bi bi-file-plus"></i>
            </a>
        </div>
    </div>
</div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" name="apellidos" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Cedula de Identidad</label>
                                            <input type="text" name="ci" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Fecha de Nacimiento</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Cargo</label>
                                            <input type="text" name="profesion" class="form-control" value="ESTUDIANTE" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Direccion</label>
                                            <input type="text" name="direccion" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">Llene los datos académicos</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Niveles</label>
                                            <div class="form-inline">
                                                <select name="nivel_id" id="" class="form-control">
                                                    <?php
                                                    foreach ($grados as $grado){ ?>
                                                        <option value="<?=$grado['id_nivel'];?>"><?=$grado['nivel']." - ".$grado['turno']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Grados</label>
                                            <div class="form-inline">
                                                <select name="grado_id" id="" class="form-control">
                                                    <?php
                                                    foreach ($grados as $grado){ ?>
                                                        <option value="<?=$grado['id_grado'];?>"><?=$grado['curso']." - ".$grado['paralelo']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Llene los datos del representante</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombres y Apellidos</label>
                                            <input type="text" name="nombres_apellidos_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Cedula de Identidad</label>
                                            <input type="text" name="ci_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dirección</label>
                                            <input type="text" name="direccion_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Parentesco</label>
                                            <input type="text" name="parentesco_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title">Otro contacto de referencia</h3>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombre y Apellido</label>
                                            <input type="text" name="ref_nombre_apellido_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="ref_celular_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Parentesco</label>
                                            <input type="text" name="ref_parentesco_ppff" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                        <a href="<?=APP_URL;?>/admin/inscripciones" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>
