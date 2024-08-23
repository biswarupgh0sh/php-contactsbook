<?php
//function to connect to database
    function db_connect(){
        $host = "localhost";
        $user = "root";
        $password = null;
        $dbName = "contactsbook";

        //connecting to sql database using mysqli class
        $conn = mysqli_connect($host, $user, $password, $dbName);

        //if connection isn't established then die
        if(!$conn) {
            die("Connection failed".mysqli_connect_error());
        }
        return $conn;
    }

    //function to close database connection
    function db_close($conn) {
        mysqli_close($conn);
    }
?>