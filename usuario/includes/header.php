<?php
include_once '../includes/funciones/sesion-user.php';
try {
  include_once '../includes/funciones/conexionBDD.php';
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
?>
<!-- ------------------------------------------------------------ -->
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Eventos UNMDP</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="../site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="../css/normalize.css">
<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 -->  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <link rel="stylesheet" href="../css/colorbox.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../admin/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../admin/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../admin/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../admin/css/AdminLTE.css">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="../admin/css/skins/_all-skins.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../admin/css/bootstrap.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../admin/css/bootstrap-datepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../admin/css/select2.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../admin/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="../admin/css/admin.css">

  <?php
  $archivo = basename($_SERVER['PHP_SELF']);
  $pagina = str_replace(".php", "", $archivo);


  /* if ($pagina == 'galeria')
      echo '<link rel="stylesheet" href="css/lightbox.css">';
    else
      if ($pagina == 'oradores' || $pagina == 'index')
        echo '<link rel="stylesheet" href="css/colorbox.css">'; */
  ?>


  <meta name="theme-color" content="#fafafa">
  <link rel="stylesheet" href="../css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans&display=swap" rel="stylesheet">

</head>

<body class="<?php echo $pagina; ?> min-altura">

  <div class="barra fixed-top" id="seccion">
    <div class="contenedor clearfix">
      <div class="menu-movil">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="contenido-barra">
        <div class="logo">
          <img src="../img/logoUNMDP.svg" alt="logo UNMDP">
        </div>
        <nav class="navegacion-principal clearfix">
          <a href="mis-eventos.php">Mis eventos</a>
          <a href="certificados.php">Certificados</a>
          <a href="ajustes.php">Ajustes</a>
          <a href="login-user.php?out=true">Cerrar sesión</a>
        </nav>
      </div>

    </div>
    <!--contenedor-->
  </div>
  <!--barra-->