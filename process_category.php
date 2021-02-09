<?php
    session_start();
    include('connection.php');
    include('functions.php');

/*********************************************CATEGORY-CODE-START*******************************************************/
  
    $name = "";
    $code = "";
    $update = false;
    $id = 0;
   

    if (array_key_exists('save',$_POST)){
        if (!$_POST['category_name']){
            $_SESSION['message']="category name required!";
            $_SESSION['msg_type']="warning";
            header("location:item_category.php");
        }else{
            $categoryName = $_POST['category_name'];
            $query ="SELECT * FROM public.category WHERE category_name = '".pg_escape_string($link,$categoryName)."'LIMIT 1";
            $data = pg_query($query);                                                                        
            $arr_check = pg_num_rows($data);
            if ($arr_check > 0){
                $_SESSION['message']="category name has been used,try again!";
                $_SESSION['msg_type']="warning";
                header("location:item_category.php");
            }
        else{
            $gencategoryCode = productCode($categoryName);
            $result = pg_query($link,"INSERT INTO public.category(category_code,category_name)VALUES('$gencategoryCode','$categoryName')");
            $_SESSION['message']="Record has been saved successfully!";
            $_SESSION['msg_type']="success";
            header("location:item_category.php");
            }
        }
    }
    if (isset($_GET['delete'])){
        $id = $_GET['delete'];
        $deleteRecord = pg_query($link,"DELETE FROM public.category WHERE category_id = '$id'");
        if(!$deleteRecord){
            echo "An error occured.\n";
            exit;
        }
        $_SESSION['message']="Record has been deleted successfully!";
        $_SESSION['msg_type']="danger";
        header("location:item_category.php");
    }  
    if (isset($_GET['edit'])){
        $id =$_GET['edit'];
        $update = true;
        $query = "SELECT * FROM public.category WHERE category_id ='".pg_escape_string($link,$id)."'LIMIT 1";
            $data = pg_query($link,$query);
            $arr_check=pg_num_rows($data);
            if($arr_check > 0){
                $row = pg_fetch_array($data);
                $code = $row['category_code'];
                $name = $row['category_name'];
                }
    }
    if (array_key_exists('update',$_POST)){
        if(!$_POST['category_name']){
            $_SESSION['message']="category name required!";
            $_SESSION['msg_type']="warning";
            header("location:item_category.php"); 
        }else{
            $id = $_POST['id'];
            $name = $_POST['category_name'];
            $code = productCode($name);
            $query ="SELECT * FROM public.category WHERE category_name = '".pg_escape_string($link,$name)."'LIMIT 1";
            $data = pg_query($query);
            $arr_check =pg_num_rows($data);
            if ($arr_check >0){
                $_SESSION['message']="category name has been used,try again!";
                $_SESSION['msg_type']="warning";
                header("location:item_category.php");
            }
            else{
                $query = pg_query($link,"UPDATE public.category SET category_code = '$code',category_name = '$name' WHERE category_id = $id");
                $_SESSION['message'] = "Record updated successfully!";
                $_SESSION['msg_type'] = "warning";
                header("location:item_category.php");   
            }   
        }   
    }
/***********************************************CATEGORY-CODE-END********************************************************/
?>
