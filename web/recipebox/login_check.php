<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['USER_ID'])) {
  header('Location: login.php');
}
?>
