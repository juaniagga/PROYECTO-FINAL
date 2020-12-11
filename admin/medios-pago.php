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
        Medios de pago del sistema
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-6">
            <!-- BOX ADMIN SISTEMA -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Gestiones los medios de pago</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="registros" class="table table-bordered table-striped text-center">
                  <thead>
                  <tr>
                    <th>Medio de pago</th>
                    <th class="col-lg-3">Estado</th>
                    <th class="col-xs-2">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                  try{
                    include_once 'funciones/funciones.php';
                    $sql= "
                    SELECT m.id_pago, m.nombre, m.estado
                    FROM medios_pago m
                    ORDER BY m.estado DESC";
                    $tuplas= $db->query($sql);
                  }catch(Exception $e){
                    echo "Error: " . $e->getMessage();
                  }

                  while ($medio= $tuplas->fetch_assoc()){
                  ?>
                  <tr>  
                    <td><?php echo $medio['nombre']; ?></td>
                    <td> <?php 
                      if($medio['estado']){
                        echo "Activado  "; ?><i class="fa fa-circle text-success"></i>
                        </td>
                        <td>
                          <button type="button" id="btn-pago" data="0" data-id="<?php echo $medio['id_pago']; ?>" class="btn btn-block btn-warning" style="width:100%; color:black">Desactivar</button>
                        </td>
                        <?php
                      }else{
                        echo "Desactivado  ";  ?><i class="fa fa-circle-o text-red"></i>
                        <td>
                          <button type="button" id="btn-pago" data="1" data-id="<?php echo $medio['id_pago']; ?>"  class="btn btn-block btn-warning" style="width:100%; color:black">Activar</button>
                        </td>
                        <?php
                      }
                      ?>
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
