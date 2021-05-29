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
            Categorías de participantes
          </h1>

      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row centrar-contenido">
          <div class="col-xs-12 col-lg-8">
            <!-- BOX ADMIN EVENTOS -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Listado de categorías</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th >Nombre</th>
                      <th class="col-xs-3">Auto-inscripción</th>
                      <th class="col-xs-3">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    try {
                      include_once 'funciones/funciones.php';

                      $sql = "
                      SELECT c.id_categoria, c.nombre, c.autoreg
                      FROM categoria_participante c";
                      $tuplas = $db->query($sql);  
                    
                    } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    while ($cat = $tuplas->fetch_assoc()) {

                    ?>
                      <tr>
                        <td><?php echo $cat['nombre']; ?></td>
                        <td> <?php
                              if ($cat['autoreg']) {
                                echo "Activada  "; ?><i class="fa fa-circle text-success"></i>
                          <?php
                              } else {
                                echo "Desactivada  ";  ?><i class="fa fa-circle-o text-red"></i>
                         <?php
                              }
                           ?>
                        </td>
                          <td>
                            <?php $encrypt= openssl_encrypt($cat['id_categoria'],"AES-128-ECB","unmdp2021"); ?>
                            <a href="editar-categoria.php?id=<?php echo urlencode($encrypt); ?>" class="btn bg-orange btn-flat margin">
                              <i class="fa fa-pencil"></i>
                            </a>
                          </td>

                      </tr>
                    <?php
                    }
                    ?>
                    </tr>

                    </tfoot>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
    include_once 'templates/footer.php';
    ?>