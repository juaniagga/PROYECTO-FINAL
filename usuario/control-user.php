<?php
    include_once '../includes/funciones/sesion-user.php';
    include_once '../includes/funciones/conexionBDD.php';
    

    if (isset($_POST['nuevo-registro'])){
            $id_user= $_SESSION['id_user'];
            $id_categoria= $_POST['id_categoria']; 
            $id_evento= $_POST['id_evento']; 
            $fecha_registro= date('Y-m-d',time());   
            
            $alojamiento= $_POST['hotel'];
            $fecha_arribo= $_POST['arribo'];
            $fecha_partida= $_POST['partida'];
            $traslado= $_POST['traslado'];

            try {
                $stmt= $db->prepare("INSERT INTO participante (id_user, id_evento, id_categoria, fecha_registro, alojamiento,fecha_arribo, fecha_partida, traslado) VALUES(?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iiisssss", $id_user, $id_evento, $id_categoria, $fecha_registro, $alojamiento, $fecha_arribo, $fecha_partida, $traslado);
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

    if (isset($_POST['cargar-comprobante'])) {
        $id_participante = $_POST['participante'];
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
                $stmt = $db->prepare("UPDATE participante p SET comprobante=? WHERE p.id_participante=?");
                $stmt->bind_param("si", $file, $id_participante);
                $stmt->execute();
    
                if ($stmt->affected_rows) {
                    $respuesta = array(
                        'respuesta' => 'exito',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => "error",
                    );
                };
    
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }else{
            $respuesta = array(
                'respuesta' => "Extensión de archivo no permitida",
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
