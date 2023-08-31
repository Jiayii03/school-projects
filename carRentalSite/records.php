<?php

    require "db/DBConnected.php";
    session_start();

    $invalid_login = true; // for checking credentials when deleting records
    $show_invalid = false;

    if(isset($_GET["username"])){ // if the page is logged in

        $logoHyperlink = "index.php?username=" .$_GET["username"];

    }

    if(isset($_GET["deleteRsId"])){

        $action = "records.php?username=" . $_GET["username"] . "&deleteRsId=" . $_GET["deleteRsId"] . "&deleteCsId=" . $_GET["deleteCsId"];
        if(isset($_POST["submit"]) == "Delete Reservation"){
            
            // check credentials
            $username = $_POST["username"];
            $password = $_POST["password"];
       
            $sql = "SELECT * FROM `staff` WHERE `username` = '". $username ."'";
   
            if($sql_run = $conn->query($sql)){
                if($sql_run->num_rows > 0){ 
                    while($row = $sql_run->fetch_assoc()){ 
                        
                        if($username == $row["username"] && $password == $row["password"]){ //if username and password matches

                            $invalid_login = false;

                            $sql2 = "DELETE FROM `reservation` WHERE `reservation_id` = '".$_GET['deleteRsId']."';"; // delete that particular reservation from database
                            $sql_run = $conn->query($sql2);
                            
                            $sql1 = "DELETE FROM `customer` WHERE `customer_id` = '".$_GET['deleteCsId']."';";
                            $sql_run = $conn->query($sql1);

                            header("Location: records.php?username=" . $_GET["username"] . "&viewReservation");
                          
                       } else{
                        $show_invalid = true;
                       }
                   }
               } else{
                $show_invalid = true;
               }
           }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="records.css">
    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <title>View Reservation</title>
</head>
<body>
    <div class="mainContainer">
        <!-- navBar -->
        <div class="navBar">
            <div class="logo">
                <a href="index.php?username=<?=$_GET['username']?>"><img class="logo" src="images/logo.jpeg"></a>
            </div>

            <div class="navLinks">
                <div class="hyperlink1">
                    <a class="hyperlink1" href="index.php?username=<?=$_GET['username']?>" style="text-decoration: underline">Index Page</a>
                </div>
                <div class="hyperlink2">
                    <a class="hyperlink2" href="checkAvailability.php?username=<?=$_GET['username']?>">Check Availability</a>
                </div>
                <div class="hyperlink3">
                    <a class="hyperlink3" href="records.php?username=<?=$_GET['username']?>">View All Records</a>
                </div>
                <div class="logInOut">
                <?php
                if(isset($_GET["username"])){ // $_GET method from login.php (when the page is logged in)
                    ?>
                        <span style="margin-right: 1vw;">Hello, <?= $_GET["username"] ?>!</span>
                        <a class="logOutHyper" href="login/logout.php">Log Out</a>
                    <?php
                    }
                    else{
                    ?>
                        <span style="margin-right: 1vw;">Guest</span>
                        <a class="logInHyper" href="login/login.php">Log In</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="dbMenu">
            <button class="viewReservationBtn" onclick="document.location.href='records.php?username=<?=$_GET['username']?>&viewReservation'">View Reservations</button>
            <button class="viewCustomerBtn" onclick="document.location.href='records.php?username=<?=$_GET['username']?>&viewCustomer'">View Customers</button>
        </div>      
        
        <div class="searchBar">
            <div class="searchBarPosition">
                <img src="images/search.png" alt="">
                <?php
            if(isset($_GET["viewReservation"])){
                ?>
                <input type="text" name="" class="searchValue" onkeyup="search()" placeholder="Search Reservation ID">
                <?php
            }
            else if(isset($_GET["viewCustomer"])){
                ?>
                <input type="text" name="" class="searchValue" onkeyup="search()" placeholder="Search Customer ID">
            <?php
            }
            ?>
            </div>
        </div>
        
        <script>
            function search(){
                var searchValue = document.querySelector(".searchValue").value;
                let rows = document.getElementsByClassName("rows");

                const regex = new RegExp(searchValue); // regular expression
                console.log(regex.test(rows[0].childNodes[1].innerHTML));

                for(let i = 0; i < rows.length; i++){ // hide all rows
                    rows[i].hidden = true;
                }

                for(let i = 0; i < rows.length; i++){
                    if(searchValue === "") { // if input string is empty, show all records
                        rows[i].hidden = false;
                    }
                    else if(regex.test(rows[i].childNodes[1].innerHTML)){ // if search value contains a substring of the innerHTML, show the row
                        rows[i].hidden = false;
                    }
                }
                // console.log(rows[0].childNodes[1].innerHTML); // get reservation id
                // console.log(rows[1].childNodes[1].innerHTML); // get reservation id
            }
        </script>

        <div class="recordsTable">
            
            <?php
            if(isset($_GET["viewReservation"])){ // if view reservation button is clicked
                ?>

            <script>
                document.querySelector(".viewReservationBtn").style.transform = "scale(1.1)";
            </script>

            <table class="records reservationRecords">
                <tr>
                    <th>Reservation ID</th>
                    <th>Date/Time</th>
                    <th>Customer ID</th>
                    <th>Staff ID</th>
                    <th>Car ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total (MYR)</th>
                    <th>Payment Method</th>
                </tr>
                <?php
                $sql = "SELECT * FROM `reservation`";
                $sql_run = $conn->query($sql);
                if($sql_run->num_rows > 0){
                    while($row = $sql_run->fetch_assoc()){

                        $sql2 = "SELECT `name` FROM `cars` WHERE `car_id` = '" . $row['car_id'] ."';";
                        $sql_run2 = $conn->query($sql2);
                        $arr = $sql_run2->fetch_assoc();
                        $car = $arr['name'];
                        
                        ?>
                        
                <tr class="rows">
                    <td><?= $row["reservation_id"]?></td>
                    <td><?= $row["date"]?></td>
                    <td><?= $row["customer_id"]?></td>
                    <td><?= $row["staff_id"]?></td>
                    <td><?= $row["car_id"]?></td>
                    <td><?= $row["rs_start_date"]?></td>
                    <td><?= $row["rs_end_date"]?></td>
                    <td><?= $row["total_proceed"]?></td>
                    <td><?= $row["payment_method"]?></td>
                    <td>
                        <div class="buttons">
                            <button class="editButton" onclick="location.href='details.php?customerID=<?=$row['customer_id']?>&edit=<?=$row['reservation_id']?>&car=<?=$car?>&vehicleType=all&username=<?=$_GET['username']?>&startDate=<?=$row['rs_start_date']?>&endDate=<?=$row['rs_end_date']?>&minPrice=1301&maxPrice=9800'">Edit</button>
                            <button class="deleteButton" onclick="location.href='records.php?username=<?= $_GET['username']?>&deleteRsId=<?= $row['reservation_id']?>&deleteCsId=<?=$row['customer_id']?>'">Delete</button>
                        </div>
                    </td>
                </tr>
                        
                    <?php
                    }
                }
                else{
                    ?>
                <tr>
                    <td colspan="9" class="no-records">No records found!</td>
                </tr>
            </table>
                    <?php
                }   
            }

            if(isset($_GET["viewCustomer"])){ // if view customer button is clicked
                ?>

            <script>
                document.querySelector(".viewCustomerBtn").style.transform = "scale(1.1)";
            </script>

            <table class="records customerRecords">
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                </tr>
                <?php

                $sql1 = "SELECT * FROM `customer`";
                $sql_run1 = $conn->query($sql1);
                if($sql_run1->num_rows > 0){
                    while($row = $sql_run1->fetch_assoc()){
                       
                        $sql2 = "SELECT * FROM `reservation` WHERE `customer_id` = '". $row['customer_id'] ."';";
                        $sql_run2 = $conn->query($sql2);
                        $reserveRows = $sql_run2->fetch_assoc();

                        $sql3 = "SELECT `name` FROM `cars` WHERE `car_id` = '" . $reserveRows['car_id'] ."';";
                        $sql_run3 = $conn->query($sql3);
                        $arr = $sql_run3->fetch_assoc();
                        $car = $arr['name'];
                    ?>   
                <tr  class="rows">
                    <td><?=$row["customer_id"]?></td>
                    <td><?=$row["name"]?></td>
                    <td><?=$row["email"]?></td>
                    <td><?=$row["phone_num"]?></td>
                    <td><?=$row["address"]?></td>
                    <td class="lastCol">
                        <div class="buttons">
                            <button class="editButton csEditButton" onclick="location.href='details.php?username=<?=$_GET['username']?>&reservationID=<?=$reserveRows['reservation_id']?>&editCustomerID=<?=$row['customer_id']?>&car=<?=$car?>&vehicleType=all&startDate=<?=$reserveRows['rs_start_date']?>&endDate=<?=$reserveRows['rs_end_date']?>&minPrice=1301&maxPrice=9800'">Edit</button>
                        </div>
                    </td>
                </tr>               
                    <?php
                    }
                }
                else{
                    ?>
                <tr>
                    <td colspan="9" class="no-records">No records found!</td>
                </tr>
            </table>
                    <?php
                }   
            }
            ?>

            
        </div>
    </div>
    

    <?php
    if(isset($_GET["deleteRsId"]) && $invalid_login = true){
        ?>

        <script>
            document.querySelector(".mainContainer").style.filter = "blur(5px)";  
        </script>


        <div class="popUpContainer">
            <a href="records.php?username=<?=$_GET['username']?>&viewReservation" class="closeHyperlink">
                <img src="images/close.png" alt="">
            </a>
            <h2>Deleting Reservation <?=$_GET["deleteRsId"]?></h2>
            <p>Please enter username and password to verify your identity.</p>
            <form action="<?=$action?>" method="post" autocomplete="off">

                <label for="username">Username</label><br>
                <input type="text" class="username" name="username"><br>
                      
                <label for="password">Password</label><br>
                <input type="password" class="password" name="password"><br>

                <?php
                if($show_invalid == true){
                    ?>
                    <span>Invalid credentials. Try again<br></span>
                    <?php
                }
                ?>

                <button type="submit" name="submit" value="Delete Reservation" class="delete"><img src="images/garbage.png" alt=""></button>
                <!-- <input type="submit" name="submit" value="Delete Reservation"><br> -->
             
            </form>
        </div>
        
        <?php
    }
    ?>
</body>
</html>

