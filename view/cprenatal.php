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
                          <h1 class="box-title">Consulta prenatal <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Seguro</th>
                            <th>Monto a cobrar</th>
                            <th>Fecha de registro</th>
                            <th>Resultado de examen</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>Paciente</th>
                            <th>Seguro</th>
                            <th>Monto a cobrar</th>
                            <th>Fecha de registro</th>
                            <th>Resultado de examen</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="container-fluid">
                          <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h4 style="text-align: center;">Información general</h4>
                              <input type="hidden" name="idcprenatal" id="idcprenatal">
                          </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Paciente(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idpaciente" id="idpaciente" style="width:100%;">
                            </select>
                        </div> 
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Embarazo(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idembarazo" id="idembarazo" style="width:100%;">
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Seguro médico(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idseguro" id="idseguro" style="width:100%;">
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Historia de la enfermedad:</label>
                            <textarea type="text" class="form-control" name="historia" id="historia" maxlength="256" placeholder="" rows="5"></textarea>
                        </div>

                        
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Edad Gestacional Actual:</label>
                            <input type="number" class="form-control" name="edadgestaact" id="edadgestaact" maxlength="256" placeholder="Escribe el número de semanas">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Peso:</label>
                            <input type="text" class="form-control" name="peso" id="peso" maxlength="256" placeholder="Libras">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Estatura:</label>
                            <input type="number" class="form-control" name="estatura" id="estatura" maxlength="256" placeholder="En centimetros">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Temperatura:</label>
                            <input type="text" class="form-control" name="temperatura" id="temperatura" maxlength="256" placeholder="En °C">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Presión Arterial:</label>
                            <input type="text" class="form-control" name="pa" id="pa" maxlength="256" placeholder="">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Frecuencia Cardíaca:</label>
                            <input type="text" class="form-control" name="fc" id="fc" maxlength="256" placeholder="">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Frecuencia Respiratoria:</label>
                            <input type="text" class="form-control" name="fr" id="fr" maxlength="256" placeholder="">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Examen de Mamas:</label>
                            <input type="text" class="form-control" name="examenmamas" id="examenmamas" maxlength="256" placeholder="">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Examen Ginecológico:</label>
                            <input type="text" class="form-control" name="examenginec" id="examenginec" maxlength="256" placeholder="">
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Examen físico:</label>
                            <textarea type="text" class="form-control" name="examenfisico" id="examenfisico" maxlength="256" placeholder="" rows="4"></textarea>
                        </div>
                     


                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Resultado de examen de diagnóstico(Archivo PDF):</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <input type="hidden" value=""  id="imagenmuestra">
                        </div>



                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Descripción de resultado examen:</label>
                            <textarea type="text" class="form-control" name="descripcionresexadiag" id="descripcionresexadiag" maxlength="256" placeholder="" rows="4"></textarea>
                        </div>
                    
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Ultrasonido Obstétrico:</label>
                            <textarea class="form-control" name="usgobs" id="usgobs" maxlength="250" placeholder="información del usg" rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Impresión Clínica:</label>
                            <textarea class="form-control" name="ic" id="ic" maxlength="250" placeholder="Impresión Clínica" rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Tratamiento:</label>
                            <textarea class="form-control" name="tx" id="tx" maxlength="250" placeholder="Tratamiento" rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Orden de Examen de Diagnóstico:</label>
                            <textarea class="form-control" name="ordenexadiag" id="ordenexadiag" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Próxima cita:</label>
                            <input type="date" class="form-control" name="proximacita" id="proximacita" maxlength="256">
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Monto a cobrar:</label>
                            <input type="text" class="form-control" name="montoacobrar" id="montoacobrar" maxlength="256">
                        </div>
                        
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Observaciones:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" maxlength="250" placeholder="" rows="4"></textarea>
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
<script type="text/javascript" src="scripts/cprenatal.js"></script>
<script>
// In your Javascript (external .js resource or <script> tag)

//Initialize Select2 Elements

$(document).ready(function() {
    $('#idpaciente').select2({
      theme:"bootstrap"
    });
});
$(document).ready(function() {
    $('#idembarazo').select2({
      theme:"bootstrap"
    });
});
$(document).ready(function() {
    $('#idseguro').select2({
      theme:"bootstrap"
    });
});

</script>
<?php 
}
ob_end_flush();
?>


