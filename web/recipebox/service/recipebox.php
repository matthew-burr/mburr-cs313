<?php
// This defines the recipebox service.
require 'service.php';

$action = $_POST['action'];

switch ($action) {
case 'getMealList':
  getMealList();
  break;
case 'getRecipeList':
  getRecipeList();
  break;
case 'getRecipeByID':
  getRecipeByID();
  break;
default:
  sendResponse('failure', "ERROR: $action is an unknown action");
}

// getMealList returns the list of possible meals
function getMealList() {
  $db = getConnection();
  $stmt = $db->prepare('SELECT unnest(enum_range(NULL::meal_type)) AS "name"');
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $rowCount = count($rows);

  sendResponse("success", "$rowCount rows retrieved", $rows);
}

// getRecipeList returns a list of all the user's recipes
function getRecipeList() {
  $meal = $_POST['meal'];
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
}

function getRecipeByID() {
  $id = $_POST['id'];
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
}
?>
