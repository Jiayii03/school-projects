<?php
    require "DBConnection.php";

    $sql = "CREATE TABLE IF NOT EXISTS `Customer`(
    `customer_id`       INT NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(100) NOT NULL,
    `contact_number`    VARCHAR(20) NOT NULL,
    `email`             VARCHAR(50) NOT NULL,
    `address`           VARCHAR(100) NOT NULL,
    `state`             VARCHAR(30) NOT NULL,

    PRIMARY KEY(`customer_id`)
    -- FOREIGN KEY(`contact_number`) REFERENCES `feedbackTable`(`contact_number`)
    );";

    if($conn->query($sql)) echo "Table created successfully!";
    else echo "Error creating Customer table: " . $conn->error;

    $conn->close();

    // <?php
    // require "DBConnection.php";

    // $sql = "CREATE TABLE IF NOT EXISTS `Customer`(
    // `id`            INT NOT NULL AUTO_INCREMENT,
    // `name`          VARCHAR(100) NOT NULL,
    // `contactnumber` VARCHAR(20) NOT NULL,
    // `email`         VARCHAR(50) NOT NULL,
    // `address`       VARCHAR(100) NOT NULL,
    // `state`         VARCHAR(20) NOT NULL, 

    // PRIMARY KEY(`id`)
    // ) AUTO_INCREMENT = 1001;";

    // if($conn->query($sql)) echo "Table created successfully!";
    // else echo "Error creating Employee table: " . $conn->error;

    // $conn->close();