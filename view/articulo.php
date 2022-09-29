<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'template/header.php';

    if ($_SESSION['almacen'] == 1) {
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
                                <h1 class="box-title">Artículo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info">Reporte Artículos</button></a> <a href="../reportes/rptabastecer.php" target="_blank"><button class="btn btn-warning">Reporte de artículos para abastecer</button></a></h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>

                                        <th>Stock</th>
                                        <th>Ubicación</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Imagen</th>
                                        <th>Estado</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>

                                        <th>Stock</th>
                                        <th>Ubicación</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Imagen</th>
                                        <th>Estado</th>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Nombre(*):</label>
                                                <input type="hidden" name="idarticulo" id="idarticulo">
                                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Categoría(*):</label>
                                                <select id="idcategoria" name="idcategoria" class="form-control form-control-lg js-example-basic-single select2" style="width:100%;" required></select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Ubicación(*):</label>
                                                <select id="idubicacion" name="idubicacion" class="form-control form-control-lg js-example-basic-single select2" style="width:100%;" required></select>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Medida:</label>
                                                <input type="text" class="form-control" name="medida" id="medida" maxlength="256" placeholder="Medida" required>
                                            </div>

                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Descripción:</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <label>Imagen:</label>
                                                <input type="file" class="form-control" name="imagen" id="imagen">
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                                <img src="" width="150px" height="120px" id="imagenmuestra">
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                            </div>
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
    <script type="text/javascript" src="scripts/articulo.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)

        //Initialize Select2 Elements

        $(document).ready(function() {
            $('#idcategoria').select2({
                theme: "bootstrap"
            });
        });
        $(document).ready(function() {
            $('#idubicacion').select2({
                theme: "bootstrap"
            });
        });
    </script>
<?php
}
ob_end_flush();
?>