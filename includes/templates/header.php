<?php
  session_start();
  try{
    include_once 'includes/funciones/conexionBDD.php';
  }catch(Exception $e){
    echo "Error: " . $e->getMessage();
  }
?>
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
  $archivo = basename($_SERVER['PHP_SELF']);
  $pagina = str_replace(".php", "", $archivo);


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

<body class="<?php echo $pagina; ?>">

  <?php $id_evento= urldecode(openssl_decrypt($_GET['id'], "AES-128-ECB","unmdp2021"));?>
  <!-- OBTENER EL ID DE ALGUNA MANERA !!!!!!!!! podria ser de la url-->
  <?php
  setlocale(LC_TIME, 'es_RA');
  setlocale(LC_TIME, 'spanish');
  try {
    $sql = "
            SELECT e.id_evento, e.nombre, e.fecha_inicio, e.fecha_fin, e.descripcion, e.ubicacion, e.imagen, e.estado, e.organizador
            FROM evento e
            WHERE e.id_evento=". $id_evento;
    $tupla = $db->query($sql);
    if (!($tupla)){
      header("Location: usuario/not-found.php");
      exit();
    }else{
      $evento = $tupla->fetch_assoc();
    }
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }

  ?>

  <header class="site-header">
    <div class="hero" style="background-image: url(img/<?php echo "evento_" . $id_evento . "/" . $evento['imagen'];?>);">
      <div class="contenido-header">
        <nav class="redes-sociales">
          <a href="https://www.facebook.com/unmdp"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/unmdp"><i class="fab fa-twitter"></i></a>
          <a href="https://www.youtube.com/user/canalunmdp"><i class="fab fa-youtube"></i></a>
          <a href="https://www.instagram.com/unmdp_oficial/?hl=es-la"><i class="fab fa-instagram"></i></a>
        </nav>
        <div class="informacion-evento">
          <div class="info-evento">
            <p class="item-info">Organizado por <?php echo $evento['organizador'];?></p>
            <p class="fecha item-info"><i class="far fa-calendar-alt"></i>
              <?php
              if ($evento['fecha_inicio'] == $evento['fecha_fin']) {
                echo utf8_encode(strftime("%d %B, %Y", strtotime($evento['fecha_inicio'])));
              } else {
                echo utf8_encode(strftime("%d %B - ", strtotime($evento['fecha_inicio']))) . utf8_encode(strftime("%d %B, %Y", strtotime($evento['fecha_fin'])));
              }

              ?>
            </p>
            <p class="ciudad item-info"><i class="fas fa-map-marker-alt"></i> <?php echo $evento['ubicacion'] ?> </p>
              
          </div>
          <br><br>
          <h1 class="nombre-sitio"><?php echo $evento['nombre'] ?></h1>
          

        </div> <!-- informacion evento-->

      </div>
    </div>
    <!--hero-->
  </header>

  <div class="barra" id="seccion">
    <div class="contenedor clearfix">
      
      <div class="menu-movil">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="contenido-barra">
        <div class="logo">
          <img src="img/logoUNMDP.svg" alt="logo UNMDP">
        </div>
        <nav class="navegacion-principal clearfix">
          <?php $encrypt= openssl_encrypt($evento['id_evento'],"AES-128-ECB","unmdp2021"); ?>
          <a href="index.php?id=<?php echo urlencode($encrypt);?>">Evento</a>
          <a href="calendario.php?id=<?php echo urlencode($encrypt);?>#seccion">Programa</a>
          <a href="oradores.php?id=<?php echo urlencode($encrypt);?>#seccion">Oradores</a>
          <a href="galeria.php?id=<?php echo urlencode($encrypt);?>#seccion">Galería</a>
          <a href="registro.php?id=<?php echo urlencode($encrypt);?>#seccion">Inscripción</a>
          <?php
            if (isset($_SESSION['id_user'])){
              ?>
              <a href="usuario/mis-eventos.php">Mi cuenta</a>
              <a href="usuario/login-user.php?out=true">Cerrar sesión</a>
              <?php
            }else{
              ?>
              <a href="usuario/login-user.php">Ingresar / Crear cuenta</a>
              <?php
            }
          ?>
        </nav>
      </div>
      
    </div>
    <!--contenedor-->
  </div>
  <!--barra-->