<?php
    function usuario_autentificado(){
        if (!revisar_usuario()){
            header('Location: login-admin.php');
            exit();
        };
    };

    function revisar_usuario(){
        return isset($_SESSION['usuario']);
    };

    session_start();
    usuario_autentificado();

?>