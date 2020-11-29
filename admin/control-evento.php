<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    $nombre= $_POST['nombre'];
    $descripcion= $_POST['descripcion'];
    $id_evento= $_SESSION['id_evento'];

    if (isset($_POST['crear-actividad'])){
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
        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['medios'])){
        $respuesta= array(
            'respuesta' => 'exito',
        );
        echo json_encode($respuesta);
    }
?>