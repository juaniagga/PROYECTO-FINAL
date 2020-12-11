<?php
  include_once 'funciones/sesion-admin.php';
  include_once 'templates/header.php';

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
        Administradores del sistema
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-9">
            <!-- BOX ADMIN SISTEMA -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Gestiones los administradores</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                  <tr>
                    <th class="col-xs-2">Nombre</th>
                    <th class="col-xs-2">Usuario</th>
                    <th class="col-xs-3">Email</th>
                    <th class="col-xs-2">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                  try{
                    include_once 'funciones/funciones.php';
                    $sql= "
                    SELECT a.id_admin, a.nombre, a.usuario, a.email
                    FROM administrador a
                    WHERE a.permiso=1
                    ORDER BY a.nombre";
                    $tuplas= $db->query($sql);
                  }catch(Exception $e){
                    echo "Error: " . $e->getMessage();
                  }

                  while ($admin= $tuplas->fetch_assoc()){
                  ?>
                  <tr>
                    <td><?php echo $admin['nombre']; ?></td>
                    <td> <?php echo $admin['usuario']; ?></td>
                    <td> <?php echo $admin['email']; ?></td>
                    <td>
                      <a href="editar-admin.php?id=<?php echo $admin['id_admin']; ?>" class="btn bg-orange btn-flat margin">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="#" data-id="<?php echo $admin['id_admin']; ?>" data-tipo="admin" url="control-admin.php" class="btn bg-maroon btn-flat margin borrar-registro">
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
