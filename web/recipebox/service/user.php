<?php
// This file contains the User service, which allows interaction with user functionality such as
// adding a user, logging in a user, and retrieving the user's details
require "service.php";

switch ($_POST["action"]) {

}

class User {
  private $id = 0;
  public $first_name = '';
  public $last_name = '';
  public $email = '';
}


?>
