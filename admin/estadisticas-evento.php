<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';

$permiso = $_SESSION['permiso'];
if ($permiso) {
  $id_evento = urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB", "unmdp2021"));
} else {
  $id_evento = $_SESSION['id_evento'];
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
          Estadísticas del evento
        </h1>
      </section>

      <?php
      try {
        include_once 'funciones/funciones.php';
        $sql = "
                      SELECT e.id_evento, e.nombre, e.acreditados, e.inscriptos
                      FROM evento e
                      WHERE e.id_evento=" . $id_evento;
        $tupla = $db->query($sql);
        $evento = $tupla->fetch_assoc();
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
      }
      ?>

      <!-- Main content -->
      <section class="content page-estadisticas" style="width: 100%;">
        <div class="row text-center">
          <div class="col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="box-total small-box bg-yellow center-block">
              <div class="inner">
                <h3><?php echo $evento['inscriptos']; ?></h3>

                <p>Total inscriptos</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-plus"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->

          <div class="col-sm-6 col-xs-12">
            <!-- small box -->
            <div class="box-total small-box bg-green center-block">
              <div class="inner">
                <h3><?php echo $evento['acreditados']; ?></h3>

                <p>Total acreditados</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <h2>Estadísticas de los participantes acreditados</h2>
        <div class="">
          <div style="display:none;" id="data-evento" data-id="<?php echo $id_evento; ?>">
          </div>
          <div class="row">
            <div class="col-xs-12 text-center col-lg-6">
              <h2>Institución (%)</h2>
              <div class="box-body chart-responsive">
                <div class="chart" id="institucion-chart" style="position: relative;"></div>
              </div>
              <div class="referencia">
                <ul id="lista-inst">
                </ul>
              </div>
            </div>
            <div class="col-xs-12 text-center col-lg-6">
              <h2>Localidad (%)</h2>
              <div class="box-body chart-responsive">
                <div class="chart" id="localidad-chart" style="position: relative;"></div>
              </div>
              <div class="referencia">
                <ul id="lista-loc">
                </ul>
              </div>
            </div>
          </div>


        </div>
        <!-- /.row -->

      </section>
      <!-- /.content -->


    </div>
    <!-- /.content-wrapper -->
    <?php
    include_once 'templates/footer.php';
    ?>