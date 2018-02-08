<?php
require_once "../service.php";

$meal = $_GET['meal'];
$userId = 2; // TODO: Bind this to a session value
$db = getConnection();
$stmt = $db->prepare(
  'SELECT "id", name, servings, meal, true AS owned 
  FROM recipe_box.recipe 
  WHERE owner_user_id = :user_id
  AND meal = :meal
  UNION 
  SELECT r."id", name, servings, meal, false
  FROM recipe_box.recipe AS r
  JOIN recipe_box.user_recipe AS u
  ON u.recipe_id = r."id"
  WHERE u.user_id = :user_id
  AND r.meal = :meal');

$stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
$stmt->bindValue(':meal', $meal, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rowCount = count($rows);

sendResponse("success", "$rowCount rows retrieved", $rows);
?>
