<?php
    include_once '../includes/funciones/sesion-user.php';
    include_once '../includes/funciones/conexionBDD.php';
    $id_user= $_SESSION['id_user'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    if (isset($_POST['nuevo-registro'])){
            $id_categoria= $_POST['id_categoria']; 
            $id_evento= $_POST['id_evento']; 
            $fecha_registro= date('Y-m-d',time());   
            
            $alojamiento= $_POST['hotel'];
            $fecha_arribo= $_POST['arribo'];
            $fecha_partida= $_POST['partida'];
            $traslado= $_POST['traslado'];
            $pago_confirmado=0;

            try {
                $sql = "
                    SELECT c.tarifa
                    FROM cat_asociadas c
                    WHERE c.id_evento=" . $id_evento;
                $tuplas = $db->query($sql);
              } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
              }
            $cat = $tuplas->fetch_assoc();
    
            if ($cat['tarifa']==0){
                $pago_confirmado=1;
            }
    
            $res_e= $db->query("SELECT e.limite, e.inscriptos FROM evento e WHERE e.id_evento=" . $id_evento);
            $res= $res_e->fetch_assoc();

            if ($res['inscriptos'] < $res['limite'] || $res['limite']==0){
                try {
                    $stmt= $db->prepare("INSERT INTO participante (id_user, id_evento, id_categoria, fecha_registro, pago_confirmado, alojamiento,fecha_arribo, fecha_partida, traslado) VALUES(?,?,?,?,?,?,?,?,?)");
                    $stmt->bind_param("iiisissss", $id_user, $id_evento, $id_categoria, $fecha_registro, $pago_confirmado, $alojamiento, $fecha_arribo, $fecha_partida, $traslado);
                    $stmt->execute();
                    
                    if (mysqli_insert_id($db) > 0){ 
                        $respuesta= array(
                            'respuesta' => 'exito',
                        );
                    }else{
                        $msj= $db->error;
                        if (strpos($msj, "Duplicate entry")!==false){
                            $respuesta= array(
                                'respuesta' => 'Ya estás registrado en este evento.');
                        }else{
                            $respuesta= array(
                                'respuesta' => $db->error,
                            );
                        }
                    };
        
                    $stmt->close();
                    $db->close();
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }else{
                $respuesta= array(
                    'respuesta' => 'No quedan cupos disponibles en este momento.',
                );
            }
            
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['cargar-comprobante'])) {
        $id_participante = $_POST['participante'];
        $id_evento = $_POST['id_evento'];
        $forma_pago= $_POST['medio'];
        $importe_abonado= $_POST['importe'];
        $f= str_replace('/', '-', $_POST['fecha_pago']);
        $fecha_pago= date_format(date_create($f), 'Y-m-d');
        $comentario= $_POST['comentario'];
        $iva= $_POST['iva'];
        $cuit= $_POST['cuit'];
        $nombre_factura= $_POST['nombre_factura'];
        $adicionales= $_POST['conceptos'];


        if (str_replace(' ', '', $iva)!=""){
            $facturacion= 1;
        } else{
            $facturacion=0;
        }

        $directorio = "../comprobantes/evento_" . $id_evento . "/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // file name
        $filename = $_FILES['file']['name'];

        // Location
        $location = $directorio . $filename;

        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);

        // Valid extensions
        $file_ext = array("jpg", "png", "jpeg", "pdf");

        $new_name = "pago_" . $id_participante;
        if (in_array($file_extension, $file_ext)) {
            // Upload file
            if (move_uploaded_file($_FILES['file']['tmp_name'], $directorio . $new_name . "." . $file_extension)) {
                $file = $new_name;
            } else {
                $respuesta = array(
                    'respuesta' => error_get_last(),
                );
            }

            try {
                $stmt = $db->prepare("UPDATE participante SET forma_pago=?, importe_abonado=?, comprobante=?, fecha_pago=?, comentario_pago=?,facturacion=?,  iva=?, cuit=?, adicionales=?, nombre_factura=? WHERE id_participante=?");
                $stmt->bind_param("idsssisissi", $forma_pago, $importe_abonado, $file, $fecha_pago, $comentario, $facturacion, $iva, $cuit, $adicionales, $nombre_factura, $id_participante);
                $stmt->execute();
    
                if ($stmt->affected_rows) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                    );
                } else {
                    $msj = $db->error;
                    $respuesta = array(
                        'respuesta' => $msj,
                    );
                };
    
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }else{
            $respuesta = array(
                'respuesta' => "Extensión incorrecta",
            );
        }

        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['baja'])){
        $id_participante= $_POST['id'];
        $id_evento= $_POST['id_evento'];
        $acreditado= $db->query("SELECT p.acreditado FROM participante p WHERE p.id_participante=" . $id_participante);
        $acreditado= $acreditado->fetch_assoc();
        $filename="";
        $file = "../comprobantes/evento_" . $id_evento . "/pago_". $id_participante;
        if (file_exists($file . ".pdf")){
            $filename = $file . ".pdf";
        } elseif(file_exists($file . ".jpg")){
            $filename = $file . ".jpg";
        } elseif(file_exists($file . ".png")){
            $filename = $file . ".png";
        } elseif(file_exists($file . ".jpeg")){
            $filename = $file . ".jpeg";
        }
        if ($filename!=""){
            unlink($filename);
        }
        if ($acreditado['acreditado'])
            $db->query("UPDATE evento SET acreditados=acreditados-1 WHERE id_evento=" . $id_evento);
        try {
            $stmt= $db->prepare("DELETE FROM participante WHERE id_participante=?");
            $stmt->bind_param("i", $id_participante);
            $stmt->execute();
            if ($stmt->affected_rows){
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => $db->error,
                );
            };
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }
    elseif (isset($_POST['editar-user'])){
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

        $respuesta=array();


        try {
            $stmt= $db->prepare("UPDATE usuario SET email=?, dni=?, nombre=?, apellido=?, telefono=?, calle=?, numero=?, ciudad=?, provincia=?, pais=?, trabajo_cientifico=?, institucion=?, cargo=? WHERE id_user=?");
            $stmt->bind_param("sissisisssissi", $email, $dni, $nombre, $apellido, $telefono, $calle, $numero, $ciudad, $provincia, $pais, $trabajo_cientifico, $institucion, $cargo, $id_user);
            $stmt->execute();
            if ($stmt->affected_rows || $db->error == ""){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => $db->error,
                );
                echo " Problem: " . $db->error;
            };           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['nueva-clave'])){
        $clave_actual= $_POST['password'];
        $clave_nueva= $_POST['new_password'];
        $respuesta=array();

        try {
            $stmt= $db->prepare(" SELECT u.clave FROM usuario u WHERE u.id_user=? ");
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $stmt->bind_result($clave);
            $stmt->store_result();  //para poder usar num_rows
            $stmt->fetch();

            if ($stmt->num_rows){
                if (password_verify($clave_actual, $clave)){    //compara la password ingresada con la encriptada en la bdd
        
                    $new_pass= password_hash($clave_nueva, PASSWORD_BCRYPT);
                    try {
                        $stmt_2= $db->prepare("UPDATE usuario SET clave=? WHERE id_user=?");
                        $stmt_2->bind_param("si", $new_pass, $id_user);
                        $stmt_2->execute();
                        if ($stmt_2->affected_rows || $db->error == ""){ 
                            $respuesta= array(
                                'respuesta' => 'exito',
                            );
                        }else{
                            $respuesta= array(
                                'respuesta' => $db->error,
                            );
                        };           
                        $stmt_2->close();
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }else{
                    $respuesta= array(
                        'respuesta' => "La contraseña actual es incorrecta.",
                    );
                }
            }else{
                $respuesta= array(
                    'respuesta'=> $db->error,
                );
            };
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }

    