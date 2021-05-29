<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

$permiso = $_SESSION['permiso'];
$id_orador= urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB","unmdp2021"));
$id_evento = $_SESSION['id_evento'];

if (!filter_var($id_orador,FILTER_VALIDATE_INT)){
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
          Editar orador
        </h1>
      </section>

      <div class="row centrar-contenido">
        <!-- Main content -->
        <div class="col-12 col-lg-6">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Edite la información <span style="font-size: 15px;">( * campo obligatorio )</span></h3>

              </div>
              <div class="box-body">
                <!-- CUERPO -->
                <?php
                  try {
                    $sql = "
                      SELECT o.id_orador, o.nombre, o.apellido, o.dni, o.biografia, o.imagen
                      FROM orador o
                      WHERE o.id_orador=" . $id_orador;
                    $tuplas = $db->query($sql);
                    $orador = $tuplas->fetch_assoc();
                  } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                  }
                ?>
                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="editar-orador" id="editar-orador" method="post" action="control-evento.php" enctype="multipart/form-data">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nombre" class="control-label">Nombre *</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" required placeholder="Nombre" value="<?php echo $orador['nombre']; ?>">
                        <label for="apellido" class="control-label">Apellido *</label>
                        <input name="apellido" type="text" class="form-control" id="apellido" required placeholder="Apellido" value="<?php echo $orador['apellido'];?>">
                      </div>
                      <div class="form-group">
                        <label for="dni" class="control-label">DNI *</label>
                        <input name="dni" type="number" class="form-control" id="dni" required placeholder="DNI" value="<?php echo $orador['dni'];?>">
                      </div>
                      <div class="form-group">
                        <label for="biografia" class="control-label">Biografía *</label>
                        <textarea name="biografia" type="text" class="form-control" required rows="3" id="biografia" placeholder="Biografía del orador"><?php echo $orador['biografia'];?></textarea>
                      </div>
                      <div class="form-group">
                        <label>Actividades dictadas *</label>
                        <select name="actividades[]" id="actividades" class="form-control select2" required multiple="multiple" data-placeholder="Selecciones las actividades" style="width: 100%;">
                          <?php
                          try {
                            //actividades actuales del orador

                            $sql_act = "
                            SELECT a.nombre_act, a.id_actividad
                            FROM orador o INNER JOIN dicta d ON o.id_orador=d.id_orador INNER JOIN actividad a ON a.id_actividad=d.id_actividad
                            WHERE d.id_orador=" . $id_orador . " and o.id_evento=" . $id_evento . "
                            ORDER BY a.nombre_act";
                            $tuplas_dicta = $db->query($sql_act);

                            $sql = "
                            SELECT a.id_actividad, a.nombre_act
                            FROM actividad a
                            WHERE a.id_evento=" . $id_evento . "
                            ORDER BY a.nombre_act";
                            $tuplas = $db->query($sql);
                          } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                          }
                          $act_selected= array();
                          while($dicta= $tuplas_dicta->fetch_assoc()){
                            ?>
                            <option value="<?php echo $dicta['id_actividad']; ?>" selected><?php echo $dicta['nombre_act']; ?></option>
                            <?php
                            $act_selected[]=$dicta['id_actividad'];
                          }
                          while ($actividades = $tuplas->fetch_assoc()) {
                            if (!in_array($actividades['id_actividad'], $act_selected)) {
                              ?>
                              <option value="<?php echo $actividades['id_actividad']; ?>"><?php echo $actividades['nombre_act']; ?></option>
                              <?php
                            } //if
                          } //while
                              ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="imagen">Foto actual</label>
                        <br>
                        <img src="../img/<?php echo "evento_". $id_evento . "/" ?>oradores/<?php echo $orador['imagen'];?>" width="40%" alt=" Foto del orador">
                      </div>
                      <div class="form-group">
                        <label for="imagen">Actualizar foto <span style="font-weight:300">(Formatos permitidos: .JPG, .JPEG, .PNG)</span></label>
                        <input type="file" id="imagen" name="imagen">
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="editar-orador" value="1">
                      <input type="hidden" name="id_orador" value="<?php echo $id_orador?>">
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