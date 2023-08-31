<?php
// require "DBConnected.php", creates a table called `reservation`
    require "DBConnected.php";

    $sql = 
        "CREATE TABLE IF NOT EXISTS `reservation` (
        `reservation_id` VARCHAR(12) PRIMARY KEY,
        `date` VARCHAR(100),
        `customer_id` VARCHAR(12),
        `staff_id` VARCHAR(12),
        `car_id` VARCHAR(12),
        `rs_start_date` DATE,
        `rs_end_date` DATE,
        `total_proceed` FLOAT(7,2),
        `payment_method` VARCHAR(100),
        
        FOREIGN KEY (staff_id) REFERENCES staff(staff_id),
        FOREIGN KEY (car_id) REFERENCES cars(car_id),
        FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
    )";
    
    if($conn->query($sql)){
        //echo "Table created successfully!"
    }
    else echo "Error creating reservation table: " . $conn->error;

    $conn->close();
?>
