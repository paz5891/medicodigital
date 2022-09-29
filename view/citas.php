<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'template/header.php';

    if ($_SESSION['pacientes'] == 1) {
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
                                <h1 class="box-title">Citas <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Médico</th>
                                        <th>Seguro</th>
                                        <th>Tipo de cita</th>
                                        <th>Paciente</th>
                                        <th>Visitador</th>
                                        <th>Asunto</th>
                                        <th>Teléfono</th>
                                        <th>Fecha y Hora</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Médico</th>
                                        <th>Seguro</th>
                                        <th>Tipo de cita</th>
                                        <th>Paciente</th>
                                        <th>Visitador</th>
                                        <th>Asunto</th>
                                        <th>Teléfono</th>
                                        <th>Fecha y Hora</th>
                                        <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="panel-body" style="height: 400px;" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="row">


                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Médico:</label>
                                            <input type="hidden" name="idcita" id="idcita">
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="idmedico" id="idmedico" style="width:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Seguro:</label>
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="idseguro" id="idseguro" style="width:100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Tipo de cita:</label>
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="tipocita" id="tipocita" style="width:100%;">
                                            <option value='Ginecologica'>Ginecológica</option>
                                                <option value='Prenatal'>Prenatal</option>
                                                <option value='Pediatrica'>Pediatrica</option>
                                            
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Paciente:</label>
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="pacienteovisitador" id="pacienteovisitador" style="width:100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Visitador/Paciente:</label>
                                            <input type="text" class="form-control" name="visitador" id="visitador" maxlength="256" placeholder="">
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <label>Asunto:</label>
                                            

                                            <textarea class="form-control" name="asunto" id="asunto" maxlength="250" placeholder="" rows="4"></textarea>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <label>Teléfono:</label>
                                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="256" placeholder="">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <label>Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" maxlength="256" placeholder="">
                                        </div>



                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <label>Hora:</label>
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="hora" id="hora" style="width:100%;">

                                                <option value='12:00 AM'>12:00 AM</option>
                                                <option value='12:15 AM'>12:15 AM</option>
                                                <option value='12:30 AM'>12:30 AM</option>
                                                <option value='12:45 AM'>12:45 AM</option>

                                                <option value='01:00 AM'>01:00 AM</option>
                                                <option value='01:15 AM'>01:15 AM</option>
                                                <option value='01:30 AM'>01:30 AM</option>
                                                <option value='01:45 AM'>01:45 AM</option>


                                                <option value='02:00 AM'>02:00 AM</option>
                                                <option value='02:15 AM'>02:15 AM</option>
                                                <option value='02:30 AM'>02:30 AM</option>
                                                <option value='02:45 AM'>02:45 AM</option>

                                                <option value='03:00 AM'>03:00 AM</option>
                                                <option value='03:15 AM'>03:15 AM</option>
                                                <option value='03:30 AM'>03:30 AM</option>
                                                <option value='03:45 AM'>03:45 AM</option>


                                                <option value='04:00 AM'>04:00 AM</option>
                                                <option value='04:15 AM'>04:15 AM</option>
                                                <option value='04:30 AM'>04:30 AM</option>
                                                <option value='04:45 AM'>04:45 AM</option>

                                                <option value='05:00 AM'>05:00 AM</option>
                                                <option value='05:15 AM'>05:15 AM</option>
                                                <option value='05:30 AM'>05:30 AM</option>
                                                <option value='05:45 AM'>05:45 AM</option>






                                                <option value='06:00 AM'>06:00 AM</option>
                                                <option value='06:15 AM'>06:15 AM</option>
                                                <option value='06:30 AM'>06:30 AM</option>
                                                <option value='06:45 AM'>06:45 AM</option>


                                                <option value='07:00 AM'>07:00 AM</option>
                                                <option value='07:15 AM'>07:15 AM</option>
                                                <option value='07:30 AM'>07:30 AM</option>
                                                <option value='07:45 AM'>07:45 AM</option>


                                                <option value='08:00 AM'>08:00 AM</option>
                                                <option value='08:15 AM'>08:15 AM</option>
                                                <option value='08:30 AM'>08:30 AM</option>
                                                <option value='08:45 AM'>08:45 AM</option>
                                                

                                                <option value='09:00 AM'>09:00 AM</option>
                                                <option value='09:15 AM'>09:15 AM</option>
                                                <option value='09:30 AM'>09:30 AM</option>
                                                <option value='09:45 AM'>09:45 AM</option>


                                                <option value='10:00 AM'>10:00 AM</option>
                                                <option value='10:15 AM'>10:15 AM</option>
                                                <option value='10:30 AM'>10:30 AM</option>
                                                <option value='10:45 AM'>10:45 AM</option>

                                                <option value='11:00 AM'>11:00 AM</option>
                                                <option value='11:15 AM'>11:15 AM</option>
                                                <option value='11:30 AM'>11:30 AM</option>
                                                <option value='11:45 AM'>11:45 AM</option>



                                                <option value='12:00 PM'>12:00 PM</option>
                                                <option value='12:15 PM'>12:15 PM</option>
                                                <option value='12:30 PM'>12:30 PM</option>
                                                <option value='12:45 PM'>12:45 PM</option>

                                                <option value='01:00 PM'>01:00 PM</option>
                                                <option value='01:15 PM'>01:15 PM</option>
                                                <option value='01:30 PM'>01:30 PM</option>
                                                <option value='01:45 PM'>01:45 PM</option>


                                                <option value='02:00 PM'>02:00 PM</option>
                                                <option value='02:15 PM'>02:15 PM</option>
                                                <option value='02:30 PM'>02:30 PM</option>
                                                <option value='02:45 PM'>02:45 PM</option>

                                                <option value='03:00 PM'>03:00 PM</option>
                                                <option value='03:15 PM'>03:15 PM</option>
                                                <option value='03:30 PM'>03:30 PM</option>
                                                <option value='03:45 PM'>03:45 PM</option>


                                                <option value='04:00 PM'>04:00 PM</option>
                                                <option value='04:15 PM'>04:15 PM</option>
                                                <option value='04:30 PM'>04:30 PM</option>
                                                <option value='04:45 PM'>04:45 PM</option>

                                                <option value='05:00 PM'>05:00 PM</option>
                                                <option value='05:15 PM'>05:15 PM</option>
                                                <option value='05:30 PM'>05:30 PM</option>
                                                <option value='05:45 PM'>05:45 PM</option>

                                                <option value='06:00 PM'>06:00 PM</option>
                                                <option value='06:15 PM'>06:15 PM</option>
                                                <option value='06:30 PM'>06:30 PM</option>
                                                <option value='06:45 PM'>06:45 PM</option>

                                                <option value='07:00 PM'>07:00 PM</option>
                                                <option value='07:15 PM'>07:15 PM</option>
                                                <option value='07:30 PM'>07:30 PM</option>
                                                <option value='07:45 PM'>07:45 PM</option>

                                                <option value='08:00 PM'>08:00 PM</option>
                                                <option value='08:15 PM'>08:15 PM</option>
                                                <option value='08:30 PM'>08:30 PM</option>
                                                <option value='08:45 PM'>08:45 PM</option>

                                                <option value='09:00 PM'>09:00 PM</option>
                                                <option value='09:15 PM'>09:15 PM</option>
                                                <option value='09:30 PM'>09:30 PM</option>
                                                <option value='09:45 PM'>09:45 PM</option>

                                                <option value='10:00 PM'>10:00 PM</option>
                                                <option value='10:15 PM'>10:15 PM</option>
                                                <option value='10:30 PM'>10:30 PM</option>
                                                <option value='10:45 PM'>10:45 PM</option>

                                                <option value='11:00 PM'>11:00 PM</option>
                                                <option value='11:15 PM'>11:15 PM</option>
                                                <option value='11:30 PM'>11:30 PM</option>
                                                <option value='11:45 PM'>11:45 PM</option>



                                                
	                         
                                            </select>
                                        </div>




                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                                            <button class="btn btn-warning" onclick="limpiar()" type="button"><i class="fa fa-trash"></i> Limpiar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                                        </div>

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
    <script type="text/javascript" src="scripts/cita.js"></script>
  
    <script>
        $(document).ready(function() {
            $('#idmedico').select2({
                theme: "bootstrap"
            });
        });


        $(document).ready(function() {
            $('#pacienteovisitador').select2({
                theme: "bootstrap"
            });
        });

        $(document).ready(function() {
            $('#tipocita').select2({
                theme: "bootstrap"
            });
        });

        $(document).ready(function() {
            $('#idseguro').select2({
                theme: "bootstrap"
            });
        });
        $(document).ready(function() {
            $('#hora').select2({
                theme: "bootstrap"
            });
        });
        $(document).ready(function() {
            $('#estadocita').select2({
                theme: "bootstrap"
            });
        });


        $(document).ready(function() {
            $("#visitador").on("keyup", function() {
                if ($("#visitador").val() == "") {
                    $("#pacienteovisitador").prop("disabled", false);
                } else {
                    $("#pacienteovisitador").prop("disabled", true );
                }
            });
            $("#pacienteovisitador").on("change", function() {
                if ($("#pacienteovisitador").val() == null || $("#pacienteovisitador").val() == "") {
                    $("#visitador").prop("disabled", false);
                } else {
                    $("#visitador").prop("disabled", true);
                }
            });
        });
    </script>
<?php
}
ob_end_flush();
?>