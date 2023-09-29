<?php
    require "DBConnectionTest.php";

    $sql = "CREATE DATABASE IF NOT EXISTS `wpasgm_db`"; // create SQL statement to be executed by MySQL

    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully.";
    } else {
        echo "Error creating database: " . $conn->error;
    }
   
    $conn->close(); 