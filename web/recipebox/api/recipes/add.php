<?php
require_once "../service.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  sendResponse("NOT_ALLOWED", "That method is not yet supported");
}
?>
