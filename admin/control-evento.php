<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    

    if (isset($_POST['crear-actividad'])){
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $id_evento= $_SESSION['id_evento'];
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
        $id_categoria= $_POST['categoria'];
        $fecha= date_format(date_create($_POST['fecha']), 'Y-m-d');
        $hora_inicio= date_format(date_create($_POST['hora_inicio']), 'H:i');
        $hora_fin= date_format(date_create($_POST['hora_fin']), 'H:i');
        $id_actividad= $_POST['id_actividad'];

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

        $directorio= "../archivos/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }

        if (move_uploaded_file($_FILES['pdf']['tmp_name'], $directorio . $_FILES['pdf']['name'])){
            $pdf= $_FILES['pdf']['name'];
        }else{
            $respuesta= array(
                'respuesta' => error_get_last(),
            );
            $pdf= "";
        }


        try {
            $stmt= $db->prepare("UPDATE evento SET nombre=?, fecha_inicio=?, fecha_fin=?, estado=?, organizador=?, ubicacion=?, descripcion=?, info_pago=? 
            WHERE id_evento=?");
            $stmt->bind_param("sssissssi", $nombre, $fecha_inicio, $fecha_fin, $estado, $organizador,$ubicacion, $descripcion, $pdf, $id_evento);
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
            $stmt= $db->prepare("UPDATE medios_pago SET estado=? WHERE id_medio=?");
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
        $tarifa= $_POST['tarifa'];
        try {
            $stmt= $db->prepare("INSERT INTO cat_asociadas (id_evento, id_categoria, tarifa) VALUES(?,?,?)");
            $stmt->bind_param("iid", $id_evento, $id_categoria, $tarifa);
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

    elseif (isset($_POST['editar-tarifa'])){
        $id= $_POST['id_categoria'];
        $tarifa= $_POST['tarifa'];
        try {
            $stmt= $db->prepare("UPDATE cat_asociadas SET tarifa=? WHERE id_categoria=?");
            $stmt->bind_param("di", $tarifa, $id);
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
        $dni= $_POST['dni'];
        if (isset($_POST['actividades'])){
            $actividades= $_POST['actividades'];
        }
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
            $imagen_url= "icono.png";
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
                if (isset($actividades)){
                    for ($i=0; $i<count($actividades);$i++)    
                    {     
                        $id_actividad= $actividades[$i];
                        try {
                            $stmt_d= $db->prepare("INSERT INTO dicta (id_orador, id_actividad) VALUES(?,?)");
                            $stmt_d->bind_param("ii", $id_orador, $id_actividad);
                            $stmt_d->execute();
                            $stmt_d->close();
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    } 
                }
                
            }else{
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };
            $stmt_o->close();
            
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
                $stmt_o= $db->prepare("UPDATE orador SET id_evento=?, dni=?, nombre=?, apellido=?, biografia=?, imagen=? WHERE id_orador=?");
                $stmt_o->bind_param("iissssi", $id_evento, $dni, $nombre, $apellido, $biografia, $imagen_url, $id);
            }else {
                $stmt_o= $db->prepare("UPDATE orador SET id_evento=?, dni=?, nombre=?, apellido=?, biografia=? WHERE id_orador=?");
                $stmt_o->bind_param("iisssi", $id_evento, $dni, $nombre, $apellido, $biografia, $id);
            }
            $estado=  $stmt_o->execute();
            if ($stmt_o->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
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
            try {
                $stmt_d = $db->prepare("INSERT INTO dicta (id_orador, id_actividad) VALUES(?,?)");
                $stmt_d->bind_param("ii", $id, $id_actividad);
                $stmt_d->execute();

                if ($stmt_d->affected_rows){ 
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => 'error',
                    );
                };
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

    elseif (isset($_POST['crear-inscripto'])){
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $email= $_POST['email'];
        $telefono= $_POST['telefono'];
        $dni= $_POST['dni'];
        $pais= $_POST['pais'];
        $provincia= $_POST['provincia'];
        $ciudad= $_POST['ciudad'];
        $calle= $ciudad= $_POST['calle'];
        $numero= $_POST['numero'];

        $institucion = $_POST['institucion'];
        $cargo = $_POST['cargo'];
        $trabajo_cientifico = $_POST['trabajo'];
        
    
        try {
            $stmt= $db->prepare("INSERT INTO usuario (email, dni, nombre, apellido, telefono, calle, numero, ciudad, provincia, pais, trabajo_cientifico, institucion, cargo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sissisisssiss", $email, $dni, $nombre, $apellido, $telefono, $calle, $numero, $ciudad, $provincia, $pais, $trabajo_cientifico, $institucion, $cargo);
            $stmt->execute();
            echo "id:  " . mysqli_insert_id($db);
            if (mysqli_insert_id($db) > 0){ 
                $id_user= mysqli_insert_id($db);
                echo " adentro";
            }else{
                echo "Error: " . $db->error;
                $tupla = $db->query("SELECT u.id_user FROM usuario u WHERE u.dni=" . $dni);
                $u=$tupla->fetch_assoc();
                $id_user= $u['id_user'];
            };

            
           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $categoria= $_POST['categoria']; 
        $fecha_registro= date('Y-m-d',time());
        $forma_pago= $_POST['medio'];
        $importe_abonado= $_POST['importe'];
        $fecha_pago= $_POST['fecha_pago'];
        $comentario= $_POST['comentario'];
        $exento= $_POST['exento'];
        $alojamiento= $_POST['hotel'];
        $fecha_arribo= $_POST['arribo'];
        $fecha_partida= $_POST['partida'];
        $traslado= $_POST['traslado'];
        $acreditado=0;
        $pago_confirmado=0;

        if (isset($_POST['cuit'])){
            $facturacion= 1;
        } else{
            $facturacion=0;
        }
        $iva= $_POST['iva'];
        $cuit= $_POST['cuit'];
        $nombre_factura= $_POST['nombre_factura'];
        $adicionales= $_POST['conceptos'];

        $directorio= "../comprobantes/";
        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }
    
        if (isset($_FILES['pdf']) && move_uploaded_file($_FILES['pdf']['tmp_name'], $directorio . $_FILES['pdf']['name'])){
            $pdf= $_FILES['pdf']['name'];
        }else{
            $respuesta= array(
                'respuesta' => error_get_last(),
            );
            $pdf= "";
        }
        try {
            echo "id user " . $id_user;
            $stmtp= $db->prepare("INSERT INTO participante (id_user, id_evento, id_categoria, fecha_registro, acreditado,forma_pago, importe_abonado, comprobante, fecha_pago, comentario_pago, pago_confirmado,exento, facturacion,  iva, cuit, adicionales, nombre_factura, alojamiento,fecha_arribo, fecha_partida, traslado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmtp->bind_param("iiisisdsssiiisissssss", $id_user, $id_evento, $id_categoria, $fecha_registro, $acreditado,$forma_pago, $importe_abonado, $comprobante, $fecha_pago, $comentario_pago, $pago_confirmado,$exento, $facturacion, $iva, $cuit, $adicionales, $nombre_factura, $alojamiento, $fecha_arribo, $fecha_partida, $traslado);
            $stmtp->execute();
            
            if ($stmtp->affected_rows){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                echo " id par:  " . mysqli_insert_id($db);
                echo " adentro";
            }else{
                echo " Problem: " . $db->error;
                $respuesta= array(
                    'respuesta' => 'error',
                );
            };

            $stmtp->close();
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['acreditar'])){
        $id_participante= $_POST['id'];
        $id_evento= $_SESSION['id_evento'];
        $valor= 1;
        try {
            $stmt= $db->prepare("UPDATE participante SET acreditado=? WHERE id_participante=?");
            $stmt->bind_param("ii", $valor, $id_participante);
            $stmt->execute();

            if ($stmt->affected_rows){  //siempre devuelve 0..
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                $db->query("UPDATE evento SET acreditados=acreditados+1 WHERE id_evento=" . $id_evento);
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

    elseif (isset($_POST['validar'])){
        $id_participante= $_POST['id'];
        $valor= 1;
        try {
            $stmt= $db->prepare("UPDATE participante SET pago_confirmado=? WHERE id_participante=?");
            $stmt->bind_param("ii", $valor, $id_participante);
            $stmt->execute();

            if ($stmt->affected_rows){  //siempre devuelve 0..
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                $id_admin= $db->insert_id;
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
    
    elseif (isset($_POST['descargar'])) {
        //nombre de archivos: "pago_id.pdf"
        $id = $_POST['id'];

        $filename = "pago_". $id .".pdf";
        $filepath = '../comprobantes/'. $filename;

        // header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        /* header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Lenght: '.filesize($filepath));
                header('Content-Transfer-Encoding: binary'); */
        readfile($filepath);
        exit;
    }

?>