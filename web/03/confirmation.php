<?php 
  error_reporting(E_WARNING | E_ERROR | E_PARSE);
  session_start();
  
  require 'catalog.php';
  $_SERVER["REQUEST_METHOD"] == "POST" or die;

  isset($_POST["buyer-name"]) or die;
  isset($_POST["buyer-street"]) or die;
  isset($_POST["buyer-city"]) or die;
  isset($_POST["buyer-state"]) or die;
  isset($_POST["buyer-zip"]) or die;

  $buyerName = cleanup($_POST["buyer-name"]);
  $buyerStreet = cleanup($_POST["buyer-street"]);
  $buyerCity = cleanup($_POST["buyer-city"]);
  $buyerState = cleanup($_POST["buyer-state"]);
  $buyerZip = cleanup($_POST["buyer-zip"]);

  function cleanup($input) {
    $input = trim($input); // a la https://www.w3schools.com/php/showphp.asp?filename=demo_form_validation_complete
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
?>
<!doctype html>
<html>
  <head>
  <?php require 'header_include.php' ?>
  <title>Confirmation</title>
  </head>
  <body>
  <?php require 'navigation_include.php' ?>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <h1>Order Confirmation</h1>
          <p>Your order has been confirmed. Here are the details for your records.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm">
          <h2>Items Ordered</h2>
          <?php require 'render_cart.php';
  renderCart(false);
?>
        </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <h2>Shipping Info</h2>
              <div class="row">
                <div class="col-sm-1">
                  <strong>Name:</strong>
                </div>
                <div class="col-sm-11">
                  <?php echo $buyerName ?>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-1">
                  <strong>Address:</strong>
                </div>
                <div class="col-sm-11">
                  <?php echo $buyerStreet ?><br />
                  <?php echo "$buyerCity, $buyerState $buyerZip" ?>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
