<?php

session_start();
require "DBConnection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require "DBConnection.php";

        $_SESSION['name'] = $_POST['name'];

        var_dump($_POST);
        $sql = "INSERT INTO `Customer` (`name`, `contact_number`, `email`, `address`, `state`) VALUES (?, ?, ?, ?, ?);";

        $stmt = $conn->prepare($sql);

        if($stmt){
            $stmt->bind_param("sssss", $_POST['name'], $_POST['contact_number'], $_POST['email'], $_POST['address'], $_POST['state']);
            if($stmt->execute()){
                echo "Details updated successfully!";
            } else echo "Error adding record to table: " . $stmt->error;
        } else echo "Unable to prepare statement: " . $conn->error;
        $conn->close();
    }

header("Location: confirmation.php");

