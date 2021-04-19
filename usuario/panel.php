<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    

    if (isset($_POST['eliminar'])){
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

        elseif ($_POST['tipo']=='participante'){
            try {
                $stmt= $db->prepare("DELETE FROM participante WHERE id_participante=?");
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

    
    elseif (isset($_POST['infoPago'])) {

        $filename = "info_pago.pdf";
        $filepath = '../archivos/'. $filename;

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