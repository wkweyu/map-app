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

    $product_code = $_POST['prdcode'];
    $stmt = $link->prepare( "SELECT item_id,item_code,item_description,price FROM public.items WHERE product_code = ?");
    $stmt->bind_Param("s",$product_code);
    $stmt->bind_result($id,$prdcode,$prdname,$price);

    if($stmt->execute()){
        while($stmt->fetch()){
            $output[] = array("item_id"=>$id,"item_code"=>$prdcode,"item_description"=>prdname,"price"=>$price);
        }
        echo json_encode($output);
    }


?>
