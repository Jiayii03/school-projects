<?php
// require "DBConnected.php", creates a table called `cars`
    require "DBConnected.php";

    $sql = 
        "CREATE TABLE IF NOT EXISTS `cars` (
        `car_id` VARCHAR(12) PRIMARY KEY,
        `name` VARCHAR(100),
        `type` VARCHAR(100),
        `colour` VARCHAR(100),
        `rental` FLOAT(10,2)
    )";
    
    if($conn->query($sql)){
        //echo "Table created successfully!"
    }
    else echo "Error creating Cars table: " . $conn->error;

    $sql_select = "SELECT * FROM `cars`";
    $sql_run = $conn->query($sql_select); //query the select statement

    if($sql_run->num_rows == 0){ //check if the table has any rows, if no rows -> then insert values
        $sql = "  INSERT INTO `cars` VALUES
        ('c1000', 'Rolls Royce Phantom', 'luxurious', 'blue', 9800),
        ('c1001', 'Bentley Continental Flying Spur', 'luxurious', 'white', 4800),
        ('c1002', 'Mercedes Benz CLS 350', 'luxurious', 'silver', 1350),
        ('c1003', 'Jaguar S Type', 'luxurious', 'champagne', 1350),
        ('c1004', 'Ferrari F430 Scuderia', 'sports', 'red', 6000),
        ('c1005', 'Lamborghini Murcielago LP640', 'sports', 'matte black', 7000),
        ('c1006', 'Porsche Boxster', 'sports', 'white', 2800),
        ('c1007', 'Lexus SC430', 'sports', 'black', 1600),
        ('c1008', 'Jaguar MK 2', 'classics', 'white', 2200),
        ('c1009', 'Rolls Royce Silver Spirit Limousine', 'classics', 'georgian silver', 3200),
        ('c1010', 'MG TD', 'classics', 'red', 2500);
        ";
    
        if($conn->query($sql)){
            //echo "Table created successfully!"
        }
        else echo "Error inserting values into Cars table: " . $conn->error;
    
        $conn->close();
    }

   
?>
