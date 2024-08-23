<?php
ob_start();
session_start();
require_once "../includes/config.php";
require_once "../includes/db.php";
$errors = [];
$cId = "";

if (isset($_POST) && !empty($_SESSION['user'])) {
    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $photo_file = !empty($_FILES['photo']) ? $_FILES['photo'] : [];
    $cId = !empty($_POST['contactId']) ? $_POST['contactId'] : "";

    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email id.";
    }
    if (empty($phone)) {
        $errors[] = "Phone no. can't be empty.";
    }
    if (!empty($phone) && strlen($phone) != 10) {
        $errors[] = "Invalid Phone no.";
    }
    if (!empty($phone) && !is_numeric($phone)) {
        $errors[] = "Phone no. should be numeric.";
    }
    if (empty($address)) {
        $errors[] = "Address can't be blank.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("location:" . SITE . "addcontacts.php");
        die;
    }


    $photo_name = "";
    if (!empty($photo_file['name'])) {
        //to get the temporary path of the file
        $fileTempPath = $photo_file['tmp_name'];
        $fileName = $photo_file['name'];
        //to convert a string into array by specific separator "."
        $fileNameCmp = explode(".", $fileName);
        //to cast it to lowercase
        $fileExt = strtolower(end($fileNameCmp));
        //to hash using md5(message-digest) algorithm to create a 128-bit hash value
        $fileNewName = md5(time() . $fileName) . "." . $fileExt;
        $photo_name = $fileNewName;

        //setting which extensions will be allowed
        $allowd_entry = ["jpg", "jpeg", "png", "gif"];
        //checking wheather file extension is there in the allowed extention
        if (in_array($fileExt, $allowd_entry)) {
            $desti = "../uploads/photos/".$photo_name;
            if (!move_uploaded_file($fileTempPath, $desti)) {
                $errors[] = "The file wasn't uploaded";
            }
        } else {
            $errors[] = "Invalid photo extension";
        }
    }

    $owner_id = ($_SESSION['user'] && $_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;


    if (!empty($cId)) {
        //update old record
        if (!empty($photo_name)) {
            //if photo is changed then the below query will be executed
            $sql = "UPDATE `contacts` SET first_name = '$first_name', last_name = '$last_name', email = '$email' , phone = '$phone', address = '$address', photo = '$photo_name' WHERE id = $cId AND owner_id = $owner_id";
        } else {
            //if photo is not changed then the below query will be executed
            $sql = "UPDATE `contacts` SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', address = '$address' WHERE id = $cId AND owner_id = $owner_id";
        }
        $message = "Contact has been updated successfully!";
    } else {
        //insert new record
        $sql = "INSERT INTO `contacts` (first_name, last_name, email, phone, address, photo, owner_id) VALUES ('$first_name', '$last_name', '$email', '$phone', '$address', '$photo_name', '$owner_id')";
        $message = "New Contact has been added successfully!";
    }

    $conn = db_connect();

    // if(mysqli_query($conn, $sql)){
    //     db_close($conn);
    //     $message = "New contact has been added";
    //     $_SESSION['success'] = $message;
    //     header("location:".SITE);
    // } 

    if($conn){
        if(mysqli_query($conn, $sql)){
            db_close($conn);
            $_SESSION['success'] = $message;
            header("location:".SITE);
            die;
        }else{
            echo "Error:".mysqli_error($conn);
        }
    }else{
        echo "Unable to establish a connection to the database";
    }
}
