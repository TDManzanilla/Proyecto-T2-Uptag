<?php
include('../../../app/config.php');
include(APP_PATH . 'admin/layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Asignación de Docentes</h1>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4>Secciones</h4>
                    <select class="form-control" id="selectSeccion">
                        <option value="">Seleccione una sección</option>
                        <!-- Secciones cargadas dinámicamente -->
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Materias</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Docente Asignado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMaterias">
                            <tr>
                                <td colspan="3" class="text-center">Seleccione una sección para ver las materias.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include(APP_PATH . 'admin/layout/parte2.php');
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarSecciones();

        document.getElementById('selectSeccion').addEventListener('change', function () {
            cargarMaterias(this.value);
        });

        // Corregir el botón "Cerrar" del modal
        document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(botonCerrar => {
            botonCerrar.addEventListener('click', function () {
                cerrarModal(); // Llama a la función alternativa para cerrar el modal
            });
        });
    });

    function cargarSecciones() {
        fetch('../../../app/controllers/docentes/asignaciones/listado_materias_por_seccion.php')
            .then(response => response.json())
            .then(data => {
                const selectSeccion = document.getElementById('selectSeccion');
                selectSeccion.innerHTML = '<option value="">Seleccione una sección</option>';

                if (!data.secciones || data.secciones.length === 0) {
                    Swal.fire('Error', 'No se encontraron secciones disponibles.', 'error');
                    return;
                }

                // Utilizar las secciones ya ordenadas del backend
                data.secciones.forEach(seccion => {
                    const option = document.createElement('option');
                    option.value = seccion.seccion;
                    option.textContent = seccion.seccion;
                    selectSeccion.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar las secciones:', error);
                Swal.fire('Error', 'Hubo un error al cargar las secciones.', 'error');
            });
    }

    function cargarMaterias(seccion) {
        const tabla = document.getElementById('tablaMaterias');
        if (!seccion) {
            tabla.innerHTML = '<tr><td colspan="3" class="text-center">Seleccione una sección para ver las materias.</td></tr>';
            return;
        }

        fetch('../../../app/controllers/docentes/asignaciones/listado_materias_por_seccion.php?seccion=' + encodeURIComponent(seccion))
            .then(response => response.json())
            .then(data => {
                tabla.innerHTML = '';

                if (!data.materias || data.materias.length === 0) {
                    tabla.innerHTML = '<tr><td colspan="3" class="text-center">No hay materias asignadas para esta sección.</td></tr>';
                    return;
                }

                data.materias.forEach(materia => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${materia.materia}</td>
                        <td>${materia.docente}</td>
                        <td>
                            <button class="btn btn-primary btn-sm btn-asignar-docente" data-materia="${materia.id_materia}" data-seccion="${seccion}">
                                Asignar Docente
                            </button>
                        </td>
                    `;
                    tabla.appendChild(fila);
                });

                document.querySelectorAll('.btn-asignar-docente').forEach(boton => {
                    boton.addEventListener('click', function () {
                        abrirVentanaAsignarDocente(this.dataset.materia, this.dataset.seccion);
                    });
                });
            })
            .catch(error => {
                console.error('Error al cargar las materias:', error);
                Swal.fire('Error', 'Hubo un error al cargar las materias.', 'error');
            });
    }

    function abrirVentanaAsignarDocente(materia, seccion) {
        fetch('../../../app/controllers/docentes/asignaciones/listado_de_docentes.php')
            .then(response => response.json())
            .then(docentes => {
                const tablaDocentes = document.getElementById('tablaDocentes');
                tablaDocentes.innerHTML = '';

                docentes.forEach(docente => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${docente.cedula}</td>
                        <td>${docente.nombre_completo}</td>
                        <td>
                            <button class="btn btn-primary btn-sm btn-seleccionar-docente" data-id="${docente.id_docente}" data-nombre="${docente.nombre_completo}">
                                Asignar
                            </button>
                        </td>
                    `;
                    tablaDocentes.appendChild(fila);
                });

                document.querySelectorAll('.btn-seleccionar-docente').forEach(boton => {
                    boton.addEventListener('click', function () {
                        confirmarAsignacionDocente(this.dataset.id, materia, seccion);
                        cerrarModal(); // Llama a la función alternativa para cerrar el modal
                    });
                });

                document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(botonCerrar => {
                    botonCerrar.addEventListener('click', function () {
                        cerrarModal(); // Llama a la función alternativa para cerrar el modal
                    });
                });

                const modal = new bootstrap.Modal(document.getElementById('modalAsignarDocente'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un error al cargar los docentes.', 'error');
            });
    }

    function confirmarAsignacionDocente(docenteId, materia, seccion) {
        fetch('../../../app/controllers/docentes/asignaciones/asignar_docente.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ docenteId, materia, seccion })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Asignado',
                        text: `El docente fue asignado correctamente.`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        cerrarModal(); // Llama a la función alternativa para cerrar el modal
                        document.getElementById('selectSeccion').dispatchEvent(new Event('change'));
                    });
                } else if (data.message === 'already_assigned') {
                    Swal.fire('Información', 'El docente ya está asignado a esta materia.', 'info');
                } else {
                    Swal.fire('Error', 'No se pudo asignar el docente.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un error al asignar el docente.', 'error');
            });
    }

    function cerrarModal() {
        const modal = document.getElementById('modalAsignarDocente');
        if (modal) {
            modal.classList.remove('show'); // Quita la clase 'show' del modal
            modal.style.display = 'none'; // Oculta el modal
            document.body.classList.remove('modal-open'); // Quita la clase 'modal-open' del body
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove(); // Elimina el backdrop del DOM
        }
    }
</script>

<!-- Modal para Asignar Docente -->
<div class="modal fade" id="modalAsignarDocente" tabindex="-1" aria-labelledby="modalAsignarDocenteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAsignarDocenteLabel">Asignar Docente</h5>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre Completo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDocentes">
                        <!-- Contenido dinámico -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>