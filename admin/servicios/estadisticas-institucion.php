<?php

    include_once '../../includes/funciones/conexionBDD.php';
    include_once '../funciones/sesion-admin.php';
    

    $permiso = $_SESSION['permiso'];
    if ($permiso){
      $id_evento= $_GET['id'];
    }else{
      $id_evento= $_SESSION['id_evento'];
    }



    $sql2 = "
    SELECT COUNT(*) as res
    FROM categoria_participante c INNER JOIN participante p ON c.id_categoria=p.id_categoria
    WHERE p.id_evento=" . $id_evento . "
    AND p.acreditado=1 AND c.autoreg=1";
    $tupla2 = $db->query($sql2);
    if ($tupla2){
        $total= $tupla2->fetch_assoc();
        $total= $total['res'];
    }
    else{
        $total= 0;
    }
    $data = array();
    if ($total!=0){
        $sql = "
        SELECT COUNT(*) as total, u.institucion
        FROM usuario u INNER JOIN participante p on p.id_user=u.id_user INNER JOIN categoria_participante c ON c.id_categoria=p.id_categoria
        WHERE p.id_evento=" . $id_evento . " and p.acreditado=1 AND c.autoreg=1
        GROUP BY u.institucion
        ORDER BY total desc";
        $tupla = $db->query($sql);
        while ($institucion= $tupla->fetch_assoc()){
            $valor= ($institucion['total'] * 100) / $total;
            $valor= round($valor,2);
            $data[]= array( 'label'=> $institucion['institucion'], 'value'=> $valor);
        }
    }else{
        $data[]= array( 'label'=> "", 'value'=> "");
    }

        echo json_encode($data);

?>