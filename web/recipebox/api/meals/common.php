<?php 
// See first tip at http://us3.php.net/manual/en/function.require-once.php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once(__ROOT__.'/api/service.php');
require_once(__ROOT__.'/api/database.php');

// getMeals returns the list of meals, which may be stored in
// a session variable.
function getMeals() {
  if (!isset($_SESSION['MEALS'])) {
    $_SESSION['MEALS'] = getRows('SELECT unnest(enum_range(NULL::meal_type)) AS "name"');
  }
  return $_SESSION['MEALS'];
}
?>
