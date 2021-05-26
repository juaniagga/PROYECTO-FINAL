<?php
    include_once 'funciones/funciones.php';
    $usuario= $_POST['usuario'];
    
    if (isset($_POST['login-admin'])){
        $password= $_POST['password'];
        /* $opciones= array(
        'cost'=> 12
        ); */

        try {
            $stmt= $db->prepare(" SELECT a.id_admin, a.usuario, a.clave, a.nombre, a.permiso FROM administrador a WHERE usuario=? ");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->bind_result($id_admin, $user, $clave, $nombre, $permiso);
            $stmt->store_result();  //para poder usar num_rows
            $stmt->fetch();

            if ($stmt->num_rows){
                if (password_verify($password, $clave)){    //compara la password ingresada con la encriptada en la bdd
                    session_start();
                    $_SESSION['usuario']= $user;
                    $_SESSION['id_admin']= $id_admin;
                    $_SESSION['nombre']= $nombre;
                    $_SESSION['permiso']= $permiso;

                    if (!$permiso){
                        $query= "
                        SELECT a.id_evento
                        FROM administrado a
                        WHERE a.id_admin=" . "'" . $id_admin . "'";
                        $tupla= $db->query($query);
                        $id_evento= $tupla->fetch_assoc();

                        $_SESSION['id_evento']= $id_evento['id_evento'];
                    }
                    if(isset($_POST["remember"])) {
                        setcookie ("member_login", $user, time()+ (10 * 365 * 24 * 60 * 60));
                    } else {
                        if(isset($_COOKIE["member_login"])) {
                            setcookie ("member_login","");
                        }
                    }
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => 'Contraseña incorrecta',
                    );
                };
            }else{
                $respuesta= array(
                    'respuesta'=> 'El usuario ingresado no está registrado.',
                );
            };
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        echo json_encode($respuesta);
    }

    elseif (isset($_POST['forgotpass'])){
        $usuario= $_POST['usuario'];

        $newpass= random_str(15,'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

        $clave= password_hash($newpass, PASSWORD_BCRYPT);

        $admin= $db->query("SELECT a.id_admin, a.email FROM administrador a WHERE a.usuario='" . $usuario . "'");
        $admin= $admin->fetch_assoc();
        if ($admin){
            try {
                $stmt_2= $db->prepare("UPDATE administrador SET clave=? WHERE id_admin=?");
                $stmt_2->bind_param("si", $clave, $admin['id_admin']);
                $stmt_2->execute();
                if ($stmt_2->affected_rows){ 
                    $to = $admin['email'];
                    $subject = "Nueva contraseña";
                    $txt = "Su nueva contraseña es: <br/>" . $newpass;
                    /* $headers = "From: webmaster@example.com" . "\r\n" . "CC: somebodyelse@example.com"; */

                    mail($to,$subject,$txt/* ,$headers */);

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
                'respuesta' => 'El usuario ingresado no está registrado. Ingrese un usuario válido.',
            );
        }
        $db->close();
        echo json_encode($respuesta);
    }  

    function random_str($length, $keyspace) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
?>