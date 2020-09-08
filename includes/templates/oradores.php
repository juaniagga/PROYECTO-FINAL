<?php 
        try{
            require_once('includes/funciones/conexionBDD.php');
            $sql_oradores="
            SELECT nombre, apellido, descripcion, url_imagen, legajo
            FROM orador";
            $tuplas_oradores= $db->query($sql_oradores);    //oradores con el id_actividad
        }
        catch(Exception $e){
            echo ($e->getMessage());
        }
    ?>

        <?php
            //$anterior='';
            $oradores= array();
            while ($aux_oradores= $tuplas_oradores->fetch_assoc()){
                $o_aux= array(
                    'nombre_ape' => $aux_oradores['nombre'] . ' ' . $aux_oradores['apellido'],
                    'descripcion' => $aux_oradores['descripcion'],
                    'imagen' => $aux_oradores['url_imagen'],
                    'legajo' => $aux_oradores['legajo']
                );
                $oradores[]= $o_aux;
            }
        
        ?>
        
        <section id="invitados" class="invitados contenedor seccion">
            <h2>Nuestros Oradores</h2>
            <ul class="lista-invitados clearfix">
                <?php
                    foreach($oradores as $orador){ ?>
                        <li>
                            <div class="invitado">
                                <a class="invitado-info" href="#orador<?php echo $orador['legajo']; ?>">
                                    <img src= "img/<?php echo $orador['imagen']; ?>" alt="imagen orador">
                                    <p> <?php echo $orador['nombre_ape']; ?> </p>
                                </a>
                            </div>
                        </li>
                        <div id="#orador_hidden" style="display:none;">
                            <div class="invitado-info" id="orador<?php echo $orador['legajo']; ?>">
                                <h2><?php echo $orador['nombre_ape']; ?></h2>
                                <img src="img/<?php echo $orador['imagen']; ?>" alt="imagen orador">
                                <p><?php echo $orador['descripcion']; ?></p>

                            </div>
                        </div>
            <?php   }
                ?>
                
            </ul>
        </section>