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
                          <h1 class="box-title">Paciente <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Móvil</th>
                            <th>Seguros</th>
                            <th>Fecha de registro</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Móvil</th>
                            <th>Seguros</th>
                            <th>Fecha de registro</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="container">
                          <div class="row">
                          <input type="hidden" name="idpaciente" id="idpaciente">
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Seguros:</label>
                            <textarea class="form-control" name="seguros" id="seguros" maxlength="250" placeholder="EPSS, COLUMNA, ROBLERED, RPN, REDTOTAL, MEDIRED, SEGURED, ESCOLAR, UNIVERSALES, ETC." rows="3"></textarea>
                          </div>
                         <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombres(*):</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Escribe los nombres" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellidos(*):</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" maxlength="50" placeholder="Escribe los apellidos" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Apellido Casada:</label>
                            <input type="text" class="form-control" name="apellidocasada" id="apellidocasada" maxlength="50" placeholder="Apellido Casada">
                          </div>


                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Estado civil(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="estadocivil" id="estadocivil" style="width:100%;">
                                    <option value='No aplica'>No aplica</option>
                                    <option value='Casado(a)'>Casado(a)</option>
                                    <option value='Divorciado(a)'>Divorciado(a)</option>
                                    <option value='Unido(a)'>Unido(a)</option>
                                    <option value='Soltero(a)'>Soltero(a)</option>
                                
                                </select>
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Municipios(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="municipio" id="municipio" style="width:100%;">
                                    <option value='No aplica'>No aplica</option>
                                    <option value='Jalapa'>Jalapa</option>
                                    <option value='Mataquescuintla'>Mataquescuintla</option>
                                    <option value='Monjas'>Monjas</option>
                                    <option value='San Carlos Alzatate'>San Carlos Alzatate</option>
                                    <option value='San Luis Jilotepeque'>San Luis Jilotepeque</option>
                                    <option value='San Pedro Pinula'>San Pedro Pinula</option>
                                    <option value='San Manuel Chaparrón'>San Manuel Chaparrón</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Dirección(*):</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="50" placeholder="Escribe la dirección" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Móvil:</label>
                            <input type="number" class="form-control" name="movil" id="movil" maxlength="50">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Género(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="sexo" id="sexo" style="width:100%;">
                                    <option value=''>Seleccionar una opción</option>
                                    <option value='M'>Hombre</option>
                                    <option value='F'>Mujer</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Grupo sanguineo(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="gsanguineo" id="gsanguineo" style="width:100%;">
                                    <option value='Ninguno'>Ninguna</option>
                                    <option value='A positivo (A +)'>A positivo (A +)</option>
                                    <option value='A negativo (A-)'>A negativo (A-)</option>
                                    <option value='B positivo (B +)'>B positivo (B +)</option>
                                    <option value='B negativo (B-)'>B negativo (B-)</option>
                                    <option value='AB positivo (AB+)'>AB positivo (AB+)</option>
                                    <option value='AB negativo (AB-)'>AB negativo (AB-)</option>
                                    <option value='O positivo (O+)'>O positivo (O+)</option>
                                    <option value='O negativo (O-)'>O negativo (O-)</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha Nacimiento(*):</label>
                            <input type="date" class="form-control" name="fechanac" id="fechanac"  required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nacionalidad:</label>
                            <input type="text" class="form-control" name="nacionalidad" id="nacionalidad">
                          </div>

                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>DPI:</label>
                            <input type="number" class="form-control" name="numero_documento" id="numero_documento" maxlength="256" placeholder="Escribe el número de DPI">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Religión(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="religion" id="religion" style="width:100%;">
                                    <option value='Ninguna'>Ninguna</option>
                                    <option value='Católico'>Católico</option>
                                    <option value='Evangélico'>Evangélico</option>
                                    <option value='Cristiano'>Cristiano</option>
                                    <option value='Testigo de Jehová'>Testigo de Jehová</option>
                                    <option value='Mormón'>Mormón</option>
                                    <option value='Judío'>Judío</option>
                                    <option value='Musulmán'>Musulmán</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Correo electrónico:</label>
                            <input type="email" class="form-control" name="email" id="email" maxlength="256" placeholder="Escribe el correo electrónico">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Observaciones:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" maxlength="250" placeholder="Observaciones" rows="3"></textarea>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombre Encargado:</label>
                            <input type="text" class="form-control" name="nencargado" id="nencargado" maxlength="256" placeholder="Nombre del encargado">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Parentesco:</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="parentesco" id="parentesco" style="width:100%;">
                                    <option value='Amigo'>Amigo(a)</option>
                                    <option value='Padre'>Padre</option>
                                    <option value='Madre'>Madre</option>
                                    <option value='Tio'>Tio(a)</option>
                                    <option value='Primo'>Primo(a)</option>
                                    <option value='Cónyuge'>Cónyuge</option>
                                    <option value='Hijo'>Hijo(a)</option>
                                    <option value='Abuelo'>Abuelo(a)</option>
                                    <option value='Hermano'>Hermano(a)</option>
                                    <option value='Encargado'>Encargado(a)</option>
                                    <option value='Otros'>Otros</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Tel. Referencia:</label>
                            <input type="number" class="form-control" name="tel_referencia" id="tel_referencia" maxlength="50">
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
<script type="text/javascript" src="scripts/paciente.js"></script>
<script>
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('#sexo').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#municipio').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#religion').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#parentesco').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#estadocivil').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#gsanguineo').select2({
      theme:"bootstrap"
    });
});


//Initialize Select2 Elements
</script>
<?php 
}
ob_end_flush();
?>


