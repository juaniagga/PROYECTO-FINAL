<?php
    include_once '../includes/funciones/conexionBDD.php';
    
    if (isset($_POST['login-user'])){
        $email= $_POST['email'];
        $password= $_POST['password'];

        try {
            $stmt= $db->prepare(" SELECT u.id_user, u.nombre, u.apellido, u.clave FROM usuario u WHERE u.email=? ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id_user, $nombre, $apellido, $clave);
            $stmt->store_result();  //para poder usar num_rows
            $stmt->fetch();

            if ($stmt->num_rows){
                if (password_verify($password, $clave)){    //compara la password ingresada con la encriptada en la bdd
                    session_start();
                    $_SESSION['nombre']= $nombre . " " . $apellido;
                    $_SESSION['id_user']= $id_user;
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                    
                }else{
                    $respuesta= array(
                        'respuesta' => 'Contraseña incorrecta.',
                    );
                };
            }else{
                $respuesta= array(
                    'respuesta'=> 'El email ingresado no está registrado.',
                );
            };
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['crear-user'])){
        $password= $_POST['password'];
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


        $clave= password_hash($password, PASSWORD_BCRYPT);/* , $opciones */
        $respuesta=array();


        try {
            $stmt= $db->prepare("INSERT INTO usuario (email, clave, dni, nombre, apellido, telefono, calle, numero, ciudad, provincia, pais, trabajo_cientifico, institucion, cargo) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssissisisssiss", $email, $clave, $dni, $nombre, $apellido, $telefono, $calle, $numero, $ciudad, $provincia, $pais, $trabajo_cientifico, $institucion, $cargo);
            $stmt->execute();
            if (mysqli_insert_id($db) > 0){ 
                $respuesta= array(
                    'respuesta' => 'exito',
                );
            }else{
                $msj= $db->error;
                if (strpos($msj, "Duplicate entry")!==false){
                    $respuesta= array(
                        'respuesta' => 'El email ingresado ya se encuentra registrado.',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => $db->error,
                    );
                }
                
            };           
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        echo json_encode($respuesta);
    }

?>