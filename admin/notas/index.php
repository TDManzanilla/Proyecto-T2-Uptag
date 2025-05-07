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
            document.getElementById('guardarNotas').disabled = true; // Disable save button initially
        });

        document.getElementById('selectMateria').addEventListener('change', function () {
            const seccion = document.getElementById('selectSeccion').value;
            const materia = this.value;
            if (seccion && materia) {
                document.getElementById('guardarNotas').disabled = false; // Enable save button
                cargarEstudiantes(seccion, materia);
            } else {
                document.getElementById('guardarNotas').disabled = true; // Disable save button
            }
        });

        document.getElementById('guardarNotas').addEventListener('click', function (e) {
            if (!validarNotas()) {
                e.preventDefault(); // Detener el envío si hay errores
            } else {
                guardarNotas(); // Proceder a guardar si todo es válido
            }
        });
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
                    guardarNotasButton.disabled = false;
                    return;
                }

                let i = 1; // Inicializa el contador aquí
                data.estudiantes.forEach(estudiante => {
                    const estado = estudiante.estado || '000'; // Estado en formato "111"
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${estudiante.nombre_completo}
                        <input type="hidden" id="id_nota-${i}" value="${estudiante.id_nota}">
                        </td>
                        <td>${estudiante.cedula}
                        <input type="hidden" id="id_estudiante${i}" value="${estudiante.id_estudiante}">
                        </td>
                        <td><input type="number" class="form-control" id="nota_1-${i}" value="${estudiante.nota_1 || ''}" ${estado[0] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" id="nota_2-${i}" value="${estudiante.nota_2 || ''}" ${estado[1] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" id="nota_3-${i}" value="${estudiante.nota_3 || ''}" ${estado[2] === '0' ? 'readonly' : ''}></td>
                        <td><input type="number" class="form-control" id="nota_final-${i}" value="${estudiante.nota_final}" readonly></td>
                    `;
                    tablaEstudiantes.appendChild(fila);
                    i++; // Incrementa el contador
                });

                guardarNotasButton.disabled = !(seccion && materia_id); // Enable button only if both are selected
            })
            .catch(error => {
                console.error('Error al cargar los estudiantes:', error);
                Swal.fire('Error', 'Hubo un error al cargar los estudiantes.', 'error');
            });
    }

    function guardarNotas() {
        const notas = [];
        const tabla = document.getElementById('tablaEstudiantes');
        const filas = tabla.rows.length;

        for (let i = 1; i <= filas; i++) {
            const idNotaElement = document.getElementById('id_nota-' + i);
            const idEstudianteElement = document.getElementById('id_estudiante' + i);
            const nota1Element = document.getElementById('nota_1-' + i);
            const nota2Element = document.getElementById('nota_2-' + i);
            const nota3Element = document.getElementById('nota_3-' + i);
            const notaFinalElement = document.getElementById('nota_final-' + i);

            // Verifica si los elementos existen
            if (!idNotaElement || !nota1Element || !nota2Element || !nota3Element || !notaFinalElement) {
                console.warn(`Elementos faltantes para la fila ${i}`);
                continue; // Salta a la siguiente iteración si algún elemento falta
            }

            const idNota = idNotaElement.value;
            const idEstudiante = idEstudianteElement.value;
            const materia_id = document.getElementById('selectMateria').value;

            // Si el campo está deshabilitado, conserva su valor original
            const nota_1 = nota1Element.hasAttribute('readonly') ? nota1Element.value : nota1Element.value;
            const nota_2 = nota2Element.hasAttribute('readonly') ? nota2Element.value : nota2Element.value;
            const nota_3 = nota3Element.hasAttribute('readonly') ? nota3Element.value : nota3Element.value;
            const nota_final = notaFinalElement.value; // Nota final siempre es readonly

            notas.push({
                [`id_nota-${i}`]: idNota,
                [`id_estudiante-${i}`]: idEstudiante,
                materia_id: materia_id,
                [`nota_1-${i}`]: nota_1,
                [`nota_2-${i}`]: nota_2,
                [`nota_3-${i}`]: nota_3,
                [`nota_final-${i}`]: nota_final,
            });
        }

        console.log(notas);
        console.log(JSON.stringify({ notas }));
        fetch('../../app/controllers/notas/guardar_notas.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ notas }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
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

    function validarNotas() {
        const inputs = document.querySelectorAll('input[type="number"]');
        for (const input of inputs) {
            // Omitir validación si el campo está deshabilitado (readonly)
            if (input.hasAttribute('readonly')) {
                continue;
            }

            const valor = parseFloat(input.value);
            if (isNaN(valor) || valor < 0 || valor > 20) {
                Swal.fire({
                    icon: 'error',
                    title: 'Valor inválido',
                    text: `El valor ingresado en el campo ${input.id} no es válido. Debe ser un número entre 0 y 20.`,
                    confirmButtonText: 'Aceptar'
                });
                return false; // Detener la validación si hay un error
            }
        }
        return true; // Si todo es válido, continuar
    }
</script>
