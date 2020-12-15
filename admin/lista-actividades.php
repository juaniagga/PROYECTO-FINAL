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
          Actividades
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row centrar-contenido">
          <div class="col-xs-12">

            <!-- BOX LISTA ACTIVIDADEA -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Gestiona las actividades de tu evento</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th class="col-xs-2">Categoría</th>
                      <th class="col-xs-2">Fecha</th>
                      <th class="col-xs-1">Hora inicio</th>
                      <th class="col-xs-1">Hora fin</th>
                      <th class="col-xs-2">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    try {
                      include_once 'funciones/funciones.php';
                      $sql = "
                      SELECT a.id_actividad, a.nombre_act, a.fecha, a.hora_inicio, a.hora_fin, a.id_categoria, c.nombre as nombre_cat
                      FROM actividad a INNER JOIN categoria_act c ON a.id_categoria=c.id_categoria
                      WHERE a.id_evento=" . $id_evento;
                      $tuplas = $db->query($sql);
                    } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    while ($actividad = $tuplas->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $actividad['nombre_act']; ?></td>
                        <td><?php echo $actividad['nombre_cat']; ?></td>
                        <td> <?php echo date_format(date_create($actividad['fecha']), 'd-m-Y'); ?></td>
                        <td> <?php echo date_format(date_create($actividad['hora_inicio']), 'H:i'); ?></td>
                        <td> <?php echo date_format(date_create($actividad['hora_fin']), 'H:i'); ?></td>
                        <td>
                          <a href="editar-actividad.php?id=<?php echo $actividad['id_actividad']; ?>" class="btn bg-orange btn-flat margin">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="#" data-id="<?php echo $actividad['id_actividad']; ?>" data-tipo="actividad" url="control-evento.php" class="btn bg-maroon btn-flat margin borrar-registro">
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