<?php
  
  error_reporting(E_WARNING | E_ERROR | E_PARSE);
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
        <?php 
require 'render_cart.php';
renderCart(true);
?>
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
