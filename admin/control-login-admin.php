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
                        echo "no permiso";
                        $query= "
                        SELECT a.id_evento
                        FROM administrado a
                        WHERE a.id_admin=" . "'" . $id_admin . "'";
                        $tupla= $db->query($query);
                        $id_evento= $tupla->fetch_assoc();

                        $_SESSION['id_evento']= $id_evento['id_evento'];
                    }

                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $respuesta= array(
                        'respuesta' => 'clave incorrecta',
                    );
                };
            }else{
                $respuesta= array(
                    'respuesta'=> 'no existe',
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