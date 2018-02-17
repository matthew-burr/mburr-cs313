<?php
require_once "../service.php";
require_once "../database.php";

stopIfNot('GET');

$meal = $_GET['meal'];
$userId = getUserID();

try {
  $rows = getRows(
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
    AND r.meal = :meal',
    array(':user_id' => $userId, ':meal' => $meal)
  );
  sendResponse('SUCCESS', "Retrieved recipes", $rows);
} catch (Exception $ex) {
  sendResponse('FAILURE', 'Failed to retrieve rows', $ex);
  exit();
}

?>
