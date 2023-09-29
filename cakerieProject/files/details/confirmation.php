<?php
    require "DBConnection.php";
    // require "DBInsertRecord.php";
    session_start();

//     if(isset($_GET['id'])){
//         $session = 'name_new';
//     }else{
//         $session = 'name';
//     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="confirmation2.css">
    <link rel="icon" type="image/png" href="../../image/favicon.png">

    <title>Confirmation Page</title>
</head>
<body>
    <div class="confirmation-container">
        <div class="header">
            <h1>Confirmation Page</h1>
            <p>Here's your details:</p>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>Name</th>
                    <th class="contactNumber">Contact Number</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>State</th>
                </tr>
                    <?php
                        $sql = "SELECT * FROM `Customer` WHERE `name` = '". $_SESSION['name'] . "';";
                        // $sql = "SELECT * FROM `Customer`";
                        
                        $sql_run = $conn->query($sql);

                        if($sql_run){
                            if($sql_run->num_rows > 0){
                                while($row = $sql_run->fetch_assoc()){
                                    ?>
                                <tr class="details">
                                    <td><?= $row['name']; ?></td>
                                    <td class="contactNumber"><?= $row['contact_number']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                    <td><?= $row['address']; ?></td>
                                    <td><?= $row['state']; ?></td>
                                </tr>
                                
                                <tr class="btns">
                                    <td colspan="5">
                                        <button class="correct_btn" onclick="alertDone()">They're Correct</button>
                                        <button class="edit_btn" onclick="document.location.href = 'details.php?customer_id=<?= $row['customer_id']; ?>'">Edit</button>
                                        <button class="delete-btn" onclick="document.location.href = 'DBDeleteRecord.php?customer_id=<?= $row['customer_id']; ?>';">Delete</button>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                <?php
                            }else{
                                ?>
                                <tr>
                                    <td class="no-record" colspan="6">No Records Found!</td>
                                </tr>
                                <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="5">Error retrieving table rows: <?= $conn->error; ?></td>
                            </tr>
                            <?php
                        }
                    ?>
            </table>
        </div>
        
    </div>
    <script src="confirmation.js"></script>
</body>
</html>