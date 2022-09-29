<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'template/header.php';

    if ($_SESSION['reportes'] == 1) {
?>
        <br>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Total consulta pediátrica </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    
                     
                    <div class="panel-body table-responsive" id="listadoregistros">
                       
                    <div class="container-fluid">
                                        <div class="row">
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                          
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="datetime-local" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                           
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                          <label></label>
                           <button class="form-control btn btn-success" onclick="listar()">Mostrar</button>
                        </div>
                        </div>
                        </div>
                       
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Total</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                           <th>Total</th>
                           
                           
                          </tfoot>
                        </table>
                    </div>
                
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <?php
    } else {
        require 'noacceso.php';
    }

    require 'template/footer.php';
    ?>
    <script type="text/javascript" src="scripts/totalpediatrica.js"></script>
 
<?php
}
ob_end_flush();
?>