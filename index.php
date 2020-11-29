<?php include_once 'includes/templates/header.php'; ?>

<?php $id_evento= 1?>   <!-- OBTENER EL ID DE ALGUNA MANERA !!!!!!!!! podria ser de la url-->

  <section class="seccion contenedor">
    <h2> FIESA Mar del Plata 2021</h2>
      <p>
        La Feria Internacional de Educación Superior Argentina (FIESA) es un encuentro internacional de Instituciones de Educación Superior que tendrá a la Universidad Nacional de Mar del Plata y a la Ciudad de Mar del Plata como anfitrionas y reunirá a referentes de todo el mundo.
      </p>
  </section> <!--seccion-->

  <?php

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

  <section id="programa" class="programa">
    <div class="contenedor-video">
      <video autoplay loop poster="bg-talleres.jpg">
        <source src="video/video.mp4" type="video/mp4">
        <source src="video/video.webm" type="video/webm">
        <source src="video/video.ogv" type="video/ogv">
      </video> 
    </div><!--contenedor video-->

    <div class="contenido-programa">
      <div class="contenedor">
        <div class="programa-evento">
          <h2>Programa del Evento</h2>
          
          <?php
             try{
                require_once('includes/funciones/conexionBDD.php');
                $sql_cat="
                SELECT DISTINCT nombre, icono
                FROM categoria_act c, actividad a
                WHERE c.id_categoria=a.id_categoria AND a.id_evento=" . $id_evento . "
                ORDER BY c.id_categoria";
            
                $tuplas_cat= $db->query($sql_cat);
             }
             catch (Exception $e){
               $error= $e->getMessage();
             }
          ?>
          
          <nav class="menu-programa">
             <?php
                while ($categorias = $tuplas_cat->fetch_assoc()){
                  ?>
                  <a href="#<?php echo $categorias['nombre']; ?>"><i class="fa <?php echo $categorias['icono']; ?>">
                  </i><?php echo $categorias['nombre']; ?></a>
                <?php }
             ?>
          </nav>
        
          <?php
            try {
              require_once('includes/funciones/conexionBDD.php');
              $sql_act= "
              SELECT nombre_act, descripcion, fecha, hora_inicio, hora_fin, id_actividad, cat.id_categoria, cat.nombre as nombre_cat
              FROM actividad act, categoria_act cat
              WHERE act.id_categoria=cat.id_categoria AND act.id_evento=" . $id_evento . "
                    AND EXISTS 
                              (SELECT nombre_act, descripcion, fecha, hora_inicio, hora_fin, id_actividad, c.id_categoria
                              FROM actividad a, categoria_act c
                              WHERE a.id_categoria=c.id_categoria AND a.id_evento=" . $id_evento . "
                                                                    AND c.id_categoria=cat.id_categoria
                              ORDER BY fecha, hora_inicio
                              LIMIT 2)
              ORDER BY cat.id_categoria, fecha, hora_inicio";
              /* Obtengo dos actividades de cada categoria */
              $tuplas_act= $db->query($sql_act);
              
              $sql_oradores="
              SELECT nombre, apellido, o.dni, id_actividad
              FROM orador o, dicta d
              WHERE o.dni = d.dni
              ORDER BY nombre";;
              $tuplas_oradores= $db->query($sql_oradores);
            }
            catch (Exception $e){
              $error= $e->getMessage();
            }
          ?>
          
          <?php
            $oradores= array();   /* Armo array de oradores */
            while ($aux_oradores= $tuplas_oradores->fetch_assoc()){
              $orador= array(
                  'nombre_ape' => $aux_oradores['nombre'] . ' ' . $aux_oradores['apellido'],
                  'id_actividad' => $aux_oradores['id_actividad']
              );
              $oradores[]= $orador;
            }


            $actividades= array();
            while ($tupla = $tuplas_act->fetch_assoc()){ 
                $c= $tupla['nombre_cat'];
                $aux_act= array(
                    'descripcion' => $tupla['descripcion'],
                    'nombre_act' => $tupla['nombre_act'],
                    'fecha' => $tupla['fecha'],
                    'horario' => date_format(date_create($tupla['hora_inicio']), 'H:i') . ' - ' . date_format(date_create($tupla['hora_fin']), 'H:i'),
                    'oradores' => array()
                );

                /* Agrego los oradores */
                foreach($oradores as $o){
                  if ($o['id_actividad']==$tupla['id_actividad']){
                    $aux_act['oradores'][]=$o['nombre_ape'];
                    /* unset($oradores[$o]); */
                  }
                }

                $actividades[$c][]= $aux_act;
            } ?>



          
          <!-- Actividades del programa -->
          <?php
            setlocale(LC_TIME, 'es_RA');
            setlocale(LC_TIME,'spanish');
					
              foreach ($actividades as $cat => $lista_act){ ?>
                <div id="<?php echo $cat?>" class="info-curso ocultar clearfix">
                  <?php
                  foreach($lista_act as $a){ ?>
                    <div class="detalle-evento">
                      <h3><?php echo $a['nombre_act'] ?></h3>
                      <p><i class="fa fa-clock"></i> <?php echo $a['horario'] ?> hs </p>
                      <p><i class="fa fa-calendar"></i> <?php echo utf8_encode(strftime("%d de %B del %Y", strtotime($a['fecha']))); ?> </p>
                      <p>
                        <?php 
                        foreach($a['oradores'] as $o){?>
                          <i class="fa fa-user" aria-hidden="true"></i>
                          <?php
                            echo $o;
                            echo "<br>";
                        } ?>
                      </p>
                    </div>
                  <?php }?>
                  
                </div><!--#charlas-->
              
            <?php } ?>
          <a href="calendario.php" class="button float-right">Ver Todos</a>





          



          

        </div><!--programa evento-->
      </div><!--contenedor-->
    </div><!--contenido-programa-->

  </section><!--programa-->

  <?php include_once 'includes/templates/oradores.php'; ?> 
  <!-- <section id="invitados" class="invitados contenedor seccion">
    <h2>Nuestros Oradores</h2>
    <ul class="lista-invitados clearfix">
      <li>
        <div class="invitado">
          <img src="img/invitado1.jpg" alt="imagen invitado">
          <p> Juan Sanchez </p>
        </div>
      </li>
      <li>
        <div class="invitado">
          <img src="img/invitado2.jpg" alt="imagen invitado">
          <p> Maria Garcia </p>
        </div>
      </li>
      <li>
        <div class="invitado">
          <img src="img/invitado3.jpg" alt="imagen invitado">
          <p> Facundo Perez </p>
        </div>
      </li>
      <li>
        <div class="invitado">
          <img src="img/invitado4.jpg" alt="imagen invitado">
          <p> Fernanda Lopez </p>
        </div>
      </li>
      <li>
        <div class="invitado">
          <img src="img/invitado5.jpg" alt="imagen invitado">
          <p> Franco Rossi </p>
        </div>
      </li>
      <li>
        <div class="invitado">
          <img src="img/invitado6.jpg" alt="imagen invitado">
          <p> Mirta Gonzales </p>
        </div>
      </li>
    </ul>
  </section> -->


<!-- CONTADOR EVENTO -->
 <!--  <div class="contador parallax">
    <div class="contenedor">
      <ul class="resumen-evento clearfix">
        <li><p class="numero"></p>Participantes</li>
        <li><p class="numero"></p>Univeridades</li>
        <li><p class="numero"></p>Países</li>
        <li><p class="numero"></p>Stands</li>
      </ul>
    </div>
  </div> -->

<!-- <section class="precios seccion">
  <h2> Precios </h2>
  <div class="contenedor">
    <ul class="lista-precios clearfix">
      <li>
        <div class="tabla-precio">
          <h3>Estudiante</h3>
          <p class="numero">$0</p>
          <ul>
            <li>Bocadillos gratis</li>
            <li>Todas las conferencias</li>
            <li>Todos los talleres</li>
          </ul>
          <a href="#" class="button hollow">Comprar</a>
        </div>
      </li>
      <li>
        <div class="tabla-precio">
          <h3>Docente</h3>
          <p class="numero">$0</p>
          <ul>
            <li>Bocadillos gratis</li>
            <li>Todas las conferencias</li>
            <li>Todos los talleres</li>
          </ul>
          <a href="#" class="button hollow">Comprar</a>
        </div>
      </li>
      <li>
        <div class="tabla-precio">
          <h3>Externo</h3>
          <p class="numero">$500</p>
          <ul>
            <li>Bocadillos gratis</li>
            <li>Todas las conferencias</li>
            <li>Todos los talleres</li>
          </ul>
          <a href="#" class="button hollow">Comprar</a>
        </div>
      </li>
    </ul>
  </div>
</section> -->


  
  <div id="mapa" class="mapa">
    <p id="coordenadas" style="display:none"> <?php echo $evento['ubicacion']; ?></p>
  </div>


  <section class="seccion">
    <h2>Faltan</h2>
    <div class="cuenta-regresiva contenedor">
      <ul class="clearfix">
        <li><p id="dias" class="numero"></p>dias</li>
        <li><p id="horas" class="numero"></p>horas</li>
        <li><p id="minutos" class="numero"></p>minutos</li>
        <li><p id="segundos" class="numero"></p>segundos</li>
      </ul>
    </div>
  </section>


  <div class="newsletter parallax">
    <div class="contenido contenedor">
      <p> Registrate al newsletter</p>
      <h3>FIESA UNMDP</h3>
      <a href="#mc_embed_signup" class="boton_newsletter button transparente">Registro</a>
    </div><!--contenido-->
  </div><!--newsletter-->
  

  <?php include_once 'includes/templates/footer.php'; ?>
