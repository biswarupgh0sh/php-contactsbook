<?php
ob_start();
session_start();
require_once "../includes/config.php";
require_once "../includes/db.php";
if(isset($_POST['register'])){
    $errors = [];

    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['cpassword']);

    if(empty($first_name)) {
        $errors[] = 'Enter the first name.';
    }
    if(empty($last_name)){
        $errors[] = 'Enter the last name.';
    }
    if(empty($email)){
        $errors[] = 'Enter the email.';
    }
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Enter a valid email.';
    }
    if(empty($password)){
        $errors[] = 'Enter a password.';
    }
    if(empty($confirm_password)){
        $errors[] = 'Enter the password to confirm.';
    }
    if(!empty($password) && !empty($cpassword) && $password != $confirm_password){
        $errors[] = 'Make sure to type the same password in boths the password fields.';
    }
    if(!empty($email)){
        $conn = db_connect();
        $sanitize_email = mysqli_real_escape_string($conn, $email); // sanitizing the given mail id to prevent sql injection
        $email_sql = "SELECT * FROM `users` WHERE email = '$sanitize_email'";
        $sql_res = mysqli_query($conn, $email_sql);
        if(mysqli_num_rows($sql_res) > 0) {
            $errors[] = "Email Id already exists!";
        }
        db_close($conn);
    }

    //it will check for any errors
    if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header("location:".SITE."signup.php");
        die;
    }

    //if no error
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `users` (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$passwordHash')";
    $conn = db_connect();

    if(mysqli_query($conn, $sql)){
        db_close($conn);
        $message = "You're succesfully registered!!";
        $_SESSION['success'] = $message;
        header("location:".SITE."signup.php");
        die;
    }
}
?>