<?php include_once 'includes/header.php';
$id_user = $_SESSION['id_user'];
?>
<!-- ----------------------------------------------------------------------------- -->
<section class="seccion contenedor min-altura margin-barra">
  <h2> Mis datos </h2>

  <?php
  try {
    $sql = "
                      SELECT u.clave
                      FROM usuario u
                      WHERE u.id_user=" . $id_user;
    $tuplas = $db->query($sql);
    $user = $tuplas->fetch_assoc();
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>

  <div class="">
    <!-- Main content -->
    <div class=" main">
      <section class="content">

        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Actualice sus datos <span style="font-size: 15px;">( * campo obligatorio )</span></h3>

          </div>
          <div class="box-body">
            <!-- CUERPO -->
            <div class="box box-info">
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" name="nueva-clave" id="nueva-clave" method="post" action="control-user.php">
                <div class="box-body">

                  <legend class="col-form-label col-sm-12">Contraseña</legend>
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

                  <div id="error"></div>
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


</section>
<!--seccion-->


<!-- =============================================== -->

<?php
include_once 'includes/footer.php';
include_once 'includes/scripts-footer.php';
?>

<!-- =============================================== -->