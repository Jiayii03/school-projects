<?php

    /**
     * staff:
     * staff log in to check availability, 
     * make new reservation, 
     * key in customer details,
     * edit or delete reservation.
     * 
     * customer:
     * check reservation status and details using reservation id
     * check in and check out system
     */


    require "db/DBCreateDatabase.php"; // this file creates a database called `car_reservation_db`, after connecting to the localhost
    require "db/DBCreateStaffTable.php"; // require "DBConnected.php", creates a table called `staff`
    require "db/DBCreateCarsTable.php"; // require "DBConnected.php", creates a table called `cars`
    require "db/DBCreateCustomerTable.php"; // require "DBConnected.php", creates a table called `customer`
    require "db/DBCreateReservationTable.php"; // require "DBConnected.php", creates a table called `reservation`

    session_start(); // for reservation form submission

    $showLogInAlert = false;

    if(isset($_GET["username"])){ // if the page is logged in

        $formAction = "checkAvailability.php?username=".$_GET["username"]; // direct to newReservation.php upon submit check availability
        $logoHyperlink = "index.php?username=" .$_GET["username"];

    }
    else{
        $formAction = "index.php"; // if not logged in, stay in index.php
        $logoHyperlink = "index.php";
    }

    //----------reservation form submission---------------
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST["startDate"])){ // if the check availability form is submitted
            require "db/DBConnected.php";
    
            if(isset($_GET["username"])){ // if the page is logged in
                $_SESSION["startDate"] = $_POST["startDate"]; // start a session
            }
    
            else{ // if the page is not logged in
                $showLogInAlert = true;
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
    <title>Car Rental Booking</title>
    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <script src="index.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    
    <!-- navBar -->
    <div class="navBar">
        <div class="logo">
            <a href="<?=$logoHyperlink?>"><img class="logo" src="images/logo.jpeg"></a>
        </div>

        <div class="navLinks">
            <?php
            if(isset($_GET["username"])){
                ?>
                <div class="hyperlink1">
                    <a class="hyperlink1" href="index.php?username=<?=$_GET['username']?>" style="">Index Page</a>
                </div>
                <div class="hyperlink2">
                    <a class="hyperlink2" href="checkAvailability.php?username=<?=$_GET['username']?>">Check Availability</a>
                </div>
                <div class="hyperlink3">
                    <a class="hyperlink3" href="records.php?username=<?=$_GET['username']?>&viewReservation">View All Records</a>
                </div>
            <?php
            } 
            else{
                ?>
                <div class="hyperlink3">
                    <a class="hyperlink3" href="qr-scanner/checkReservation.php">Check Reservation</a>
                </div>
                <?php
            }
            ?>
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

    <div class="container">
        <!-- header -->
        
        <header>
            <div class="banner" id="head">
                <img src="images/banner/banner_image_1.jpg" alt="" class="slide">
                <img src="images/banner/banner_image_2.jpg" alt="" class="slide">
                <img src="images/banner/banner_image_3.jpg" alt="" class="slide">
                <img src="images/banner/banner_image_4.jpg" alt="" class="slide">

                <script>
                    // banner slideshow
                    var index = 0;//number of looping//
                    var i = 0;
                    var images = document.getElementsByClassName("slide");

                    auto();

                    function show(n){
                        for(i = 0;i < images.length; i++){
                            images[i].style.display = "none";
                        }
                        images[n-1].style.display = "block";
                    }
                    function auto(){
                        index++;
                        if(index > images.length){
                        index = 1;
                        }
                        show(index);
                        setTimeout(auto,2500);
                    }
                </script>
                
                <div class="selectDate">
                    <form action="<?= $formAction?>" method="post" autocomplete="off" class="reservation">
                        <label id="startDate" for="startDate">Start Date: </label>
                        <input type="date" name="startDate" id="startDate" >
                
                        <label for="endDate">End Date: </label>
                        <input type="date" name="endDate" id="endDate" >
                        
                        <label for="vehicleType">Select type of vehicle: </label>
                        <select name="vehicleType" id="vehicleType" >
                            <option value="all" id="all">All types</option>
                            <option value="luxurious" id="luxurious">Luxurious Car</option>
                            <option value="sports" id="sports">Sports Car</option>
                            <option value="classics" id="classics">Classics Car</option>
                        </select>
                
                        <input type="submit" name="submit1" value="Check Availability" class="checkAvailability">
                    </form>
                        <?php
                        if($showLogInAlert){ // if form is submitted but not logged in
                            echo '<h3>Please Log In First</h3>';
                        }
                        ?>
                    <div class="title">
                        <div>
                            <h3 class="titleHeader">Online Car Rental</h3>
                        </div>
                        <div>
                            <h2 class="anywhere">Anywhere,</h2>
                        </div>
                        <div>
                            <h2 class="anytime">Anytime</h2>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="brands">
            <div class="brands-header">
                <h1>Paid partnership:</h1>
                <marquee behavior="scroll" width="100%" direction="left" height="140px" scrollamount="7">
                    <img style="margin-right: 35px" src="images/logo/rolls_royce_logo.png" width="120" height="105" alt="Rolls Royce Logo"/>
                    <img style="margin-right: 35px" src="images/logo/ferrari_logo.png" width="170" height="100" alt="Ferrari Logo" class="logo"/>
                    <img style="margin-right: 35px" src="images/logo/bentley_logo.png" width="140" height="100" alt="Bentley Logo" class="logo"/>
                    <img style="margin-right: 35px" src="images/logo/mercedes_logo.png" width="170" height="100" alt="Mercedes Logo" class="logo"/>
                    <img style="margin-right: 60px" src="images/logo/lamborghini_logo.png" width="90" height="95" alt="Lamborghini Logo" class="logo"/>
                    <img style="margin-right: 60px" src="images/logo/porsche_logo.png" width="220" height="95" alt="Porsche Logo" class="logo"/>
                    <img style="margin-right: 60px" src="images/logo/tesla_logo.png" width="90" height="90" alt="Tesla Logo" class="logo"/>
                </marquee>
            </div> 
        </div>
        <br><br>

        <!-- short about us page-->
        <div class="aboutUs" id="aboutUs">
            <div class="info">
                <h1>About M.Car</h1><br>
                <p>Welcome to Group 6's car rental! We are a trusted provider of rental cars for both personal and business use. Whether you need a vehicle for a family vacation or a business trip, we have a wide range of options to choose from.</p><br>
                
                <p>Our fleet of cars includes everything from <a href="#luxurious-car">luxurious</a>, <a href="#sports-car">sports</a> and <a href="#classic-car">classic</a> cars, ensuring that we have a vehicle that fits your needs and budget.</p><br>
                <p>With our easy booking process and competitive prices, renting a car has never been easier. We strive to provide our customers with exceptional service and reliable vehicles, so you can enjoy your journey with peace of mind.</p>
                </div>
            <img src="images/aboutus.png" alt="About Us"/>
        </div>
        <br><br><br>
        
        <div class="OurCars">
            <img src="images/mountain.png" class="mountain"/>
            <img src="images/trees.png" class="trees"/>
            <h1 class="shadow-animation">Our Cars</h1>
        </div>
        <section class ="container-section">
            <div id="luxurious-car"> <h1 class="heading">Luxurious Cars</h1>
                <section class="horizontal">
                    <article>
                        <img src="images/cars/rolls_royce_phantom.png" alt="Rolls Royce Phantom" class="cars"/>
                        <p>
                            <b>Rolls Royce Phantom</b>
                            <br>Colour: Blue – RM 9800 per day
                        </p>
                    </article>
                    <article>
                        <img src="images/cars/bentley_continental.png" alt="Bentley Continental Flying Spur" class="cars"/>
                        <p>
                            <b>Bentley Continental Flying Spur</b>
                            <br>Colour: White - RM 4800 per day
                        </p>
                    </article>
                    <article>
                        <img src="images/cars/mercedes_benz.png" alt="Mercedes Benz CLS 350" class="cars"/>
                        <p>
                            <b>Mercedes Benz CLS 350</b>
                            <br>Colour: Silver - RM 1350 per day
                        </p>
                    </article>
                    <article>
                        <img src="images/cars/jaguar_s.png" alt="Jaguar S Type" class="cars"/>
                        <p>
                            <b>Jaguar S Type</b>
                            <br>Colour: Champagne - RM 1350 per day
                        </p>
                    </article>
                </section>
            </div>
            <br>

            <div id="sports-car"> <h1 class="heading">&nbsp;&nbsp;Sports Cars&nbsp;&nbsp;</h1></div>
            <section class="horizontal">
                <article>
                    <img src="images/cars/ferrari_scuderia.png" alt="Ferrari F430 Scuderia" class="cars" width="100px"/>
                    <p>
                        <b>Ferrari F430 Scuderia</b>
                        <br>Colour: Red - RM 6000 per day
                    </p>
                </article>
                <article>
                    <img src="images/cars/lamborghini.png" alt="Lamborghini Murcielago LP640" class="cars" width="100px"/>
                    <p>
                        <b>Lamborghini Murcielago LP640</b>
                        <br>Colour: Matte Black - RM 7000 per day
                    </p>
                </article>
                <article>
                    <img src="images/cars/porsche_boxster.png" alt="Porsche Boxster" class="cars" />
                    <p>
                        <b>Porsche Boxster</b>
                        <br>Colour: White - RM 2800 per day
                    </p>
                </article>
                <article>
                    <img src="images/cars/lexus.png" alt="Lexus SC430" class="cars"/>
                    <p>
                        <b>Lexus SC430</b>
                        <br>Colour: Black - RM 1600 per day
                    </p>
                </article>
                </section>

                <div id="classic-car"> <h1 class="heading">&nbsp;&nbsp;Classic Cars&nbsp;&nbsp;</h1>
                    <section class="horizontal last">
                        <article>
                            <img src="images/cars/jaguar_mk2.png" alt="Jaguar MK 2" class="cars" style="width: 80%; height: 70%"/>
                            <p>
                                <b>Jaguar MK 2</b>
                                <br>Colour: White - RM 2200 per day
                            </p>
                        </article>
                        <article>
                            <img src="images/cars/rolls_royce_silver_spirit.png" alt="Rolls Royce Silver Spirit Limousine" class="cars" style="width: 80%; height: 70%"/>
                            <p>
                                <b>Rolls Royce Silver Spirit Limousine</b>
                                <br>Colour: Georgian Silver - RM 3200 per day
                            </p>
                        </article>
                        <article>
                            <img src="images/cars/MG_TD.png" alt="MG TD" class="cars" style="width: 80%; height: 70%"/>
                            <p>
                                <b>MG TD</b>
                                <br>Colour: Red - RM 2500 per day
                            </p>
                        </article>
                    </section>
                </div>
                <a href="#head"><button class="go-back">Back to Availability</button></a>

                <div class="statistics">
                    <div class="stats">
                        <img src="images/rentals.png" name="Flexible Rentals" />
                        <div class="inner-stats">
                            <h2>Flexible rentals</h2>
                            <p>Cancel or change most bookings for free<br>up to 48 hours before pick-up</p>
                        </div>
                    </div>
                    <div class="stats">
                        <img src="images/fees.png" name="No Hidden Fees" />
                        <div class="inner-stats">
                            <h2>No hidden fees</h2>
                            <p>Know exactly what you’re paying</p>
                        </div>
                    </div>
                </div>

                <div id="FAQ">
                <h1 class="frequently-asked">FAQ</h1>
                    <details>
                        <summary>How old do I need to be to rent a car?</summary>
                        <p>Like many rental companies, you must be at least 21 years of age to rent a car, and any driver under 25 may have to pay a Young Driver Fee. You may check the terms and conditions to see if your age would make any difference.</p>
                    </details>
                    <details>
                        <summary>What documents do I need to provide to rent a car?</summary>
                        <p>You will need to provide</p>
                        <ul>
                            <li>Valid driver's license</li>
                            <li>A credit card, or any payment method used</li>
                            <li>Proof of insurance</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Do I need to pay a security deposit or additional fee?</summary>
                        <p>No security deposit is required. You will only be charged additional fees if you:</p>
                        <ul>
                            <li>Exceed the given mileage</li>
                            <li>Incur summons</li>
                            <li>Damage the car</li>
                            <li>Leave the car in a non-hygienic manner (smoke smell, stains, etc)</li>
                            <li>Did not adhere to our Terms and Conditions</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Can I rent a car if I'm traveling internationally?</summary>
                        <p>Yes, but you may need to provide additional documentation (such as an international driver's license) and be aware of any local laws or driving regulations.</p>
                    </details>
                </div>


                <div id="contact-us">
                    <h1>Contact Us</h1><br>
                    <form action="mailto:info@mcars.com">
                        <input type="text" name="name" placeholder="Your Name">
                        <input type="email" name="mail" placeholder="Your email"><br />
                        <textarea name="comment" rows="5" cols="50" placeholder="Your Message"></textarea><br /><br />
                        <input type="submit" value="Submit" class="submitFeedback">
                        <input type="reset" value="Reset" class="resetFeedback">
                    </form>
                </div>
                <br><br>

            <section class="footer-container">
                <div class="footer">
                    <div class="footer-heading-1">
                        <h2>Our Company</h2>
                            <ul class="footer-list1">
                                <li><a href="#aboutUs" class="hyperlink2">About Us</a></li>
                                <li><a href="#" class="hyperlink2">Terms & Conditions</a></li>
                                <li><a href="#" class="hyperlink2">Privacy Policy</a></li>
                                <li><a href="#" class="hyperlink2">Career</a></li>
                            </ul>
                    </div>
                    <div class="footer-heading-2">
                        <h2>Help & Support</h2>
                            <ul class="footer-list2">
                                <li><a href="#FAQ" class="hyperlink2">FAQ</a></li>
                                <li><a href="#contact-us" class="hyperlink2">Contact Us</a></li>
                                <li><a href="#" class="hyperlink2">Refunds</a></li>
                                <li><a href="#head" class="hyperlink2">Availability</a></li>
                                <li><a href="#" class="hyperlink2">Payment Methods</a></li>
                        </ul>
                    </div>
                    <div class="footer-heading-3">
                        <h2>Our Cars</h2>
                            <ul class="footer-list3">
                                <li><a href="#luxurious-car" class="hyperlink3">Luxurious Cars</a></li>
                                <li><a href="#sports-car" class="hyperlink3">Sports Cars</a></li>
                                <li><a href="#classic-car" class="hyperlink3">Classic Cars</a></li>
                            </ul>
                    </div>
                    <div class="footer-heading-4">
                        <div>
                            <img title="MCar" src="images/logo.jpeg" class="logo1"/>
                        </div>
                        <div>
                            <h2>Find us on: </h2>
                                <ul class="footer-list4">
                                    <li><a href="https://instagram.com/" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a></li>
                                    <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a></li>
                                </ul>
                        </div>
                    </div>
                </div>
                <div id="footer-row-2">
                        <p>&copy; 2023 Copyright by M.Car</p>
                </div>
            </section>

        </section>
    </div>
   
</body>
</html>