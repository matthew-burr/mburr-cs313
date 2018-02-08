<?php
require_once "../service.php";

$db = getConnection();
$stmt = $db->prepare('SELECT unnest(enum_range(NULL::meal_type)) AS "name"');
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rowCount = count($rows);

sendResponse("success", "$rowCount rows retrieved", $rows);
?>
