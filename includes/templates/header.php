<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Eventos UNMDP</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/lightbox.css">
  <link rel="stylesheet" href="css/colorbox.css">
  
  <?php 
    $archivo= basename($_SERVER['PHP_SELF']);
    $pagina= str_replace(".php","",$archivo);


   /* if ($pagina == 'galeria')
      echo '<link rel="stylesheet" href="css/lightbox.css">';
    else
      if ($pagina == 'oradores' || $pagina == 'index')
        echo '<link rel="stylesheet" href="css/colorbox.css">'; */
  ?>


  <meta name="theme-color" content="#fafafa">
  <link rel="stylesheet" href="css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans&display=swap" rel="stylesheet">

</head>

<body class="<?php echo $pagina;?>">

<?php $id_evento= 1?>   <!-- OBTENER EL ID DE ALGUNA MANERA !!!!!!!!! podria ser de la url-->
  <?php
  setlocale(LC_TIME, 'es_RA');
  setlocale(LC_TIME,'spanish');
    try {
      require_once('includes/funciones/conexionBDD.php');
      $sql = "
            SELECT e.id_evento, e.nombre, e.fecha_inicio, e.fecha_fin, e.descripcion, e.ubicacion
            FROM evento e
            WHERE e.id_evento=1"; //. $_GET['id'];
      $tupla = $db->query($sql);
      $evento = $tupla->fetch_assoc();
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }

  ?>

  <header class="site-header">
    <div class="hero">
      <div class="contenido-header">
        <nav class="redes-sociales">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </nav>
        <div class="informacion-evento">
          <div class="clearfix">
            <p class="fecha"><i class="far fa-calendar-alt"></i>
            <?php 
              if ($evento['fecha_inicio']==$evento['fecha_fin']){
                echo utf8_encode(strftime("%d %B, %Y", strtotime($evento['fecha_inicio']))); 
              }else{
                echo utf8_encode(strftime("%d %B - ", strtotime($evento['fecha_inicio']))) . utf8_encode(strftime("%d %B, %Y", strtotime($evento['fecha_fin'])));
              }
              
            ?></p>
            <p class="ciudad"><i class="fas fa-map-marker-alt"></i> <?php echo $evento['ubicacion']?> </p>
          </div>
          <br><br>
          <h1 class="nombre-sitio"><?php echo $evento['nombre']?></h1>
          <p class="slogan"> Feria Internacional de Educación Superior Argentina</p>
        
        </div> <!-- informacion evento-->
        
      </div>
    </div> <!--hero-->
  </header>

  <div class="barra" id="seccion">
    <div class="contenedor clearfix">
      <div class="logo">
        <!-- <img src="logo.svg" alt="logo jornadas"> -->
      </div>
      <div class="menu-movil">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <nav class="navegacion-principal clearfix">
        <a href="index.php">Evento</a>
        <a href="calendario.php#seccion">Programa</a>
        <a href="oradores.php#seccion">Oradores</a>
        <a href="galeria.php#seccion">Galería</a>
        <a href="registro.php">Registrarse</a>
      </nav>
    </div><!--contenedor-->
  </div><!--barra-->