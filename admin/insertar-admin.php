<?php
    echo "ENTRO";

    if (isset($_POST['crear-admin'])){
        $usuario= $_POST['usuario'];
        $nombre= $_POST['nombre'];
        $password= $_POST['password'];
    /* $opciones= array(
        'cost'=> 12
        ); */

        $password_hashed= password_hash($password, PASSWORD_BCRYPT/* , $opciones */);

        try {
            include_once 'funciones/funciones.php';
            $stmt= $db->prepare("INSERT INTO administrador (usuario, contraseña, nombre) VALUES(?,?,?)");
            $stmt->bind_param("sss", $usuario, $password_hashed, $nombre);
            $stmt->execute();
            if ($stmt->affected_rows){
                $respuesta= array(
                    'respuesta'=> 'exito',
                );
            }else{
                $respuesta= array(
                    'respuesta'=> 'error',
                );
            }
            $stmt->close();
            $db->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        die(json_encode($respuesta));
    }
?>