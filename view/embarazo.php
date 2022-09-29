<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'template/header.php';

if ($_SESSION['embarazos']==1)
{
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
                          <h1 class="box-title">Embarazo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Paciente</th>
                            <th>Edad gestacional inicial</th>
                            <th>Edad gestacional por</th>
                            <th>Fecha probable de parto</th>
                            <th>Fecha registro</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>Paciente</th>
                            <th>Edad gestacional inicial</th>
                            <th>Edad gestacional por</th>
                            <th>Fecha probable de parto</th>
                            <th>Fecha registro</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="container">
                          <div class="row">
                
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="idembarazo" id="idembarazo">
                            <label>Paciente(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idpaciente" id="idpaciente" style="width:100%;">
                            </select>
                        </div> 
                      
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Edad Gestacional Inicial:</label>
                            <input type="text" class="form-control" name="edadgestaini" id="edadgestaini" maxlength="256" placeholder="La edad es en semanas">
                        </div>
                         
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Edad Gestacional por:(*)</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="edadgestapor" id="edadgestapor" style="width:100%;">
                                    <option value=''>Seleccionar una opción</option>
                                    <option value='USG OBS. GENESIS'>USG OBS. GENESIS</option>
                                    <option value='USG OBS. OTRO'>USG OBS. OTRO</option>
                                </select>
                        </div>

                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Probable del Parto:</label>
                            <input type="date" class="form-control" name="fpp" id="fpp">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Estado gestacional(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="estadogesta" id="estadogesta" style="width:100%;">
                                    <option value=''>Seleccionar una opción</option>
                                    <option value='EN CURSO'>EN CURSO</option>
                                    <option value='INTERRUMPIDO'>INTERRUMPIDO</option>
                                    <option value='FINALIZADO'>FINALIZADO</option>
                                </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Detalles del Estado Gestacional:</label>
                            <input type="text" class="form-control" name="detallesestado" id="detallesestado" maxlength="256" placeholder="Detalles del estado gestacional">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Nivel de Riesgo:</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="nivelriesgo" id="nivelriesgo" style="width:100%;">
                                    <option value=''>Seleccionar una opción</option>
                                    <option value='ALTO'>ALTO</option>
                                    <option value='MEDIO'>MEDIO</option>
                                    <option value='BAJO'>BAJO</option>
                                </select>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Observaciones:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" maxlength="250" placeholder="" rows="3"></textarea>
                        </div>
                         
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                </div>

                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
?>
<script type="text/javascript" src="scripts/embarazo.js"></script>
<script>
// In your Javascript (external .js resource or <script> tag)

//Initialize Select2 Elements

$(document).ready(function() {
    $('#idpaciente').select2({
      theme:"bootstrap"
    });
});


$(document).ready(function() {
    $('#edadgestapor').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#estadogesta').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#nivelriesgo').select2({
      theme:"bootstrap"
    });
});

</script>
<?php 
}
ob_end_flush();
?>


