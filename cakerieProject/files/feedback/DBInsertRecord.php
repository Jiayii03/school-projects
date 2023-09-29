<?php

require "DBConnection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require "DBConnection.php";

        var_dump($_POST);
        $sql = "INSERT INTO `feedbackTable` (`name`, `contact_number`, `email`, `feedback`) VALUES (?, ?, ?, ?);";

        $stmt = $conn->prepare($sql);

        if($stmt){
            $stmt->bind_param("ssss", $_POST['name'], $_POST['contact_number'], $_POST['email'], $_POST['feedback']);
            if($stmt->execute()){
                echo "Details updated successfully!";
            } else echo "Error adding record to table: " . $stmt->error;
        } else echo "Unable to prepare statement: " . $conn->error;
        $conn->close();
    };

header("Location: ../landing/landingpage.html");


