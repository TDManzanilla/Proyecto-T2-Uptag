<?php
include('../../app/config.php');
include(APP_PATH . 'admin/layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Habilitar/Deshabilitar Edición de Notas</h1>
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
                    <h4>Lapso</h4>
                    <select class="form-control" id="selectLapso">
                        <option value="1">Primer Lapso</option>
                        <option value="2">Segundo Lapso</option>
                        <option value="3">Tercer Lapso</option>
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
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMaterias">
                            <tr>
                                <td colspan="4" class="text-center">Seleccione una sección y un lapso para ver las materias.</td>
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

        document.getElementById('selectLapso').addEventListener('change', function () {
            const seccion = document.getElementById('selectSeccion').value;
            const lapso = this.value;
            if (seccion && lapso) {
                cargarMaterias(seccion, lapso);
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
        const tabla = document.getElementById('tablaMaterias');
        const lapso = document.getElementById('selectLapso').value;

        if (!seccion || !lapso) {
            tabla.innerHTML = '<tr><td colspan="4" class="text-center">Seleccione una sección y un lapso para ver las materias.</td></tr>';
            return;
        }

        fetch(`../../app/controllers/notas/listado_secciones.php?action=getSubjects&seccion=${encodeURIComponent(seccion)}&lapso=${lapso}`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error);

                tabla.innerHTML = '';

                if (!data.materias || data.materias.length === 0) {
                    tabla.innerHTML = '<tr><td colspan="4" class="text-center">No hay materias asignadas para esta sección.</td></tr>';
                    return;
                }

                data.materias.forEach(materia => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${materia.materia}</td>
                        <td>${materia.docente}</td>
                        <td>${materia.estado}</td>
                        <td>
                            <button class="btn btn-success btn-sm btn-habilitar" data-materia="${materia.id_materia}" data-lapso="${lapso}" ${materia.estado === 'Habilitado' ? 'disabled' : ''}>
                                Habilitar
                            </button>
                            <button class="btn btn-danger btn-sm btn-deshabilitar" data-materia="${materia.id_materia}" data-lapso="${lapso}" ${materia.estado === 'Deshabilitado' ? 'disabled' : ''}>
                                Deshabilitar
                            </button>
                        </td>
                    `;
                    tabla.appendChild(fila);
                });

                document.querySelectorAll('.btn-habilitar').forEach(boton => {
                    boton.addEventListener('click', function () {
                        cambiarEstadoNota(this.dataset.materia, this.dataset.lapso, '1');
                    });
                });

                document.querySelectorAll('.btn-deshabilitar').forEach(boton => {
                    boton.addEventListener('click', function () {
                        cambiarEstadoNota(this.dataset.materia, this.dataset.lapso, '0');
                    });
                });
            })
            .catch(error => {
                console.error('Error al cargar las materias:', error);
                Swal.fire('Error', 'Hubo un error al cargar las materias.', 'error');
            });
    }

    function cambiarEstadoNota(materia_id, lapso, estado) {
        fetch('../../app/controllers/notas/listado_secciones.php?action=updateNoteState', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ materia_id, lapso, estado }) // Enviar lapso y estado correctamente
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) throw new Error(data.error);
                Swal.fire('Éxito', data.message, 'success');
                const seccion = document.getElementById('selectSeccion').value;
                const lapso = document.getElementById('selectLapso').value;
                cargarMaterias(seccion, lapso); // Recargar las materias con el lapso seleccionado
            })
            .catch(error => {
                console.error('Error al cambiar el estado de la nota:', error);
                Swal.fire('Error', 'Hubo un error al cambiar el estado de la nota.', 'error');
            });
    }
</script>
