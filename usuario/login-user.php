<?php
session_start();
$out = isset($_GET['out']);  //isset evita el mensaje de error en caso de que out no exista
if ($out) {
  session_destroy();
}
?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Eventos UNMDP</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="../site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <link rel="stylesheet" href="../css/colorbox.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../admin/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../admin/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/css/AdminLTE.min.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="../admin/css/skins/_all-skins.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../admin/css/bootstrap.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../admin/css/bootstrap-datepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../admin/css/select2.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../admin/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="../admin/css/admin.css">

  <?php
  $archivo = basename($_SERVER['PHP_SELF']);
  $pagina = str_replace(".php", "", $archivo);


  /* if ($pagina == 'galeria')
      echo '<link rel="stylesheet" href="css/lightbox.css">';
    else
      if ($pagina == 'oradores' || $pagina == 'index')
        echo '<link rel="stylesheet" href="css/colorbox.css">'; */
  ?>


  <meta name="theme-color" content="#fafafa">
  <link rel="stylesheet" href="../css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans&display=swap" rel="stylesheet">

</head>

<body class="">

  <div class="barra" id="seccion">
    <div class="contenedor clearfix">
      <div class="logo">
        <!-- <img src="logo.svg" alt="logo jornadas"> -->
      </div>

    </div>
    <!--contenedor-->
  </div>
  <!--barra-->

  <!-- Site wrapper -->
  <div class="wrapper">


    <div class="login-box">
      <div class="login-logo">
        <a href="../index.php"><b>UNMDP </b>Eventos</a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Iniciar sesión</p>

        <form name="login-user" id="login-user" method="post" action="control-login-user.php">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            <span class="form-control-feedback"><i class="fa fa-user"></i></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="pass" name="password" placeholder="Contraseña">
            <span class="form-control-feedback"><i class="fa fa-unlock-alt"></i></span>
          </div>
          <div class="row">
            <div class="recordarme col-xs-12">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Recordarme
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-12">
              <input type="hidden" name="login-user" value="1">
              <button type="submit" class="btn btn-primary btn-block btn-flat">INICIAR SESIÓN</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <a href="#">Olvidé mi contraseña</a><br>
        <div class="row">
          <div class="col-xs-12">
            <a href="crear-cuenta.php">
              <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin-top:3rem;">CREAR CUENTA</button>
            </a>
            
          </div>
        </div>


      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->


<!-- =============================================== -->

<?php include_once 'includes/scripts-footer.php'; ?>

<!-- =============================================== -->