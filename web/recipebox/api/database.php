<?php 
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/api/service.php');

// set up the connection string if it isn't already
if (!isset($_SESSION['CONNECTION_STRING'])) {
  $dbUrl = getenv('DATABASE_URL');

  $dbOpts = parse_url($dbUrl);

  $dbHost = $dbOpts['host'];
  $dbPort = $dbOpts['port'];
  $dbUser = $dbOpts['user'];
  $dbPass = $dbOpts['pass'];
  $dbName = ltrim($dbOpts['path'], '/');

  $_SESSION['CONNECTION_STRING'] = "pgsql:host=$dbHost;dbname=$dbName;port=$dbPort";
  $_SESSION['DB_USER'] = $dbUser;
  $_SESSION['DB_PASS'] = $dbPass;
}

// getConnection returns a database connection to send and retrieve queries
function getConnection() {
  try {
    $db = new PDO($_SESSION['CONNECTION_STRING'], $_SESSION['DB_USER'], $_SESSION['DB_PASS']);
  }
  catch (PDOException $ex) {
    sendResponse("failure", $ex->getMessage());
    die();
  }
  return $db;
}

function getRows($query, $params = array()) {
  $db = getConnection();
  $stmt = $db->prepare($query);
  $stmt->execute($params);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
