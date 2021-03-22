<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';

$permiso = $_SESSION['permiso'];
if ($permiso){
  $id_evento= $_GET['id'];
}else{
  $id_evento= $_SESSION['id_evento'];
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
      <section class="content" style="width: 100%;">
        <div class="row centrar-contenido">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
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

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
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
        <h3>Estadísticas de los participantes</h3>
        <div class="row centrar-contenido">

          <div class="col-xs-4 box-body centrar-contenido">
            <h3>Institución</h3>
            <div id="procedencia" data-id="<?php echo $id_evento?>" style="width:250px; height: 250px;"></div>
          </div>
          <div class="col-xs-4 box-body centrar-contenido">
            <h3>Localidad</h3>
            <div id="ciudad" style="width:250px; height: 250px;"></div>
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