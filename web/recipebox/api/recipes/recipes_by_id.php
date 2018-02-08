<?php
require_once "../service.php";

$id = $_GET['id'];
$userId = 2; // TODO: Bind this to a session value
$db = getConnection();
$stmt = $db->prepare(
  'SELECT name, servings, instructions
  FROM recipe_box.recipe
  WHERE ("id" = :id
  AND owner_user_id = :user_id)
  OR EXISTS (SELECT * FROM recipe_box.user_recipe 
  WHERE recipe_id = :id 
  AND recipe_id = "id"
  AND user_id = :user_id)'
);
$stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rowCount = count($rows);
$recipe = $rows[0];

$stmt = $db->prepare(
  'SELECT i.name
     FROM recipe_box.ingredient AS i
     JOIN recipe_box.recipe_ingredient AS ri
       ON i."id" = ri.ingredient_id
    WHERE ri.recipe_id = :id'
);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$recipeWithIng = array(
  "name" => $recipe['name'], 
  "servings" => $recipe['servings'],
  "instructions" => $recipe['instructions'],
  "ingredients" => $ingredients);
sendResponse("success", "$rowCount rows retrieved", $recipeWithIng);
?>
