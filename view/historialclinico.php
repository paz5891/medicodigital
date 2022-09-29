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

if ($_SESSION['pacientes']==1)
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
                          <h1 class="box-title">Historial Clínico <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th>Historia/Enfermedad</th>
                            <th>Fecha de registro</th>
                            <th>Expediente</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                          <th>Opciones</th>
                            <th>Paciente</th>
                            <th>Historia/Enfermedad</th>
                            <th>Fecha de registro</th>
                            <th>Expediente</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="container-fluid">
                          <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Expediente(Archivo PDF):</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <input type="hidden" value=""  id="imagenmuestra">
                        </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h4 style="text-align: center;">Información general</h4>
                          </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="idhistoriaclinica" id="idhistoriaclinica">
                            <label>Paciente(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idpaciente" id="idpaciente" style="width:100%;">
                            </select>
                        </div> 
                      
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Historia/Enfermedad:</label>
                            <textarea class="form-control" name="enfermedadingreso" id="enfermedadingreso" maxlength="250" placeholder="Diabetes, VIH, Anemia, Hipertensión, Fumadora, Alcohol, Drogas, Violencia, Otros." rows="4"></textarea>
                        </div>
                         
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Antecedentes médicos:</label>
                            <textarea class="form-control" name="antecedentesmedicos" id="antecedentesmedicos" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                         
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Antecedentes quirúrgicos:</label>
                            <textarea class="form-control" name="antecedentesquir" id="antecedentesquir" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>


                       


                        
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Antecedentes familiares:</label>
                            <textarea class="form-control" name="antecedentesfam" id="antecedentesfam" maxlength="250" placeholder="Diabetes, VIH, Anemia, Hipertensión, Fumadora, Alcohol, Drogas, Violencia, Otros." rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Alergias:</label>
                            <textarea class="form-control" name="alergias" id="alergias" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Medicamentos:</label>
                            <textarea class="form-control" name="medicamentos" id="medicamentos" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Vacunas:</label>
                            <ul style="list-style: none;" id="vacunas">
                              
                            </ul>
                          </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Hábitos/Estilo de vida:</label>
                            <textarea class="form-control" name="habitos" id="habitos" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label>Antecedentes prenatales:</label>
                            <textarea class="form-control" name="antecedentespren" id="antecedentespren" maxlength="250" placeholder="Solo para niños" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Observaciones:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <h4 style="text-align: center;">Información ginecológica</h4>
                        </div>
                     
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Antecedentes ginecológicos:</label>
                            <textarea class="form-control" name="antecedentesgin" id="antecedentesgin" maxlength="250" placeholder="Solo para mujeres" rows="4"></textarea>
                        </div>
                  




                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Gestas:</label>
                            <textarea class="form-control" name="gestas" id="gestas" maxlength="250" placeholder="Escribe las gestas" rows="4"></textarea>
                        </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Hijos vivos:</label>
                            <input type="number" class="form-control" name="hv" id="hv" maxlength="256" placeholder="Cantidad de hijos vivos">
                        </div>
                         
                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Hijos muertos:</label>
                            <input type="number" class="form-control" name="hm" id="hm" maxlength="256" placeholder="Cantidad de hijos muertos">
                        </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha del último parto:</label>
                            <input type="date" class="form-control" name="fup" id="fup">
                        </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha del último papanicolau:</label>
                            <input type="date" class="form-control" name="fupap" id="fupap">
                        </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Estatura:</label>
                            <input type="text" class="form-control" name="estatura" id="estatura">
                        </div>

                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Ciclos:</label>
                            <textarea class="form-control" name="ciclos" id="ciclos" maxlength="250" placeholder="Escriba los ciclos" rows="4"></textarea>
                        </div>


                         <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Planificación familiar:</label>
                            <textarea class="form-control" name="planfam" id="planfam" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>


                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label>Infecciones:</label>
                            <textarea class="form-control" name="infecciones" id="infecciones" maxlength="250" placeholder="" rows="4"></textarea>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Observaciones ginecológicas:</label>
                            <textarea class="form-control" name="observacionesg" id="observacionesg" maxlength="250" placeholder="" rows="4"></textarea>
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
<script type="text/javascript" src="scripts/historiaclinica.js"></script>
<script>
// In your Javascript (external .js resource or <script> tag)

//Initialize Select2 Elements

$(document).ready(function() {
    $('#idpaciente').select2({
      theme:"bootstrap"
    });
});

</script>
<?php 
}
ob_end_flush();
?>


