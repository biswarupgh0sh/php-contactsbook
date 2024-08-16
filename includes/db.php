<?php
    function db_connect(){
        $host = "localhost";
        $user = "root";
        $password = null;
        $dbName = "contactsbook";

        $conn = mysqli_connect($host, $user, $password, $dbName);

        if(!$conn) {
            die("Connection failed".mysqli_connect_error());
        }
        return $conn;
    }

    function db_close($conn) {
        mysqli_close($conn);
    }
?>