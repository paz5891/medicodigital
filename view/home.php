<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'template/header.php';

  if ($_SESSION['escritorio'] == 1) {
?>
    <br>
   

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">

          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="box-title">Citas por fecha</h1>
            <div class="box-tools pull-right">
            </div>
          </div>

          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Fecha Inicio</label>
            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
          </div>
          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label>Fecha Fin</label>
            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
          </div>


        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box">

              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">

                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                  <th>Opciones</th>
                    <th>Seguro</th>
                    <th>Médico</th>
                    <th>Tipo de cita</th>
                    <th>Paciente/Visitador</th>
                    <th>Asunto</th>
                    <th>Teléfono</th>
                    <th>Hora y Fecha</th>
                    <th>Estado cita</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                  <th>Opciones</th>
                    <th>Seguro</th>
                    <th>Médico</th>
                    <th>Tipo de cita</th>
                    <th>Paciente/Visitador</th>
                    <th>Asunto</th>
                    <th>Teléfono</th>
                    <th>Hora y Fecha</th>
                    <th>Estado cita</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="container">
                    <div class="row">

                      <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <input type="hidden" name="idcita" id="idcita">
                        <label>Estado de la cita:</label>
                        <select class="form-control form-control-lg js-example-basic-single select2" name="estadocita" id="estadocita" style="width:100%;">
                          <option value='Pendiente'>Pendiente</option>
                          <option value='Confirmada'>Confirmada</option>
                          <option value='Cancelada'>Cancelada</option>
                          <option value='No contestada'>No contestada</option>
                          <option value='Atendida'>Atendida</option>

                        </select>
                      </div>
                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                        <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                      </div>
                </form>
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
  <script type="text/javascript" src="scripts/citasporfecha.js"></script>
  <script>
        $(document).ready(function() {
            $('#estadocita').select2({
                theme: "bootstrap"
            });
        });

  </script>

<?php
}
ob_end_flush();
?>