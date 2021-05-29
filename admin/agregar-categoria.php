<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';
try {
  include_once 'funciones/funciones.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
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
          Agregar categoría de participante
        </h1>
      </section>

      <div class="row centrar-contenido">
        <!-- Main content -->
        <div class=" col-lg-4">
          <section class="content">

            <!-- Default box -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Seleccione la categoría que desee agregar</h3>
              </div>
              <div class="box-body">
                <!-- CUERPO -->

                <?php
                try {
                  include_once 'funciones/funciones.php';

                  $sql = "
                SELECT c.id_categoria, c.nombre
                FROM categoria_participante c";
                  $tuplas = $db->query($sql);
                  $cat = $tuplas->fetch_assoc();
                } catch (Exception $e) {
                  echo "Error: " . $e->getMessage();
                }
                ?>

                <div class="box box-info">
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="agregar-categoria" id="agregar-categoria" method="post" action="control-evento.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="categoria" class="col-sm-3 control-label">Categoría</label>
                        <div class="col-sm-12">
                        <select name="categoria" class="form-control select2" id="categoria" placeholder="categoria" style="width: 100%;" required>
                          <option value="">- Seleccione -</option>
                          <?php
                          try {
                            $sql = "
                          SELECT c.id_categoria, c.nombre
                          FROM categoria_participante c";
                            $tuplas = $db->query($sql);
                          } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                          }

                          while ($categoria = $tuplas->fetch_assoc()) {
                          ?>
                            <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        </div>
                        
                      </div>
                      <div class="form-group">
                        <label for="tarifa" class="col-sm-3 control-label">Tarifa</label>
                        <div class="col-sm-12">
                          <input name="tarifa" type="number" step="0.01" class="form-control" id="tarifa" placeholder="Tarifa" required>
                        </div>
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="agregar-categoria" value="1">
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