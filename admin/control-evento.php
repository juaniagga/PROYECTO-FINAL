<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    date_default_timezone_set("America/Argentina/Buenos_Aires");

    if (isset($_POST['crear-actividad'])){
        $nombre= $_POST['nombre'];
        $descripcion= $_POST['descripcion'];
        $id_evento= $_SESSION['id_evento'];
        $id_categoria= $_POST['categoria'];
        $f= str_replace('/', '-', $_POST['fecha']);
        $fecha= date_format(date_create($f), 'Y-m-d');
        $hora_inicio= date_format(date_create($_POST['hora_inicio']), 'H:i');
        $hora_fin= date_format(date_create($_POST['hora_fin']), 'H:i');

        try {
            $stmt_act= $db->prepare("INSERT INTO actividad (nombre_act, fecha, hora_inicio, hora_fin, descripcion, id_categoria, id_evento) VALUES(?,?,?,?,?,?,?)");
            $stmt_act->bind_param("sssssii", $nombre, $fecha, $hora_inicio, $hora_fin, $descripcion, $id_categoria, $id_evento);
            $stmt_act->execute();

            if (mysqli_insert_id($db) > 0){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta' => $db->error,
                );
            };

            $stmt_act->close();
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
        $f= str_replace('/', '-', $_POST['fecha']);
        $fecha= date_format(date_create($f), 'Y-m-d');
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
                    'respuesta' => $db->error,
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
        $limite= $_POST['limite'];
        $f_inicio= str_replace('/', '-', $_POST['fecha_inicio']);
        $f_fin = str_replace('/', '-', $_POST['fecha_fin']);
        $fecha_inicio= date_format(date_create($f_inicio), 'Y-m-d');
        $fecha_fin= date_format(date_create($f_fin), 'Y-m-d');
        
        $estado= $_POST['estado'];

        $directorio1= "../pago/evento_" . $id_evento . "/";

        if (!is_dir($directorio1)){
            mkdir($directorio1,0755, true);
        }
        if (isset($_FILES['pdf']) && $_FILES['pdf']['name']!=""){
            // file name
            $filename1 = $_FILES['pdf']['name'];

            // file extension
            $file_extension1 = pathinfo($filename1, PATHINFO_EXTENSION);
            $file_extension1 = strtolower($file_extension1);

            // Valid extensions
            $file_ext1 = array("pdf");

            if (in_array($file_extension1, $file_ext1)){
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $directorio1 . "info_pago_" . $id_evento . ".pdf")){
                    $pdf= "info_pago_" . $id_evento . ".pdf";
                }else{
                    $respuesta= array(
                        'respuesta' => error_get_last(),
                    );
                    $pdf= "";
                }
            }else{
                $respuesta= array(
                    'respuesta' => "El formato del documento con información del pago es incorrecto. El formato debe ser .PDF",
                );
                echo exit(json_encode($respuesta));
            }
        } else{
            $resp= $db->query("SELECT e.info_pago FROM evento e WHERE e.id_evento=". $id_evento);
            $resp= $resp->fetch_assoc();
            if ($resp['info_pago']!=""){
                $pdf= $resp['info_pago'];
            }else
                $pdf="";
        }
        
        
        if (isset($_FILES['imagen']) && $_FILES['imagen']['name']!=""){
            // file name
            $filename = $_FILES['imagen']['name'];

            // Location
            $directorio2= "../img/evento_" . $id_evento . "/";

            if (!is_dir($directorio2)){
                mkdir($directorio2,0755, true);
            }
            // file extension
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
          // Valid extensions
            $file_ext = array("jpg", "png", "jpeg");
            $img= "";
            if (in_array($file_extension, $file_ext)) {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio2 . "imagen_evento_" . $id_evento . "." . $file_extension)){
                    $img= "imagen_evento_" . $id_evento . "." . $file_extension;
                }
            }else{
                $respuesta= array(
                    'respuesta' => "El formato de la imagen es incorrecto. Formatos permitidos: .JPG, .PNG, .JPEG",
                );
                echo exit(json_encode($respuesta));
            }
        }else{
            $res= $db->query("SELECT e.imagen FROM evento e WHERE e.id_evento=". $id_evento);
            $res= $res->fetch_assoc();
            if ($res['imagen']!=""){
                $img= $res['imagen'];
            }else
                $img="";
        }
        try {
            $stmt= $db->prepare("UPDATE evento SET nombre=?, fecha_inicio=?, fecha_fin=?, estado=?, organizador=?, limite=?, ubicacion=?, descripcion=?, imagen=?,info_pago=? 
            WHERE id_evento=?");
            $stmt->bind_param("sssisissssi", $nombre, $fecha_inicio, $fecha_fin, $estado, $organizador, $limite, $ubicacion, $descripcion, $img, $pdf, $id_evento);
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

    elseif (isset($_POST['eliminar'])){
        $id_evento=$_SESSION['id_evento'];
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
                        'respuesta' => $db->error,
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
                        'respuesta' => $db->error,
                    );
                };
                $stmt->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        elseif ($_POST['tipo']=='evento'){
            try {
                $stmt= $db->prepare("DELETE FROM evento WHERE id_evento=?");
                $stmt->bind_param("i", $id);
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
        }
        elseif ($_POST['tipo']=='participante'){
            try {
                $filename="";
                $file = "../comprobantes/evento_" . $id_evento . "/pago_". $id;
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
                $acreditado= $db->query("SELECT p.acreditado FROM participante p WHERE p.id_participante=" . $id);
                $acreditado= $acreditado->fetch_assoc();
                $aux= $db->query("SELECT p.id_categoria FROM participante p WHERE p.id_participante=" . $id);
                $aux= $aux->fetch_assoc();
                $cat= $db->query("SELECT c.autoreg FROM categoria_participante c WHERE c.id_categoria=" . $aux['id_categoria']);
                $cat= $cat->fetch_assoc();
                $stmt= $db->prepare("DELETE FROM participante WHERE id_participante=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                if ($stmt->affected_rows){
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                    if ($acreditado['acreditado'])
                        $db->query("UPDATE evento SET acreditados=acreditados-1 WHERE id_evento=" . $id_evento);
                    
                    if ($cat['autoreg']){
                        $db->query("UPDATE evento SET inscriptos=inscriptos-1 WHERE id_evento=" . $id_evento);
                    }
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
        }
        elseif ($_POST['tipo']=='sin-confirmar'){
            $id_evento= $_SESSION['id_evento'];
            try {
                $total= $db->query("SELECT COUNT(*) as total FROM participante p WHERE p.id_evento=" . $id_evento . " and p.acreditado=1 and pago_confirmado=0");
                $total=$total->fetch_assoc();

                $sql= $db->query("SELECT p.acreditado, p.id_participante FROM participante p WHERE p.id_evento=" . $id_evento . " and p.acreditado=1");
                while ($p= $sql->fetch_assoc()){
                    $filename="";
                    $file = "../comprobantes/evento_" . $id_evento . "/pago_". $p['id_participante'];
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
                }
                $ins= $db->query("SELECT COUNT(*) as total FROM participante p WHERE p.id_evento=" . $id_evento . " and pago_confirmado=0");
                $ins= $ins->fetch_assoc();
                $condicion=0;
                $stmt= $db->prepare("DELETE FROM participante WHERE id_evento=? AND pago_confirmado=?");
                $stmt->bind_param("ii", $id_evento, $condicion);
                $stmt->execute();
                if ($stmt->affected_rows){
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                    if ($total)
                        $db->query("UPDATE evento SET acreditados=acreditados-" . $total['total'] . " WHERE id_evento=" . $id_evento);
                    if ($ins)
                        $db->query("UPDATE evento SET inscriptos=inscriptos-" . $ins['total'] . " WHERE id_evento=" . $id_evento);
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
        }
        
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['medios'])){ //cambiar el estado del medio de pago
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

    elseif (isset($_POST['crear-categoria'])){
        $nombre= $_POST['nombre'];
        $autoreg= $_POST['autoreg'];

        try {
            $stmt= $db->prepare("INSERT INTO categoria_participante (nombre,autoreg) VALUES(?,?)");
            $stmt->bind_param("si", $nombre, $autoreg);
            $stmt->execute();

            if (mysqli_insert_id($db) > 0){ 
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

    elseif (isset($_POST['agregar-categoria'])){
        $id_evento= $_SESSION['id_evento'];
        $id_categoria= $_POST['categoria'];
        $tarifa= $_POST['tarifa'];
        try {
            $stmt= $db->prepare("INSERT INTO cat_asociadas (id_evento, id_categoria, tarifa) VALUES(?,?,?)");
            $stmt->bind_param("iid", $id_evento, $id_categoria, $tarifa);
            $stmt->execute();

            if (mysqli_insert_id($db) > 0){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $msj= $db->error;
                if (strpos($msj, "Duplicate entry")!==false){
                    $respuesta= array(
                        'respuesta' => 'La categoría seleccionada ya se encuentra añadida al evento.');
                }else{
                    $respuesta= array(
                        'respuesta' => $msj,
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

    elseif (isset($_POST['editar-tarifa'])){
        $id= $_POST['id_categoria'];
        $tarifa= $_POST['tarifa'];
        try {
            $stmt= $db->prepare("UPDATE cat_asociadas SET tarifa=? WHERE id_categoria=?");
            $stmt->bind_param("di", $tarifa, $id);
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
        $directorio= "../img/evento_". $id_evento . "/" . "oradores/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }
        if (isset($_FILES['imagen']) && $_FILES['imagen']['name']!=""){
            // file name
            $filename = $_FILES['imagen']['name'];

            // file extension
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
          // Valid extensions
            $file_ext = array("jpg", "png", "jpeg");
            $img= "";
            if (in_array($file_extension, $file_ext)) {
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])){
                    $imagen_url= $_FILES['imagen']['name'];
                }
            }else{
                $respuesta= array(
                    'respuesta' => "El formato de la imagen es incorrecto. Formatos permitidos: .JPG, .PNG, .JPEG",
                );
                echo exit(json_encode($respuesta));
            }
        }else{
            $imagen_url= "icono.png";
        }
        try {
            $stmt_o= $db->prepare("INSERT INTO orador (id_evento, dni, nombre, apellido, biografia, imagen) VALUES(?,?,?,?,?,?)");
            $stmt_o->bind_param("iissss", $id_evento, $dni, $nombre, $apellido, $biografia, $imagen_url);
            $stmt_o->execute();

            if (mysqli_insert_id($db) > 0){ 
                $respuesta= array(
                    'respuesta' => 'exito',
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
                    'respuesta' => $db->error,
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
        $directorio= "../img/evento_". $id_evento . "/" . "oradores/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }

        try {
            if ($_FILES['imagen']['size'] > 0){
                    // file name
                $filename = $_FILES['imagen']['name'];

                // file extension
                $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);
                // Valid extensions
                $file_ext = array("jpg", "png", "jpeg");
                $img= "";
                if (in_array($file_extension, $file_ext)) {
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name'])){
                        $imagen_url= $_FILES['imagen']['name'];
                    }
                }else{
                    $respuesta= array(
                        'respuesta' => "El formato de la imagen es incorrecto. Formatos permitidos: .JPG, .PNG, .JPEG",
                    );
                    echo exit(json_encode($respuesta));
                }
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
                $msj= $db->error;
                if ($msj!=""){
                    $respuesta= array(
                        'respuesta' => $msj,
                    );
                    echo exit(json_encode($respuesta));
                }
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

                if (mysqli_insert_id($db) > 0){ 
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                } else {
                    $respuesta = array(
                        'respuesta' => $db->error,
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

            if (mysqli_insert_id($db) > 0){ 
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

    elseif (isset($_POST['editar-pago'])){
        $id= $_POST['id_medio'];
        $nombre= $_POST['nombre'];
        try {
            $stmt= $db->prepare("UPDATE medios_pago SET nombre=? WHERE id_medio=?");
            $stmt->bind_param("si", $nombre, $id);
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

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['crear-inscripto'])){
        $id_evento= $_SESSION['id_evento'];
        $nombre= $_POST['nombre'];
        $apellido= $_POST['apellido'];
        $email= $_POST['email'];
        $telefono= $_POST['telefono'];
        $dni= $_POST['dni'];
        $clave= password_hash($dni, PASSWORD_BCRYPT);
        $pais= $_POST['pais'];
        $provincia= $_POST['provincia'];
        $ciudad= $_POST['ciudad'];
        $calle= $_POST['calle'];
        $numero= $_POST['numero'];

        $institucion = $_POST['institucion'];
        $cargo = $_POST['cargo'];
        $trabajo_cientifico = $_POST['trabajo'];
        
        $directorio= "../comprobantes/evento_" . $id_evento . "/";
        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }

        //valido que el comprobante tenga el formato correcto
        if (isset($_FILES['file']) && $_FILES['file']['name']!=""){
            // file name
            $filename = $_FILES['file']['name'];
            
            // Location
            $location = $directorio . $filename;

            // file extension
            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            // Valid extensions
            $file_ext = array("jpg", "png", "jpeg", "pdf");

            if (!in_array($file_extension, $file_ext)) {
                $respuesta = array(
                    'respuesta' => "El formato del comprobante es incorrecto. Formatos permitidos: .PDF, .JPG, .PNG., .JPEG",
                );
                exit(json_encode($respuesta));
            }
        }
    
        try {
            $stmt= $db->prepare("INSERT INTO usuario (email, clave, dni, nombre, apellido, telefono, calle, numero, ciudad, provincia, pais, trabajo_cientifico, institucion, cargo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssissisisssiss", $email, $clave, $dni, $nombre, $apellido, $telefono, $calle, $numero, $ciudad, $provincia, $pais, $trabajo_cientifico, $institucion, $cargo);
            $stmt->execute();
            if (mysqli_insert_id($db) > 0){ 
                $id_user= mysqli_insert_id($db);
            }else{  //si el usuario ya esta registrado
                $tupla = $db->query("SELECT u.id_user FROM usuario u WHERE u.email='" . $email . "'");
                if ($tupla){
                    $u=$tupla->fetch_assoc();
                    $id_user= $u['id_user'];
                }else{
                    throw new Exception($db->error);
                }
            };   
        } catch (Exception $e) {
            $respuesta= array(
                'respuesta' => $e->getMessage(),
            );
            exit(json_encode($respuesta));
        }

        $id_categoria= $_POST['categoria']; 
        $fecha_registro= date('Y-m-d',time());
        $forma_pago= $_POST['medio'];
        $importe_abonado= $_POST['importe'];
        $f= str_replace('/', '-', $_POST['fecha_pago']);
        $fecha_pago= date_format(date_create($f), 'Y-m-d');
        $comentario= $_POST['comentario'];
        $exento= $_POST['exento'];
        $alojamiento= $_POST['hotel'];
        $fecha_arribo= $_POST['arribo'];
        $fecha_partida= $_POST['partida'];
        $traslado= $_POST['traslado'];
        $acreditado=0;
        $pago_confirmado=0;

        $iva= $_POST['iva'];
        $cuit= $_POST['cuit'];
        $nombre_factura= $_POST['nombre_factura'];
        $adicionales= $_POST['conceptos'];

        try {
            $sql = "
                SELECT c.tarifa
                FROM cat_asociadas c
                WHERE c.id_evento=" . $id_evento . " and c.id_categoria=" . $id_categoria;
            $tuplas = $db->query($sql);
          } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
          }
        $cat = $tuplas->fetch_assoc();

        if ($cat['tarifa']==0 || $exento==1){    // si no abona o si la categoria no es autoregistrable
            $pago_confirmado=1;
        }

        if (str_replace(' ', '', $iva)!=""){
            $facturacion= 1;
        } else{
            $facturacion=0;
        }

        
    
        try {
            $stmtp= $db->prepare("INSERT INTO participante (id_user, id_evento, id_categoria, fecha_registro, acreditado,forma_pago, importe_abonado, fecha_pago, comentario_pago, pago_confirmado,exento, facturacion,  iva, cuit, adicionales, nombre_factura, alojamiento,fecha_arribo, fecha_partida, traslado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmtp->bind_param("iiisisdssiiisissssss", $id_user, $id_evento, $id_categoria, $fecha_registro, $acreditado, $forma_pago, $importe_abonado, $fecha_pago, $comentario, $pago_confirmado, $exento, $facturacion, $iva, $cuit, $adicionales, $nombre_factura, $alojamiento, $fecha_arribo, $fecha_partida, $traslado);
            $stmtp->execute();
            $id_participante= mysqli_insert_id($db);
            if (mysqli_insert_id($db) > 0){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                $cat_reg= $db->query("SELECT c.autoreg FROM categoria_participante c WHERE c.id_categoria=" . $id_categoria);
                $cat_reg= $cat_reg->fetch_assoc();
                if ($cat_reg['autoreg']){
                    $db->query("UPDATE evento SET inscriptos=inscriptos+1 WHERE id_evento=" . $id_evento);
                }
            }else{
                $msj= $db->error;
                if (strpos($msj, "Duplicate entry")!==false){
                    $respuesta= array(
                        'respuesta' => 'El usuario ingresado ya se encuentra registrado en el evento.');
                }else{
                    $respuesta= array(
                        'respuesta' => $msj,
                    );
                }
                exit(json_encode($respuesta));
            };

            if (isset($_FILES['file']) && $_FILES['file']['name']!=""){
                $directorio= "../comprobantes/evento_" . $id_evento . "/";
                $new_name = "pago_" . $id_participante;
                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $directorio . $new_name . "." . $file_extension)) {
                    $file = $new_name;
                } else {
                    $respuesta = array(
                        'respuesta' => error_get_last(),
                    );
                }
                try {
                    $stmtf = $db->prepare("UPDATE participante p SET comprobante=? WHERE p.id_participante=?");
                    $stmtf->bind_param("si", $file, $id_participante);
                    $stmtf->execute();
        
                    if ($stmtf->affected_rows) {
                        $respuesta = array(
                            'respuesta' => 'exito',
                        );
                    } else {
                        $msj = $db->error;
                        $respuesta = array(
                            'respuesta' => $msj,
                        );
                    };
        
                    $stmtf->close();
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            $stmtp->close();
            $stmt->close();
            $db->close();
            echo json_encode($respuesta);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
    }

    elseif (isset($_POST['acreditar'])){
        $id_participante= $_POST['id'];
        $id_evento= $_SESSION['id_evento'];
        $tipo= $_POST['tipo'];
        if ($tipo=="add")
            $valor= 1;
        else
            $valor=0;
        try {
            $id_categoria= $db->query("SELECT id_categoria FROM participante WHERE id_participante=". $id_participante);
            $id_categoria= $id_categoria->fetch_assoc();
            $cat_reg= $db->query("SELECT c.autoreg FROM categoria_participante c WHERE c.id_categoria=" . $id_categoria['id_categoria']);
            $cat_reg= $cat_reg->fetch_assoc();
            
            $stmt= $db->prepare("UPDATE participante SET acreditado=? WHERE id_participante=?");
            $stmt->bind_param("ii", $valor, $id_participante);
            $stmt->execute();
            if ($stmt->affected_rows){  //siempre devuelve 0..
                $respuesta= array(
                    'respuesta' => 'exito',
                );
                if ($valor==1 && $cat_reg['autoreg']==1)
                    $db->query("UPDATE evento SET acreditados=acreditados+1 WHERE id_evento=" . $id_evento);
                else
                    if ($cat_reg['autoreg']==1)
                        $db->query("UPDATE evento SET acreditados=acreditados-1 WHERE id_evento=" . $id_evento);
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
    
    elseif (isset($_POST['descargar'])) {
        //nombre de archivos: "pago_id"
        $id = $_POST['id'];
        $id_evento= $_SESSION['id_evento'];
        $directorio= "../comprobantes/evento_" . $id_evento . "/";
        $name = "pago_". $id;
        $filename="";
        if (file_exists($directorio . $name . ".pdf")){
            $filename = $name . ".pdf";
        } elseif(file_exists($directorio . $name . ".jpg")){
            $filename = $name . ".jpg";
        } elseif(file_exists($directorio . $name . ".png")){
            $filename = $name . ".png";
        } elseif(file_exists($directorio . $name . ".jpeg")){
            $filename = $name . ".jpeg";
        }
        
        if ($filename!=""){
            $filepath = $directorio . $filename;
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($filepath);
            exit;
        }
        else{
            header("HTTP/1.1 403 Forbidden");
        }
    }
    elseif (isset($_POST['verpago'])) {
        //nombre de archivos: "pago_id"
        $id = $_POST['id'];
        $id_evento= $_SESSION['id_evento'];
        $directorio= "../comprobantes/evento_" . $id_evento . "/";
        $name = "pago_". $id;
        $filename="";
        if (file_exists($directorio . $name . ".pdf")){
            $filename = $name . ".pdf";
        } elseif(file_exists($directorio . $name . ".jpg")){
            $filename = $name . ".jpg";
        } elseif(file_exists($directorio . $name . ".png")){
            $filename = $name . ".png";
        } elseif(file_exists($directorio . $name . ".jpeg")){
            $filename = $name . ".jpeg";
        }
        
        if ($filename!=""){
            $filepath = $directorio . $filename;
            echo json_encode($filepath);
        }
        else{
            echo json_encode('error');
        }
    }

    elseif (isset($_POST['guia'])) {

        $filename = "guia_usuario.pdf";
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

    elseif (isset($_POST['cargar-certificados'])){
        $id_evento= $_SESSION['id_evento'];
        $directorio= "../certificados/evento_" . $id_evento . "/";

        if (!is_dir($directorio)){
            mkdir($directorio,0755, true);
        }
        $countfiles = count($_FILES['file']['name']);
        // Looping all files
        for($i=0; $i < $countfiles; $i++){
          $filename = $_FILES['file']['name'][$i];

            // file extension
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            // Valid extensions
            $file_ext = array("pdf");

            if (in_array($file_extension, $file_ext)){
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $directorio . $filename)){
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => $db->error,
                    );
                    exit(json_encode($respuesta));
                }
            }else{
                $respuesta= array(
                    'respuesta' => "El formato de uno o más documentos es incorreto. El formato debe ser .PDF",
                );
                exit(json_encode($respuesta));
            }
        }
        echo json_encode($respuesta);
    }

    elseif (isset($_POST['modelo'])) {
        $filename = "modelo_certificado.xlsm";
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