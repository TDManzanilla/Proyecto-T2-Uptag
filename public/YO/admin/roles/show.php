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
          <h1>Rol: <?=$nombre_rol?></h1>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    <div class="row">
      <div class="col-md-10">
        <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Datos Registrados</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
              <label for="nombre_rol">Nombre del Rol</label>
              <p><?=$nombre_rol?></p>
            </div>
            <div class="form-group">
              <a href="<?php echo APP_URL; ?>admin/roles/index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
              </a>
              <a href="<?php echo APP_URL; ?>admin/roles/edit.php?id=<?php echo $id_rol; ?>" class="btn btn-success">
                <i class="fas fa-pencil-alt"></i> Editar
              </a>
            </div>
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






