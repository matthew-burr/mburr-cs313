<?php
require_once "../service.php";
require_once "../database.php";

stopIfNot('PUT');

// Thanks https://codepen.io/dericksozo/post/fetch-api-json-php
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
$recipeID = $decoded['id'];
$name = $decoded['name'];
$servings = $decoded['servings'];
$instructions = $decoded['instructions'];
$meal = $decoded['meal'];
$ingredients = $decoded['ingredients'];
$ownerID = getUserID();

try {
  $insertResponse = getRows('
  UPDATE recipe_box.recipe 
  SET name = :name,
      servings = :servings,
      meal = :meal,
      instructions = :instructions
  WHERE id = :id
  ',
    array(
    ':id' => $recipeID,
    ':name' => $name, 
    ':servings' => $servings, 
    ':meal' => $meal,
    ':instructions' => $instructions)
  );

  getRows('DELETE FROM recipe_box.recipe_ingredient WHERE recipe_id = :id', array(':id' => $recipeID));

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
sendResponse('SUCCESS', 'Updated recipe', $recipeID);
?>
