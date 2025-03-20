<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      V 0.1.
    </div>
    <!-- Default to the left -->
    <strong id="datetime"><?php echo $fechahora; ?> <a>UPTAG</a></strong>

    <script>
      function updateDateTime() {
        var now = new Date();
        var formattedDateTime = now.toLocaleString();
        document.getElementById('datetime').innerHTML = formattedDateTime + ' <a>UPTAG</a>';
      }

      setInterval(updateDateTime, 1000); // Update every second
      updateDateTime(); // Initial call to set the current time immediately
    </script>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo APP_URL; ?>public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo APP_URL; ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo APP_URL; ?>public/dist/js/adminlte.min.js"></script>
<!-- DataTables JS -->
<script src="<?php echo APP_URL; ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo APP_URL; ?>public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Custom Script -->
<script src="<?php echo APP_URL; ?>public/js/scripts.js"></script>
</body>
</html>