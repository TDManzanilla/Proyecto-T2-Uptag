<?php
include('../../app/config.php');
include('../../admin/layout/parte1.php');

// Obtener grados y materias usando los controladores existentes
include('../../app/controllers/grados/listado_de_grados.php');
include('../../app/controllers/materias/listado_de_materias.php');
?>
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Asignación de Pensum</h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        
                        <div class="card-body">
                        <div class="container mt-4">
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <!-- Grados -->
            <h4>Grados y Secciones</h4>
            <ul class="list-group" id="listaGrados">
                <?php foreach ($grados as $grado): ?>
                    <li class="list-group-item grado-item" data-id-grado="<?= $grado['id_grado']; ?>">
                        <input type="checkbox" class="grado-checkbox" value="<?= $grado['id_grado']; ?>">
                        <?= $grado['curso'] . " - " . $grado['paralelo']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-sm-12 col-md-7">
            <!-- Materias -->
            <h4>Materias</h4>
            <ul class="list-group" id="listaMaterias">
                <?php foreach ($materias as $materia): ?>
                    <li class="list-group-item materia-item" data-id-materia="<?= $materia['id_materia']; ?>">
                        <input type="checkbox" class="materia-checkbox" value="<?= $materia['id_materia']; ?>">
                        <?= $materia['nombre_materia']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Botones -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" id="btnAsignarMaterias">Asignar Materias</button>
            <button class="btn btn-secondary" data-toggle="modal" data-target="#modalVerAsignaciones" onclick="cargarAsignaciones()">Ver Asignaciones</button>
        </div>
    </div>
</div>
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

<!-- Modal para ver asignaciones -->
<div class="modal fade" id="modalVerAsignaciones" tabindex="-1" role="dialog" aria-labelledby="modalVerAsignacionesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerAsignacionesLabel">Editar Asignaciones</h5>
                <a href="<?= APP_URL ?>/admin/docentes/asignacion" class="btn btn-primary btn-sm ml-auto">Asignar Docentes</a>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenedorAsignaciones">
                    <!-- Contenido dinámico de asignaciones -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
include ('../layout/parte2.php');
include ('../../layout/mensajes.php');
?>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?= $_SESSION['mensaje']['type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['mensaje']['message'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['duplicidad'])): ?>
    <div class="alert alert-<?= $_SESSION['duplicidad']['type'] ?>" role="alert">
        <p><?= $_SESSION['duplicidad']['message'] ?></p>
        <?php if (!empty($_SESSION['duplicidad']['duplicadas'])): ?>
            <p><strong>Materias anteriormente asignadas:</strong> <?= implode(', ', $_SESSION['duplicidad']['duplicadas']) ?></p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['duplicidad']['asignadas'])): ?>
            <p><strong>Materias asignadas:</strong> <?= implode(', ', $_SESSION['duplicidad']['asignadas']) ?></p>
        <?php endif; ?>
        <button class="btn btn-primary mt-2" onclick="this.parentElement.remove()">Aceptar</button>
    </div>
    <?php unset($_SESSION['duplicidad']); ?>
<?php endif; ?>

<style>
#listaGrados, #listaMaterias {
    max-height: 400px;
    overflow-y: auto;
}

.list-group-item {
    font-size: 14px;
    padding: 10px;
}

.btn-materia {
    border-radius: 20px;
    font-size: 14px;
    padding: 5px 15px;
    margin: 5px;
}
</style>

<script>
    // Asignar materias
    document.getElementById('btnAsignarMaterias').addEventListener('click', function () {
        const gradosSeleccionados = Array.from(document.querySelectorAll('.grado-checkbox:checked'))
            .map(checkbox => checkbox.value);

        const materiasSeleccionadas = Array.from(document.querySelectorAll('.materia-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (gradosSeleccionados.length === 0 || materiasSeleccionadas.length === 0) {
            Swal.fire('Error', 'Por favor, seleccione al menos un grado y una materia.', 'error');
            return;
        }

        fetch('../../app/controllers/asignaciones/guardar_asignaciones.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                grados: gradosSeleccionados,
                materias: materiasSeleccionadas
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let mensaje = data.message;

                    if (data.duplicadas && data.duplicadas.length > 0) {
                        mensaje += `<br><strong>Materias anteriormente asignadas:</strong> ${data.duplicadas.join(', ')}`;
                    }

                    Swal.fire({
                        title: 'Éxito',
                        html: mensaje,
                        icon: data.type,
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Atención',
                        html: data.message,
                        icon: data.type,
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un error al asignar las materias.', 'error');
            });
    });

    // Ver asignaciones en el modal
    document.querySelector('[data-target="#modalVerAsignaciones"]').addEventListener('click', function () {
        cargarAsignaciones();
    });

    // Cargar asignaciones dinámicamente
    function cargarAsignaciones() {
        fetch('../../app/controllers/asignaciones/listado_asignaciones.php?seccion=TODAS')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar las asignaciones');
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos recibidos:', data); // Depuración
                const contenedor = document.getElementById('contenedorAsignaciones');
                contenedor.innerHTML = ''; // Limpiar contenido

                if (data.length === 0) {
                    contenedor.innerHTML = '<p class="text-center">No hay asignaciones registradas.</p>';
                    return;
                }

                data.forEach(asignacion => {
                    const divSeccion = document.createElement('div');
                    divSeccion.classList.add('mb-4', 'p-3', 'border', 'rounded');
                    divSeccion.innerHTML = `
                        <h5>${asignacion.seccion}</h5>
                        <div class="d-flex flex-wrap" id="materias-${asignacion.seccion.replace(/\s+/g, '-')}">
                            ${asignacion.materias
                                .map(
                                    materia => `
                                    <button class="btn btn-outline-primary btn-materia" data-seccion="${asignacion.seccion}" data-materia="${materia}">
                                        ${materia}
                                    </button>
                                `
                                )
                                .join('')}
                        </div>
                    `;
                    contenedor.appendChild(divSeccion);
                });

                // Agregar eventos a los botones de materias
                document.querySelectorAll('.btn-materia').forEach(boton => {
                    boton.addEventListener('click', function () {
                        const seccion = this.dataset.seccion;
                        const materia = this.dataset.materia;

                        Swal.fire({
                            title: `¿Desea eliminar ${materia} asignada a ${seccion}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then(result => {
                            if (result.isConfirmed) {
                                eliminarAsignacion(seccion, materia, this);
                            }
                        });
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error); // Depuración
                Swal.fire('Error', 'Hubo un error al cargar las asignaciones.', 'error');
            });
    }

    function eliminarAsignacion(seccion, materia, boton) {
        fetch('../../app/controllers/asignaciones/eliminar_asignaciones.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ seccion, materia })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Eliminado', `La asignación de ${materia} en ${seccion} fue eliminada.`, 'success');
                    boton.remove(); // Eliminar el botón de la materia
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la asignación.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Hubo un error al eliminar la asignación.', 'error');
            });
    }
</script>
