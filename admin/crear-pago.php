<?php
  include_once 'funciones/sesion-admin.php';
  include_once 'templates/header.php';
  try{
    include_once 'funciones/funciones.php';
  }catch(Exception $e){
    echo "Error: " . $e->getMessage();
  }
  $permiso= $_SESSION['permiso'];


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
        Nuevo medio de pago
      </h1>
    </section>

    <div class="centrar-contenido">
<!-- Main content -->
<div class="row col-md-3">
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Complete la información</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">  <!-- CUERPO -->

            <div class="box box-info">  
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" name="crear-pago" id="crear-pago" method="post" action="control-evento.php">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre del medio de pago">
                      </div>
                    </div>
                    <div id="error" style="display: none"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="crear-pago" value="1">
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
