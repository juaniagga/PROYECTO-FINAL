<?php
  include_once 'funciones/sesion-admin.php';
  include_once 'templates/header.php';
  try{
    include_once 'funciones/funciones.php';
  }catch(Exception $e){
    echo "Error: " . $e->getMessage();
  }
  $id_admin= $_GET['id'];
  $permiso= $_SESSION['permiso'];

  if (!filter_var($id_admin,FILTER_VALIDATE_INT)){
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
        Editar administrador
      </h1>
    </section>

    <!-- Main content -->
    <div class="centrar-contenido">
      <div class="row col-md-6">
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edite la información</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">  <!-- CUERPO -->

              <?php
                $sql="
                SELECT a.usuario, a.nombre, a.email
                FROM administrador a
                WHERE a.id_admin='" . $id_admin . "'";
                $tupla= $db->query($sql);
                $admin= $tupla->fetch_assoc();
              ?>

              <div class="box box-info">  
                  <!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" name="editar-admin" id="editar-admin" method="post" action="control-admin.php">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="usuario" class="col-sm-2 control-label">Usuario</label>
                        <div class="col-sm-10">
                          <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Nombre de usuario" value="<?php echo $admin['usuario'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                          <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre y apellido" value="<?php echo $admin['nombre'] ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $admin['email'] ?>">
                        </div>
                      </div>
                      <div id="error" style="display: none"></div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                      <input type="hidden" name="editar-admin" value="1">
                      <input type="hidden" name="id_admin" value="<?php echo $id_admin ?>">
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
