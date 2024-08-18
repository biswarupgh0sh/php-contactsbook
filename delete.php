<?php
ob_start();
session_start();
require_once "includes/config.php";
require_once "includes/db.php";

if(empty($_SESSION['user'])){
    header("location:".SITE."login.php");
    die;
}

if(!empty($_GET['id']) && is_numeric($_GET['id'])){
    $userId = $_SESSION['user']['id'];
    $contactId = $_GET['id'];
    $conn = db_connect();
    $cId = mysqli_real_escape_string($conn, $contactId);
    $sql = "DELETE FROM `contacts` WHERE `id` = $cId AND `owner_id` = $userId";
    if(mysqli_query($conn, $sql)){
        db_close($conn);
        $_SESSION['success'] = "Contact has been deleted";
        header("location:" .SITE);
    }else{
        $_SESSION['errors'] = "Failed to delete a contact";
    }

}else{
    echo "Invalid Id.";
    die;
}
?>