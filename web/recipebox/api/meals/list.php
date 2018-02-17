<?php
require_once "../service.php";
require_once "../database.php";

// we don't expect the list of meals to change any time soon
// so we will cache the list in a session
if (!isset($_SESSION['MEALS'])) {
  $_SESSION['MEALS'] = getRows('SELECT unnest(enum_range(NULL::meal_type)) AS "name"');
}

$rowCount = count($_SESSION['MEALS']);
sendResponse("success", "$rowCount rows retrieved", $_SESSION['MEALS']);
?>
