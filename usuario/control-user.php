<?php
    include_once '../includes/funciones/sesion-user.php';
    include_once '../includes/funciones/conexionBDD.php';
    $id_user= $_SESSION['id_user'];

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
    

            try {
                $stmt= $db->prepare("INSERT INTO participante (id_user, id_evento, id_categoria, fecha_registro, pago_confirmado, alojamiento,fecha_arribo, fecha_partida, traslado) VALUES(?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iiisissss", $id_user, $id_evento, $id_categoria, $fecha_registro, $pago_confirmado, $alojamiento, $fecha_arribo, $fecha_partida, $traslado);
                $stmt->execute();
                
                if ($stmt->affected_rows){ 
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $msj= $db->error;
                    if (strpos($msj, "Duplicate entry")!==false){
                        $respuesta= array(
                            'respuesta' => 'usuario duplicado',
                    );
                    }else{
                        $respuesta= array(
                            'respuesta' => 'error',
                        );
                    }
                };
    
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['cargar-comprobante'])) {
        $id_participante = $_POST['participante'];
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

        $directorio = "../comprobantes/";
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
        $id_evento= $_POST['id'];
        try {
            $stmt= $db->prepare("DELETE FROM participante WHERE id_participante=?");
            $stmt->bind_param("i", $id_evento);
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
        $respuesta= array(
            'respuesta' => 'exito',
        );
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
                        'respuesta' => "clave incorrecta",
                    );
                }
            }else{
                $respuesta= array(
                    'respuesta'=> 'error',
                );
            };
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }