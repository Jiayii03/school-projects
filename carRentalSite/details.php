<?php
    require "db/DBConnected.php";
    session_start();
    $displayForm = true;

    if(isset($_GET["username"])){ // if the page is logged in

        $logoHyperlink = "index.php?username=" .$_GET["username"];

    }

    // when load this page, this part should be the first thing to do, i.e. get staff ID and car ID corresponding to the checkAvailability page
    if(isset($_GET["username"]) && isset($_GET["car"])){   

        // get staff id from staff table, through staff username
        $sql = "SELECT `staff_id` from `staff` WHERE `username` = '". $_GET['username'] ."'";
        if($sql_run = $conn->query($sql)){
            if($sql_run->num_rows > 0){
                $row = $sql_run->fetch_assoc();
                // var_dump($row);
                $_SESSION["staff_id"] = $row["staff_id"];
            }
        }
    
        // get car id from cars table, through car name
        $sql = "SELECT `car_id` from `cars` WHERE `name` = '". $_GET['car'] ."'";
        if($sql_run = $conn->query($sql)){
            if($sql_run->num_rows > 0){
                $row = $sql_run->fetch_assoc();
                
                $_SESSION["car_id"] = $row["car_id"];
                // var_dump($_SESSION["car_id"]);
            }
        }
    }

    // when edit button is clicked at the summary page, get the details to autofill the input text
    if(isset($_GET["customerID"]) && isset($_GET["reservationID"])){

        // when edit, immediately that record is deleted first, to avoid duplicated records
        $sql1 = "DELETE FROM `reservation` WHERE `reservation_id` = '". $_GET["reservationID"] ."';";
        $sql2 = "DELETE FROM `customer` WHERE `customer_id` = '". $_GET["customerID"] ."';";
        if($conn->query($sql1) && $conn->query($sql2))


        // get the details of that particular customer id from database
        $sql = "SELECT * FROM `customer` WHERE `customer_id` = '". $_GET["customerID"] ."';";
        $sql_run = $conn->query($sql);

        if($sql_run->num_rows > 0){
            while($rows = $sql_run->fetch_assoc()){
                
                $_SESSION["name"] = $rows["name"];
                $_SESSION["email"] = $rows["email"];
                $_SESSION["phoneNum"] = $rows["phone_num"];
                $_SESSION["address"] = $rows["address"];

            }
        }

        // get the details of that particular reservation id from database
        $sql = "SELECT * FROM `reservation` WHERE `reservation_id` = '". $_GET["reservationID"] ."';";
        $sql_run = $conn->query($sql);

        if($sql_run->num_rows > 0){
            while($rows = $sql_run->fetch_assoc()){
                
                $_SESSION["paymentMethod"] = $rows["payment_method"];

            }
        }
    }

    // when edit button is clicked from records.php
    if(isset($_GET['edit'])){

        $sql1 = "DELETE FROM `reservation` WHERE `reservation_id` = '". $_GET["edit"] ."';";
        $sql2 = "DELETE FROM `customer` WHERE `customer_id` = '". $_GET["customerID"] ."';";
        if($conn->query($sql1) && $conn->query($sql2))
        
        // get the details of that particular customer id from database
        $sql = "SELECT * FROM `customer` WHERE `customer_id` = '". $_GET["customerID"] ."';";
        $sql_run = $conn->query($sql);

        if($sql_run->num_rows > 0){
            while($rows = $sql_run->fetch_assoc()){
                
                $_SESSION["name"] = $rows["name"];
                $_SESSION["email"] = $rows["email"];
                $_SESSION["phoneNum"] = $rows["phone_num"];
                $_SESSION["address"] = $rows["address"];

            }
        }

        // get the details of that particular reservation id from database
        $sql = "SELECT * FROM `reservation` WHERE `reservation_id` = '". $_GET['edit'] ."';"; // edit here is equivalent to reservationID when clicking edit from records.php
        $sql_run = $conn->query($sql);

        if($sql_run->num_rows > 0){
            while($rows = $sql_run->fetch_assoc()){
                
                $_SESSION["paymentMethod"] = $rows["payment_method"];

            }
        }
    }

    if(isset($_GET["editCustomerID"])){ // if click edit from records.php (customer table)

        $sql1 = "DELETE FROM `reservation` WHERE `reservation_id` = '". $_GET["reservationID"] ."';";
        $sql2 = "DELETE FROM `customer` WHERE `customer_id` = '". $_GET["editCustomerID"] ."';";
        $conn->query($sql1);
        $conn->query($sql2);
    }

    // select the particular car's record
    $sql = "SELECT * FROM `cars` WHERE `name` = '". $_GET['car'] ."';";
    $sql_run = $conn->query($sql);
    $rows = $sql_run->fetch_assoc();

    // Get number of days between startDate and endDate
    $startDate = strtotime($_SESSION['startDate']);
    $endDate = strtotime($_SESSION['endDate']);
    $datediff = round(($endDate - $startDate) / (60 * 60 * 24));

    // Get total proceed
    $total = $datediff * $rows["rental"];
    $total2dp = number_format((float)$total, 2, '.', '');
    $_SESSION["totalProceed"] = $total2dp;
                            
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // <----------submit reservation details form---------->
        if($_POST['submit'] == "Make A Reservation"){

            // echo "reservation form submitted";
            $displayForm = false;
    
            // from customer details form
            $_SESSION["customerID"] = $_POST["customerID"];
            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["phoneNum"] = $_POST["phone_num"];
            $_SESSION["address"] = $_POST["address"];
    
            // from reservation details form
            $_SESSION["reservation_id"] = $_POST["reservation_id"];
            $_SESSION["date"] = $_POST["date"];
            $_SESSION["staff_id"] = $_GET["staffid"];
            $_SESSION["car"] = $_GET["car"];
            $_SESSION["startDate"] = $_GET["startDate"];
            $_SESSION["endDate"] = $_GET["endDate"];
            $_SESSION["paymentMethod"] = $_POST["payment_method"];

            // others
            $_SESSION["minPrice"] = $_GET["minPrice"];
            $_SESSION["maxPrice"] = $_GET["maxPrice"];
            $_SESSION["vehicleType"] = $_GET["vehicleType"];
    
            // insert customer details into database first
            $sql1 = "INSERT INTO `customer` VALUES ('".$_SESSION['customerID']."', '". $_SESSION["name"] ."', '". $_SESSION["email"] ."', '". $_SESSION["phoneNum"] ."', '". $_SESSION["address"] ."')";
            if($conn->query($sql1)){
                // echo "Inserted customer details successful";
            }
            else{
                echo "Inserted unsuccessfully!";
            }
    
            $sql2 = "INSERT INTO `reservation` VALUES ('" . $_SESSION['reservation_id']. "', '". $_SESSION["date"] ."', '". $_SESSION["customerID"]. "', '". $_SESSION["staff_id"]. "', '". $_SESSION["car_id"]. "', '". $_SESSION["startDate"]. "', '". $_SESSION["endDate"]. "', '". $_SESSION["totalProceed"] ."' ,'". $_SESSION["paymentMethod"]. "')";
                
            if($conn->query($sql2)){
                // echo "reservation made!";
    
                // $username = $_GET["username"];
                // header("Location: records.php?username=" . $_GET["username"]);
                }
            else{
                echo "reservation unsuccessful!";
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
    <link rel="stylesheet" href="details.css">
    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <title>Reservation Page</title>
</head>
<body onload="autofill();getCustomerID()"> 

    <!-- navBar -->
    <div class="navBar">
        <div class="logo">
            <a href="index.php?username=<?=$_GET['username']?>"><img class="logo" src="images/logo.jpeg"></a>
        </div>

        <div class="navLinks">
            <div class="hyperlink1">
                <a class="hyperlink1" href="index.php?username=<?=$_GET['username']?>">Index Page</a>
            </div>
            <div class="hyperlink2">
                <a class="hyperlink2" href="checkAvailability.php?username=<?=$_GET['username']?>">Check Availability</a>
            </div>
            <div class="hyperlink3">
                <a class="hyperlink3" href="records.php?username=<?=$_GET['username']?>&viewReservation">View All Records</a>
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

    <div class="mainContainer">
        <?php
        if($displayForm){
        ?>
        <div class="formContainer">
            <!-- fill in customer details first, then submit form (action = same php page), reservation details remain disabled
            after getting customer details, enables reservation form. -->
            <h2 class="customerHeader">Customer Details</h2>

            <form action="details.php?username=<?=$_GET['username']?>&staffid=<?=$_SESSION["staff_id"]?>&car=<?=$_GET['car']?>&vehicleType=<?=$_GET['vehicleType']?>&startDate=<?=$_GET['startDate']?>&endDate=<?=$_GET['endDate']?>&minPrice=<?=$_GET['minPrice']?>&maxPrice=<?=$_GET['maxPrice']?>" method="post" autocomplete="off">
            
                <!-- customer details form -->
                <table class="customerDetails">

                    <input type="text" name="customerID" id="customerID" value="" hidden="true"> <!--customer id is obtained through a function below -->

                    <tr>
                        <th class="customerLabel"><label for="name">Name</label></th>
                        <td class="customerDetail"><input type="text" name="name" id="name" required onfocus="reservationID()"><br></td>
                    </tr>
                    <tr>
                        <th class="customerLabel"><label for="email">Email</label></th>
                        <td class="customerDetail"><input type="text" name="email" id="email" required onfocus="getCustomerID()"><br></td>
                    </tr>
                    <tr>
                        <th class="customerLabel"><label for="phoneNum">Phone Number</label></th>
                        <td class="customerDetail"><input type="text" name="phone_num" id="phoneNum" required><br></td>
                    </tr>
                    <tr>
                        <th class="customerLabel"><label for="address">Address</label></th>
                        <td class="customerDetail"><input type="text" name="address" id="address" required><br> </td>
                    </tr>
                </table>
           
                <!-- reservation details  -->
                <h2 class="reservationHeader">Reservation Details</h2>

                <input type="text" name="reservation_id" value="" id="reservation_id" hidden="true"> <!-- this input is hidden, get reservationID from a random function -->
                
                <input type="text" name="date" id="date" value="" hidden="true"> <!-- this input is hidden, get date from a the date function -->

                <input type="text" name="customer_id" value="" id="customer_id" hidden="true" > <!-- this input is hidden, get customerID from the previous customer details form -->

                <table class="reservationDetails">
                    <tr>
                        <th class="reservationLabel"><label for="staffID">Staff ID</label></th>
                        <td class="reservationDetail">
                            <p id="staffID"></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="reservationLabel"><label for="car">Car</label></th>
                        <td class="reservationDetail ">
                           <p id="car"></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="reservationLabel"><label for="startDate">Start Date</label></th>
                        <td class="reservationDetail modifyRow">
                            <p id="startDate"></p>
                            <img src="images/captcha.png" alt="" class="updateIcon">
                            <a href="checkAvailability.php?username=<?=$_GET['username']?>&startDate=<?=$_GET['startDate']?>&vehicleType=<?=$_GET['vehicleType']?>&endDate=<?=$_GET['endDate']?>&minPrice=<?=$_GET['minPrice']?>&maxPrice=<?=$_GET['maxPrice']?>&change=#" class="change">Change</a>
                        </td>
                    </tr>
                    <tr>
                        <th class="reservationLabel"><label for="endDate">End Date </label></th>
                        <td class="reservationDetail">
                            <p id="endDate"></p>
                        </td>
                    </tr>
                    <tr>
                        <th class="reservationLabel"><label for="paymentMethod">Payment Method</label></th>
                        <td class="reservationDetail"><input type="text" name="payment_method" id="paymentMethod" required><br></td>
                    </tr>
                </table>

                <div>

                </div>

                <button type="submit" name="submit" class="submitReservation" value="Make A Reservation" id="submit">
                    <img src="images/checkmark.png" alt="">
                </button>
                
            </form>
        </div>

            <script>
                // this function is to generate a unique id for each customer
                function generateUniqueID(name){
                    // let val1 = name.charCodeAt(0).toString(); // use charCodeAt function to obtain ASCII value
                    // let val2 = name.charCodeAt(2).toString();
                    let x1 = (Math.floor(Math.random() * 10)).toString();
                    let x2 = (Math.floor(Math.random() * 10)).toString();
                    let x3 = (Math.floor(Math.random() * 10)).toString();
                    let x4 = (Math.floor(Math.random() * 10)).toString();
                    let randomVal = x1 + x2 + x3 + x4;
                    let firstName = name.replace(' ', 'z').toLowerCase().substring(0, 4);
                    return firstName + randomVal;

                }

                    // this function is to fill the hidden customerID input with his/her customerID
                function getCustomerID(){
                    let name = document.getElementById("name").value;
            
                    document.getElementById("customerID").value = generateUniqueID(name);
                    console.log(document.getElementById("customerID").value);

                }

                // this part is to fill in the hidden reservation ID and date
                function reservationID(){
                    let x1 = (Math.floor(Math.random() * 10)).toString();
                    let x2 = (Math.floor(Math.random() * 10)).toString();
                    let x3 = (Math.floor(Math.random() * 10)).toString();
                    let x4 = (Math.floor(Math.random() * 10)).toString();
                    let x5 = (Math.floor(Math.random() * 10)).toString();
                    let x6 = (Math.floor(Math.random() * 10)).toString();
                    
                    let randomID = x1 + x2 + x3 + x4 + x5 + x6;
                    document.getElementById("reservation_id").value = "r" + randomID;
                    console.log(document.getElementById("reservation_id"));
                }

                function getDate(){
                    <?php
                    date_default_timezone_set('Asia/Kuala_Lumpur'); //Set timezone to Asia/Kuala Lumpur
                    $date = date('d/m/Y H:i:s');
                    ?>

                    document.getElementById("date").value = "<?=$date?>";
                    console.log(document.getElementById("date").value);
                    
                }

                function autofill(){
                        document.getElementById("staffID").innerHTML = "<?= $_SESSION["staff_id"]?>";
                        document.getElementById("car").innerHTML = "<?= $_GET["car"]?>";
                        document.getElementById("startDate").innerHTML = "<?= $_GET["startDate"]?>";
                        document.getElementById("endDate").innerHTML = "<?= $_GET["endDate"]?>";
                    }

                getDate();
                reservationID();
            </script>

            <?php
            // this part is particularly for when the edit button is clicked at the summary page
            if((isset($_GET["customerID"]) && isset($_GET["reservationID"]) || isset($_GET['edit']))){
                
                ?>
                <script>
                    // autofill customer details input (and reservation details) when edit button is clicked at the summary page
                    document.getElementById("name").value = "<?= $_SESSION['name']?>";
                    document.getElementById("email").value = "<?= $_SESSION['email']?>";
                    document.getElementById("phoneNum").value = "<?= $_SESSION['phoneNum']?>";
                    document.getElementById("address").value = "<?= $_SESSION['address']?>";
                    document.getElementById("paymentMethod").value = "<?= $_SESSION['paymentMethod']?>"
                </script>
                    
                <?php
            }
        }

        $imageLinks = array( // store the absolute links for every image
            "Rolls Royce Phantom" => "images/cars/rolls_royce_phantom.png",
            "Bentley Continental Flying Spur" => "images/cars/bentley_continental.png",
            "Mercedes Benz CLS 350" => "images/cars/mercedes_benz.png",
            "Jaguar S Type" => "images/cars/jaguar_s.png",
            "Ferrari F430 Scuderia" => "images/cars/ferrari_scuderia.png",
            "Lamborghini Murcielago LP640" => "images/cars/lamborghini.png",
            "Porsche Boxster" => "images/cars/porsche_boxster.png",
            "Lexus SC430" => "images/cars/lexus.png",
            "Jaguar MK 2" => "images/cars/jaguar_mk2.png",
            "Rolls Royce Silver Spirit Limousine" => "images/cars/rolls_royce_silver_spirit.png",
            "MG TD" => "images/cars/mg_td.png"
        );

        $sql = "SELECT * FROM `cars` WHERE `name` = '". $_GET['car'] ."';";
        $sql_run = $conn->query($sql);
        $rows = $sql_run->fetch_assoc();


        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST["submit"] == "Make A Reservation"){
                ?>
                <div class="summaryContainer" id="summaryContainer">
                    <h2 class="summaryHeader">Reservation ID <span><?=$_POST['reservation_id']?></span> booked!</h2>
                    <div class="imageContainer">
                        <img src="<?=$imageLinks[$_SESSION['car']]?>" alt="">
                    </div>
                    <h3 class="summaryh3">Here are the details:</h3>
                    <div class="qrContainer">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?=$_POST['reservation_id']?>" alt="" class="qrImage">
                    </div>
                    <div class="detailsContainer"> <!-- display : flex -->
                        <!-- left side, car summary -->
                        <div class="carSummary">
                            <table>
                                <tr>
                                    <th class="summaryLabel">Car ID</th>
                                    <td class="summaryDetail"><?=$rows['car_id']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Vehicle Name</th>
                                    <td class="summaryDetail"><?=$rows['name']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Type</th>
                                    <td class="summaryDetail"><?=$rows['type']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Color</th>
                                    <td class="summaryDetail"><?=$rows['colour']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Start Date</th>
                                    <td class="summaryDetail"><?=$_SESSION['startDate']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">End Date</th>
                                    <td class="summaryDetail"><?=$_SESSION['endDate']?></td>
                                </tr>
    
                                
    
                                <tr>
                                    <th class="summaryLabel">Days</th>
                                    <td class="summaryDetail"><?=$datediff?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Total proceed</th>
                                    <td class="summaryDetail">MYR <?=$total2dp?></td>
                                </tr>
                            </table>
                        </div>

                        <!-- right side, customer summary -->
                        <div class="customerSummary">
                            <table>
                                <tr>
                                    <th class="summaryLabel">Customer ID</th>
                                    <td class="summaryDetail"><?=$_POST['customerID']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Customer Name</th>
                                    <td class="summaryDetail"><?=$_POST['name']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Email</th>
                                    <td class="summaryDetail"><?=$_POST['email']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Contact Number</th>
                                    <td class="summaryDetail"><?=$_POST['phone_num']?></td>
                                </tr>
                                <tr>
                                    <th class="summaryLabel">Address</th>
                                    <td class="summaryDetail"><?=$_POST['address']?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- edit customer and reservation details -->
                    <!-- here, we pass customerID, reservationID, username, car, startDate and endDate with GET method -->
                    <div class="buttons">
                        
                        <button class="editBtn" onclick="location.href='details.php?customerID=<?=$_SESSION['customerID']?>&reservationID=<?=$_SESSION['reservation_id']?>&username=<?=$_GET['username']?>&car=<?=$_SESSION['car']?>&vehicleType=<?=$_GET['vehicleType']?>&startDate=<?=$_SESSION['startDate']?>&endDate=<?=$_SESSION['endDate']?>&minPrice=<?=$_GET['minPrice']?>&maxPrice=<?=$_GET['maxPrice']?>'">Edit</button>

                        <button class="viewRsBtn" onclick="location.href='records.php?username=<?=$_GET['username']?>&viewReservation'">View all records</button>

                        <button onclick="printPageArea('summaryContainer')" class="printBtn">
                            <img src="images/printer.png" alt="" class="printImg">
                        </button>

                    </div>
                    
                    <script>
                        function printPageArea(areaID){
                            var originalContent = document.body.innerHTML;
                            let imgElement = document.querySelector(".imageContainer");
                            imgElement.remove();
                            let editBtn = document.querySelector(".editBtn");
                            editBtn.remove();
                            let viewRsBtn = document.querySelector(".viewRsBtn");
                            viewRsBtn.remove();
                            let printBtn = document.querySelector(".printBtn");
                            printBtn.remove();
                            let qrImage = document.querySelector(".qrImage");
                            qrImage.style.marginLeft = "70px";
                            var printContent = document.getElementById(areaID).innerHTML;
                            
                            document.body.innerHTML = printContent;
                            window.print();
                            document.body.innerHTML = originalContent;
                        }
                        
                        
                    </script>
                </div>
            <?php
          
            }
        }
    ?>
    </div>

    


</body>
</html>