<?php include_once 'includes/header.php';
$id_user = $_SESSION['id_user'];
?>
<!-- ----------------------------------------------------------------------------- -->
<section class="seccion contenedor min-altura margin-barra">
  <h2> Mis datos </h2>

  <?php
  try {
    $sql = "
                      SELECT u.nombre, u.apellido, u.email, u.dni, u.telefono, u.calle, u.numero, u.ciudad, u.provincia,
                      u.pais, u.trabajo_cientifico, u.institucion, u.cargo
                      FROM usuario u
                      WHERE u.id_user=" . $id_user;
    $tuplas = $db->query($sql);
    $user = $tuplas->fetch_assoc();
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>

  <div class="centrar-contenido">
    <!-- Main content -->
    <div class="row col-sm-9 main">
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
              <form class="form-horizontal" name="editar-user" id="editar-user" method="post" action="control-user.php">
                <div class="box-body">

                  <legend class="col-form-label col-sm-12">Usuario</legend>
                  <div class="form-row">
                    <div class="form-group col-sm-12">
                      <label for="email" class="col-sm-1 control-label">Email *</label>
                      <div class="col-sm-12 ">
                        <input name="email" type="email" class="form-control" id="email" placeholder="" style="width: 50%;" value="<?php echo $user['email'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <a href="new-password.php" class="btn btn-info pull-right">Cambiar contraseña</a>
                  </div>

                  <legend class="col-form-label col-sm-12">Datos personales</legend>
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <label for="nombre" class="col-sm-2 control-label">Nombre *</label>
                      <div class="col-sm-12">
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="" value="<?php echo $user['nombre'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="apellido" class="col-sm-2 control-label">Apellido *</label>
                      <div class="col-sm-12">
                        <input name="apellido" type="text" class="form-control" id="apellido" placeholder="" value="<?php echo $user['apellido'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-sm-4">
                      <label for="pais" class="col-sm-2 control-label">País *</label>
                      <div class="col-sm-12">
                        <input name="pais" type="text" class="form-control" id="pais" placeholder="" value="<?php echo $user['pais'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="provincia" class="col-sm-3 control-label">Provincia *</label>
                      <div class="col-sm-12">
                        <input name="provincia" type="text" class="form-control" id="provincia" placeholder="" value="<?php echo $user['provincia'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="ciudad" class="col-sm-2 control-label">Ciudad *</label>
                      <div class="col-sm-12">
                        <input name="ciudad" type="text" class="form-control" id="ciudad" placeholder="" value="<?php echo $user['ciudad'] ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="dni" class="col-sm-3 control-label">DNI/pasaporte *</label>
                    <div class="col-sm-12">
                      <input name="dni" type="number" class="form-control" id="dni" placeholder="" style="width: 30%;" value="<?php echo $user['dni'] ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-sm-5">
                      <label for="calle" class="col-sm-2 control-label">Calle *</label>
                      <div class="col-sm-12">
                        <input name="calle" type="text" class="form-control" id="calle" placeholder="" value="<?php echo $user['calle'] ?>" required>
                      </div>
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="numero" class="col-sm-2 control-label">Número *</label>
                      <div class="col-sm-12">
                        <input name="numero" type="number" class="form-control" id="numero" placeholder="" style="width: 50%;" value="<?php echo $user['numero'] ?>" required>
                      </div>
                    </div>
                  </div>



                  <legend class="col-form-label col-sm-12">Datos de contacto</legend>
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <label for="telefono" class="col-sm-2 control-label">Teléfono *</label>
                      <div class="col-sm-12">
                        <input name="telefono" type="number" class="form-control" id="telefono" placeholder="Número de teléfono celular" value="<?php echo $user['telefono'] ?>" style="width: 50%;" required>
                      </div>
                    </div>
                  </div>


                  <legend class="col-form-label col-sm-12">Datos institucionales</legend>
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <label for="institucion" class="col-sm-2 control-label">Institución</label>
                      <div class="col-sm-12">
                        <input name="institucion" type="text" class="form-control" id="institucion" placeholder="" value="<?php echo $user['institucion'] ?>">
                      </div>
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                      <div class="col-sm-12">
                        <input name="cargo" type="text" class="form-control" id="cargo" placeholder="" value="<?php echo $user['cargo'] ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label class="col-sm-2 control-label">Tiene trabajos científicos</label>
                    <?php if ($user['trabajo_cientifico']) { ?>
                      <div class="radio col-sm-2">
                        <label>
                          <input type="radio" name="trabajo" id="trabajo1" value="1" checked>
                          <b>Si</b>
                        </label>
                      </div>
                      <div class="radio col-sm-2 ">
                        <label>
                          <input type="radio" name="trabajo" id="trabajo0" value="0">
                          <b>No</b>
                        </label>
                      </div>
                    <?php } else { ?>
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
                    <?php } ?>
                  </div>

                  <div id="error"></div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <input type="hidden" name="editar-user" value="1">
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