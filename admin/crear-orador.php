<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

$permiso = $_SESSION['permiso'];
$id_evento = $_SESSION['id_evento'];
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
          Nuevo orador
        </h1>
      </section>

      <div class="centrar-contenido">
        <!-- Main content -->
        <div class="row col-md-6">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Complete el formulario</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <!-- CUERPO -->

                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="crear-orador" id="crear-orador" method="post" action="control-evento.php" enctype="multipart/form-data">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre">
                        <label for="apellido" class="control-label">Apellido</label>
                        <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellido">
                      </div>
                      <div class="form-group">
                        <label for="dni" class="control-label">DNI</label>
                        <input name="dni" type="number" class="form-control" id="dni" placeholder="DNI">
                      </div>
                      <div class="form-group">
                        <label for="biografia" class="control-label">Biografía</label>
                        <textarea name="biografia" type="text" class="form-control" rows="3" id="biografia" placeholder="Biografía del orador"></textarea>
                      </div>
                      <div class="form-group">
                        <label>Actividades dictadas</label>
                        <select name="actividades[]" id="actividades" class="form-control select2" multiple="multiple" data-placeholder="Selecciones las actividades" style="width: 100%;" required>
                          <?php
                          try {
                            $sql = "
                            SELECT a.id_actividad, a.nombre_act
                            FROM actividad a
                            WHERE a.id_evento=" . $id_evento . "
                            ORDER BY a.nombre_act";
                            $tuplas = $db->query($sql);
                          } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                          }

                          while ($act = $tuplas->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $act['id_actividad']; ?>"><?php echo $act['nombre_act']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="imagen">Añadir foto <span style="font-weight:300">(Formatos permitidos: .JPG, .JPEG, .PNG)</span></label>
                        <input type="file" id="imagen" name="imagen">
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="crear-orador" value="1">
                      <button type="submit" class="btn btn-info pull-right">Añadir</button>
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