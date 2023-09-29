<?php
    require "DBConnection.php";

    $sql = "DROP TABLE IF EXISTS `feedbackTable`;";

    if($conn->query($sql)) echo "Table dropped successfully!";
    else echo "Error dropping table: " . $conn->error;

    $conn->close();