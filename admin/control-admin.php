<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    $usuario= $_POST['usuario'];
    $nombre= $_POST['nombre'];
    $email= $_POST['email'];
    $permiso= $_SESSION['permiso'];

    if (isset($_POST['crear-admin'])){
        $password= $_POST['password'];
        $tipo= $_POST['tipo-admin'];
        /* $opciones= array(
        'cost'=> 12
        ); */

        $password_hashed= password_hash($password, PASSWORD_BCRYPT);/* , $opciones */

        if ($tipo){                                                                 // agrego ADMIN SISTEMA
            try {
                $stmt_admin= $db->prepare("INSERT INTO administrador (usuario, clave, email, nombre, permiso) VALUES(?,?,?,?,?)");
                $stmt_admin->bind_param("ssssi", $usuario, $password_hashed, $email, $nombre, $tipo);
                $stmt_admin->execute();

                if ($stmt_admin->affected_rows){ 
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                    echo mysqli_insert_id($db) . "</br>";
                }else{
                    $respuesta= array(
                        'respuesta' => 'error',
                    );
                };
                $stmt_admin->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }else {                                                                      // agrego ADMIN EVENTO
            try {
                $stmt_admin= $db->prepare("INSERT INTO administrador (usuario, clave, email, nombre, permiso) VALUES(?,?,?,?,?)");
                $stmt_admin->bind_param("ssssi", $usuario, $password_hashed, $email, $nombre, $tipo);
                $stmt_admin->execute();
                                
                if ($stmt_admin->affected_rows){    
                    $respuesta= array(
                        'respuesta1' => 'exito',
                        'respuesta2' => '',
                    );
                    echo mysqli_insert_id($db) . "</br>";
                    $id_admin= mysqli_insert_id($db);
                    echo "id_admin: " . $id_admin . "</br>";
                    //echo $stmt_admin->insert_id . "</br>";

                    if ($permiso){                  //soy admin-sistema
                        $nombre_evento= $_POST['evento'];

                        $stmt_ev= $db->prepare("INSERT INTO evento (nombre) VALUES(?)");
                        echo "insertando evento";
                        $stmt_ev->bind_param("s", $nombre_evento);
                        $stmt_ev->execute();

                        $id_evento= mysqli_insert_id($db);

                        echo "id_evento: " . $id_evento; 
                    } else{
                        $id_evento= $_SESSION['id_evento'];
                    };
    
                    if ($id_evento){
                        $stmt_ev= $db->prepare("INSERT INTO administrado (id_admin, id_evento) VALUES(?,?)");
                        $stmt_ev->bind_param("ii", $id_admin, $id_evento);
                        $stmt_ev->execute();
                        if ($stmt_ev->affected_rows){
                            $respuesta['respuesta2']= 'exito';
                            //echo $db->insert_id . "</br>";
                        }else {
                            $respuesta['respuesta2']= 'error';
                        };
                    }
                    
                }else{
                    $respuesta= array(
                        'respuesta1' => 'error',
                    );
                };
                $stmt_admin->close();
                $stmt_ev->close();
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        echo json_encode($respuesta);
    }
    

    elseif (isset($_POST['editar-admin'])){
        $id_admin= $_POST['id_admin'];
        /* $opciones= array(
        'cost'=> 12
        ); */

        try {
            $stmt= $db->prepare("UPDATE administrador SET usuario=?, email=?, nombre=? WHERE id_admin=?");
            $stmt->bind_param("ssss", $usuario, $email, $nombre, $id_admin);
            $stmt->execute();
            echo $usuario . "</br>";
            echo $email . "</br>";
            echo $nombre . "</br>";
            echo $stmt->affected_rows ;

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

    elseif (isset($_POST['eliminar'])){
        $id_admin= $_POST['id_admin'];
        try {
            $stmt= $db->prepare("DELETE FROM administrador WHERE id_admin=?");
            $stmt->bind_param("i", $id_admin);
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
?>