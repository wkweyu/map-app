<?php
    session_start();
    include('connection.php');
    include('functions.php');

/********************************************GROUPS-CODE-START***********************************************************/
  
    $name = "";
    $code = "";
    $update = false;
    $id = 0;
   

    if (array_key_exists('save',$_POST)){
        if (!$_POST['group_name']){
            $_SESSION['message']="Group name required!";
            $_SESSION['msg_type']="warning";
            header("location:item_groups.php");
        }else{
            $groupName = $_POST['group_name'];
            $query ="SELECT * FROM public.group WHERE group_name = '".pg_escape_string($link,$groupName)."'LIMIT 1";
            $data = pg_query($query);                                                                        
            $arr_check = pg_num_rows($data);
            if ($arr_check > 0){
                $_SESSION['message']="Group name has been used,try again!";
                $_SESSION['msg_type']="warning";
                header("location:item_groups.php");
            }
            else{
                $genGroupCode = productCode($groupName);
                $result = pg_query($link,"INSERT INTO public.group(group_code,group_name)VALUES('$genGroupCode','$groupName')");
                $_SESSION['message']="Record has been saved successfully!";
                $_SESSION['msg_type']="success";
                header("location:item_groups.php");
                }
        }
    }
    if (isset($_GET['delete'])){
        $id = $_GET['delete'];
        $deleteRecord = pg_query($link,"DELETE FROM public.group WHERE group_id = '$id'");
        if(!$deleteRecord){
            echo "An error occured.\n";
            exit;
        }
        $_SESSION['message']="Record has been deleted successfully!";
        $_SESSION['msg_type']="danger";
        header("location:item_groups.php");
    }  
    if (isset($_GET['edit'])){
        $id =$_GET['edit'];
        $update = true;
        $query = "SELECT * FROM public.group WHERE group_id ='".pg_escape_string($link,$id)."'LIMIT 1";
            $data = pg_query($link,$query);
            $arr_check=pg_num_rows($data);
            if($arr_check > 0){
                $row = pg_fetch_array($data);
                $code = $row['group_code'];
                $name = $row['group_name'];
                }
    }
    if (array_key_exists('update',$_POST)){
        if(!$_POST['group_name']){
            $_SESSION['message']="Group name required!";
            $_SESSION['msg_type']="warning";
            header("location:item_groups.php"); 
        }else{
            $id = $_POST['id'];
            $name = $_POST['group_name'];
            $code = productCode($name);
            $query ="SELECT * FROM public.group WHERE group_name = '".pg_escape_string($link,$name)."'LIMIT 1";
            $data = pg_query($query);
            $arr_check =pg_num_rows($data);
            if ($arr_check >0){
                $_SESSION['message']="Group name has been used,try again!";
                $_SESSION['msg_type']="warning";
                header("location:item_groups.php");
            }
            else{
                $query = pg_query($link,"UPDATE public.group SET group_code = '$code',group_name = '$name' WHERE group_id = $id");
                $_SESSION['message'] = "Record updated successfully!";
                $_SESSION['msg_type'] = "warning";
                header("location:item_groups.php");   
            }   
        }   
    }
/***********************************************GROUPS-CODE-END**********************************************************/
?>
