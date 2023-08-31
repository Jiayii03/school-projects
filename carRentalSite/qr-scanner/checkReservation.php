<?php
    require "../db/DBConnected.php";
    $showNotFound = false;
    $showNotFoundQR = false;
    $showInputForm = true;
    $showQRForm = false;

    if(isset($_GET["qrCode"])){
        $showQRForm = true;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["qrCode"]) && $_GET["qrCode"] != ""){
        // get reservation details  
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){ // if key in manually
            $sql = "SELECT * FROM `reservation` WHERE `reservation_id` = '". $_POST["reservationID"] ."';";
            $reservationID = $_POST["reservationID"];
        }
        elseif(isset($_GET["qrCode"])){ // if by qr code
            $sql = "SELECT * FROM `reservation` WHERE `reservation_id` = '". $_GET["qrCode"] ."';";
            $reservationID = $_GET["qrCode"];
        }

        $sql_run = $conn->query($sql);
        if($_SERVER["REQUEST_METHOD"] == "POST" && $sql_run->num_rows == 0){ // if reservation ID not found (if no record found) when manually key in id
            $showNotFound = true;
        }
        elseif($sql_run->num_rows == 0 && isset($_GET["qrCode"])){ // if reservation ID not found when using qr code scanner
            $showNotFoundQR = true;
            $showQRForm = true;
        }
        else{ // if reservation id found
            $showInputForm = false;
            $showQRForm = false;
        }
    }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    <link rel="stylesheet" href="checkReservation.css">
    <title>Check Reservation Page</title>

    <style>
        main {
        display: flex;
        justify-content: center;
        align-items: center;
        }
        #reader {
        width: 600px;
        }
        #result {
        text-align: center;
        font-size: 1.5rem;
        }
    </style>
</head>
<body>

<!-- navBar -->
    <div class="navBar">
        <div class="logo">
            <a href="../index.php"><img class="logo" src="../images/logo.jpeg"></a>
        </div>

        <div class="navLinks">
            <div class="hyperlink2">
                <a class="hyperlink2" href="../index.php">Index Page</a>
            </div>
            <div class="hyperlink3">
                <a class="hyperlink3" href="checkReservation.php">Check Reservation</a>
            </div>
            <div class="logInOut">
                <span style="margin-right: 1vw;">Guest</span>
                <a class="logInHyper" href="../login/login.php">Log In</a>
            </div>
        </div>
    </div>

    <?php
    if($showQRForm || isset($_GET["qrCode"]) && $_GET["qrCode"] == ""){ // if user wants to scan using qr code
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <div class="qrMainContainer">
        <?php
        if($showNotFoundQR){
            ?>
            <h2>Reservation ID: <?=$_GET["qrCode"]?> Not Found!</h2>
            <?php
        }
        ?>
        <main>
            <div id="reader"></div>
        </main>
    </div>
    <div class="backContainer">
        <a href="checkReservation.php" class="keyInHyper">
            <img src="../images/previous.png" alt="">
        </a>
    </div>

    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 20,
            });
        scanner.render(success, error);
        function success(result) {
            document.location.href = `checkReservation.php?qrCode=${result}`;
        }

        function error(err) {
            console.error(err);
        }
    </script>
    <?php
    }
    ?>

    <div class="mainContainer">
    <?php
    if($showInputForm && !(isset($_GET["qrCode"]))){ // if user wants to key in manually
    ?>
        <div class="formContainer">
            <form action="checkReservation.php" method="post" autocomplete="false">
                <label for="inputReservationID" class="formLabel">Enter reservation ID</label>
                <br>
                <input type="text" name="reservationID" class="inputReservationID" autocomplete="off" placeholder="Reservation ID">
                <?php
                if($showNotFound){
                    ?>
                    <br><br>
                    <span class="notFound">Reservation ID Not Found!</span>
                    <script>
                        document.querySelector(".formContainer").style.height = "300px";
                    </script>
                    <?php
                }
                ?>
                <br>
                <input type="submit" name="checkReservation" value="Check Reservation" class="submitReservationID"><br><br>
                <div class="qrHyperContainer">
                    <a href="checkReservation.php?qrCode" class="qrCodeHyper">Scan QR Code
                        <img src="../images/qr-code.png" alt="">
                    </a>
                </div>
            </form>
        </div>
    
    <?php
    }
    ?>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["qrCode"]) && $_GET["qrCode"] != ""){ // if reservation id is gotten
        if($showNotFound == false){
        ?>
        <script>
            document.querySelector("body").style.height = "150vh";
        </script>
        <?php
            }
        if($sql_run->num_rows > 0){ // if reservation ID is found
            $rows = $sql_run->fetch_assoc();

            // get car details
            $sql2 = "SELECT * FROM `cars` WHERE `car_id` = '". $rows['car_id'] ."';";
            $sql_run2 = $conn->query($sql2);
            $rows2 = $sql_run2->fetch_assoc();

            // get customer details
            $sql3 = "SELECT * FROM `customer` WHERE `customer_id` = '". $rows['customer_id'] ."';";
            $sql_run3 = $conn->query($sql3);
            $rows3 = $sql_run3->fetch_assoc();

            $imageLinks = array( // store the absolute links for every image
                "Rolls Royce Phantom" => "../images/cars/rolls_royce_phantom.png",
                "Bentley Continental Flying Spur" => "../images/cars/bentley_continental.png",
                "Mercedes Benz CLS 350" => "../images/cars/mercedes_benz.png",
                "Jaguar S Type" => "../images/cars/jaguar_s.png",
                "Ferrari F430 Scuderia" => "../images/cars/ferrari_scuderia.png",
                "Lamborghini Murcielago LP640" => "../images/cars/lamborghini.png",
                "Porsche Boxster" => "../images/cars/porsche_boxster.png",
                "Lexus SC430" => "../images/cars/lexus.png",
                "Jaguar MK 2" => "../images/cars/jaguar_mk2.png",
                "Rolls Royce Silver Spirit Limousine" => "../images/cars/rolls_royce_silver_spirit.png",
                "MG TD" => "../images/cars/mg_td.png"
            );
            
            ?>
            <div class="summaryContainer" id="summaryContainer">
                <h2 class="summaryHeader">Reservation ID: <span><?=$reservationID?></span> found!</h2>
                <div class="imageContainer">
                    <img src="<?=$imageLinks[$rows2["name"]]?>" alt="">
                </div>
                <h3 class="summaryh3">Here are the details:</h3>

                <!-- QR code -->
                <div class="qrContainer">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?=$reservationID?>" alt="" class="qrImage">
                </div>

                <div class="detailsContainer"> <!-- display : flex -->
                    <!-- left side, car summary -->
                    <div class="carSummary">
                        <table>
                            <tr>
                                <th class="summaryLabel">Car ID</th>
                                <td class="summaryDetail"><?=$rows2['car_id']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Vehicle Name</th>
                                <td class="summaryDetail"><?=$rows2['name']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Type</th>
                                <td class="summaryDetail"><?=$rows2['type']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Color</th>
                                <td class="summaryDetail"><?=$rows2['colour']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Start Date</th>
                                <td class="summaryDetail"><?=$rows["rs_start_date"]?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">End Date</th>
                                <td class="summaryDetail"><?=$rows["rs_end_date"]?></td>
                            </tr>

                            <?php
                            // Get number of days between startDate and endDate
                            $startDate = strtotime($rows["rs_start_date"]);
                            $endDate = strtotime($rows["rs_end_date"]);
                            $datediff = round(($endDate - $startDate) / (60 * 60 * 24));

                            // Get total proceed
                            $total = $datediff * $rows2["rental"];
                            $total2dp = number_format((float)$total, 2, '.', '');
                        
                            ?>

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
                                <td class="summaryDetail"><?=$rows3['customer_id']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Customer Name</th>
                                <td class="summaryDetail"><?=$rows3['name']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Email</th>
                                <td class="summaryDetail"><?=$rows3['email']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Contact Number</th>
                                <td class="summaryDetail"><?=$rows3['phone_num']?></td>
                            </tr>
                            <tr>
                                <th class="summaryLabel">Address</th>
                                <td class="summaryDetail"><?=$rows3['address']?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="buttons">
                    <button onclick="printPageArea('summaryContainer')" class="printBtn">
                        <img src="../images/printer.png" alt="" class="printImg">
                    </button>

                    <script>
                        function printPageArea(areaID){
                            var originalContent = document.body.innerHTML;
                            let imgElement = document.querySelector(".imageContainer");
                            imgElement.remove();
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
            </div> 
            <?php
        }
    }
        ?>
    </div>  
</body>
</html>