 <?php
session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require "DBConnection.php";

        $_SESSION['name'] = $_POST['name'];
        var_dump($_POST);

        // $_SESSION['name_new'] = $_POST['name'];
        // $_SESSION['id'] = $_POST['id'];

        // var_dump($_POST);
        $sql = "UPDATE `Customer` SET `name` = ?, `contact_number` = ?, `email` = ?, `address` = ?, `state` = ? WHERE `customer_id` = '". $_SESSION['customer_id'] . "';";

        $stmt = $conn->prepare($sql);

        if($stmt){
            // $int_id = intval($_SESSION['id']);

            $stmt->bind_param("sssss", $_POST['name'], $_POST['contact_number'], $_POST['email'], $_POST['address'], $_POST['state']);
            
            if($stmt->execute()){
                echo "Details updated successfully!";
            } else echo "Error updating record to table: " . $stmt->error;
        } else echo "Unable to prepare statement: " . $conn->error;

        $conn->close();
    }

header("Location: confirmation.php");