<?php
include_once 'funciones/sesion-admin.php';
include_once 'templates/header.php';

$permiso = $_SESSION['permiso'];
$id_evento= $_SESSION['id_evento'];
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
          Oradores
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row centrar-contenido">
          <div class="col-xs-12">

            <!-- BOX LISTA ACTIVIDADEA -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Gestiona los oradores de tu evento</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th class="col-xs-2">Nombre</th>
                      <th class="col-xs-1">DNI</th>
                      <th class="col-xs-3">Biografía</th>
                      <th class="col-xs-2">Actividades dictadas</th>
                      <th class="col-xs-1">Foto</th>
                      <th class="col-xs-1">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    try {
                      include_once 'funciones/funciones.php';
                      $sql = "
                      SELECT o.id_orador, o.nombre, o.apellido, o.dni, o.biografia, o.imagen
                      FROM orador o
                      WHERE o.id_evento=" . $id_evento;
                      $tuplas = $db->query($sql);
                    } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    while ($orador = $tuplas->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $orador['nombre']; ?></td>
                        <td><?php echo $orador['dni']; ?></td>
                        <td> <?php echo $orador['biografia']; ?></td>
                        <td> <?php 
                          try {
                            $sql2 = "
                            SELECT a.nombre_act
                            FROM actividad a INNER JOIN dicta d ON a.id_actividad=d.id_actividad INNER JOIN orador o ON d.id_orador=o.id_orador
                            WHERE o.id_orador=" . $orador['id_orador'];
                            $tuplas_act = $db->query($sql2);
                          } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                          }
                          while ($act = $tuplas_act->fetch_assoc()) {
                            echo "- " . $act['nombre_act'] . "<br>";
                            
                          }
                        ?>
                        </td>
                        <td> <img style="width: 100px;" src="../img/<?php echo "evento_". $id_evento . "/" ?>oradores/<?php echo $orador['imagen']; ?>" alt=""></td>
                        <td>
                          <a href="editar-orador.php?id=<?php echo urlencode(base64_encode($orador['id_orador'])); ?>" class="btn bg-orange btn-flat margin">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="#" data-id="<?php echo $orador['id_orador']; ?>" data-tipo="orador" url="control-evento.php" class="btn bg-maroon btn-flat margin borrar-registro">
                            <i class="fa fa-trash"></i>
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