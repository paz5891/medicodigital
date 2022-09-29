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
                                <h1 class="box-title">Historia de consulta ginecológica por paciente </h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label>Paciente(*):</label>
                                            <select class="form-control form-control-lg js-example-basic-single select2" name="idpaciente" id="idpaciente" style="width:100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Fecha Inicio</label>
                                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <label>Fecha Fin</label>
                                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <label></label>
                                            <button class="form-control btn btn-success" onclick="listar()">Mostrar</button>
                                        </div>
                                    </div>
                                </div>
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th>Paciente</th>
                                        <th>Peso</th>
                                        <th>Estatura</th>
                                        <th>Temperatura</th>
                                        <th>Presión arterial</th>
                                        <th>Frecuencia cardíaca</th>

                                        <th>Frecuencia respiratoria</th>
                                        <th>Fecha</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Paciente</th>
                                        <th>Peso</th>
                                        <th>Estatura</th>
                                        <th>Temperatura</th>
                                        <th>Presión arterial</th>
                                        <th>Frecuencia cardíaca</th>

                                        <th>Frecuencia respiratoria</th>
                                        <th>Fecha</th>
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
    <script type="text/javascript" src="scripts/rginecologica.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)

        //Initialize Select2 Elements

        $(document).ready(function() {
            $('#idpaciente').select2({
                theme: "bootstrap"
            });
        });
    </script>

<?php
}
ob_end_flush();
?>