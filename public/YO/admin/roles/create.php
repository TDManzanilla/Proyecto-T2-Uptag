<?php
include ('../../app/config.php');
include ('../../admin/layout/parte1.php');

// Recuperar el valor del campo nombre_rol desde la sesión
$nombre_rol = isset($_SESSION['nombre_rol']) ? $_SESSION['nombre_rol'] : '';
unset($_SESSION['nombre_rol']); // Limpiar el valor de la sesión después de usarlo
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <br>
    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <h1>Creación de Nuevo Rol</h1>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    <div class="row">
      <div class="col-md-10">
        <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Rellene los campos</h3>
        </div>
        <div class="card-body">
            <form id="createRoleForm" action="<?php echo APP_URL; ?>/app/controllers/roles/create.php" method="POST" onkeydown="return handleEnter(event, 'createRoleForm', confirmCreateRole)">
            <div class="form-group">
              <label for="nombre_rol">Nombre del Rol</label>
              <input type="text" name="nombre_rol" class="form-control" id="nombre_rol" placeholder="Ingrese el nombre del rol" value="<?php echo htmlspecialchars($nombre_rol); ?>" required>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary btn-sm" onclick="confirmCreateRole()">
                <i class="bi bi-plus-circle"></i> Confirmar
              </button>
              <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='<?php echo APP_URL; ?>admin/roles/index.php'">
                <i class="bi bi-x-circle"></i> Cancelar
              </button>
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
function showAlert(title, icon, href = '', confirmButtonText = 'Confirmar', cancelButtonText = 'Cancelar') {
    // Validar la URL antes de redirigir
    if (href && !href.startsWith(window.location.origin)) {
        console.error('URL no válida:', href);
        return;
    }

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

function confirmCreateRole() {
    const nombreRol = document.getElementById('nombre_rol').value;
    showAlert(
        `¿Quiere crear este rol: ${nombreRol}?`,
        'question',
        '',
        'Confirmar',
        'Cancelar'
    ).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('createRoleForm').submit();
        }
    });
}

function handleEnter(event, formId, confirmFunction) {
    if (event.key === 'Enter') {
        event.preventDefault();
        confirmFunction(formId);
    }
}
</script>