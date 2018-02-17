<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// This file contains common functionality shared by all services
session_start();

$STATUS_CODE = array(
  'OK' => 200,
  'SUCCESS' => 200,
  'BAD_REQUEST' => 400,
  'FAILURE' => 400,
  'UNAUTHORIZED' => 401,
  'NOT_ALLOWED' => 405
);

function stopIfNot($supportedMethod) {
  if ($_SERVER['REQUEST_METHOD'] != $supportedMethod) {
    sendResponse('NOT_ALLOWED', "Does not support $method");
    exit();
  }
}

function getStatusCode($status) {
  global $STATUS_CODE;
  return $STATUS_CODE[strtoupper($status)];
}
// getUserID gets the current user's ID; logs the user in
// if they don't have an ID in the session yet
function getUserID() {
  if (!isset($_SESSION['USER_ID'])) {
    sendResponse('UNAUTHORIZED', 'User has not logged in');
    exit();
  }
  return $_SESSION['USER_ID'];
}


// sendResponse is the method for returning anything back from the service
function sendResponse($status = "SUCCESS", $message = "", $content = NULL) {
  // set the response status code
  $statusCode = getStatusCode($status);
  http_response_code($statusCode);

  // build the response content
  $response = array("message" => $message);
  if ($content != NULL) {
    $response["content"] = $content;
  }
  header('Content-Type: application/json');

  // send the response
  echo json_encode($response);
}

?>
