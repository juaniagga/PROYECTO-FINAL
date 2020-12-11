<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';

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
          Información sobre medios de pago
        </h1>
      </section>

      <!-- Main content -->
      <div class="centrar-contenido">

      </div>
      <section class="row col-md-6 content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Cargue el PDF informativo para los eventos</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="box-footer">
              <div class="box box-info">
                <form class="form-horizontal" name="subir-pdf" id="subir-pdf" method="post" action="control-evento.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="pdf">Cargar PDF</label>
                    <input type="file" id="pdf" name="pdf">
                  </div>
                  <div id="error" style="display: none"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="subir-pdf" value="1">
                <button type="submit" class="btn btn-info pull-right">Subir</button>
              </div>
            </div>
              <!-- /.box-footer -->
              </form>
            </div>
          </div>
          <!-- /.box-body -->
      </section>
    </div>
    <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
  include_once 'templates/footer.php';
  ?>