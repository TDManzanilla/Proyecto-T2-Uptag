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
        <p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/TDManzanilla/Proyecto-T2-Uptag">Sistema de Gestión Escolar V-1.0.</a> - <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/TDManzanilla">Admin</a> Está bajo licencia <a href="https://creativecommons.org/licenses/by-sa/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC A-S 4.0 International<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/sa.svg?ref=chooser-v1" alt=""></a></p>
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
<script src="<?=APP_URL;?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=APP_URL;?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Datatables -->
<script src="<?=APP_URL;?>/public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/jszip/jszip.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=APP_URL;?>/public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<!-- AdminLTE App -->
<script src="<?=APP_URL;?>/public/dist/js/adminlte.min.js"></script>
</body>
</html>