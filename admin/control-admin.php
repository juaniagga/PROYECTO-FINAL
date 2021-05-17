<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';
    
    $permiso= $_SESSION['permiso'];

    if (isset($_POST['crear-admin'])){
        $password= $_POST['password'];
        $usuario= $_POST['usuario'];
        $nombre= $_POST['nombre'];
        $email= $_POST['email'];
        $tipo= $_POST['tipo-admin'];
        /* $opciones= array(
        'cost'=> 12
        ); */

        $password_hashed= password_hash($password, PASSWORD_BCRYPT);/* , $opciones */
        $respuesta=array();
        if ($tipo){                                                                 // agrego ADMIN SISTEMA
            try {
                $stmt_admin= $db->prepare("INSERT INTO administrador (usuario, clave, email, nombre, permiso) VALUES(?,?,?,?,?)");
                $stmt_admin->bind_param("ssssi", $usuario, $password_hashed, $email, $nombre, $tipo);
                $stmt_admin->execute();

                if (mysqli_insert_id($db) > 0){ 
                    $respuesta= array(
                        'respuesta' => 'exito',
                    );
                }else{
                    $msj= $db->error;
                        if (strpos($msj, "Duplicate entry")!==false){
                            $respuesta= array(
                                'respuesta' => 'El nombre de usuario ingresado ya se encuentra registrado. Intente con otro.');
                        }else{
                            $respuesta= array(
                                'respuesta' => $msj,
                            );
                        }
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
                $id_admin= mysqli_insert_id($db);

                if ($id_admin > 0){  
                    echo "es mayor";  
                    $respuesta= array(
                        'respuesta' => 'exito',
                        'id' => $id_admin
                    );

                    if ($permiso){                  //soy admin-sistema
                        $nombre_evento= $_POST['evento'];

                        $stmt_ev= $db->prepare("INSERT INTO evento (nombre) VALUES(?)");
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
                    }
                    $stmt_ev->close();
                }else{
                    $msj= $db->error;
                        if (strpos($msj, "Duplicate entry")!==false){
                            $respuesta= array(
                                'respuesta' => 'El nombre de usuario ingresado ya se encuentra registrado. Intente con otro.');
                        }else{
                            $respuesta= array(
                                'respuesta' => $msj,
                            );
                        }
                };
                $stmt_admin->close();
                
                $db->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        echo json_encode($respuesta);
    }
    

    elseif (isset($_POST['editar-admin'])){
        $id_admin= $_SESSION['id_admin'];
        $usuario= $_POST['usuario'];
        $nombre= $_POST['nombre'];
        $email= $_POST['email'];
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

    elseif (isset($_POST['nueva-clave'])){
        $id_admin= $_SESSION['id_admin'];
        $clave_actual= $_POST['password'];
        $clave_nueva= $_POST['new_password'];
        $respuesta=array();

        try {
            $stmt= $db->prepare(" SELECT a.clave FROM administrador a WHERE a.id_admin=? ");
            $stmt->bind_param("i", $id_admin);
            $stmt->execute();
            $stmt->bind_result($clave);
            $stmt->store_result();  //para poder usar num_rows
            $stmt->fetch();

            if ($stmt->num_rows){
                if (password_verify($clave_actual, $clave)){    //compara la password ingresada con la encriptada en la bdd
        
                    $new_pass= password_hash($clave_nueva, PASSWORD_BCRYPT);
                    try {
                        $stmt_2= $db->prepare("UPDATE administrador SET clave=? WHERE id_admin=?");
                        $stmt_2->bind_param("si", $new_pass, $id_admin);
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

    elseif (isset($_POST['eliminar'])){
        $id_admin= $_POST['id'];
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