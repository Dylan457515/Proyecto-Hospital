<?php
session_start();
if (!isset($_SESSION['S_IDUSUARIO'])) {
  header('Location: ../Login/index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Plantilla/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../Plantilla/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Plantilla/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../Plantilla/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../Plantilla/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../Plantilla/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../Plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../Plantilla/plugins/DataTables/datatables.min.css">

  <link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">




</head>

<style>
  .swal2-popup {
    font-size: 1.6rem !important;
  }
</style>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>HOSPITAL</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->


            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img id="img_nav" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['S_USER']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img id="img_subnav" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $_SESSION['S_USER']; ?>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" onclick="AbrirModalEditarContra()" class="btn btn-default btn-flat">Canbiar Contra&ntilde;a</a>
                  </div>
                  <div class="pull-right">
                    <a href="../controlador/usuario/controlador_cerrar_session.php" class="btn btn-default btn-flat">Salir</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <br>
          <div class="pull-left image">
            <img id="img_lateral" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['S_USER']; ?></p>
            <p><?php echo $_SESSION['S_ROL']; ?></p>
            <br>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <br>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">PANEL</li>
          <li class="active treeview">
            <?php
            if ($_SESSION['S_ROL'] == 'ADMINISTRADOR') {
            ?>
              <a onclick="cargar_contenido('contenido_principal','cita/vista_cita_listar.php')">
                <i class="fa fa-user"></i> <span>Cita</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','consulta/vista_consulta_listar.php')">
                <i class="fa fa-stethoscope"></i> <span>Consulta Medica</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','paciente/vista_paciente_listar.php')">
                <i class="fa fa-user"></i> <span>Paciente</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','medico/vista_medico_listar.php')">
                <i class="fa fa-user-md"></i> <span>Medico</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','usuario/vista_usuario_listar.php')">
                <i class="fa fa-user"></i> <span>Usuario</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','procedimiento/vista_procedimiento_listar.php')">
                <i class="fa fa-spinner"></i> <span>Procedimiento</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','historial/vista_historial_listar.php')">
                <i class="fa fa-file-text-o"></i> <span>Historial Clinico</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','insumo/vista_insumo_listar.php')">
                <i class="fa fa-cubes"></i> <span>Insumos</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','medicamento/vista_medicamento_listar.php')">
                <i class="fa fa-medkit"></i> <span>Medicamentos</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <a onclick="cargar_contenido('contenido_principal','especialidad/vista_especialidad_listar.php')">
                <i class="fa fa-gg"></i> <span>Especialidad</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <?php
            }
            ?>

            <?php
            if ($_SESSION['S_ROL'] == 'RECEPCIONISTA') {
            ?>
              <!-- /.contenido que se vera segun el rol -->
              <a onclick="cargar_contenido('contenido_principal','cita/vista_cita_listar.php')">
                <i class="fa fa-user"></i> <span>Cita</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>

              <a onclick="cargar_contenido('contenido_principal','historial/vista_historial_listar.php')">
                <i class="fa fa-file-text-o"></i> <span>Historial Clinico</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <?php
            }
            ?>
            <?php
            if ($_SESSION['S_ROL'] == 'MEDICO') {
            ?>
              <!-- /.contenido que se vera segun el rol -->
              <a onclick="cargar_contenido('contenido_principal','consulta/vista_consulta_listar.php')">
                <i class="fa fa-stethoscope"></i> <span>Consulta Medica</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>

              <a onclick="cargar_contenido('contenido_principal','historial/vista_historial_listar.php')">
                <i class="fa fa-file-text-o"></i> <span>Historial Clinico</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <?php
            }
            ?>



          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content">
        <input type="text" id="txtidprincipal" value="<?php echo $_SESSION['S_IDUSUARIO'] ?>" hidden>
        <input type="text" id="usuarioprincipal" value="<?php echo $_SESSION['S_USER'] ?>" hidden>
        <div class="row" id="contenido_principal">
          <div class="col-md-12">
            <div class="box box-warning box-solid">

              <div class="box-header with-border">
                <h3 class="box-title">ESTADISTICAS DE CITAS HECHAS</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="col-lg-12" style="padding-top:40px;">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-6">
                          <canvas id="StadisticasCitas" width="400" height="400"></canvas>
                        </div>
                        <div class="col-md-6">
                          <div class="box box-default box-solid">
                            <div class="box-header with-border">
                              <h3 class="box-title">Analisis citas</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                              <div class="col-lg-12">
                                <label for="">Funcion Polinomial</label>
                                <input type="text" id="polinomio" class="form-control" disabled>
                                <br>
                              </div>
                              <div class="col-lg-6">
                                <label for="">Busca la cita en tal dia</label>
                                <input type="text" id="buscar_cantidad_citas" class="form-control" onkeypress="return soloNumeros(event)">
                              </div>
                              <div class="col-lg-3">
                                <label for="">&nbsp;</label><br>
                                <button class="btn btn-success" style="width: 100%;" onclick="EvaluarPolinomio()"><i class="glyphicon glyphicon-search"></i>Buscar</button><br><br>
                              </div>

                              <div class="col-lg-6">
                                <label for="">Resultado</label>
                                <input type="text" id="resultado_pol" class="form-control" disabled>
                              </div>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.18
      </div>
      <strong>Copyright &copy; 2014-2019 <a href="#">HOSPITAL</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark" style="display: none;">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-user bg-yellow"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                  <p>New phone +1(800)555-1234</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                  <p>nora@example.com</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                  <p>Execution time 5 seconds</p>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="label label-danger pull-right">70%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Update Resume
                  <span class="label label-success pull-right">95%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Laravel Integration
                  <span class="label label-warning pull-right">50%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Back End Framework
                  <span class="label label-primary pull-right">68%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Allow mail redirect
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Other sets of options are available
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Expose author name in posts
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Allow the user to show his name in blog posts
              </p>
            </div>
            <!-- /.form-group -->

            <h3 class="control-sidebar-heading">Chat Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Show me as online
                <input type="checkbox" class="pull-right" checked>
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Turn off notifications
                <input type="checkbox" class="pull-right">
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Delete chat history
                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
              </label>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <div class="modal fade" id="modal_editar_contra" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Modificar Contrase&ntilde;a</b></h4>
        </div>
        <div class="modal-body">
          <div class="col-lg-12">
            <input type="text" id="txtcontra_bd" hidden>
            <label for="">Contrase&ntilde;a Atual</label>
            <input type="password" class="form-control" id="txtcontraactual_editar" placeholder="Contrase&ntilde;a Actual"><br>
          </div>

          <div class="col-lg-12">
            <label for="">Nueva Contrase&ntilde;a</label>
            <input type="password" class="form-control" id="txtcontranueva_editar" placeholder="Nueva Contrase&ntilde;a"><br>
          </div>

          <div class="col-lg-12">
            <label for="">Repetir Contrase&ntilde;a</label>
            <input type="password" class="form-control" id="txtcontrare_editar" placeholder="Repetir Contrase&ntilde;a"><br>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" onclick="Editar_Contra()"><i class="fa fa-check"><b>&nbsp;Registrar</b></i></button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
        </div>
      </div>
    </div>
  </div>


  <script src="../Plantilla/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../Plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    var idioma_espanol = {
      select: {
        rows: "%d fila seleccionada"
      },
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
      "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
      "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "<b>No se encontraron datos</b>",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }


    function cargar_contenido(contenedor, contenido) {
      $('#' + contenedor).load(contenido);
    }
    $.widget.bridge('uibutton', $.ui.button);


    function soloNumeros(e) {
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla == 8) {
        return true;
      }
      // Patron de entrada, en este caso solo acepta numeros
      patron = /[0-9]/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
    }

    function soloLetras(e) {
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toLowerCase();
      letras = "áéíóúabcdefghijklmnñopqrstuvwxyz ";
      especiales = "8-37-39-46";
      tecla_especial = false
      for (var i in especiales) {
        if (key == especiales[i]) {
          tecla_especial = true;
          break;
        }
      }
      if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
      }
    }
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="../Plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="../Plantilla/bower_components/raphael/raphael.min.js"></script>
  <!-- Sparkline -->
  <script src="../Plantilla/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../Plantilla/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../Plantilla/bower_components/moment/min/moment.min.js"></script>
  <script src="../Plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="../Plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="../Plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="../Plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="../Plantilla/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="../Plantilla/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- AdminLTE for demo purposes -->
  <script src="../Plantilla/dist/js/demo.js"></script>
  <script src="../Plantilla/plugins/DataTables/datatables.min.js"></script>
  <script src="../Plantilla/plugins/select2/select2.min.js"></script>
  <script src="../Plantilla/plugins/sweetalert2/sweetalert2.js"></script>
  <script src="../js/usuario.js"></script>


  <script src="../Plantilla/plugins/chartjs/popper.min.js"></script>
  <script src="../Plantilla/plugins/chartjs/Chart.bundle.min.js"></script>
  <script src="../Plantilla/plugins/chartjs/Chart.min.js"></script>







  <script>
    TraerDatosUsuario();
    Cargar_Gafico_Citas();

    var fechaToTimestampCounter = 0; // Contador global para los timestamps

    function fechaToTimestamp(fecha) {
      fechaToTimestampCounter++; // Incrementar el contador global
      return {
        fecha: fecha,
        numero: fechaToTimestampCounter
      };
    }



    var titulosParaInterpolacion = []; // Array para almacenar números únicos por fecha


    function Cargar_Gafico_Citas() {
      $.ajax({
        url: "../controlador/inicio/controlador_grafica_citas.php",
        type: "POST"
      }).done(function(resp) {
        if (resp.length > 0) {
          var titulo = [];
          var cantidad = [];
          var colores = [];
          var data = JSON.parse(resp);


          for (var i = 0; i < data.length; i++) {
            titulo.push(data[i][1]); // Mantener la fecha como string en titulo
            cantidad.push(data[i][0]);
            colores.push(colorRGB());

            // Convertir la fecha a un número único y agregar al array separado
            var numeroUnico = fechaToTimestamp(data[i][1]).numero;
            titulosParaInterpolacion.push(numeroUnico);
          }

          CrearGrafico(titulo, cantidad, colores, 'line', 'CANTIDAD DE CITAS AL DIA', 'StadisticasCitas');

          // Enviar datos para la interpolación del polinomio
          $.ajax({
            url: "../controlador/interpolacion/interpolacion_generar_polinomio.php",
            type: 'POST',
            data: {
              x: titulosParaInterpolacion,
              fx: cantidad
            }
          }).done(function(resp) {
            $("#polinomio").val(resp);
          });
        }
      });
    }


    function CrearGrafico(titulo, cantidad, colores, tipo, encabezado, id) {
      var ctx = document.getElementById(id);
      var myChart = new Chart(ctx, {
        type: tipo,
        data: {
          labels: titulo,
          datasets: [{
            label: encabezado,
            data: cantidad,
            backgroundColor: colores,
            borderColor: colores,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    }

    function generarNumero(numero) {
      return (Math.random() * numero).toFixed(0);
    }

    function colorRGB() {
      var coolor = "(" + generarNumero(255) + "," + generarNumero(255) + "," + generarNumero(255) + ")";
      return "rgb" + coolor;
    }




    function EvaluarPolinomio() {
      var Ndia = $("#buscar_cantidad_citas").val(); // Obtener el valor del input (puede ser un número o una fecha)
      $.ajax({
        url: "../controlador/inicio/controlador_grafica_citas.php",
        type: "POST"
      }).done(function(resp) {
        if (resp.length > 0) {
          var titulo = [];
          var cantidad = [];
          var colores = [];
          var data = JSON.parse(resp);


          for (var i = 0; i < data.length; i++) {
            titulo.push(data[i][1]); // Mantener la fecha como string en titulo
            cantidad.push(data[i][0]);
            colores.push(colorRGB());

          }

          // CrearGrafico(titulo, cantidad, colores, 'line', 'CANTIDAD DE CITAS AL DIA', 'StadisticasCitas');
          $.ajax({
            url: "../controlador/interpolacion/interpolacion_generar_polinomio.php",
            type: 'POST',
            data: {
              x: titulosParaInterpolacion,
              fx: cantidad
            }
          }).done(function(resp) {
            $("#polinomio").val(resp);
            $.ajax({
              url: "../controlador/interpolacion/interpolacion_evalua_polinomio.php",
              type: 'POST',
              data: {
                polinomio: resp,
                x_evaluar: Ndia
              }
            }).done(function(respEval) {
              $("#resultado_pol").val(respEval);
            })
          });
        }
      });
    }
  </script>

</body>

</html>