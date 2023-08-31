<?php
    require "db/DBConnected.php";
    session_start();

    if(isset($_GET["username"])){ // if the page is logged in

        $logoHyperlink = "index.php?username=" .$_GET["username"];

    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["submit1"]) || isset($_POST["submit2"])){ // if form is submitted from index.php

            $_SESSION["startDate"] = $_POST["startDate"];
            $_SESSION["endDate"] = $_POST["endDate"];
            $_SESSION["vehicleType"] = $_POST["vehicleType"];
            $_SESSION["minPrice"] = "1300";
            $_SESSION["maxPrice"] = "9800";
            
        }

        if(isset($_POST["submit2"])){ // if form is submitted from checkAvailability.php

            $_SESSION["minPrice"] = $_POST["minPrice"];
            $_SESSION["maxPrice"] = $_POST["maxPrice"];

        }
        
    } else if(isset($_GET["change"])){ // if click change from details.php

        $_SESSION["startDate"] = $_GET["startDate"];
        $_SESSION["endDate"] = $_GET["endDate"];
        $_SESSION["vehicleType"] = $_GET["vehicleType"];
        $_SESSION["minPrice"] = $_GET["minPrice"];
        $_SESSION["maxPrice"] = $_GET["maxPrice"];

    } else{ // if click from hyperlink

        $_SESSION["startDate"] = "";
        $_SESSION["endDate"] = "";
        $_SESSION["vehicleType"] = "all";
        $_SESSION["minPrice"] = "1300";
        $_SESSION["maxPrice"] = "9800";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation</title>
    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <link rel="stylesheet" href="checkAvailability3.css">
    <!-- <script src="checkAvailability.js"></script> -->


</head>
<body>
    <!-- navBar -->
    <div class="navBar">
        <div class="logo">
            <a href="<?=$logoHyperlink?>"><img class="logo" src="images/logo.jpeg"></a>
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

    <!-- check availability form -->
    <div class="checkAvailability">
        <img src="https://res.klook.com/image/upload/car-rental/car-rental-banner.webp" alt="">
        <?php
        if(isset($_GET["username"])){ // check if logged in or not
            ?>
        
        <div class="form">
            <div class="container1">
                <form action="checkAvailability.php?username=<?=$_GET["username"]?>" method="post" autocomplete="off" class="reservation">
                    <table>
                        <tr>
                            <td><label for="startDate">Start Date: </label></td>
                            <td><input type="date" name="startDate" id="startDate" required></td>
                        </tr>
                        <tr>
                            <td><label for="endDate">End Date: </label></td>
                            <td><input type="date" name="endDate" id="endDate" required></td>
                        </tr>
                        <tr>
                            <td><label for="vehicleType">Select type of vehicle: </label></td>
                            <td>
                                <select name="vehicleType" id="vehicleType">
                                    <option value="all" id="all">All types</option>
                                    <option value="luxurious" id="luxurious">Luxurious Car</option>
                                    <option value="sports" id="sports">Sports Car</option>
                                    <option value="classics" id="classics">Classics Car</option>
                                </select>
                            </td>
                        </tr>
                    </table>  
            </div>
            
            <script>
                // this is to retain the information (date, type of vehicles) entered by the user
                <?php
            
                if(isset($_POST["submit1"]) || isset($_POST["submit2"])){ // if form is submitted from index.php
                ?>

                    document.querySelector("#<?=$_POST["vehicleType"]?>").selected = true;
                    document.querySelector("#startDate").value = "<?=$_POST["startDate"]?>";
                    document.querySelector("#endDate").value = "<?=$_POST["endDate"]?>";

                <?php
                } else{  // if click change from details.php
                    
                    ?>
                    document.querySelector("#<?=$_SESSION["vehicleType"]?>").selected = true;
                    document.querySelector("#startDate").value = "<?=$_SESSION["startDate"]?>";
                    document.querySelector("#endDate").value = "<?=$_SESSION["endDate"]?>";
                    
                    <?php
                }
                ?>
               
            </script>

            <!-- price slider -->
            <div class="sliderContainer">
                <h4>Price Range</h4>
                <div class="priceContent">
                    <div>   
                        <label for="minPrice">Min</label>
                        <p id="minValue">MYR 1350</p>
                    </div>

                    <div>
                        <label for="minPrice">Max</label>
                        <p id="maxValue">MYR 9800</p>
                    </div>
                </div>
              
                <div class="slider">
                    <input type="range" name="minPrice" id="minPrice" value="1350" min="1001" max="9999" step="10" class="inputRange">

                    <input type="range" name="maxPrice" id="maxPrice" value="9800" min="1001    " max="9999" step="10" class="inputRange">
                </div>
            </div> 

            <script>
                <?php
                if(isset($_POST["submit2"])){ // if submit form from checkAvailability.php
                    ?>
                    document.getElementById("minPrice").value = "<?=$_SESSION['minPrice']?>";
                    document.getElementById("maxPrice").value = "<?=$_SESSION['maxPrice']?>";
                    
                    <?php
                } else{ // if click change from details.php
                    ?>
                    
                    document.querySelector("#minPrice").value = "<?=$_SESSION['minPrice']?>";
                    document.querySelector("#maxPrice").value = "<?=$_SESSION['maxPrice']?>";
                    <?php

                }
                
                ?>
            </script>

            <script>

                let min = document.getElementById("minValue");
                let max = document.getElementById("maxValue");

                function validateRange(minPrice, maxPrice){
                    if(minPrice > maxPrice){
    
                        //swap values
                        let tempValue = maxPrice;
                        maxPrice = minPrice;
                        minPrice = tempValue;
                    }
    
                    min.innerHTML = "MYR " + minPrice;
                    max.innerHTML = "MYR " + maxPrice;
                };
    
                const inputElements = document.querySelectorAll(".inputRange");
                console.log(inputElements);
                console.log(inputElements[0].value);
                console.log(inputElements[1].value);
                inputElements.forEach((element) => {
                    element.addEventListener("change", (e) => {
                    let minPrice = parseInt(inputElements[0].value);
                    let maxPrice = parseInt(inputElements[1].value);
                        
                    validateRange(minPrice, maxPrice);
                       
                    });
                });
    
                validateRange(inputElements[0].value, inputElements[1].value);
                
                
            </script>
            
            <div class="checkAvailabilityBtn">
                <input type="submit" name="submit2" value="Check Availability" class="checkAvailabilityBtn"><br>
                <p class="alertCheckAvailability" hidden="true">Please check availability first</p>
            </div>
               
            </form>
        </div>
    </div>
    <div class="mainContainer">
        <div class="carDetails">
            <div class="divContainer">
                <h2 class="carName"></h2>
                <img src="" alt="" class="carImg">
                <table class="carInfo">
                    <tr>
                        <td class="label">Car ID: </td>
                        <td class="details carID"></td>
                    </tr>
                    <tr>
                        <td class="label">Type: </td>
                        <td class="details type"></td>
                    </tr>
                    <tr>
                        <td class="label">Color: </td>
                        <td class="details color"></td>
                    </tr>
                    <tr>
                        <td class="label">Rental: </td>
                        <td class="details rental"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="displayCars">
            <!-- images are appended using JavaScript dom element -->
        </div>
    </div>
    
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["submit1"])){ // if check availability button is pressed from index.php (no minPrice/maxPrice)

            if($_POST["vehicleType"] == "all"){ // if select all types of vehicle
    
                $sql = 
                    "SELECT DISTINCT `name` 
                    FROM `cars` c 
                    LEFT JOIN `reservation` r 
                        ON c.car_id = r.car_id 
                    WHERE rs_start_date IS NULL AND rs_end_date IS NULL OR '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '". $_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'; ";
                
            }
            else{ // if select luxurious/sports/classics
        
                $sql = 
                    "SELECT DISTINCT `name` 
                    FROM `cars` c 
                    LEFT JOIN `reservation` r 
                        ON c.car_id = r.car_id 
                    WHERE `type` = '". $_SESSION['vehicleType'] . "' AND rs_start_date IS NULL AND rs_end_date IS NULL OR `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND `type` = '". $_SESSION['vehicleType'] . "' AND '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'; ";
        
            }
        } else if(isset($_POST["submit2"])){ // if check availability button is pressed from checkAvailability.php (got minPrice/ maxPrice)

            if($_POST["vehicleType"] == "all"){ // if select all types of vehicle
        
                $sql = 
                    "SELECT DISTINCT `name` 
                    FROM `cars` c 
                    LEFT JOIN `reservation` r 
                        ON c.car_id = r.car_id 
                    WHERE `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND (rs_start_date IS NULL AND rs_end_date IS NULL OR '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '". $_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'); ";
    
            }
            else{ // if select luxurious/sports/classics
        
                $sql = 
                    "SELECT DISTINCT `name` 
                    FROM `cars` c 
                    LEFT JOIN `reservation` r 
                        ON c.car_id = r.car_id 
                    WHERE `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND (`type` = '". $_SESSION['vehicleType'] . "' AND rs_start_date IS NULL AND rs_end_date IS NULL OR `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND `type` = '". $_SESSION['vehicleType'] . "' AND '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'); ";
        
            }
        }

    } else if($_SESSION["vehicleType"] == "all"){ // if click change from details.php

        $sql = 
            "SELECT DISTINCT `name` 
            FROM `cars` c 
            LEFT JOIN `reservation` r 
                ON c.car_id = r.car_id 
            WHERE `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND (rs_start_date IS NULL AND rs_end_date IS NULL OR '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '". $_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'); ";

    } else{

        $sql = 
            "SELECT DISTINCT `name` 
            FROM `cars` c 
            LEFT JOIN `reservation` r 
                ON c.car_id = r.car_id 
            WHERE `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND (`type` = '". $_SESSION['vehicleType'] . "' AND rs_start_date IS NULL AND rs_end_date IS NULL OR `rental` BETWEEN '". $_SESSION['minPrice'] ."' AND '". $_SESSION['maxPrice'] ."' AND `type` = '". $_SESSION['vehicleType'] . "' AND '". $_SESSION['startDate']."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND '". $_SESSION['endDate'] ."' NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."' AND `rs_end_date` NOT BETWEEN '".$_SESSION['startDate'] ."' AND '". $_SESSION['endDate']."'); ";
    }

        /*
        SELECT * 
        FROM cars c 
        LEFT JOIN reservation r -- use left join to return every record of cars even though there's no reservation for that car
            ON c.car_id = r.car_id 
        WHERE (type = "luxurious" -- select that particular vehicle type
        AND rs_start_date NOT BETWEEN "2023-03-14" AND "2023-03-16" AND rs_end_date NOT BETWEEN "2023-03-14" AND "2023-03-16") -- select those dates don't match the reserved date
        OR
        (type = "luxurious" AND rs_start_date IS NULL AND rs_end_date IS NULL); -- select those vehicles which don't have a reservation

        SELECT DISTINCT `name` FROM `cars` c LEFT JOIN `reservation` r ON c.car_id = r.car_id WHERE `rental` BETWEEN "1400" AND "8000" AND rs_start_date IS NULL AND rs_end_date IS NULL OR "2023-03-01" NOT BETWEEN `rs_start_date` AND `rs_end_date` AND "2023-03-02" NOT BETWEEN `rs_start_date` AND `rs_end_date` AND `rs_start_date` NOT BETWEEN "2023-03-01" AND "2023-03-02" AND `rs_end_date` NOT BETWEEN "2023-03-01" AND "2023-03-02";
        */
    
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
    
    $imageClass = array( //store the class for every image
        "Rolls Royce Phantom" => "rollsRoyce",
        "Bentley Continental Flying Spur" => "bentleyContinental",
        "Mercedes Benz CLS 350" => "mercedesBenz",
        "Jaguar S Type" => "jaguarS",
        "Ferrari F430 Scuderia" => "ferrariScuderia",
        "Lamborghini Murcielago LP640" => "lamborghiniMurcielago",
        "Porsche Boxster" => "porscheBoxster",
        "Lexus SC430" => "lexusSC430",
        "Jaguar MK 2" => "jaguarMK2",
        "Rolls Royce Silver Spirit Limousine" => "rollsRoyceSilver",
        "MG TD" => "mgTD"
    );
       
    if($sql_run = $conn->query($sql)){ // query the SQL statement
        if($sql_run->num_rows > 0){
            while($row = $sql_run->fetch_assoc()){
            ?>
                <script>
                        
                    // create <div> container for each image
                    var divNode = document.createElement('div'); //create a div element
                    divNode.className = "imageContainer"; // set div class to divContainer
    
                    console.log(divNode);
    
                    // create <img>
                    var imageNode = document.createElement('img'); //use var here, because the variable 'imageNode' needs to be changed every loop
                    imageNode.className = "<?= $imageClass[$row['name']]?>" // set imageNode class
                    imageNode.setAttribute('src', '<?= $imageLinks[$row['name']]?>'); // set imageNode img attribute to the absolute link
                    imageNode.setAttribute('onmouseover', 'imageRollOver(this); showDetails(this, imageClassToName)');
                    imageNode.setAttribute('onmouseout', 'imageMouseAway(this); removeDetails(this)');
                        
                    console.log(imageNode);  
                    divNode.appendChild(imageNode); // append to the div element
                        
                    console.log(divNode);
    
                    // create reserve <button>
                    var buttonNode = document.createElement('button');
                    buttonNode.className = "<?= $imageClass[$row['name']]?>Btn";
                    buttonNode.textContent = "Reserve";
                    buttonNode.setAttribute('onmouseover', 'buttonRollOver(this); showDetails(this, buttonClassToName)');
                    buttonNode.setAttribute('onmouseout', 'removeDetails(this)');

                    <?php
                    if(!($_SESSION["startDate"] == "" && $_SESSION["endDate"] == "")){
                        ?>
                        buttonNode.setAttribute('onclick', "location.href='details.php?username=<?= $_GET["username"]?>&car=<?= $row['name']?>&vehicleType=<?=$_SESSION['vehicleType']?>&startDate=<?= $_SESSION['startDate']?>&endDate=<?= $_SESSION['endDate']?>&minPrice=<?=$_SESSION['minPrice']?>&maxPrice=<?=$_SESSION['maxPrice']?>'"); // this line is important, to transport all the details, i.e. username, car, startDate and endDate to the details page
                        <?php
                    } 
                    else{
                        ?>
                        buttonNode.setAttribute('onclick', 'document.querySelector(".alertCheckAvailability").hidden = false');
                        <?php
                    }
                    ?>
                    buttonNode.style.visibility = "hidden";
                    // buttonNode.hidden = "true";
                    console.log(buttonNode);
                    divNode.appendChild(buttonNode);
    
                    // create <p> for car name
                    var paraNode = document.createElement('p');
                    paraNode.className = "<?= $imageClass[$row['name']]?> Title";
                    paraNode.textContent = "<?= $row['name']?>";
                    paraNode.style.textAlign = "center";
                    divNode.appendChild(paraNode);
    
                    document.querySelector(".displayCars").appendChild(divNode);
    
                </script>

                <?php
            }
        }
        else{
            ?>
            <p class="notAvailable">No cars available</p>
            <?php
        }
    }
    ?>
    
    <script>
    
        function imageRollOver(my_image){
            my_image.style.opacity = "0.5";
            console.log(my_image.className); // my_image here = this
            // console.log(document.getElementsByClassName(`${my_image.className}Btn`));
            document.querySelector(`.${my_image.className}Btn`).style.visibility = "visible";
        }

        function imageMouseAway(my_image){
            
            my_image.style.opacity = "1.0";
            document.querySelector(`.${my_image.className}Btn`).style.visibility = "hidden";
                
        }
    
        function buttonRollOver(my_button){
            my_button.style.visibility = "visible";
            let imageClass = my_button.className.substring(0, my_button.className.length-3); // this line is to get the imageClass name, i.e. "rollsRoyceBtn" -> "rollsRoyce"
            document.querySelector(`.${imageClass}`).style.opacity = "0.5";
        }

        // now there's two elements in the image container, <img> and <button>, both need to be considered.
        let imageClassToName = {
            "rollsRoyce" : "Rolls Royce Phantom",
            "bentleyContinental" : "Bentley Continental Flying Spur",
            "mercedesBenz" : "Mercedes Benz CLS 350",
            "jaguarS" : "Jaguar S Type",
            "ferrariScuderia" : "Ferrari F430 Scuderia",
            "lamborghiniMurcielago" : "Lamborghini Murcielago LP640",
            "porscheBoxster" : "Porsche Boxster",
            "lexusSC430" : "Lexus SC430",
            "jaguarMK2" : "Jaguar MK 2",
            "rollsRoyceSilver" : "Rolls Royce Silver Spirit Limousine",
            "mgTD" : "MG TD"
        };

        let buttonClassToName = {
            "rollsRoyceBtn" : "Rolls Royce Phantom",
            "bentleyContinentalBtn" : "Bentley Continental Flying Spur",
            "mercedesBenzBtn" : "Mercedes Benz CLS 350",
            "jaguarSBtn" : "Jaguar S Type",
            "ferrariScuderiaBtn" : "Ferrari F430 Scuderia",
            "lamborghiniMurcielagoBtn" : "Lamborghini Murcielago LP640",
            "porscheBoxsterBtn" : "Porsche Boxster",
            "lexusSC430Btn" : "Lexus SC430",
            "jaguarMK2Btn" : "Jaguar MK 2",
            "rollsRoyceSilverBtn" : "Rolls Royce Silver Spirit Limousine",
            "mgTDBtn" : "MG TD"
        };

        let imageLinks = {
            "Rolls Royce Phantom" : "images/cars/rolls_royce_phantom.png",
            "Bentley Continental Flying Spur" : "images/cars/bentley_continental.png",
            "Mercedes Benz CLS 350" : "images/cars/mercedes_benz.png",
            "Jaguar S Type" : "images/cars/jaguar_s.png",
            "Ferrari F430 Scuderia" : "images/cars/ferrari_scuderia.png",
            "Lamborghini Murcielago LP640" : "images/cars/lamborghini.png",
            "Porsche Boxster" : "images/cars/porsche_boxster.png",
            "Lexus SC430" : "images/cars/lexus.png",
            "Jaguar MK 2" : "images/cars/jaguar_mk2.png",
            "Rolls Royce Silver Spirit Limousine" : "images/cars/rolls_royce_silver_spirit.png",
            "MG TD" : "images/cars/mg_td.png"
        };
        

        // function to show car details when hover
        // parameter 1: my_element, because this element could be image or button when hover around
        // parameter 2: if image, use imageClassToName; if button, use buttonClassToName
        function showDetails(my_element, array){

            document.querySelector(".divContainer").style.visibility = "visible";
            var carName = array[`${my_element.className}`];
            document.querySelector(".carName").innerHTML = carName;

            var imageNode = document.querySelector(".carImg");
            imageNode.setAttribute('src', `${imageLinks[carName]}`);
          
            if(my_element.className == "rollsRoyce" || my_element.className == "rollsRoyceBtn"){
                document.querySelector(".carID").innerHTML = "c1000";
                document.querySelector(".type").innerHTML = "Luxurious";
                document.querySelector(".color").innerHTML = "Blue";
                document.querySelector(".rental").innerHTML = "MYR 9800.00";
            }

            else if(my_element.className == "bentleyContinental" || my_element.className == "bentleyContinentalBtn"){
                document.querySelector(".carID").innerHTML = "c1001";
                document.querySelector(".type").innerHTML = "Luxurious";
                document.querySelector(".color").innerHTML = "White";
                document.querySelector(".rental").innerHTML = "MYR 4800.00";
            }

            else if(my_element.className == "mercedesBenz" || my_element.className == "mercedesBenzBtn"){
                document.querySelector(".carID").innerHTML = "c1002";
                document.querySelector(".type").innerHTML = "Luxurious";
                document.querySelector(".color").innerHTML = "Silver";
                document.querySelector(".rental").innerHTML = "MYR 1350.00";
            }

            else if(my_element.className == "jaguarS" || my_element.className == "jaguarSBtn"){
                document.querySelector(".carID").innerHTML = "c1003";
                document.querySelector(".type").innerHTML = "Luxurious";
                document.querySelector(".color").innerHTML = "Champagne";
                document.querySelector(".rental").innerHTML = "MYR 1350.00";
            }

            else if(my_element.className == "ferrariScuderia" || my_element.className == "ferrariScuderiaBtn"){
                document.querySelector(".carID").innerHTML = "c1004";
                document.querySelector(".type").innerHTML = "Sports";
                document.querySelector(".color").innerHTML = "Red";
                document.querySelector(".rental").innerHTML = "MYR 6000.00";
            }

            else if(my_element.className == "lamborghiniMurcielago" || my_element.className == "lamborghiniMurcielagoBtn"){
                document.querySelector(".carID").innerHTML = "c1005";
                document.querySelector(".type").innerHTML = "Sports";
                document.querySelector(".color").innerHTML = "Matte Black";
                document.querySelector(".rental").innerHTML = "MYR 7000.00";
            }

            else if(my_element.className == "porscheBoxster" || my_element.className == "porscheBoxsterBtn"){
                document.querySelector(".carID").innerHTML = "c1006";
                document.querySelector(".type").innerHTML = "Sports";
                document.querySelector(".color").innerHTML = "White";
                document.querySelector(".rental").innerHTML = "MYR 2800.00";
            }

            else if(my_element.className == "lexusSC430" || my_element.className == "lexusSC430Btn"){
                document.querySelector(".carID").innerHTML = "c1007";
                document.querySelector(".type").innerHTML = "Sports";
                document.querySelector(".color").innerHTML = "Black";
                document.querySelector(".rental").innerHTML = "MYR 1600.00";
            }

            else if(my_element.className == "jaguarMK2" || my_element.className == "jaguarMK2Btn"){
                document.querySelector(".carID").innerHTML = "c1008";
                document.querySelector(".type").innerHTML = "Classics";
                document.querySelector(".color").innerHTML = "White";
                document.querySelector(".rental").innerHTML = "MYR 2200.00";
            }

            else if(my_element.className == "rollsRoyceSilver" || my_element.className == "rollsRoyceSilverBtn"){
                document.querySelector(".carID").innerHTML = "c1009";
                document.querySelector(".type").innerHTML = "Classics";
                document.querySelector(".color").innerHTML = "Georgian Silver";
                document.querySelector(".rental").innerHTML = "MYR 3200.00";
            }

            else if(my_element.className == "mgTD" || my_element.className == "mgTDBtn"){
                document.querySelector(".carID").innerHTML = "c1010";
                document.querySelector(".type").innerHTML = "Classics";
                document.querySelector(".color").innerHTML = "Red";
                document.querySelector(".rental").innerHTML = "MYR 2500.00";
            }
        }

        function removeDetails(my_element){
            document.querySelector(".divContainer").style.visibility = "hidden";
        }

           
    </script>
    <?php
    } 
    ?>
</body>
</html>