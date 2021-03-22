<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';

    if (isset($_POST['descargar'])){
$id_participante = $_POST['id'];
$file = '../comprobantes/licuadora.pdf';


    $filename = basename($file);
    $filepath = $file;
        echo $filename;
    header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Lenght: '.filesize($filepath));
            header('Content-Transfer-Encoding: binary');
            readfile($filepath);
            exit;
    $respuesta = array(
        'respuesta' => 'exito',);
echo json_encode($respuesta);
    }

?>