<?php
  session_start();
  error_reporting(E_WARNING | E_ERROR | E_PARSE);

  setlocale(LC_MONETARY, 'en_US.UTF-8'); // Per comments in http://php.net/manual/en/function.money-format.php
  require 'catalog.php';

  function sumCartItems($carry, $itemKey) {
    global $catalog;
    $unitPrice = $catalog[$itemKey]["unit-price"];
    return $carry + ($_SESSION["cart"][$itemKey] * $unitPrice);
  }

?>
