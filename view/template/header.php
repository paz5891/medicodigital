<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../plantilla/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../plantilla/dist/css/datatable.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.lite.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  <style>
    div.container {
      max-width: 1200px
    }
  </style>
  <style>
    .swal2-popup {
      font-size: 1.6rem !important;
    }

    .select2-container .select2-choice,
    .select2-result-label {
      font-size: 1.5em;
      height: 41px;
      overflow: auto;
    }

    .select2-selection {
      min-height: 10px !important;
    }

    .select2-container .select2-selection--single {
      height: 35px !important;
    }

    .select2-selection__arrow {
      height: 34px !important;
    }
  </style>
</head>



<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="../plantilla/dist/img/circulo adem.png" alt="AdminLTELogo" height="80" width="80">
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Soporte técnico</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
      <div class="dropdown">
        <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img id="img_nav" style="width: 28px;" class="img-circle elevation-2" src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>">
          <strong><span class="hidden-xs text-primary"><?php echo $_SESSION['nombre']; ?></span></strong>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li class="user-header">
            <div class="image">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2" alt="User Image" style="height:200px; width:200px;">
            </div>
            <div class="text-center">
              <strong><a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a></strong>
            </div>
          </li>
          <li class="user-footer">
            <a href="../controller/usuario.php?op=salir" class="dropdown-item">
              <i class="fas fa-arrow-left mr-2"></i> Salir
              <span class="float-right text-muted text-sm">ahora</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" onclick="AbrirModalEditarContra()">
              <i class="fas fa-users mr-2"></i> Cambiar
              <span class="float-right text-muted text-sm">Contraseña</span>
            </a>
            <div class="dropdown-divider"></div>
          </li>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="../plantilla/dist/img/circulo adem.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">EMD App</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <?php


            if ($_SESSION['escritorio'] == 1 || $_SESSION['citas'] == 1 || $_SESSION['pacientes'] == 1 || $_SESSION['consultas'] == 1 || $_SESSION['embarazos'] == 1 || $_SESSION['medicos'] == 1 || $_SESSION['segurosyvacunas'] == 1 || $_SESSION['acceso'] == 1 || $_SESSION['reportes'] == 1) {
              echo '<li class="nav-header">MÉDICOS</li>';
            }


            if ($_SESSION['escritorio'] == 1) {
              echo '<li class="nav-item">
            <a href="../view/home.php" class="nav-link active">
          <i class="nav-icon fas fa-columns"></i>
            <p>
              Home 
            </p>
          </a>
          </li>';
            }
            ?>


            <?php
            if ($_SESSION['citas'] == 1) {
              echo '<li class="nav-item">
            <a href="../view/citas.php" class="nav-link active">
            <i class="nav-icon fas fa-clock"></i>
            <p>
              Citas 
            </p>
          </a>
          </li>';
            }
            ?>


            <?php
            if ($_SESSION['pacientes'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="fas fa-procedures"></i>
              </i>
              <p>
                Pacientes
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="paciente.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Pacientes</p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="historialclinico.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Historial Clínico</p>
                </a>
              </li>
              
          <li class="nav-item">
          <a href="referencia.php" class="nav-link">
          <i class="far fa-check-circle nav-icon"></i>
            <p>Referencia</p>
          </a>
        </li>
            </ul>
          </li>';
            }
            ?>


            <?php
            if ($_SESSION['consultas'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fas fa-notes-medical"></i>
              </i>
              <p>
                Consultas
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
            <a href="cginecologica.php" class="nav-link">
            <i class="far fa-check-circle nav-icon"></i>
              <p>Consulta ginecológica</p>
            </a>
          </li>
          <li class="nav-item">
          <a href="cpediatrica.php" class="nav-link">
          <i class="far fa-check-circle nav-icon"></i>
            <p>Consulta pediátrica</p>
          </a>
        </li>
            
            </ul>
          </li>';
            }
            ?>


            <?php
            if ($_SESSION['embarazos'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fa fa-female"></i>
              </i>
              <p>
                Control de embarazos
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="embarazo.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Embarazo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cprenatal.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Consulta prenatal</p>
                </a>
              </li>
              
            </ul>
          </li>';
            }
            ?>






            <?php
            if ($_SESSION['medicos'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fas fa-user-md"></i>
              </i>
              <p>
                Médico
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="medico.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Médicos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="especialidad.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Especialidad</p>
                </a>
              </li>
            
            </ul>
          </li>';
            }
            ?>





            <?php
            if ($_SESSION['segurosyvacunas'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fas fa-syringe"></i>
              </i>
              <p>
                Vacunas y Seguros
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="seguro.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Seguros</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vacuna.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Vacunas</p>
                </a>
              </li>
            
            </ul>
          </li>';
            }
            ?>



            <?php
            if ($_SESSION['acceso'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-key">
              </i>
              <p>
                Acceso
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="usuarios.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="permisos.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Permisos</p>
                </a>
              </li>
            </ul>
          </li>';
            }
            ?>



            <?php
            if ($_SESSION['reportes'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fas fa-chart-line"></i>
              </i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="rginecologica.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>C. Ginecológica Paciente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rpediatrica.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>C. Pediátrica  Paciente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="totalprenatal.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Total C. Prenatal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="totalpediatrica.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Total C. Pediátrica </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="totalginecologica.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Total C. Ginecológica</p>
                </a>
              </li>
         
            </ul>
          </li>';
            }
            ?>

            <?php
            
 if ($_SESSION['home'] == 1 || $_SESSION['almacen'] == 1 || $_SESSION['compras'] == 1 || $_SESSION['ventas'] == 1 || $_SESSION['consultac'] == 1 || $_SESSION['consultav'] == 1 || $_SESSION['ayuda'] == 1 || $_SESSION['noadmin'] == 1) {
  echo '<li class="nav-header">POS</li>';
};

            ?>
            <?php


           


            if ($_SESSION['home'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/escritorio.php" class="nav-link active">
                    <i class="nav-icon fas fa-columns"></i>
                      <p>
                        Home 
                      </p>
                    </a>
                    </li>';
            }
            ?>


<?php
            if ($_SESSION['almacen'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
            <i class="fas fa-cubes"></i>
              </i>
              <p>
                Almacén
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="articulo.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Artículos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="categoria.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ubicacion.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Ubicación</p>
                </a>
              </li>
            
            </ul>
          </li>';
            }
            ?>
<?php
            if ($_SESSION['compras'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
           
            <i class="fas fa-money-bill-alt"></i>
              </i>
              <p>
                Compras
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="ingreso.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Ingresos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="proveedor.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
        
            
            </ul>
          </li>';
            }
            ?>

<?php
            if ($_SESSION['ventas'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
           
            <i class="fas fa-shopping-cart"></i>
              </i>
              <p>
                Ventas
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="venta.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cliente.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
        
            
            </ul>
          </li>';
            }
            ?>
<?php
            if ($_SESSION['consultac'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/consultascompras.php" class="nav-link active">
                    <i class="fas fa-chart-area"></i>
                      <p>
                        Consultas compras 
                      </p>
                    </a>
                    </li>';
            }
            ?>
<?php
            if ($_SESSION['consultav'] == 1) {
              echo '<li class="nav-item">
                    <a href="../view/consultasventas.php" class="nav-link active">
                    <i class="fas fa-chart-line"></i>
                      <p>
                        Consultas ventas 
                      </p>
                    </a>
                    </li>';
            }
            ?>


<?php
            if ($_SESSION['noadmin'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link active">
           
            <i class="fas fa-book-open"></i>
              </i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="noadmin.php" class="nav-link">
                  <i class="far fa-check-circle nav-icon"></i>
                  <p>Consulta ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="abastecer.php" class="nav-link">
                <i class="far fa-check-circle nav-icon"></i>
                  <p>Abastecer</p>
                </a>
              </li>
        
            
            </ul>
          </li>';
            }
?>


            
         


          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>