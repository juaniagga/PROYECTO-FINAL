<?php

    if (!isset($_SESSION['usuario']) && !$evento['estado']){
        header("Location: usuario/not-found.php");
        exit();
    }

?>