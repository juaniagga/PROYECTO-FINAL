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
      <section class="content" style="width: 100%;">
        <div class="row centrar-contenido">
          <div class="col-xs-12 col-lg-8">
              <!-- BOX ADMIN SISTEMA -->
              <div class="box">
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="registros" class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                      <th>Medio de pago</th>
                      <th class="col-lg-3">Estado</th>
                      <th class="col-xs-5">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    try{
                      include_once 'funciones/funciones.php';
                      $sql= "
                      SELECT m.id_medio, m.nombre, m.estado
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
                            <?php $encrypt= openssl_encrypt($medio['id_medio'],"AES-128-ECB","unmdp2021"); ?>
                            <a href="editar-pago.php?id=<?php echo urlencode($encrypt); ?>" class="btn bg-orange btn-flat margin">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <button type="button" id="btn-pago" data="0" data-id="<?php echo $medio['id_medio']; ?>" class="btn btn-warning" style="width: 90px; color:black">Desactivar</button>
                          </td>
                          <?php
                        }else{
                          echo "Desactivado  ";  ?><i class="fa fa-circle-o text-red"></i>
                          <td>
                            <?php $encrypt= openssl_encrypt($medio['id_medio'],"AES-128-ECB","unmdp2021"); ?>
                            <a href="editar-pago.php?id=<?php echo urlencode($encrypt); ?>" class="btn bg-orange btn-flat margin">
                              <i class="fa fa-pencil"></i>
                            </a>
                            <button type="button" id="btn-pago" data="1" data-id="<?php echo $medio['id_medio']; ?>"  class="btn btn-warning" style="width: 90px; color:black">Activar</button>
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
