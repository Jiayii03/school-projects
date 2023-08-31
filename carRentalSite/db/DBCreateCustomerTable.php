<?php
// require "DBConnected.php", creates a table called `customer`
    require "DBConnected.php";

    $sql = "CREATE TABLE IF NOT EXISTS `customer` (
        `customer_id` VARCHAR(12) PRIMARY KEY,
        `name` VARCHAR(100),
        `email` VARCHAR(100),
        `phone_num` VARCHAR(100),
        `address` VARCHAR(100)
    )";

    if($conn->query($sql)){
        //echo "Table created successfully!"
    }
    else echo "Error creating Customer table: " . $conn->error;

    $conn->close();
?>