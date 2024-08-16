<?php
ob_start();
session_start();
require_once "includes/config.php";
require_once "includes/db.php";
if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
    session_destroy();
    header("location:".SITE);
}
?>