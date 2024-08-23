<?php
ob_start();
session_start();
require_once "includes/config.php";
require_once "includes/db.php";
if(isset($_SESSION['user'])){
    //to unser the user session
    unset($_SESSION['user']);
    //to destroy the session
    session_destroy();
    //to redirect to homepage once session is destroyed
    header("location:".SITE);
}
?>