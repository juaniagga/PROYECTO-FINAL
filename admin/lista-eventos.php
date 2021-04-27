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
          Eventos
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row centrar-contenido">
          <div class="col-xs-10">

            <!-- BOX LISTA EVENTOS -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Visualice los eventos de UNMDP</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th class="col-xs-2">Fecha inicio</th>
                      <th class="col-xs-2">Fecha fin</th>
                      <th class="col-xs-2">Estado</th>
                      <th class="col-xs-2">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    try {
                      include_once 'funciones/funciones.php';
                      $sql = "
                      SELECT e.id_evento, e.nombre, e.fecha_inicio, e.fecha_fin, e.estado
                      FROM evento e
                      ORDER BY e.estado DESC, e.fecha_inicio, e.nombre";
                      $tuplas = $db->query($sql);
                    } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    while ($evento = $tuplas->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $evento['nombre']; ?></td>
                        <td> <?php echo date_format(date_create($evento['fecha_inicio']), 'd-m-Y'); ?></td>
                        <td> <?php echo date_format(date_create($evento['fecha_fin']), 'd-m-Y'); ?></td>
                        <td>
                          <?php
                          if ($evento['estado']) {
                            echo "Activo  "; ?><i class="fa fa-circle text-success"></i><?php
                                                                                      } else {
                                                                                        echo "Inactivo  ";  ?><i class="fa fa-circle-o text-red"></i><?php
                                                                                                                                                    }
                                                                                                                                                      ?>
                        </td>
                        <td>
                          <!-- <a href="editar-evento.php?id=<?php //echo $evento['id_admin']; 
                                                              ?>" class="btn bg-orange btn-flat margin">
                            <i class="fa fa-pencil"></i>
                          </a> -->
                          <div class="input-group margin">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">VER
                              <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="lista-inscriptos.php?id=<?php echo $evento['id_evento']; ?>">Listado inscriptos</a></li>
                              <li><a href="estadisticas-evento.php?id=<?php echo $evento['id_evento']; ?>">Estadísticas</a></li>
                            </ul>
                          </div>
                          </div>
                          <a href="#" data-id="<?php echo $evento['id_evento']; ?>" data-tipo="evento" class="borrar-registro">
                            <button type="button" class="btn  btn-danger"><i class="fa fa-trash"></i></button>
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