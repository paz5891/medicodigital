<form autocomplete="false" onsubmit="return false">
    <div class="modal fade" id="modal_editar_contra" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Editar de Contraseña</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <input type="text" id="txtidprincipal" value="<?php echo $_SESSION['idusuario'] ?>" hidden>
                        <input type="text" id="txtcontra_db" value="<?php echo $_SESSION['clave']?>" hidden>
                        <label for="">Contraseña Actual</label>
                        <input type="password" class="form-control" id="txt_contra_actual_editar" placeholder="Contraseña Actual">
                        <br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Nueva Contraseña </label>
                        <input type="password" class="form-control" id="txt_contra_nueva_editar" placeholder="Nueva Contraseña">
                        <br>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Repita la contraseña </label>
                        <input type="password" class="form-control" id="txt_contra_repet_editar" placeholder="Nueva Contraseña">
                        <br>
                    </div>
                </div>
                <div class="modal-footer">
                <button class="btn btn-primary" onclick="editar_contra()">Modificar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Main Footer -->
  <footer class="main-footer">
    <strong>Clinica de ginecología Genesis <a href="#"></a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../plantilla/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plantilla/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../plantilla/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../plantilla/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plantilla/plugins/raphael/raphael.min.js"></script>
<script src="../plantilla/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../plantilla/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../plantilla/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../plantilla/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../plantilla/dist/js/pages/dashboard2.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>


<!-- Librerias para mostrar los botones -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/js/mdb.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- finde de la importada los botones datatable
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="../plantilla/plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="scripts/usuario/contrasenia.js"></script>
<script>
 jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
    return ! data ?
        '' :
        typeof data === 'string' ?
            data
                .replace( /\n/g, ' ' )
                .replace( /[áâàä]/g, 'a' )
                .replace( /[éêèë]/g, 'e' )
                .replace( /[íîìï]/g, 'i' )
                .replace( /[óôòö]/g, 'o' )
                .replace( /[úûùü]/g, 'u' )

                .replace( /[Á]/g, 'A' )
                .replace( /[É]/g, 'E' )
                .replace( /[Í]/g, 'I' )
                .replace( /[Ó]/g, 'O' )
                .replace( /[Ú]/g, 'U' )

                .replace( /ç/g, 'c' ) :
            data;
};
</script>
<script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>

</body>
</html>