<?php
session_start();
if (isset($_SESSION['USER_ID'])) {
  unset($_SESSION['USER_ID']);
}

header('Location: welcome.php');
?>
