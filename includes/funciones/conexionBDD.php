<?php 
    $db = new mysqli('localhost','root','secret','proyecto_final');

    if ($db->connect_error){
        echo $error->$db->connect_error;
    }

    $db->set_charset('utf8');
?>