<?php
    include_once 'funciones/funciones.php';
    
    if (isset($_POST['medios'])){
        $respuesta= 'hola';
        echo json_encode($respuesta);
    }
?>