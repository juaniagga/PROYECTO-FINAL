<?php include_once 'includes/header.php';
$id_user = $_SESSION['id_user'];
?>
<!-- ----------------------------------------------------------------------------- -->
<section class="seccion contenedor min-altura margin-barra">
  <h2> Mis datos </h2>

  <div class="centrar-contenido">
      <!-- Main content -->
      <div class="row col-sm-9 main">
        <section class="content">

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Complete el formulario <span style="font-size: 15px;">( * campo obligatorio )</span></h3>

            </div>
            <div class="box-body">
              <!-- CUERPO -->
              <div class="box box-info">
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" name="crear-user" id="crear-user" method="post" action="control-login-user.php">
                  <div class="box-body">

                    <legend class="col-form-label col-sm-12">Usuario</legend>
                    <div class="form-row">
                      <div class="form-group col-sm-12">
                        <label for="email" class="col-sm-1 control-label">Email *</label>
                        <div class="col-sm-12 ">
                          <input name="email" type="email" class="form-control" id="email" placeholder="" style="width: 30%;" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-3">
                        <label for="password" class="col-sm-2 control-label">Contraseña *</label>
                        <div class="col-sm-12">
                          <input name="password" type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                        <label for="password" class="col-sm-2 control-label">Repetir contraseña *</label>
                        <div class="col-sm-12">
                          <input name="password_repit" type="password" class="form-control" id="password_repit" placeholder="Contraseña" required>
                          <span id="resultado_password" class="help-block"></span>
                        </div>
                      </div>
                    </div>

                    <legend class="col-form-label col-sm-12">Datos personales</legend>
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <label for="nombre" class="col-sm-2 control-label">Nombre *</label>
                        <div class="col-sm-12">
                          <input name="nombre" type="text" class="form-control" id="nombre" placeholder="" required>
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="apellido" class="col-sm-2 control-label">Apellido *</label>
                        <div class="col-sm-12">
                          <input name="apellido" type="text" class="form-control" id="apellido" placeholder="" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-4">
                        <label for="pais" class="col-sm-2 control-label">País *</label>
                        <div class="col-sm-12">
                          <input name="pais" type="text" class="form-control" id="pais" placeholder="" required>
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                        <label for="provincia" class="col-sm-3 control-label">Provincia *</label>
                        <div class="col-sm-12">
                          <input name="provincia" type="text" class="form-control" id="provincia" placeholder="" required>
                        </div>
                      </div>
                      <div class="form-group col-sm-4">
                        <label for="ciudad" class="col-sm-2 control-label">Ciudad *</label>
                        <div class="col-sm-12">
                          <input name="ciudad" type="text" class="form-control" id="ciudad" placeholder="" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-sm-12">
                      <label for="dni" class="col-sm-3 control-label">DNI/pasaporte *</label>
                      <div class="col-sm-12">
                        <input name="dni" type="number" class="form-control" id="dni" placeholder="" style="width: 30%;" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-sm-3">
                        <label for="calle" class="col-sm-2 control-label">Calle *</label>
                        <div class="col-sm-12">
                          <input name="calle" type="text" class="form-control" id="calle" placeholder="" required>
                        </div>
                      </div>
                      <div class="form-group col-sm-3">
                        <label for="numero" class="col-sm-2 control-label">Número *</label>
                        <div class="col-sm-12">
                          <input name="numero" type="number" class="form-control" id="numero" placeholder="" style="width: 50%;" required>
                        </div>
                      </div>
                    </div>



                    <legend class="col-form-label col-sm-12">Datos de contacto</legend>
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <label for="telefono" class="col-sm-2 control-label">Teléfono *</label>
                        <div class="col-sm-12">
                          <input name="telefono" type="number" class="form-control" id="telefono" placeholder="Número de teléfono celular" style="width: 50%;" required>
                        </div>
                      </div>
                    </div>


                    <legend class="col-form-label col-sm-12">Datos institucionales</legend>
                    <div class="form-row">
                      <div class="form-group col-sm-6">
                        <label for="institucion" class="col-sm-2 control-label">Institución</label>
                        <div class="col-sm-12">
                          <input name="institucion" type="text" class="form-control" id="institucion" placeholder="">
                        </div>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                        <div class="col-sm-12">
                          <input name="cargo" type="text" class="form-control" id="cargo" placeholder="">
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-sm-6">
                      <label class="col-sm-2 control-label">Tiene trabajos científicos</label>
                      <div class="radio col-sm-2">
                        <label>
                          <input type="radio" name="trabajo" id="trabajo1" value="1">
                          <b>Si</b>
                        </label>
                      </div>
                      <div class="radio col-sm-2 ">
                        <label>
                          <input type="radio" name="trabajo" id="trabajo0" value="0" checked>
                          <b>No</b>
                        </label>
                      </div>
                    </div>

                    <div id="error"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="crear-user" value="1">
                    <button type="submit" class="btn btn-info pull-right">Crear cuenta</button>
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