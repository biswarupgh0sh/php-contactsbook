<?php
ob_start();
session_start();
require_once "../includes/config.php";
require_once "../includes/db.php";
    if(isset($_POST['submit'])){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $errors = [];

        if(empty($email)){
            $errors[] = "Enter the email.";
        }
        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Enter a valid email.";
        }
        if(empty($password)){
            $errors[] = "Enter a password.";
        }

        if(!empty($errors)){
            $_SESSION['errors'] = $errors;
            header("location:".SITE."login.php");
        }

        if(!empty($email) && !empty($password)){
            $conn = db_connect();
            $sanitize_email = mysqli_real_escape_string($conn, $email); // to prevent sql injection
            $sql = "SELECT * FROM `users` WHERE email = '$sanitize_email'";
            $result = mysqli_query($conn, $sql);
            db_close($conn);
            if(mysqli_num_rows($result) > 0){
                $user_info = mysqli_fetch_assoc($result);
                if(!empty($user_info)){
                    $passInDb = $user_info['password'];
                    if(password_verify($password, $passInDb)){
                        unset($user_info['password']);
                        $_SESSION['user'] = $user_info;
                        header("location:".SITE);
                    }else{
                        $errors[] = "Invalid Password";
                        $_SESSION['errors'] = $errors;
                        header("location:".SITE."login.php");
                        die;
                    }
                }
            }else{
                $errors[] = "Invalid Email";
                $_SESSION['errors'] = $errors;
                header("location:".SITE."login.php");
                die;
            }
        }
    }
?>