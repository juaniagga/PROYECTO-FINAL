<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    

    if (isset($_POST['crear-actividad'])){
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $id_evento= $_SESSION['id_evento'];
        $oradores= $_POST['oradores'];
        $id_categoria= $_POST['categoria'];
        $fecha= date_format(date_create($_POST['fecha']), 'Y-m-d');
        $hora_inicio= date_format(date_create($_POST['hora_inicio']), 'H:i');
        $hora_fin= date_format(date_create($_POST['hora_fin']), 'H:i');

        try {
            $stmt_act= $db->prepare("INSERT INTO actividad (nombre_act, fecha, hora_inicio, hora_fin, descripcion, id_categoria, id_evento) VALUES(?,?,?,?,?,?,?)");
            $stmt_act->bind_param("sssssii", $nombre, $fecha, $hora_inicio, $hora_fin, $descripcion, $id_categoria, $id_evento);
            $stmt_act->execute();

            if ($stmt_act->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                $id_actividad= mysqli_insert_id($db);
                echo "id act " . $id_actividad;
                for ($i=0; $i<count($oradores);$i++)    
                {     
                    $dni= $oradores[$i];
                    try {
                        $stmt_d= $db->prepare("INSERT INTO dicta (dni, id_actividad) VALUES(?,?)");
                        $stmt_d->bind_param("ii", $dni, $id_actividad);
                        $stmt_d->execute();
                        echo "adentro";
                        
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } 
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt_act->close();
            $stmt_d->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['editar-actividad'])){
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $id_evento= $_SESSION['id_evento'];
        $oradores= $_POST['oradores'];
        $id_categoria= $_POST['categoria'];
        $fecha= date_format(date_create($_POST['fecha']), 'Y-m-d');
        $hora_inicio= date_format(date_create($_POST['hora_inicio']), 'H:i');
        $hora_fin= date_format(date_create($_POST['hora_fin']), 'H:i');
        $id_actividad= $_POST['id_actividad'];
        echo "id cat " . $id_categoria . "<br>";
        echo "id fecha " . $fecha . "<br>";
        echo "id hi " . $hora_inicio . "<br>";
        echo "id hf " . $hora_fin . "<br>";
        echo "id act " . $id_actividad . "<br>";

        try {
            $stmt_act= $db->prepare("UPDATE actividad SET nombre_act=?, fecha=?, hora_inicio=?, hora_fin=?, descripcion=?, id_categoria=? 
            WHERE id_actividad=?");
            $stmt_act->bind_param("sssssii", $nombre, $fecha, $hora_inicio, $hora_fin, $descripcion, $id_categoria, $id_actividad);
            $stmt_act->execute();

            if ($stmt_act->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt_act->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['editar-evento'])){
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $id_evento= $_SESSION['id_evento'];
        $ubicacion= $_POST['ubicacion'];
        $organizador= $_POST['organizador'];
        $fecha_inicio= date_format(date_create($_POST['fecha_inicio']), 'Y-m-d');
        $fecha_fin= date_format(date_create($_POST['fecha_fin']), 'Y-m-d');
        $estado= $_POST['estado'];

        try {
            $stmt= $db->prepare("UPDATE evento SET nombre=?, fecha_inicio=?, fecha_fin=?, estado=?, organizador=?, ubicacion=?, descripcion=? 
            WHERE id_evento=?");
            $stmt->bind_param("sssisssi", $nombre, $fecha_inicio, $fecha_fin, $estado, $organizador,$ubicacion, $descripcion, $id_evento);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['eliminar'])){
        $id= $_POST['id'];
        if ($_POST['tipo']=='actividad'){
            try {
                $stmt= $db->prepare("DELETE FROM actividad WHERE id_actividad=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows){
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => 'error',
                    );
                };
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        elseif ($_POST['tipo']=='orador'){
            try {
                $stmt= $db->prepare("DELETE FROM orador WHERE id_orador=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows){
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => 'error',
                    );
                };
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['medios'])){
        try {
            $stmt= $db->prepare("UPDATE medios_pago SET estado=? WHERE id_pago=?");
            $stmt->bind_param("ii", $_POST['accion'], $_POST['id']);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['crear-categoria'])){
        $nombre= $_POST['nombre'];
        $autoreg= $_POST['autoreg'];

        try {
            $stmt= $db->prepare("INSERT INTO categoria_participante (nombre,autoreg) VALUES(?,?)");
            $stmt->bind_param("si", $nombre, $autoreg);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['agregar-categoria'])){
        $id_evento= $_SESSION['id_evento'];
        $id_categoria= $_POST['categoria'];
        $precio= $_POST['precio'];
        try {
            $stmt= $db->prepare("INSERT INTO cat_asociadas (id_evento, id_categoria, precio) VALUES(?,?,?)");
            $stmt->bind_param("iid", $id_evento, $id_categoria, $precio);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['editar-precio'])){
        $id= $_POST['id_categoria'];
        $precio= $_POST['precio'];
        try {
            $stmt= $db->prepare("UPDATE cat_asociadas SET precio=? WHERE id_categoria=?");
            $stmt->bind_param("di", $precio, $id);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['editar-categoria'])){
        $id= $_POST['id_categoria'];
        $nombre= $_POST['nombre'];
        $autoreg= $_POST['autoreg'];
        try {
            $stmt= $db->prepare("UPDATE categoria_participante SET nombre=?, autoreg=? WHERE id_categoria=?");
            $stmt->bind_param("sii", $nombre, $autoreg, $id);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['crear-orador'])){
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $biografia= $_POST['biografia'];
        $id_evento= $_SESSION['id_evento'];
        $actividades= $_POST['actividades'];
        $dni= $_POST['dni'];

        $directorio= "../img/oradores/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])){
            $imagen_url= $_FILES['imagen']['name'];
            $img_res= "Imagen cargada";
        }else{
            $respuesta= array(
                'respuesta' => error_get_last(),
            );
            $imagen_url= "Sin foto";
            $img_res= "Sin imagen";
        }

        try {
            $stmt_o= $db->prepare("INSERT INTO orador (id_evento, dni, nombre, apellido, biografia, imagen) VALUES(?,?,?,?,?,?)");
            $stmt_o->bind_param("iissss", $id_evento, $dni, $nombre, $apellido, $biografia, $imagen_url);
            $stmt_o->execute();

            if ($stmt_o->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                    'img_res' => $img_res
                );
                $id_orador= mysqli_insert_id($db);
                echo "id orador " . $id_orador . "<br>";
                for ($i=0; $i<count($actividades);$i++)    
                {     
                    $id_actividad= $actividades[$i];
                    echo $id_actividad . "<br>";
                    try {
                        $stmt_d= $db->prepare("INSERT INTO dicta (id_orador, id_actividad) VALUES(?,?)");
                        $stmt_d->bind_param("ii", $id_orador, $id_actividad);
                        $stmt_d->execute();
                        echo "adentro";
                        
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                } 
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt_o->close();
            $stmt_d->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['editar-orador'])){
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $biografia= $_POST['biografia'];
        $id_evento= $_SESSION['id_evento'];
        $actividades= $_POST['actividades'];
        $dni= $_POST['dni'];
        $id= $_POST['id_orador'];
        $directorio= "../img/oradores/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])){
            $imagen_url= $_FILES['imagen']['name'];
            $img_res= "Imagen cargada";
        }else{
            $respuesta= array(
                'respuesta' => error_get_last(),
            );
        }

        try {
            if ($_FILES['imagen']['size'] > 0){
                echo "id " . $id_evento . "<br>";
                echo "dni " . $dni . "<br>";
                echo "nom " . $nombre . "<br>";
                echo "ap " . $apellido . "<br>";
                echo "bio " . $biografia . "<br>";
                $stmt_o= $db->prepare("UPDATE orador SET id_evento=?, dni=?, nombre=?, apellido=?, biografia=?, imagen=? WHERE id_orador=?");
                $stmt_o->bind_param("iissssi", $id_evento, $dni, $nombre, $apellido, $biografia, $imagen_url, $id);
            }else {
                $stmt_o= $db->prepare("UPDATE orador SET id_evento=?, dni=?, nombre=?, apellido=?, biografia=? WHERE id_orador=?");
                $stmt_o->bind_param("iisssi", $id_evento, $dni, $nombre, $apellido, $biografia, $id);
            }
            $stmt_o->execute();

            if ($stmt_o->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                    'img_res' => $img_res
                );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
            );
        };
        //borro los registros de dicta
        $stmt = $db->prepare("DELETE FROM dicta WHERE id_orador=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        //vuelvo a cargar los registros de dicta
        for ($i = 0; $i < count($actividades); $i++) {
            $id_actividad = $actividades[$i];
            echo $id_actividad . "<br>";
            try {
                $stmt_d = $db->prepare("INSERT INTO dicta (id_orador, id_actividad) VALUES(?,?)");
                $stmt_d->bind_param("ii", $id, $id_actividad);
                $stmt_d->execute();
                echo "adentro";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        $stmt_o->close();
            $stmt_d->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['crear-pago'])){
        $nombre= $_POST['nombre'];
        $estado= 1;
        try {
            $stmt= $db->prepare("INSERT INTO medios_pago (nombre, estado) VALUES(?,?)");
            $stmt->bind_param("si", $nombre, $estado);
            $stmt->execute();

            if ($stmt->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }
?>