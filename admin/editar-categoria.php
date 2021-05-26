<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
$id_categoria = urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB","unmdp2021"));
$permiso = $_SESSION['permiso'];

if (!filter_var($id_categoria, FILTER_VALIDATE_INT)) {
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
          Editar categoría
        </h1>
      </section>

      <div class="centrar-contenido">
        <!-- Main content -->
        <div class="row col-md-3">
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
                try {
                  include_once 'funciones/funciones.php';

                  $sql = "
                SELECT c.id_categoria, c.nombre, c.autoreg
                FROM categoria_participante c
                WHERE c.id_categoria=" . $id_categoria;
                  $tuplas = $db->query($sql);
                  $cat = $tuplas->fetch_assoc();
                } catch (Exception $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>

                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="editar-categoria" id="editar-categoria" method="post" action="control-evento.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                          <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $cat['nombre'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="autoreg" class="col-sm-2 control-label">Autoinscripción</label>
                        <div   class="col-sm-12">
                          <?php
                          if ($cat['autoreg']) {
                          ?>
                            <div class="radio">
                              <label>
                                <input type="radio" name="autoreg" id="estado1" value="1" checked>
                                <b>ACTIVADA</b>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="autoreg" id="estado0" value="0">
                                <b>DESACTIVADA</b>
                              </label>
                            </div>
                          <?php
                          } else {
                          ?>
                            <div class="radio">
                              <label>
                                <input type="radio" name="autoreg" id="estado1" value="1">
                                <b>ACTIVADA</b>
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="autoreg" id="estado0" value="0" checked>
                                <b>DESACTIVADA</b>
                              </label>
                            </div>
                          <?php
                          }
                          ?>
                        </div>


                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="editar-categoria" value="1">
                      <input type="hidden" name="id_categoria" value="<?php echo $id_categoria ?>">
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