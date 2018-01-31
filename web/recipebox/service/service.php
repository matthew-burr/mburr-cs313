<?php
// This file contains common functionality shared by all services
session_start();

// We only accept POST as a method
$_SERVER["REQUEST_METHOD"] == "POST" or die;

// We need to have an action parameter, or we can do nothing
isset($_POST["action"]) or die;

// sendResponse is the method for returning anything back from the service
function sendResponse($status = "success", $message = "", $content = NULL) {
  $response = array("status" => $status, "message" => $message);
  if ($content != NULL) {
    $response["content"] = $content;
  }
  $responseJSON = json_encode($response);
  echo $responseJSON;
}
?>
