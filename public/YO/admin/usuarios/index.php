<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/usuarios/listado_de_usuarios.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <br>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <h1>Listado de Usuarios</h1>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Usuarios Registrados</h3>
                <div class="card-tools">
                <a href="create.php" class="btn btn-primary btn-sm">
                  <i class="bi bi-plus-circle"></i> Crear Nuevo Usuario
                </a>
                </div>
            </div>
            <div class="card-body">
            <table class="table table-bordered table-sm table-hover text-center" id="example1">
                <thead>
                  <tr>
                  <th>Nro</th>
                  <th class="text-center">Nombres del Usuario</th>
                  <th class="text-center">Rol</th>
                  <th class="text-center">Fecha de Creación</th>
                  <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $contador_usuario = 0;
                  foreach ($usuarios as $usuario) {
                  $id_usuario = $usuario['id_usuario'];
                  $contador_usuario++;
                  ?>
                  <tr>
                  <td><?php echo $contador_usuario; ?></td>
                  <td class="text-center"><?php echo $usuario['nombres']; ?></td>
                  <td class="text-center"><?php echo $usuario['nombre_rol']; ?></td>
                  <td class="text-center"><?php echo $usuario['fecha_registro']; ?></td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Acciones">
                    <a href="show.php?id=<?php echo $id_usuario; ?>" class="btn btn-info">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="edit.php?id=<?php echo $id_usuario; ?>" class="btn btn-success">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteUser('<?php echo APP_URL; ?>app/controllers/usuarios/delete.php?id=<?php echo $id_usuario; ?>')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                  </td>
                  </tr>
                  <?php } ?>
                  <!-- Aquí se llenarán los datos de la base de datos -->
                </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<?php
include ('../../admin/layout/parte2.php');
include ('../../layout/mensajes.php'); // Incluir mensajes.php aquí para mostrar mensajes de éxito
?>
<style>
/* Estilo personalizado para aumentar el tamaño del texto en el menú de selección */
.dataTables_length select {
    font-size: 1em;
}
</style>
<script>
$(document).ready(function() {
  $('#example1').DataTable({
        "pageLength": 10,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún hay información disponible en la tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "csv": "CSV",
                "excel": "Excel",
                "pdf": "PDF",
                "print": "Imprimir",
                "colvis": "Columnas"
            }
        },
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "buttons": [
            {
                extend: 'collection',
                text: 'Reportes',
                className: 'btn btn-primary',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copiar',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        className: 'btn btn-warning'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        className: 'btn btn-info'
                    }
                ]
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: 'btn btn-primary',
            }
        ],
        "columnDefs": [
            { "orderable": false, "targets": 2 } // Deshabilitar ordenamiento en la columna de acciones
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});

function showAlert(title, icon, href = '', confirmButtonText = 'Confirmar', cancelButtonText = 'Cancelar') {
    return Swal.fire({
        title: title,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        if (result.isConfirmed && href) {
            window.location.href = href;
        }
        return result;
    });
}

function confirmDeleteUser(href) {
    showAlert(
        '¿Estás seguro de que deseas eliminar este usuario?',
        'warning',
        href,
        'Eliminar',
        'Cancelar'
    );
}
</script>