<?php 
function getMeals() {
  if (!isset($_SESSION['MEALS'])) {
    $_SESSION['MEALS'] = getRows('SELECT unnest(enum_range(NULL::meal_type)) AS "name"');
  }
  return $_SESSION['MEALS'];
}
?>
