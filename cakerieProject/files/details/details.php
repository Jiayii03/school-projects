<?php
session_start();
  if(isset($_GET['customer_id'])){
    require "DBConnection.php";

    $_SESSION['customer_id'] = $_GET['customer_id'];

    $sql = "SELECT * FROM `Customer` WHERE `customer_id` = ". $_GET['customer_id'] . ";";
      
    $sql_run = $conn->query($sql);

    if($sql_run){
      if($sql_run->num_rows > 0){
          $record = $sql_run->fetch_assoc();
      } else echo "No record found for ID: " . $_GET['customer_id'];
    } else echo "Error retrieving record: " . $conn->error;

    $form_action = "DBUpdateRecord.php";

  } else {
    $form_action = "DBInsertRecord.php";
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="details.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/png" href="../../image/favicon.png">
  <title>Details Page</title>
</head>
<body>
  <main class="page payment-page">
    <section class="payment-form dark">
      <div class="container">
        <div class="block-heading">
          <h2>Checkout</h2>
          <p>Please enter your details here</p>
        </div>
        <form action="<?= $form_action; ?>" autocomplete="off" method="post">
          <div class="personal-details">
            <h3 class="title">Personal Details</h3>
            <div class="row">
              <div class="form-group col-sm-7">
                <label for="full-name" class="label">Full Name</label>
                <input id="full-name" class="form-control" type="text" name="name" placeholder="Enter full name here" autocomplete="off" required 
                <?php
                  if(isset($_GET['customer_id'])){
                    ?>
                      value="<?= $record['name'];?>"
                    <?php
                  }
                ?>
                />
              </div>
              <div class="form-group col-sm-5">
                <label for="contact-number" class="label">Contact Number</label>
                <!-- <div class="contact-number"> -->
                <input type="text" class="form-control" id="contact-number" name="contact_number" placeholder="123-4567890" autocomplete="off" 
                <?php
                  if(isset($_GET['customer_id'])){
                    ?>
                      value="<?= $record['contact_number']; ?>"
                    <?php
                  }
                ?>
                />
                </div>
              <!-- </div> -->
              <div class="form-group col-sm-8 email">
              <label for="email" class="label">E-mail</label>
              <input id="email" type="email" name="email" class="form-control email" placeholder="Enter email here" autocomplete="off"
              <?php
                if(isset($_GET['customer_id'])){
                  ?>
                      value="<?= $record['email']; ?>"
                  <?php
                }
              ?>
              />
              </div>
              <div class="form-group col-sm-8">
                <label for="address" class="label">Address</label>
                <input id="address" type="text" name="address" class="form-control" placeholder="Enter address here" autocomplete="off"
                <?php
                  if(isset($_GET['customer_id'])){
                    ?>
                       value="<?= $record['address']; ?>"
                    <?php
                  }
                ?>
                />
              </div>
              <div class="form-group col-sm-4">
                <label for="state" class="label">State</label>
                <input id="state" type="text" name="state" class="form-control" placeholder="Enter your state" autocomplete="off"
                <?php
                  if(isset($_GET['customer_id'])){
                    ?>
                     value="<?= $record['state']; ?>"
                    <?php
                  }
                ?>
                />
              </div>
              <div class="form-group col-sm-12">
                <!-- <button type="button" value="submit" class="btn btn-primary btn-block">Confirm your details</button> -->
                <input type="submit" class="btn btn-primary btn-block" value="Confirm Your Details"><br>
                <div class="backToCart_div">
                  <span class="back">Back To Cart  </span><a href="../cart/cart.html"><span class="backToCart"><i class="fa fa-shopping-cart"></i></span></a>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
</body>
</html>
