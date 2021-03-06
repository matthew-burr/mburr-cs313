<?php 
  require 'helper.php';
  $_SERVER["REQUEST_METHOD"] == "POST" OR die;
  isset($_POST["action"]) or die;

  $action = htmlspecialchars($_POST["action"]);

  switch ($action) {
  case "addItem":
    addItem();
    break;
  case "removeItem":
    removeItem();
    break;
  case "getCatalog":
    getCatalog();
    break;
  case "getGrandTotal":
    getGrandTotal();
  }

  function addItem() {
    isset($_POST["item"]) or die;
    $item = htmlspecialchars($_POST["item"]);

    if (!isset($_SESSION["cart"])) {
      $_SESSION["cart"] = array($item => 1);
    } else {
      $_SESSION["cart"][$item] += 1;
    }

    sendResult("success", "Added item to cart.", $_SESSION["cart"]);
  }

  function removeItem() {
    isset($_POST["item"]) or die;
    $item = htmlspecialchars($_POST["item"]);

    if (isset($_SESSION["cart"])) {
      if (array_key_exists($item, $_SESSION["cart"])) {
        unset($_SESSION["cart"][$item]);
      }
    }

    sendResult("success", "Item removed.");
  }

  function getCatalog() {
    global $catalog;
    sendResult("success", "Retrieved catalog.", $catalog);
  }

  function getGrandTotal() {
    $grandTotal = 0;
    if (isset($_SESSION["cart"])) {
      $grandTotal = array_reduce(array_keys($_SESSION["cart"]), "sumCartItems", $grandTotal);
    }

    sendResult("success", money_format("%.2n", $grandTotal), $grandTotal);
  }

  function sendResult($status, $msg, $content = NULL) {
    $result = array("status" => $status, "message" => $msg);
    if ($content != NULL) {
      $result["content"] = $content;
    }
    $resultJSON = json_encode($result);
    echo $resultJSON;
  }

?>
