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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarSecciones();

        document.getElementById('selectSeccion').addEventListener('change', function () {
            console.log(this.value)

            cargarMaterias(this.value);
        });

        document.getElementById('selectMateria').addEventListener('change', function () {
            cargarEstudiantes(document.getElementById('selectSeccion').value, this.value);
        });

        document.getElementById('guardarNotas').addEventListener('click', guardarNotas);
    });

    function cargarSecciones() {
        fetch('../../app/controllers/notas/listado_secciones.php')
            .then(response => response.json())
            .then(data => {
                const selectSeccion = document.getElementById('selectSeccion');
                selectSeccion.innerHTML = '<option value="">Seleccione una sección</option>';
                data.secciones.forEach(seccion => {
                    const option = document.createElement('option');
                    option.value = seccion.curso +' '+seccion.paralelo;
                    option.textContent = seccion.curso +' '+seccion.paralelo;
                    selectSeccion.appendChild(option);
                });
            });
    }

    function cargarMaterias(seccion) {
        if (!seccion) return;
        fetch(`../../app/controllers/docentes/asignaciones/listado_materias_por_seccion.php?seccion=${encodeURIComponent(seccion)}`)
            .then(response => response.json())
            .then(data => {
                const selectMateria = document.getElementById('selectMateria');
                selectMateria.innerHTML = '<option value="">Seleccione una materia</option>';
                data.materias.forEach(materia => {
                    const option = document.createElement('option');
                    option.value = materia.id_materia;
                    option.textContent = materia.nombre_materia;
                    selectMateria.appendChild(option);
                });
                selectMateria.disabled = false;
            });
    }

    function cargarEstudiantes(seccion, materia_id) {
        if (!seccion || !materia_id) return;
        fetch(`../../app/controllers/notas/listado_estudiantes_por_seccion.php?seccion=${encodeURIComponent(seccion)}&materia_id=${materia_id}`)
            .then(response => response.json())
            .then(data => {
                const tabla = document.getElementById('tablaEstudiantes');
                const docenteAsignado = document.getElementById('docenteAsignado');
                tabla.innerHTML = '';
                docenteAsignado.textContent = `Docente asignado: ${data.docente.docente_nombre} (${data.docente.docente_cedula})`;

                data.estudiantes.forEach(estudiante => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${estudiante.nombre_completo}</td>
                        <td>${estudiante.cedula}</td>
                        <td><input type="number" class="form-control nota" data-id-nota="${estudiante.id_nota}" value="${estudiante.nota_1}" ${estudiante.estado_nota === '0' ? 'disabled' : ''}></td>
                        <td><input type="number" class="form-control nota" data-id-nota="${estudiante.id_nota}" value="${estudiante.nota_2}" ${estudiante.estado_nota === '0' ? 'disabled' : ''}></td>
                        <td><input type="number" class="form-control nota" data-id-nota="${estudiante.id_nota}" value="${estudiante.nota_3}" ${estudiante.estado_nota === '0' ? 'disabled' : ''}></td>
                        <td><input type="number" class="form-control" value="${estudiante.nota_final}" disabled></td>
                    `;
                    tabla.appendChild(fila);
                });

                document.getElementById('guardarNotas').disabled = false;
            });
    }

    function guardarNotas() {
        const notas = Array.from(document.querySelectorAll('.nota')).map(input => ({
            id_nota: input.dataset.idNota,
            nota_1: input.closest('tr').querySelectorAll('.nota')[0].value,
            nota_2: input.closest('tr').querySelectorAll('.nota')[1].value,
            nota_3: input.closest('tr').querySelectorAll('.nota')[2].value,
            nota_final: (parseFloat(input.closest('tr').querySelectorAll('.nota')[0].value) +
                         parseFloat(input.closest('tr').querySelectorAll('.nota')[1].value) +
                         parseFloat(input.closest('tr').querySelectorAll('.nota')[2].value)) / 3,
            estado: '0'
        }));

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
            });
    }
</script>
