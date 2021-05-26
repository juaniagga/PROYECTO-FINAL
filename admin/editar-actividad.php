<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
$id_actividad = urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB","unmdp2021"));
$permiso = $_SESSION['permiso'];
$id_evento = $_SESSION['id_evento'];

if (!filter_var($id_actividad,FILTER_VALIDATE_INT)){
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
          Editar actividad
        </h1>
      </section>

      <div class="centrar-contenido">
        <!-- Main content -->
        <div class="row col-md-6">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Edite la información</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <!-- CUERPO -->
                <?php
                try {
                  $sql = "
                SELECT a.id_actividad, a.nombre_act, a.fecha, a.hora_inicio, a.hora_fin, a.id_categoria, a.descripcion, c.nombre as nombre_cat
                FROM actividad a INNER JOIN categoria_act c ON a.id_categoria=c.id_categoria
                WHERE a.id_actividad=" . $id_actividad;
                  $tupla = $db->query($sql);
                  $actividad = $tupla->fetch_assoc();
                } catch (Exception $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>
                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="editar-actividad" id="editar-actividad" method="post" action="control-evento.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre de la actividad" value="<?php echo $actividad['nombre_act'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="categoria" class="control-label">Categoría</label>
                        <select name="categoria" class="form-control select2" id="categoria" placeholder="categoria" style="width: 100%;">
                          <option value="0">- Seleccione -</option>
                          <?php
                          try {
                            $sql = "
                          SELECT c.id_categoria, c.nombre
                          FROM categoria_act c";
                            $tuplas = $db->query($sql);
                          } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                          }

                          while ($categoria = $tuplas->fetch_assoc()) {
                            if ($categoria['id_categoria'] == $actividad['id_categoria']) {
                          ?>
                              <option value="<?php echo $categoria['id_categoria']; ?>" selected><?php echo $categoria['nombre']; ?></option>
                            <?php
                            } else {
                            ?>
                              <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                          <?php
                            } //if
                          } //while
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="descripcion" class="control-label">Descripción</label>
                        <textarea name="descripcion" type="text" class="form-control" rows="3" id="descripcion" placeholder="Descripción de la actividad"><?php echo $actividad['descripcion']; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="control-label">Fecha</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker" name="fecha" value="<?php echo date_format(date_create($actividad['fecha']), 'd/m/Y'); ?>">
                        </div>
                      </div>
                      <div class="bootstrap-timepicker">
                        <div class="form-group">
                          <label>Hora inicio</label>
                          <div class="input-group">
                            <input type="text" class="form-control timepicker" id="hora_inicio" name="hora_inicio" value="<?php echo date_format(date_create($actividad['hora_inicio']), 'H:i'); ?>">

                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                      </div>
                      <div class="bootstrap-timepicker">
                        <div class="form-group">
                          <label>Hora fin</label>
                          <div class="input-group">
                            <input type="text" class="form-control timepicker" id="hora_fin" name="hora_fin" value="<?php echo date_format(date_create($actividad['hora_fin']), 'H:i'); ?>">

                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="editar-actividad" value="1">
                      <input type="hidden" name="id_actividad" value="<?php echo $actividad['id_actividad'] ?>">
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