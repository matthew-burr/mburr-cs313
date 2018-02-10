<?php
require_once "../service.php";
require_once "../database.php";

$id = $_GET['id'];
$userId = getUserID();

$rows = getRows(
  'SELECT name, servings, instructions
  FROM recipe_box.recipe
  WHERE ("id" = :id
  AND owner_user_id = :user_id)
  OR EXISTS (SELECT * FROM recipe_box.user_recipe 
  WHERE recipe_id = :id 
  AND recipe_id = "id"
  AND user_id = :user_id)',
  array(':user_id' => $userId, ':id' => $id)
);

$recipe = $rows[0];

$ingredients = getRows(
  'SELECT i.name
     FROM recipe_box.ingredient AS i
     JOIN recipe_box.recipe_ingredient AS ri
       ON i."id" = ri.ingredient_id
    WHERE ri.recipe_id = :id',
  array(':id' => $id)
);

$recipeWithIng = array(
  "name" => $recipe['name'], 
  "servings" => $recipe['servings'],
  "instructions" => $recipe['instructions'],
  "ingredients" => $ingredients);

sendResponse("success", "1 rows retrieved", $recipeWithIng);
?>
