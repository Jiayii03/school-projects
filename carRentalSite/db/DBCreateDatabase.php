<?php
// this file creates a database called `car_reservation_db`, after connecting to the localhost
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS `car_reservation_db`"; // create SQL statement to be executed by MySQL

    if ($conn->query($sql) === TRUE) {
        //echo "Database created successfully.";
    } else {
        echo "Error creating database: " . $conn->error;
    }
?>