<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
$id_admin = $_SESSION['id_admin'];
$permiso = $_SESSION['permiso'];

if (!filter_var($id_admin, FILTER_VALIDATE_INT)) {
  die("Error");
}
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
          Ajustes
        </h1>
      </section>

      <!-- Main content -->
      <div class="centrar-contenido">
        <div class="row col-md-6">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Edite la información</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                <!-- CUERPO -->

                <?php
                $sql = "
                SELECT a.usuario, a.nombre, a.email
                FROM administrador a
                WHERE a.id_admin='" . $id_admin . "'";
                $tupla = $db->query($sql);
                $admin = $tupla->fetch_assoc();
                ?>

                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="nueva-clave" id="nueva-clave" method="post" action="control-admin.php">
                    <div class="box-body">
                      <div class="form-row">
                        <div class="form-group col-sm-12">
                          <label for="password" class="col-sm-2 control-label">Contraseña actual *</label>
                          <div class="col-sm-12">
                            <input name="password" type="password" class="form-control" id="" placeholder="Contraseña" style="width: 45%" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="password" class="col-sm-2 control-label">Contraseña nueva *</label>
                          <div class="col-sm-12">
                            <input name="new_password" type="password" class="form-control" id="password" placeholder="Contraseña" required>
                          </div>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="password" class="col-sm-2 control-label">Repetir contraseña *</label>
                          <div class="col-sm-12">
                            <input name="new_password_repit" type="password" class="form-control" id="password_repit" placeholder="Contraseña" required>
                            <span id="resultado_password" class="help-block"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="nueva-clave" value="1">
                      <button type="submit" class="btn btn-info pull-right">Guardar</button>
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