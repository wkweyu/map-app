<?php
session_start();
include('connection.php');
include('functions.php');
$error = "";
$prdCode = "";
$name = "";
$group = "";
$category = "";
$sprice = "";
    if (array_key_exists('save', $_POST)) { 
        
        $prdCode = $_POST['prd_code'];
        $name = strtoupper($_POST['prd_name']);
        $group = $_POST['group'];
        $category = $_POST['category'];
        $sprice = $_POST['selling-price'];
        
        if (!$prdCode) {
            $error .= "A Product code is needed<br>";
        }
        if (!$name) {
            $error .= "A Product name is required<br>";
        }
        if (!$group) {
            $error .= "A Group is required<br>";
        }
        if (!$category) {
            $error .= "A Category is required<br>";
        }
        if (!$sprice) {
            $error .= "A Selling price is required<br>";
        }
        if ($error !="") {
            $error = "<p>There were some error(s) in your form</p>".$error;
        }else{
            $query =pg_query($link, "SELECT * FROM public.items WHERE item_desc ='".pg_escape_string($link,$name)."'LIMIT 1");
            $row =pg_num_rows($query);
            if ($row > 0) {
                $_SESSION['message']="Product already exists.Try again";
                $_SESSION['msg_type']="warning";
            }else{
                $query="INSERT INTO public.items(item_code,item_desc,item_group,item_category,item_sprice)VALUES ('$prdCode', '$name', '$group', '$category', '$sprice')";
                $results = pg_query($link,$query);
                if(!$results) {
                    
                    $error = "<p>Could not add product try again.</p>";
                    }else{
                        $error = "Product added successfully.";
                        }
            }
            
            
            
            }
    }
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $query = pg_query($link, "SELECT * FROM public.items WHERE item_id = '".pg_escape_string($link, $id)."'LIMIT 1");
        $arr_check = pg_num_rows($query);
        if ($arr_check >0) {
            $row = pg_fetch_array($query);
            $prdCode = $row['item_code'];
            $name = $row['item_desc'];
            $group = $row['item_group'];
            echo $group;
            $category = $row['item_category'];
            echo $category;
            $sprice = $row['item_sprice'];
            
            
        }
    }
            
        
    
?>
