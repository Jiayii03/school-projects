<?php
    session_start();

    //------------log in form submission---------------
    $invalid_login = false; //set invalid_login = false first.

    if($_SERVER["REQUEST_METHOD"] == "POST"){

       //----------if it is a log in system form submission-------------
       if(isset($_POST["username"])){ 
           require "../db/DBConnected.php";

           $username = $_POST["username"];
           $password = $_POST["password"];
       
           $sql = "SELECT * FROM `staff`";
   
           if($sql_run = $conn->query($sql)){
               // var_dump($sql_run->fetch_assoc());
               if($sql_run->num_rows > 0){ //if there's any record in the table
                   while($row = $sql_run->fetch_assoc()){ //fetch each record from the table
                       if($username == $row["username"] && $password == $row["password"]){ //if username and password matches
                           header("Location:../index.php?username=" . $_POST["username"]); //direct to the index page with $_GET method
                          
                       }else{
                           $invalid_login = true; // we only want this to be true when login is invalid, i.e. after form submission
                       }
                   }
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
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    <link rel="stylesheet" href="login.css">
    <title>Log In Page</title>
</head>
<body>
    <!-- -------------log in form-------------- -->
    <form action="login.php" method="post" autocomplete="off" class="login">
        <h2>Staff Login</h2>

        <?php
        if($invalid_login == true){ // if login is invalid
            ?>
            <h3>Invalid Login</h3>
            <?php
        }
        ?>

        <label for="username">Username</label>
        <input type="text" name="username" id="username"><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off"><br>

        <button type="submit">Login</button>
        <a href="signup.php" class="sign">Not yet signed up?</a>

    </form>


   
</body>
</html>