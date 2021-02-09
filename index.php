<?php
    session_start();
    $error = "";
    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time()- 60*60) ;
        $_COOKIE["id"]= "";
    } elseif ((array_key_exists("id", $_SESSION) and $_SESSION['id']) or
              (array_key_exists("id", $_COOKIE) and $_COOKIE['id'])) {
        header("location:loggedinpage.php");
    }
    if (array_key_exists('submit', $_POST)) {
        include('connection.php');
        if (!$_POST['email']) {
            $error .= "An email address is required<br>";
        }
        if (!$_POST['password']) {
            $error .= "A password is required<br>";
        }
        if ($error !="") {
            $error = "<p>There were some error(s) in your form</p>".$error;
        } else {
            if ($_POST['signUp']== '1') {
                $hashpassword = md5($_POST['password']);
                $query ="SELECT * FROM public.users WHERE email ='".pg_escape_string($link, $_POST['email'])."'LIMIT 1";
                $data = pg_query($link, $query);
                $login_check=pg_num_rows($data);
                if ($login_check > 0) {
                    $error .= "That email address is taken";
                } else {
                    $query="INSERT INTO public.users(email,password)VALUES
                    ('".$_POST['email']."','".md5($_POST['password'])."')";
                    if (!pg_query($link, $query)) {
                        $error = "<p>Could not sign you up -please try again.</p>";
                    } else {
                        $_SESSION['id']='1';
                        if ($_POST['stayloggedin']== '1') {
                            setcookie("id", '1', time()+60*60*24*365);
                        }
                        header("location:loggedinpage.php");
                    }
                }
            } else {
                $query = "SELECT * FROM public.users WHERE email ='".pg_escape_string($link, $_POST['email'])."'";
                $result = pg_query($link,$query);
                $row = pg_fetch_array($result);
                if(isset($row)){
                    $hashpassword = md5($_POST['password']);
                    if($hashpassword == $row['password']){
                        $_SESSION['id']=$row['email'];
                        if($_POST['stayloggedin']== '1'){
                            setcookie("id",$row['email'],time()+60*60*24*365);
                            }
                        header("location:loggedinpage.php");
                        }else{
                        $error = "That email/password combination could not be found.";
                        }
                    }else{
                    $error = "That email/password combination could not be found.";
                    }
                }
            }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Map-app</title>
    <style type="text/css">
        .container {
            text-align: center;
            width: 400px;
            margin-top: 120px;
        }

        html {
            background: url(images/background.png)no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        body {
            background: none;

        }

        #loginForm {
            display: none;
        }

        #error {
            background: none;
            color: red;
            border: none;

        }

    </style>
</head>

<body>
    <div class="container">
        <h1>Secret Diary</h1>
        <div id="error" class="form-control">
            <?php 
                echo $error; 
            ?>
        </div>
        <form method="post" id="loginForm">
            <div class="mb-3">
                <input class="form-control" type="email" name="email" placeholder="Enter Email">
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" name="password" placeholder="Enter password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="stayloggedin" value="1">stay logged in
                </label>
            </div>
            <div class="mb-3">
                <input type="hidden" name="signUp" value="0">
                <input name="submit" class="btn btn-success" type="submit" value="Log In!">
            </div>
            <p><a class="toggleForm">Sign Up</a></p>
        </form>
        <form method="post" id="signUpForm">
            <div class="mb-3">
                <input class="form-control" type="email" name="email" placeholder="Enter Email">
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" name="password" placeholder="Enter password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="stayloggedin" value="1">stay logged in
                </label>
            </div>
            <input type="hidden" name="signUp" value="1">
            <div class="mb-3">
                <input name="submit" class="btn btn-success" type="submit" value="Sign Up!">
            </div>
            <p><a class="toggleForm">Log In</a></p>
        </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".toggleForm").click(function() {
            $("#loginForm").toggle();
            $("#signUpForm").toggle();
        })

    </script>
</body>

</html>
