<?php
$id_rol = $_GET['id'];
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');
include ('../../app/controllers/roles/show.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <br>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <h1>Editar el Rol: <?=$nombre_rol?></h1>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    <div class="row">
      <div class="col-md-10">
        <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Datos a Editar</h3>
        </div>
        <div class="card-body">
            <form id="editRoleForm" action="<?php echo APP_URL; ?>app/controllers/roles/edit.php" method="POST" onkeydown="return handleEnter(event, 'editRoleForm', confirmEditRole)">
                <div class="form-group">
                  <label for="nombre_rol">Nombre del Rol</label>
                  <p><?=$nombre_rol?></p>
                  <input type="text" name="nombre_rol" class="form-control" id="nombre_rol" value="<?=$nombre_rol?>" required>
                  <input type="hidden" name="id_rol" value="<?=$id_rol?>">
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-success" onclick="confirmEditRole()">
                      <i class="fas fa-check"></i> Actualizar
                    </button>  
                  <a href="<?php echo APP_URL; ?>admin/roles/index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                  </a>
                </div>
            </form>
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
<script>
function showAlert(title, icon, confirmButtonText = 'Confirmar', cancelButtonText = 'Cancelar') {
    return Swal.fire({
        title: title,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        return result;
    });
}

function confirmEditRole() {
    const nombreRol = document.getElementById('nombre_rol').value;
    showAlert(
        `¿Confirmar los cambios para el rol: ${nombreRol}?`,
        'question',
        'Confirmar',
        'Cancelar'
    ).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editRoleForm').submit();
        }
    });
}

function handleEnter(event, formId, confirmFunction) {
    if (event.key === 'Enter') {
        event.preventDefault();
        confirmFunction();
    }
}
</script>