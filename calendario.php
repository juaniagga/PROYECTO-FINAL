<?php include_once 'includes/templates/header.php'; ?>

  <!-- <section class="seccion contenedor">
    <h2> FIESA Mar del Plata 2021</h2>
      <p>
        La Feria Internacional de Educación Superior Argentina (FIESA) es un encuentro internacional de Instituciones de Educación Superior que tendrá a la Universidad Nacional de Mar del Plata y a la Ciudad de Mar del Plata como anfitrionas y reunirá a referentes de todo el mundo.
      </p>
  </section> --> <!--seccion-->

  <section id="" class="seccion contenedor">
    <h2>Calendario</h2>

    <?php 
        try{
            require_once('includes/funciones/conexionBDD.php');
            $sql_actividades="
            SELECT nombre_act, descripcion, fecha, hora_inicio, hora_fin, id_actividad,c.nombre as nombre_cat, icono
            FROM actividad a, categoria_act c
            WHERE a.id_categoria=c.id_categoria";
            $sql_oradores="
            SELECT nombre, apellido, o.id_orador, id_actividad
            FROM orador o, dicta d
            WHERE o.id_orador = d.id_orador";
            $tuplas_actividades= $db->query($sql_actividades);
            $tuplas_oradores= $db->query($sql_oradores);    //oradores con el id_actividad
        }
        catch(Exception $e){
            echo ($e->getMessage());
        }
    ?>
    <div class="calendario">
        <?php
            //$anterior='';
            $calendario= array();
            $oradores= array();
            while ($aux_actividades= $tuplas_actividades->fetch_assoc()) { 
                $f= $aux_actividades['fecha'];
                $aux_act= array(
                    'id_actividad' => $aux_actividades['id_actividad'],
                    'categoria' => $aux_actividades['nombre_cat'],
                    'descripcion' => $aux_actividades['descripcion'],
                    'icono' => $aux_actividades['icono'],
                    'nombre_act' => $aux_actividades['nombre_act'],
                    'fecha' => $aux_actividades['fecha'],
                    'horario' => $aux_actividades['hora_inicio'] . ' - ' . $aux_actividades['hora_fin'],
                    'oradores' => array()
                );
                $calendario[$f][]= $aux_act;
                }
                
            //El calendario es un arreglo de dias, cada dia es un arreglo de actividades, cada actividad es un arreglo

            while ($aux_oradores= $tuplas_oradores->fetch_assoc()){
                $orador= array(
                    'nombre_ape' => $aux_oradores['nombre'] . ' ' . $aux_oradores['apellido'],
                    'id_actividad' => $aux_oradores['id_actividad']
                );
                $oradores[]= $orador;
            }

            foreach ($calendario as $dia => $lista){
            ?>
				<h3>    <!-- Muestro fecha -->
					<i class="fa fa-calendar"></i>
					<?php
					setlocale(LC_TIME, 'es_RA');
					setlocale(LC_TIME,'spanish');
					echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($dia)));
					?>  
				</h3>

                <div class="dia"> 
                    <?php
                    foreach ($lista as $act){           //Agrego los oradores a cada actividad del calendario
                        foreach ($oradores as $ora){
                            if ($ora['id_actividad'] == $act['id_actividad'])
                                $act['oradores'][]=  $ora['nombre_ape'];
                        }

                    ?>
                        <div class="actividad">
                            <p class="titulo"> <?php echo $act['nombre_act']; ?> </p>

                            <p class="hora"> 
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <?php echo $act['horario']; 
                                // !! MOSTRAR SOLO HORA Y MINUTOS echo strtftime("$H:%M",[$act['horario']]);?> 
                            </p>

                            <p> 
                            <i class="fa <?php echo $act['icono']; ?>" aria-hidden="true"></i>
                            <?php echo $act['categoria'] ?> </p>
                            <p><?php echo $act['descripcion'] ;?></p>
                            <p>
                                <?php 
                                foreach($act['oradores'] as $o){
                                    ?>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php
                                    echo $o;
                                    echo "<br>";
                                }
                                ?>
                            </p>
                            
                        </div>
                        <!-- <pre>
                            <?php //var_dump($act); ?>
                        </pre> -->
            <?php   }/* foreach lista */ ?>

                </div>  <!-- class dia -->
                
                
                
    <?php   } /* foreach calendario */ ?>
                

        
    </div>
    
  </section>


  <?php include_once 'includes/templates/footer.php'; ?>