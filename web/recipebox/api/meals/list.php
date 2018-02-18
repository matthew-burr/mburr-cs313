<?php
require_once "../service.php";
require_once "../database.php";
require_once "./common.php";
// we don't expect the list of meals to change any time soon
// so we will cache the list in a session
$meals = getMeals();
sendResponse('SUCCESS', "Meals retrieved", $meals);
?>
