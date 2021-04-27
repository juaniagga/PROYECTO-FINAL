<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';

$permiso = $_SESSION['permiso'];

?>


<body class="hold-transition skin-blue sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <?php
    include_once 'templates/barra.php';
    ?>

    <!-- =============================================== -->
    <?php
    include_once 'templates/navegacion.php';
    ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Nuevo administrador de sistema
          <!-- <small>Completá el formulario para crear el administrador</small> -->
        </h1>
      </section>

      <div class="centrar-contenido">
        <!-- Main content -->
        <div class="row col-md-6 main">
          <section class="content">

            <!-- admin-sistema box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Complete el formulario</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <!-- CUERPO -->
                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="crear-admin" id="crear-admin" method="post" action="control-admin.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="usuario" class="col-sm-2 control-label">Usuario</label>
                        <div class="col-sm-12">
                          <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Nombre de usuario">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                          <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre y apellido">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                          <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Contraseña</label>
                        <div class="col-sm-12">
                          <input name="password" type="password" class="form-control" id="password" placeholder="Contraseña">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Repetir contraseña</label>
                        <div class="col-sm-12">
                          <input name="password_repit" type="password" class="form-control" id="password_repit" placeholder="Contraseña">
                          <span id="resultado_password" class="help-block"></span>
                        </div>
                      </div>
                      <div id="error"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="crear-admin" value="1">
                      <input type="hidden" name="tipo-admin" value="1">
                      <button type="submit" class="btn btn-info pull-right" id="btn-new">Añadir</button>
                    </div>
                    <!-- /.box-footer -->
                  </form>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->


          </section>
          <!-- /.content -->
        </div> <!-- row -->
      </div>


    </div>
    <!-- /.content-wrapper -->

    <?php
    include_once 'templates/footer.php';
    ?>