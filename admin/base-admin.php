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
        ¡Bienvenido!
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="">Primeros pasos</h3>
        </div>
        <div class="box-body instrucciones">
          Para comenzar a utilizar el sistema, se recomienda que descargue y lea la guía de usuario haciendo click en <b>Guía de usuario</b> en el menú.
          <br>
          <?php if (!$permiso){?>
          <h3>Aclaración:</h3>
          Por defecto el estado del evento es <b>desactivado</b>. En este estado sólo usted y los demás administradores podrán acceder a la página del evento. <br>
          Cambie el estado a <b>activado</b> una vez que haya completado toda la información y desee habilitar las inscripciones. <br>
          <!-- Asímismo, las inscripciones al público son inhabilitadas una vez pasada la fecha de finalización del evento. -->
          <?php } ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
  include_once 'templates/footer.php';
?>
