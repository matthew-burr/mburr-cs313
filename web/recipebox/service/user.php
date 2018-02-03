<?php
// This file contains the User service, which allows interaction with user functionality such as
// adding a user, logging in a user, and retrieving the user's details
require "service.php";

switch ($_POST["action"]) {
case "test":
  getUser();
}

class User {
  public $id = 0;
  public $first_name = '';
  public $last_name = '';
  public $email = '';
}

function getUser() {
  $user2find = $_POST["user_email"];

  $dbUrl = getenv('DATABASE_URL');

  $dbOpts = parse_url($dbUrl);

  $dbHost = $dbOpts['host'];
  $dbPort = $dbOpts['port'];
  $dbUser = $dbOpts['user'];
  $dbPass = $dbOpts['password'];
  $dbName = ltrim($dbOpts['path'], '/');
  try {
    $db = new PDO("pgsql:host=$dbHost;dbname=$dbName;port=$dbPort", $dbUser, $dbPass);
  }
  catch (PDOException $ex) {
    sendResponse("failure", parse_url($dbUrl));
    die();
  }

  $stmt = $db->prepare('SELECT *, current_user FROM recipe_box.user WHERE email=:email');
  $stmt->bindValue(':email', $user2find, PDO::PARAM_STR);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $userObj = new User();
  foreach ($rows as $row) {
    $userObj->id = $row["id"];
    $userObj->first_name = $row["first_name"];
    $userObj->last_name = $row["last_name"];
    $userObj->email = $row["email"];
  }
  sendResponse("success", "Connected", $userObj);
}
?>
