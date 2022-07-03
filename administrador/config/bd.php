<?php

    $host ='localhost';
    $dbname='phpdb';
    $username='root';
    $password='';

    try{
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    }catch(PDOException $exp){
        echo("no se logro conectar correctamente con la base de datos:$dbname, error:$exp");
    }
    
?>