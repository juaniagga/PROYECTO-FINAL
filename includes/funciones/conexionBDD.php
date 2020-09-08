<?php 
    $db = new mysqli('localhost','root','','proyecto_final');

    if ($db->connect_error){
        echo $error->$db->connect_error;
    }

    $db->set_charset('utf8');
?>

<!-- En el shell del XAMPP mete ese comando y sustituye secret por tu contraseña el usuario como comenta el maestro es root

mysqladmin.exe -u root password secret -->