<?php
require_once "../service.php";
require_once "../database.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  sendResponse("NOT_ALLOWED", "That method is not yet supported");
}

// Thanks https://codepen.io/dericksozo/post/fetch-api-json-php
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
$name = $decoded['name'];
$servings = $decoded['servings'];
$instructions = $decoded['instructions'];
$meal = $decoded['meal'];
$ingredients = $decoded['ingredients'];
$ownerID = getUserID();

try {
  $insertResponse = getRows('
  INSERT INTO recipe_box.recipe (name, servings, owner_user_id, meal, instructions)
  VALUES (:name, :servings, :ownerID, :meal, :instructions)
  RETURNING id
  ',
    array(':name' => $name, 
    ':servings' => $servings, 
    ':ownerID' => $ownerID,
    ':meal' => $meal,
    ':instructions' => $instructions)
  );

  $recipeID = $insertResponse[0]['id'];

  foreach($ingredients as $ingredient) {
    // see if the ingredient already exists
    $ingredientRows = getRows('
      SELECT MAX("id") as id FROM recipe_box.ingredient 
      WHERE name = :ingredient
    ', array(':ingredient' => $ingredient));

    // if not, then add it
    if ($ingredientRows[0]['id'] == null) {
      $ingredientRows = getRows('INSERT INTO recipe_box.ingredient (name) VALUES (:ingredient) RETURNING "id"', array(':ingredient' => $ingredient));
    }

    // insert the link
    $ingredientID = $ingredientRows[0]['id'];
    getRows('INSERT INTO recipe_box.recipe_ingredient (recipe_id, ingredient_id) VALUES (:recipeID, :ingredientID)',
    array(':recipeID' => $recipeID, ':ingredientID' => $ingredientID));
  }
} catch (Exception $ex) {
  sendResponse('FAILURE', 'Failed to add recipe', $ex);
  exit();
}
sendResponse('SUCCESS', 'Added recipe');
?>
