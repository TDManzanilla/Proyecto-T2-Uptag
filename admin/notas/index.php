<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Gestión de Notas</h1>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4>Secciones</h4>
                    <select class="form-control" id="selectSeccion">
                        <option value="">Seleccione una sección</option>
                        <!-- Secciones cargadas dinámicamente -->
                    </select>
                </div>
                <div class="col-md-4">
                    <h4>Materias</h4>
                    <select class="form-control" id="selectMateria" disabled>
                        <option value="">Seleccione una materia</option>
                        <!-- Materias cargadas dinámicamente -->
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <a href="habilitar_edicion.php" class="btn btn-secondary mt-4">Habilitar Edición de Notas</a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4 id="docenteAsignado">Docente asignado: </h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Cédula</th>
                                <th>Nota 1</th>
                                <th>Nota 2</th>
                                <th>Nota 3</th>
                                <th>Nota Final</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstudiantes">
                            <tr>
                                <td colspan="6" class="text-center">Seleccione una sección y materia para ver los estudiantes.</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary mt-3" id="guardarNotas" disabled>Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../../admin/layout/parte2.php');
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarSecciones();

        document.getElementById('selectSeccion').addEventListener('change', function () {
            cargarMaterias(this.value);
        });

        document.getElementById('selectMateria').addEventListener('change', function () {
            cargarEstudiantes(document.getElementById('selectSeccion').value, this.value);
        });

        document.getElementById('guardarNotas').addEventListener('click', guardarNotas);
    });

    function cargarSecciones() {
        fetch('../../app/controllers/notas/listado_secciones.php?action=getSections')
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error);
                const selectSeccion = document.getElementById('selectSeccion');
                selectSeccion.innerHTML = '<option value="">Seleccione una sección</option>';
                data.secciones.forEach(seccion => {
                    const option = document.createElement('option');
                    option.value = seccion.seccion;
                    option.textContent = seccion.seccion;
                    selectSeccion.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar secciones:', error));
    }

    function cargarMaterias(seccion) {
        const selectMateria = document.getElementById('selectMateria');
        const lapso = 1; // Asegúrate de definir el lapso aquí (puedes cambiarlo dinámicamente si es necesario)

        if (!seccion) {
            selectMateria.innerHTML = '<option value="">Seleccione una materia</option>';
            selectMateria.disabled = true;
            return;
        }

        fetch(`../../app/controllers/notas/listado_secciones.php?action=getSubjects&seccion=${encodeURIComponent(seccion)}&lapso=${lapso}`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error);
                selectMateria.innerHTML = '<option value="">Seleccione una materia</option>';
                data.materias.forEach(materia => {
                    const option = document.createElement('option');
                    option.value = materia.id_materia;
                    option.textContent = materia.materia;
                    selectMateria.appendChild(option);
                });
                selectMateria.disabled = false;
            })
            .catch(error => console.error('Error al cargar materias:', error));
    }

    function cargarEstudiantes(seccion, materia_id) {
        const tablaEstudiantes = document.getElementById('tablaEstudiantes');
        const docenteAsignado = document.getElementById('docenteAsignado');
        const guardarNotasButton = document.getElementById('guardarNotas');

        if (!seccion || !materia_id) {
            tablaEstudiantes.innerHTML = '<tr><td colspan="6" class="text-center">Seleccione una sección y materia para ver los estudiantes.</td></tr>';
            docenteAsignado.textContent = 'Docente asignado: ';
            guardarNotasButton.disabled = true;
            return;
        }

        fetch(`../../app/controllers/notas/listado_secciones.php?action=getStudents&seccion=${encodeURIComponent(seccion)}&materia_id=${materia_id}`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error);
                tablaEstudiantes.innerHTML = '';
                if (data.estudiantes.length === 0) {
                    tablaEstudiantes.innerHTML = '<tr><td colspan="6" class="text-center">No hay estudiantes asignados a esta sección y materia.</td></tr>';
                    guardarNotasButton.disabled = true;
                    return;
                }

                data.estudiantes.forEach(estudiante => {
                    const estado = estudiante.estado || '000'; // Estado en formato "111"
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${estudiante.nombre_completo}</td>
                        <td>${estudiante.cedula}</td>
                        <td><input type="number" class="form-control" value="${estudiante.nota_1 || ''}" ${estado[0] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" value="${estudiante.nota_2 || ''}" ${estado[1] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" value="${estudiante.nota_3 || ''}" ${estado[2] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" value="${estudiante.nota_final}" disabled></td>
                    `;
                    tablaEstudiantes.appendChild(fila);
                });

                guardarNotasButton.disabled = true; // Disable save button as editing is not allowed
            })
            .catch(error => {
                console.error('Error al cargar los estudiantes:', error);
                Swal.fire('Error', 'Hubo un error al cargar los estudiantes.', 'error');
            });
    }

    function guardarNotas() {
        const notas = [];
        let isValid = true;

        document.querySelectorAll('.nota').forEach(input => {
            let value = parseFloat(input.value);
            if (isNaN(value)) {
                value = 0; // Si el campo está vacío, tomarlo como 0
                input.value = 0; // Actualizar visualmente el campo
            }

            if (value < 0 || value > 20) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
                const materiaId = document.getElementById('selectMateria').value; // Obtener el ID de la materia seleccionada
                notas.push({
                    id_nota: input.dataset.idNota,
                    materia_id: materiaId, // Incluir el ID de la materia
                    nota_1: input.closest('tr').querySelectorAll('.nota')[0].value || 0,
                    nota_2: input.closest('tr').querySelectorAll('.nota')[1].value || 0,
                    nota_3: input.closest('tr').querySelectorAll('.nota')[2].value || 0,
                    nota_final: (
                        parseFloat(input.closest('tr').querySelectorAll('.nota')[0].value || 0) +
                        parseFloat(input.closest('tr').querySelectorAll('.nota')[1].value || 0) +
                        parseFloat(input.closest('tr').querySelectorAll('.nota')[2].value || 0)
                    ) / 3,
                    estado: '1'
                });
            }
        });

        if (!isValid) {
            Swal.fire('Error', 'Las notas deben estar entre 0 y 20.', 'error');
            return;
        }

        fetch('../../app/controllers/notas/guardar_notas.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ notas })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Éxito', data.message, 'success');
                    cargarEstudiantes(document.getElementById('selectSeccion').value, document.getElementById('selectMateria').value);
                } else {
                    Swal.fire('Error', data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Error al guardar las notas:', error);
                Swal.fire('Error', 'Hubo un error al guardar las notas.', 'error');
            });
    }
</script>
