<?php

    $host = "localhost";
    $port = "5432";
    $dbname = "secret-diary";
    $username = "postgres";
    $password = "";
    
    $link_string = "host={$host} port={$port} dbname={$dbname} user={$username} password={$password}";
    $link = pg_connect($link_string);
    if(!$link){
       die("Error:Unable to open database");
    }
?>
