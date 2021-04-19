<?php
try {
    include_once '../../includes/funciones/conexionBDD.php';
  } catch (Exception $e) {
    echo "Error: " . $e->getMessage();
  }
    
    include_once '../funciones/sesion-admin.php';
    

    $permiso = $_SESSION['permiso'];
    if ($permiso){
      $id_evento= $_GET['id'];
    }else{
      $id_evento= $_SESSION['id_evento'];
    }

    $sql = "
    SELECT COUNT(*) as res
            FROM participante p INNER JOIN usuario u on p.id_user=u.id_user
            WHERE p.id_evento=" . $id_evento . "
            AND p.acreditado=1 AND u.ciudad='Mar del Plata'";
    $tupla = $db->query($sql);
    if ($tupla){
        $interno= $tupla->fetch_assoc();
        $interno= $interno['res'];
    }
    else{
        $interno= 0;
    }

    $sql2 = "
    SELECT COUNT(*) as res
    FROM participante p
    WHERE p.id_evento=" . $id_evento . "
    AND p.acreditado=1";
    $tupla2 = $db->query($sql2);

    
    if ($tupla2){
        $total= $tupla2->fetch_assoc();
        $total= $total['res'];
    }
    else{
        $total= 0;
    }

    if ($total!=0){
        $valor1= ($interno * 100) / $total;
    }else{
        $valor1=0;
    }

  $valor2= 100-$valor1;
  

    $data = array(
        array( 'nombre'=> 'MDP', 'valor'=> $valor1),
        array( 'nombre'=> 'Exterior', 'valor'=> $valor2),
    );
    echo json_encode($data);

?>