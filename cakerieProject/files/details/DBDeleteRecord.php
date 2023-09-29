<?php

    if(isset($_GET['customer_id'])){ //checks if "?id=..." exists, i.e. if a GET value "id" is obtained
        require "DBConnection.php";

        $sql = "DELETE FROM `Customer` WHERE `customer_id` = ?;";

        $stmt = $conn->prepare($sql);

        if($stmt){
            $stmt->bind_param("i", $_GET['customer_id']);
            if($stmt->execute()){
                echo "Deleted record with ID: " . $_GET['customer_id'];
            } else echo "Unable to delete record #" . $_GET['customer_id'] . ":" . $stmt->error;

        } else echo "Unable to prepare statement: " . $conn->error;
    };

header("Location: confirmation.php");
