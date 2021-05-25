<?php
    include_once 'funciones/sesion-admin.php';
    include_once 'funciones/funciones.php';

    
    if (isset($_POST['infoPago'])) {
        $id_evento= $_POST['id_evento'];
        $filename = "info_pago_" . $id_evento . ".pdf";
        $filepath = '../archivos/'. $filename;

        // header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        /* header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Lenght: '.filesize($filepath));
                header('Content-Transfer-Encoding: binary'); */
        readfile($filepath);
        exit;
    }

?>