<?php
    function usuario_autentificado(){
        if (!revisar_usuario()){
            header('Location: login-user.php');
            exit();
        };
    };

    function revisar_usuario(){
        return isset($_SESSION['id_user']);
    };

    session_start();
    usuario_autentificado();

?>