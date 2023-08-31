<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require "../db/DBConnected.php";

        $staffId = $_POST['staffId'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $_SESSION['name'] = $name;
        
        $sql = "INSERT INTO staff VALUES ('$staffId', '$name', '$email', '$username', '$password')";

        if($conn->query($sql)){
            // echo "Signed Up Successfully!";
            // header("Location: DBSignUp.php");
        }
        else echo "Error inserting record: " . $conn->error;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>">
    <title>Sign Up Page</title>
</head>
<body>
    <form action="signup.php" method="post" autocomplete="off">
        <label for="staffId">Staff ID</label>
        <input type="text" name="staffId" id="staffId" placeholder="Eg: s1001" required><br>

        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="Type your name" required><br>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Type your email" required><br>

	<div class="line"></div>

        <br><label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Insert username" required><br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Insert password" required><br>

        <button type="submit">Sign Up</button>
	<a href="login.php" class="sign">Already have an account?</a>

	<?php
    	if(isset($_SESSION['name'])){
        	?>
		<div class="success">
        	You are successfully signed up, <?= $_SESSION['name']?>!
		</div>
		<button onclick="location.href='login.php'">Back to login</button>
        	<?php
        	unset($_SESSION['name']);
    	}
    	?>

    </form>

    <?php
    if(isset($_SESSION['name'])){
        ?>
        <h1>You are successfully signed up, <?= $_SESSION['name']?> !</h1>
        <button onclick="location.href='login.php'">Back to login</button>
        <?php
        unset($_SESSION['name']);
    }
    ?>
    
</body>
</html>