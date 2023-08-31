<?php
// require "DBConnected.php", creates a table called `staff`
    require "DBConnected.php";

    $sql = "CREATE TABLE IF NOT EXISTS `staff` (
        `staff_id` VARCHAR(12) PRIMARY KEY,
        `name` VARCHAR(100),
        `email` VARCHAR(100),
        `username` VARCHAR(100),
        `password` VARCHAR(100)
    )";

    if($conn->query($sql)){
        //echo "Table created successfully!"
    }
    else echo "Error creating Customer table: " . $conn->error;

    $conn->close();
?>