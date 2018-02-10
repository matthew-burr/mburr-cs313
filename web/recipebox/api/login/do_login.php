<?php
include_once "../service.php";

// Extract the payload for the request
// see https://davidwalsh.name/php-json
$payload = file_get_contents('php://input');
$json = json_decode($payload);

$userName = $json->user_name;
$password = $json->password;

login($userName, $password);

// TODO: replace this with a real log in process
// login logs the user into the system
function login($userName, $password) {
  $userId = 0;
  switch ($userName) {
  case "matt@fakeemail.com":
    $userId = 1;
    break;
  case "amy@fakeemail.com":
    $userId = 2;
    break;
  default:
    sendResponse('UNAUTHORIZED', 'That is not a valid login; please check the user name and password and try again.');
    return;
  }

  $_SESSION['USER_ID'] = $userId;
  $_SESSION['USER_NAME'] = $userName;
  sendResponse('SUCCESS', "$userName has logged in");
}
?>
