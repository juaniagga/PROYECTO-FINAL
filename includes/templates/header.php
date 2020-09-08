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
    /* $archivo= basename($_SERVER['PHP_SELF']);
    $pagina= str_replace(".php","",$archivo);

    if ($pagina == 'galeria')
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
            <p class="fecha"><i class="far fa-calendar-alt"></i> 16-17 Marzo</p>
            <p class="ciudad"><i class="fas fa-map-marker-alt"></i> Mar del Plata</p>
          </div>
          <br><br>
          <h1 class="nombre-sitio">FIESA 2021</h1>
          <p class="slogan"> Feria Internacional de Educación Superior Argentina</p>
        
        </div> <!-- informacion evento-->
        
      </div>
    </div> <!--hero-->
  </header>

  <div class="barra">
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
        <a href="calendario.php">Programa</a>
        <a href="oradores.php">Oradores</a>
        <a href="galeria.php">Galería</a>
        <a href="registro.php">Registrarse</a>
      </nav>
    </div><!--contenedor-->
  </div><!--barra-->