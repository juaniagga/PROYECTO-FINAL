<?php
  session_start();
  $out= isset($_GET['out']);  //isset evita el mensaje de error en caso de que out no exista
  if ($out){
    session_destroy();
  }
  include_once 'templates/header.php';
?>

<body class="hold-transition login-page">
<!-- Site wrapper -->
<div class="wrapper">


<div class="login-box">
  <div class="login-logo">
    <a><b>UNMDP </b>Eventos</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar sesión como administrador</p>

    <form name="login-admin" id="login-admin" method="post" action="control-login-admin.php" data-tipo="admin">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
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
          <input type="hidden" name="login-admin" value="1">
          <button type="submit" class="btn btn-primary btn-block btn-flat">INICIAR SESIÓN</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="#">Olvidé mi contraseña</a><br>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php
  include_once 'templates/footer.php';
?>
