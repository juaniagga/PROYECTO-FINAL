<?php
  include_once 'templates/header.php';
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
        Crear Administrador
        <small>Completá el formulario para crear el administrador</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <div class="row col-md-8">
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Crear administrador</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">  <!-- CUERPO -->
            <div class="box box-info">  
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" name="crear-admin" id="crear-admin" method="post" action="insertar-admin.php">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="usuario" class="col-sm-2 control-label">Usuario</label>
                      <div class="col-sm-10">
                        <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Usuario">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-sm-2 control-label">Contraseña</label>
                      <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="password" placeholder="Contraseña">
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="agregar-admin" value="1">
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
  <!-- /.content-wrapper -->

<?php
  include_once 'templates/footer.php';
?>
