<?php
  include_once 'funciones/sesion-admin.php';
  include_once 'templates/header.php';
  try{
    include_once 'funciones/funciones.php';
  }catch(Exception $e){
    echo "Error: " . $e->getMessage();
  }
  $id_categoria= urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB","unmdp2021"));
  $permiso= $_SESSION['permiso'];

  if (!filter_var($id_categoria,FILTER_VALIDATE_INT)){
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
        Editar precio
      </h1>
    </section>

    <div class="centrar-contenido">
<!-- Main content -->
<div class="row col-lg-3">
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
              try {
                include_once 'funciones/funciones.php';

                $sql = "
                SELECT ca.id_categoria, ca.tarifa, c.nombre
                FROM categoria_participante c INNER JOIN cat_asociadas ca ON c.id_categoria=ca.id_categoria
                WHERE ca.id_categoria=" . $id_categoria;
                $tuplas = $db->query($sql);  
                $cat= $tuplas->fetch_assoc();
              
              } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
              }
            ?>

            <div class="box box-info">  
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" name="editar-tarifa" id="editar-tarifa" method="post" action="control-evento.php">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $cat['nombre'] ?>" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tarifa" class="col-sm-2 control-label">Tarifa</label>
                      <div class="col-sm-10">
                        <input name="tarifa" type="number" step="0.01" class="form-control" id="tarifa" placeholder="tarifa" value="<?php echo $cat['tarifa'] ?>">
                      </div>
                    </div>
                    <div id="error" style="display: none"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <input type="hidden" name="editar-tarifa" value="1">
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
