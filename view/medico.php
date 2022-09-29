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

if ($_SESSION['medicos']==1)
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
                          <h1 class="box-title">Médico <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Especialidad</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Móvil</th>
                            <th>DPI</th>
                            <th>No. Colegiado</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Especialidad</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Móvil</th>
                            <th>DPI</th>
                            <th>No. Colegiado</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="container">
                          <div class="row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="hidden" name="idmedico" id="idmedico">
                            <label>Usuario(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idusuario" id="idusuario" style="width:100%;">
                            </select>
                        </div> 
                        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Especialidad(*):</label>
                            <select class="form-control form-control-lg js-example-basic-single select2"
                                name="idespecialidad" id="idespecialidad" style="width:100%;">
                            </select>
                        </div> 
                       
                         <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Escribe los nombres" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" maxlength="50" placeholder="Escribe los apellidos" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" maxlength="50" placeholder="Escribe la dirección" required>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Móvil:</label>
                            <input type="number" class="form-control" name="movil" id="movil" maxlength="50" required>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <label>Género(*):</label>
                                <select class="form-control form-control-lg js-example-basic-single select2"
                                            name="sexo" id="sexo" style="width:100%;">
                                    <option value=''>Seleccionar una opción</option>
                                    <option value='M'>Hombre</option>
                                    <option value='F'>Mujer</option>
                                </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label>Fecha Nacimiento:</label>
                            <input type="date" class="form-control" name="fechanac" id="fechanac"  required>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label>DPI(*):</label>
                            <input type="number" class="form-control" name="numero_documento" id="numero_documento" maxlength="256" placeholder="Escribe el número de DPI">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <label>No. Colegiado(*):</label>
                            <input type="number" class="form-control" name="numcolegiatura" id="numcolegiatura" maxlength="256" placeholder="Escribe el número de Colegiado">
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
<script type="text/javascript" src="scripts/medico.js"></script>
<script>
// In your Javascript (external .js resource or <script> tag)

//Initialize Select2 Elements

$(document).ready(function() {
    $('#idusuario').select2({
      theme:"bootstrap"
    });
});
$(document).ready(function() {
    $('#idespecialidad').select2({
      theme:"bootstrap"
    });
});

$(document).ready(function() {
    $('#sexo').select2({
      theme:"bootstrap"
    });
});
</script>
<?php 
}
ob_end_flush();
?>


