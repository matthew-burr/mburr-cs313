<?php
require_once "../service.php";
require_once "../database.php";
require_once "./common.php";

stopIfNot('GET');

$id = $_GET['id'];
$userId = getUserID();

try {
  $recipeWithIng = getRecipeByID($id);
} catch (Exception $ex) {
  sendResponse('FAILURE', "Failed to retrieve recipe", $ex);
  exit();
}

sendResponse('SUCCESS', "Recipe retrieved", $recipeWithIng);
?>
