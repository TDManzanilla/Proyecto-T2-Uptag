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
                                                <select name="nivel_id" id="nivel_id" class="form-control" onchange="filtrarGrados()" required>
                                                    <option value="">Seleccione un nivel</option>
                                                    <?php
                                                    $nivelesVistos = [];
                                                    foreach ($grados as $grado) {
                                                        if (!in_array($grado['nivel'] . '-' . $grado['turno'], $nivelesVistos)) {
                                                            $nivelesVistos[] = $grado['nivel'] . '-' . $grado['turno']; ?>
                                                            <option value="<?=$grado['id_nivel'];?>"><?=$grado['nivel']." - ".$grado['turno']?></option>
                                                        <?php }
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
                                                <select name="grado_id" id="grado_id" class="form-control" required>
                                                    <option value="">Seleccione un grado</option>
                                                    <?php foreach ($grados as $grado): ?>
                                                        <option value="<?=$grado['id_grado'];?>" data-nivel="<?=$grado['id_nivel'];?>">
                                                            <?=$grado['curso']." - ".$grado['paralelo']?>
                                                        </option>
                                                    <?php endforeach; ?>
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
                                <!-- DATOS DEL PADRE -->
                                <h4>DATOS DEL PADRE</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombres y Apellidos</label>
                                            <input type="text" name="nombres_apellidos_padre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Cedula de Identidad</label>
                                            <input type="text" name="ci_padre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular_padre" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dirección</label>
                                            <input type="text" name="direccion_padre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Profesión</label>
                                            <input type="text" name="profesion_padre" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <!-- DATOS DE LA MADRE -->
                                <h4>DATOS DE LA MADRE</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombres y Apellidos</label>
                                            <input type="text" name="nombres_apellidos_madre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Cedula de Identidad</label>
                                            <input type="text" name="ci_madre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Celular</label>
                                            <input type="number" name="celular_madre" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dirección</label>
                                            <input type="text" name="direccion_madre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Profesión</label>
                                            <input type="text" name="profesion_madre" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <!-- OTRO PARENTESCO FAMILIAR -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="otroParentescoCheckbox">
                                    <label class="form-check-label" for="otroParentescoCheckbox">Otro parentesco familiar</label>
                                </div>
                                <div id="otroParentescoForm" style="display: none;">
                                    <h4>OTRO PARENTESCO FAMILIAR</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Nombres y Apellidos</label>
                                                <input type="text" name="nombres_apellido_otros" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Cedula de Identidad</label>
                                                <input type="text" name="ci_otros" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="number" name="celular_otros" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Dirección</label>
                                                <input type="text" name="direccion_otros" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Profesión</label>
                                                <input type="text" name="profesion_otros" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="parentesco_otros">Tipo de Parentesco</label>
                                        <select name="parentesco_otros" id="parentesco_otros" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="abuelo">Abuelo</option>
                                            <option value="abuela">Abuela</option>
                                            <option value="tio">Tío</option>
                                            <option value="tia">Tía</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="parentescoEspecificar" style="display: none;">
                                        <label for="">Especificar Parentesco</label>
                                        <input type="text" name="parentesco_especificar" class="form-control">
                                    </div>
                                </div>
                                <hr>

                                <!-- REPRESENTANTE EN LA INSTITUCIÓN -->
                                <h4>Representante en la institución</h4>
                                <div class="form-group">
                                    <select name="representante_institucion" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="madre">Madre</option>
                                        <option value="padre">Padre</option>
                                        <option value="otro">Otro</option>
                                    </select>
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

<script>
    // Mostrar/Ocultar formulario de otro parentesco familiar
    document.getElementById('otroParentescoCheckbox').addEventListener('change', function () {
        const form = document.getElementById('otroParentescoForm');
        form.style.display = this.checked ? 'block' : 'none';
    });

    // Habilitar/Deshabilitar campo de especificar parentesco
    document.getElementById('parentesco_otros').addEventListener('change', function () {
        const especificar = document.getElementById('parentescoEspecificar');
        especificar.style.display = this.value === 'otros' ? 'block' : 'none';
    });

    function filtrarGrados() {
        const nivelId = document.getElementById('nivel_id').value;
        const gradoSelect = document.getElementById('grado_id');
        const opciones = gradoSelect.querySelectorAll('option');

        opciones.forEach(opcion => {
            if (opcion.value === "") {
                opcion.style.display = "block"; // Mostrar la opción "Seleccione un grado"
            } else if (opcion.getAttribute('data-nivel') === nivelId) {
                opcion.style.display = "block"; // Mostrar grados del nivel seleccionado
            } else {
                opcion.style.display = "none"; // Ocultar grados de otros niveles
            }
        });

        gradoSelect.value = ""; // Reiniciar selección de grados
    }
</script>

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>
