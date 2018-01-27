<?php
  session_start();
?>
<!doctype html>
<html>
  <head>
    <?php require 'header_include.php' ?>
    <title>Shopping Cart</title>
  </head>
  <body>
    <?php require 'navigation_include.php' ?>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <h1 class="mt-2">Shopping Cart</h1>
        </div> <!-- col-sm -->
      </div> <!-- row -->
      <div class="row">
        <div class="col-sm">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Item</th>
                <th scope="col">Count</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total Price</th>
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody id="cart-contents">
            <?php 
                require 'catalog.php';
                setlocale(LC_MONETARY, 'en_US.UTF-8'); // Per comments in http://php.net/manual/en/function.money-format.php

                isset($_SESSION["cart"]) or die;
                $cart = $_SESSION["cart"];

                foreach($cart as $item => $count) {
                  $name = getName($item);
                  $price = getPrice($item);
                  $total = $price * $count;
                  $priceStr = money_format('%.2n', $price); // Per comments at http://php.net/manual/en/function.money-format.php
                  $totalStr = money_format('%.2n', $total);
                  echo "<tr><td>$item</td><td>$count</td><td>$priceStr</td><td>$totalStr</td><td><input type='button' class='btn btn-primary remove-item-btn' value='Remove' id='$item' /></td></tr>";
                }

                function getName($item) {
                  global $catalog;
                  $itemDetail = $catalog[$item];
                  return $itemDetail["name"];
                }

                function getPrice($item) {
                  global $catalog;
                  $itemDetail = $catalog[$item];
                  return $itemDetail["unit-price"];
                }
            ?>
            </tbody>
          </table> <!-- table -->
        </div> <!-- col-sm -->
      </div> <!-- row -->
      <div class="row">
        <div class="col-sm text-right">
          <a href="browse.php" class="btn btn-secondary">Back to Catalog</a>
          <a href="checkout.php" class="btn btn-secondary">Checkout</a>
        </div>
      </div> <!-- row -->
    </div> <!-- container -->
    <div class="alert alert-success fixed-bottom" id="success-alert" />
  <?php require 'script_include.php' ?>
  <script src="cart.js"></script>
  </body>
</html>
