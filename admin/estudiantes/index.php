<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/estudiantes/listado_estudiantes.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Estudiantes</h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Estudiantes Inscritos</h3>
                            <div class="card-tools">
                                <a href="../inscripciones" class="btn btn-primary"><i class="bi bi-plus-square"></i> Inscribir Estudiante</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th><center>Nro</center></th>                                    
                                    <th><center>Cedula</center></th>
                                    <th><center>Nombres</center></th>
                                    <th><center>Apellidos</center></th>
                                    <th><center>Seccion</center></th>
                                    <th><center>Acciones</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador_estudiantes = 0;
                                foreach ($estudiantes as $estudiante){
                                    $id_estudiantes = $estudiante['id_estudiante'];
                                    $contador_estudiantes++; ?>
                                    <tr>
                                        <td style="text-align: center"><?=$contador_estudiantes;?></td>
                                        <td style="text-align: center"><?='V-'.$estudiante['ci'];?></td>
                                        <td><?=$estudiante['nombres'];?></td>
                                        <td><?=$estudiante['apellidos']?></td>
                                        <td>
                                            <a href="#" onclick="filtrarSeccion('<?=$estudiante['curso'].' - '.$estudiante['paralelo'];?>')">
                                                <?=$estudiante['curso'].' - '.$estudiante['paralelo'];?>
                                            </a>
                                        </td>
                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="show.php?id=<?=$id_estudiante;?>" type="button" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                <a href="edit.php?id=<?=$id_estudiante;?>" type="button" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
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

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php');

?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Estudiantes",
                "infoEmpty": "Mostrando 0 a 0 de 0 Estudiantes",
                "infoFiltered": "(Filtrado de _MAX_ total Estudiantes)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Estudiantes",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    function filtrarSeccion(seccion) {
        const buscador = document.querySelector('#example1_filter input');
        if (buscador) {
            buscador.value = seccion;
            const event = new Event('input', { bubbles: true });
            buscador.dispatchEvent(event);
        }
    }
</script>