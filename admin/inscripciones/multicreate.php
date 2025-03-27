<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/listado_de_roles.php');
include ('../../app/controllers/grados/listado_de_grados.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$importedData = isset($_SESSION['imported_data']) ? $_SESSION['imported_data'] : [];
unset($_SESSION['imported_data']); // Limpiar los datos después de usarlos
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <h1 class="text-center">Inscripción por Lotes</h1>
            </div>
            <br>
            <!-- Botones para descargar formato e importar datos -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <!-- Botón para descargar el formato -->
                    <button id="download-template" class="btn btn-success btn-lg">
                        Descargar Formato
                    </button>
                </div>
                <div class="col-md-6 text-right">
                    <!-- Formulario para importar datos -->
                    <form action="<?=APP_URL;?>/admin/inscripciones/import_excel.php" method="post" enctype="multipart/form-data" id="importForm">
                        <label for="excelFile" class="btn btn-primary btn-lg">
                            <i class="bi bi-upload"></i> Importar Datos
                        </label>
                        <input type="file" name="excelFile" id="excelFile" class="d-none" accept=".xlsx, .xls" required>
                        <!-- Select para Nivel -->
                        <div class="form-group mt-3">
                            <label for="nivel_id">Nivel</label>
                            <select name="nivel_id" id="nivel_id" class="form-control" required>
                                <option value="">Seleccione un nivel</option>
                                <?php
                                // Extraer niveles únicos de los grados
                                $nivelesUnicos = [];
                                foreach ($grados as $grado) {
                                    if (!isset($nivelesUnicos[$grado['id_nivel']])) {
                                        $nivelesUnicos[$grado['id_nivel']] = $grado['nivel'];
                                    }
                                }
                                foreach ($nivelesUnicos as $idNivel => $nombreNivel): ?>
                                    <option value="<?= $idNivel ?>"><?= $nombreNivel ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Select para Grado -->
                        <div class="form-group mt-3">
                            <label for="grado_id">Grado</label>
                            <select name="grado_id" id="grado_id" class="form-control" required>
                                <option value="">Seleccione un grado</option>
                                <?php foreach ($grados as $grado): ?>
                                    <option value="<?= $grado['id_grado'] ?>">
                                        <?= $grado['curso'] . ' - ' . $grado['paralelo'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulario para registrar estudiantes -->
            <form action="<?=APP_URL;?>/app/controllers/inscripciones/multicreate.php" method="post" id="batch-form">
                <div id="students-container">
                    <!-- Contenedor dinámico para los estudiantes -->
                    <?php if (!empty($importedData)): ?>
                        <?php foreach ($importedData as $index => $data): ?>
                            <div class="card mb-3 student-card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Estudiante #<?= $index + 1 ?></h5>
                                    <button type="button" class="btn btn-danger btn-sm float-right remove-student">Eliminar</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Datos del estudiante -->
                                        <div class="col-md-4">
                                            <h6>Datos del Estudiante</h6>
                                            <div class="form-group">
                                                <label for="">Nombres</label>
                                                <input type="text" name="students[<?= $index ?>][nombres]" class="form-control form-control-sm" value="<?= $data[1] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Apellidos</label>
                                                <input type="text" name="students[<?= $index ?>][apellidos]" class="form-control form-control-sm" value="<?= $data[2] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">CI</label>
                                                <input type="text" name="students[<?= $index ?>][ci]" class="form-control form-control-sm" value="<?= $data[3] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Fecha de Nacimiento</label>
                                                <input type="date" name="students[<?= $index ?>][fecha_nacimiento]" class="form-control form-control-sm" value="<?= $data[4] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="number" name="students[<?= $index ?>][celular]" class="form-control form-control-sm" value="<?= $data[5] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="students[<?= $index ?>][email]" class="form-control form-control-sm" value="<?= $data[6] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Dirección</label>
                                                <input type="text" name="students[<?= $index ?>][direccion]" class="form-control form-control-sm" value="<?= $data[7] ?>" required>
                                            </div>
                                        </div>

                                        <!-- Datos académicos -->
                                        <div class="col-md-4">
                                            <h6>Datos Académicos</h6>
                                            <div class="form-group">
                                                <label for="">Nivel</label>
                                                <select name="students[<?= $index ?>][nivel_id]" class="form-control form-control-sm" required>
                                                    <option value="">Seleccione un nivel</option>
                                                    <?php foreach ($niveles as $nivel): ?>
                                                        <option value="<?= $nivel['id'] ?>"><?= $nivel['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Grado</label>
                                                <select name="students[<?= $index ?>][grado_id]" class="form-control form-control-sm" required>
                                                    <option value="">Seleccione un grado</option>
                                                    <?php foreach ($grados as $grado): ?>
                                                        <option value="<?= $grado['id'] ?>"><?= $grado['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Datos del representante -->
                                        <div class="col-md-4">
                                            <h6>Datos del Representante</h6>
                                            <div class="form-group">
                                                <label for="">Nombres y Apellidos</label>
                                                <input type="text" name="students[<?= $index ?>][nombres_apellidos_ppff]" class="form-control form-control-sm" value="<?= $data[10] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">CI</label>
                                                <input type="text" name="students[<?= $index ?>][ci_ppff]" class="form-control form-control-sm" value="<?= $data[11] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Celular</label>
                                                <input type="number" name="students[<?= $index ?>][celular_ppff]" class="form-control form-control-sm" value="<?= $data[12] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Dirección</label>
                                                <input type="text" name="students[<?= $index ?>][direccion_ppff]" class="form-control form-control-sm" value="<?= $data[13] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Parentesco</label>
                                                <input type="text" name="students[<?= $index ?>][parentesco_ppff]" class="form-control form-control-sm" value="<?= $data[14] ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Si no hay datos importados, muestra una fila vacía -->
                        <div class="card mb-3 student-card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Estudiante #1</h5>
                                <button type="button" class="btn btn-danger btn-sm float-right remove-student">Eliminar</button>
                            </div>
                            <div class="card-body">
                                <!-- Campos vacíos aquí -->
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-student" class="btn btn-success btn-lg mt-3">Agregar Estudiante</button>
                <br><br>
                <button type="submit" class="btn btn-primary btn-lg">Registrar Lote</button>
                <a href="<?=APP_URL;?>/admin/inscripciones" class="btn btn-secondary btn-lg">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script>
    let studentIndex = 1;

    // Agregar un nuevo formulario de estudiante
    document.getElementById('add-student').addEventListener('click', function () {
        const container = document.getElementById('students-container');
        const newCard = document.querySelector('.student-card').cloneNode(true);
        newCard.querySelectorAll('input, select').forEach(function (input) {
            input.name = input.name.replace(/\[\d+\]/, `[${studentIndex}]`);
            if (input.type !== 'hidden') input.value = '';
        });
        newCard.querySelector('.card-title').textContent = `Estudiante #${studentIndex + 1}`;
        container.appendChild(newCard);
        studentIndex++;
    });

    // Eliminar un formulario de estudiante
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-student')) {
            e.target.closest('.student-card').remove();
        }
    });

    // Enviar formulario automáticamente al seleccionar archivo
    document.getElementById('excelFile').addEventListener('change', function () {
        document.getElementById('importForm').submit();
    });

    document.getElementById('download-template').addEventListener('click', function () {
        const url = '<?=APP_URL;?>/admin/inscripciones/generate_template.php';
        const link = document.createElement('a');
        link.href = url;
        link.download = 'plantilla_inscripcion_lotes.xlsx';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>

<?php
include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');
?>