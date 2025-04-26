<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/listado_de_roles.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Crear un nuevo docente</h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?=APP_URL;?>/app/controllers/docentes/create.php" method="post">
                                <div class="row">
                                    <div class="col-md-3">
                                    <div class="form-group">
        <label for="">Nombre del rol</label>
        <div class="form-inline">
            <select name="rol_id_disabled" id="" class="form-control" disabled>
                <?php
                foreach ($roles as $role) { ?>
                    <option value="<?=$role['id_rol'];?>" <?=$role['nombre_rol']=="DOCENTE" ? 'selected' : '';?>>
                        <?=$role['nombre_rol']?>
                    </option>
                <?php } ?>
            </select>
            <!-- Campo oculto para enviar el valor dinámico de rol_id -->
            <?php
            foreach ($roles as $role) {
                if ($role['nombre_rol'] == "DOCENTE") { ?>
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
                                            <input type="text" name="profesion" class="form-control" required>
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
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Ingreso a la Institución</label>
                                            <input type="date" name="fecha_ingreso" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">Direccion</label>
                                            <input type="text" name="direccion" class="form-control" required>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">Datos Físicos y de Salud</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patologia">Patología Crónica</label>
                                            <select name="patologia" id="patologia" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Diabetes">Diabetes</option>
                                                <option value="Hipertensión">Hipertensión</option>
                                                <option value="Asma">Asma</option>
                                                <option value="Otra">Otra</option>
                                            </select>
                                            <input type="text" name="otra_patologia" id="otra_patologia" class="form-control mt-2" placeholder="Especifique" style="display: none;" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alergia">Alergia</label>
                                            <select name="alergia" id="alergia" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Polen">Polen</option>
                                                <option value="Polvo">Polvo</option>
                                                <option value="Leguminosas">Leguminosas</option>
                                                <option value="Gluten">Gluten</option>
                                                <option value="Mariscos">Mariscos</option>
                                                <option value="Frutos secos">Frutos secos</option>
                                                <option value="Otra">Otra</option>
                                            </select>
                                            <input type="text" name="otra_alergia" id="otra_alergia" class="form-control mt-2" placeholder="Especifique" style="display: none;" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discapacidad">Discapacidad</label>
                                            <select name="discapacidad" id="discapacidad" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Amputación de extremidad">Amputación de extremidad</option>
                                                <option value="Incapacidad motriz">Incapacidad motriz</option>
                                            </select>
                                            <input type="text" name="descripcion_disc" id="descripcion_disc" class="form-control mt-2" placeholder="Descripción" style="display: none;" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="condicion">Condición Especial</label>
                                            <select name="condicion" id="condicion" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Sordo">Sordo</option>
                                                <option value="Ciego">Ciego</option>
                                                <option value="Síndrome de Down">Síndrome de Down</option>
                                                <option value="Otra">Otra</option>
                                            </select>
                                            <input type="text" name="descripcion_condicion" id="descripcion_condicion" class="form-control mt-2" placeholder="Descripción" style="display: none;" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_sangre">Tipo de Sangre</label>
                                            <select name="tipo_sangre" id="tipo_sangre" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_camisa">Talla de Camisa</label>
                                            <input type="text" name="talla_camisa" id="talla_camisa" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_pantalon">Talla de Pantalón</label>
                                            <input type="text" name="talla_pantalon" id="talla_pantalon" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="talla_zapatos">Talla de Zapatos</label>
                                            <input type="text" name="talla_zapatos" id="talla_zapatos" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                            <a href="<?=APP_URL;?>/admin/docentes" class="btn btn-secondary">Cancelar</a>
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

<script>
document.getElementById('patologia').addEventListener('change', function () {
        const otraPatologia = document.getElementById('otra_patologia');
        otraPatologia.disabled = this.value !== 'Otra';
        otraPatologia.style.display = this.value === 'Otra' ? 'block' : 'none';
    });

    document.getElementById('alergia').addEventListener('change', function () {
        const otraAlergia = document.getElementById('otra_alergia');
        otraAlergia.disabled = this.value !== 'Otra';
        otraAlergia.style.display = this.value === 'Otra' ? 'block' : 'none';
    });

    document.getElementById('discapacidad').addEventListener('change', function () {
        const descripcionDisc = document.getElementById('descripcion_disc');
        descripcionDisc.disabled = this.value === '';
        descripcionDisc.style.display = this.value !== '' ? 'block' : 'none';
    });

    document.getElementById('condicion').addEventListener('change', function () {
        const descripcionCondicion = document.getElementById('descripcion_condicion');
        descripcionCondicion.disabled = this.value === '';
        descripcionCondicion.style.display = this.value !== '' ? 'block' : 'none';
    });
</script>

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>
