<?php
        require 'template/header.php';
?>

<?php
            
            if ($_SESSION['home'] == 1 || $_SESSION['almacen'] == 1 || $_SESSION['compras'] == 1 || $_SESSION['ventas'] == 1 || $_SESSION['consultac'] == 1 || $_SESSION['consultav'] == 1 || $_SESSION['ayuda'] == 1 || $_SESSION['noadmin'] == 1) {
             
              header("Location: escritorio.php");
              exit;
           }else if($_SESSION['almacen'] == 1){
            header("Location: articulo.php");
            exit;
           }else if($_SESSION['compras'] == 1){
            header("Location: ingreso.php");
            exit;
           }
           else if($_SESSION['ventas'] == 1){
            header("Location: venta.php");
            exit;
           }
           
?>
           
<br>
<div class="content-wrapper" style="min-height: 1602px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>404 Error Page</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops!.</h3>

          <p>
           No tienes acceso a esta página.
          </p>

        
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>

<?php
        require 'template/footer.php';
?>