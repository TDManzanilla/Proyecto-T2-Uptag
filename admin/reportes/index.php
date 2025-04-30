<?php
include ('../../app/config.php');
include ('../layout/parte1.php');
include ('../../app/controllers/reportes/bitacora_controller.php');

$bitacoraController = new BitacoraController($pdo);
$bitacoraEntries = $bitacoraController->getBitacora();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Bitácora de Acciones</h1>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Acciones</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th><center>Cédula</center></th>
                                        <th><center>Correo</center></th>
                                        <th><center>Descripción</center></th>
                                        <th><center>Fecha y Hora</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bitacoraEntries as $entry): ?>
                                        <tr>
                                            <td style="text-align: center"><?= htmlspecialchars($entry['ci']) ?></td>
                                            <td><?= htmlspecialchars($entry['email']) ?></td>
                                            <td><?= htmlspecialchars($entry['descripcion']) ?></td>
                                            <td style="text-align: center"><?= htmlspecialchars($entry['fecha_hora']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
include ('../layout/parte2.php');
include ('../../layout/mensajes.php');
?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Acciones",
                "infoEmpty": "Mostrando 0 a 0 de 0 Acciones",
                "infoFiltered": "(Filtrado de _MAX_ total Acciones)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Acciones",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [ {
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [ {
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                }, {
                    extend: 'csv'
                }, {
                    extend: 'excel'
                }, {
                    text: 'Imprimir',
                    extend: 'print'
                }]
            }, {
                extend: 'colvis',
                text: 'Visor de columnas',
                collectionLayout: 'fixed three-column'
            }],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>