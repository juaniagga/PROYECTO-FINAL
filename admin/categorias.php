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
        <div class="row">
          <div class="col-xs-12">
            <!-- BOX ADMIN EVENTOS -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Listado de categorías</h3>

              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="registros" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Precio</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    try {
                      include_once 'funciones/funciones.php';

                      if ($permiso) {                        //traigo todos los admins de eventos
                        $sql = "
                    SELECT a.id_admin, a.nombre, a.usuario, a.email
                    FROM administrador a
                    WHERE a.permiso=0
                    ORDER BY a.nombre";
                      } else {                               //traigo los admins de mi evento
                        $sql = "
                    SELECT a.id_admin, a.nombre, a.usuario, a.email
                    FROM administrador a
                    WHERE a.id_admin IN (SELECT a.id_admin FROM administrado a WHERE id_evento=" . $_SESSION['id_evento'] . ")
                    ORDER BY a.nombre";
                      }

                      $tuplas = $db->query($sql);
                    } catch (Exception $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    while ($admin = $tuplas->fetch_assoc()) {
                      if ($permiso) {
                        $sql_e = "
                    SELECT e.nombre
                    FROM evento e
                    WHERE e.id_evento=(SELECT a.id_evento FROM administrado a WHERE a.id_admin='" .  $admin['id_admin']  . "')";
                        $tupla_e = $db->query($sql_e);
                        $evento = $tupla_e->fetch_assoc();
                      }

                    ?>
                      <tr>
                        <td><?php echo $admin['nombre']; ?></td>
                        <td> <?php echo $admin['usuario']; ?></td>
                        <td> <?php echo $admin['email']; ?></td>
                        <?php
                        if ($permiso) {
                        ?>
                          <td> <?php echo $evento['nombre']; ?></td>
                          <td>
                            <a href="editar-admin.php?id=<?php echo $admin['id_admin']; ?>" class="btn bg-orange btn-flat margin">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#" data-id="<?php echo $admin['id_admin']; ?>" data-tipo="admin" url="control-admin.php" class="btn bg-maroon btn-flat margin borrar-registro">
                              <i class="fa fa-trash"></i>
                            </a>
                          </td>
                        <?php
                        }
                        ?>

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