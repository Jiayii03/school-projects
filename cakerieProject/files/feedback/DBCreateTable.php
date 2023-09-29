<?php
    require "DBConnection.php";

    $sql = "CREATE TABLE IF NOT EXISTS `feedbackTable`(
    `name`              VARCHAR(50) NOT NULL,
    `contact_number`    VARCHAR(20) NOT NULL,
    `email`             VARCHAR(50) NOT NULL,
    `feedback`          VARCHAR(300) NOT NULL,

    PRIMARY KEY(`contact_number`)
    );";

    if($conn->query($sql)) echo "Table created successfully!";
    else echo "Error creating Employee table: " . $conn->error;

    $conn->close();
