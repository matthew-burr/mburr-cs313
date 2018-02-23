<?php

require_once "api/service.php";
require_once "api/database.php";
require_once "api/recipes/common.php";

$recipeID = $_GET['id'];
$recipe = getRecipeByID($recipeID);

?>
<?php require_once "header.php"; ?>
    <div class="container mt-5" id="loginPanel">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <h2>Describe your recipe</h2>
        </div> <!-- col -->
      </div> <!-- row -->
      <div class="row justify-content-center">
        <div class="col-sm-6 border rounded p-4">
          <!-- Form modeled from examples at http://getbootstrap.com/docs/4.0/components/forms/ -->
          <form id="loginForm">
<?php
echo "<input type='hidden' value='$recipeID' name='recipeID' id='recipeID' />";
?>
            <div class="form-group" id="mealgroup">
              <label for="mealSelect">Meal</label>
              <select id="mealSelect" class="form-control" name="meal">
<?php 
require_once "api/meals/common.php";

$meals = getMeals();
$currentMeal = $recipe['meal'];
foreach($meals as $meal) {
  $name = trim($meal['name']);
  $selected = "";
  if ($name == $currentMeal) {
    $selected = "selected";
  }
  echo "<option value='$name' $selected>$name</option>";
}
?>
              </select>
            </div>
            <div class="form-group" id="namegroup">
              <label for="nameInput">Recipe Name</label>
              <input type="text" class="form-control" id="nameInput" value=<?php echo $recipe['name'] ?> />
              <small id="nameHelp" class="form-text text-muted">Provide a name for the recipe</small>
              <label for="servingsInput">Servings</label>
              <input type="number" min="1" class="form-control" id="servingsInput" value=<?php echo $recipe['servings'] ?> />
              <small id="servingsHelp" class="form-text text-muted">How many people does it serve</small>
            </div> <!-- nameGroup -->
            <div class="form-group" id="ingredientGroup">
              <label>Ingredients</label>
              <div id="ingredients">
<?php
$ingredientNumber = 0;
foreach($recipe['ingredients'] as $ingredient) {
  $name = $ingredient['name'];
  echo "<div class='row'><div class='col-sm-10'>";
  echo "<input id='ingredient-$ingredientNumber' name='ingredient[]' class='ingredient form-control mb-3' value='$name' />";
  echo "</div><div class='col-sm-2'>";
  echo "<button type='button' class='delete-button btn btn-outline-danger' data-toggle='tooltip' data-placement='below' title='Remove this ingredient'>X</button>";
  echo "</div></div>";
  $ingredientNumber = $ingredientNumber + 1;
}
?>
              </div>
              <small id="ingredientsHelp" class="form-text text-muted">Click Add Ingredient to add more</small>
              <button class="btn btn-secondary mt-3" id="addIngredientButton" type="button">Add Ingredient</button>
            </div> <!-- ingredientGroup -->
            <div class="form-group" id="instructionGroup">
              <label for="instructionInput">Instructions</label><br />
              <textarea class="form-control" id="instructionInput" cols="60" rows="10" placeholder="Enter instructions for the recipe">
<?php
echo $recipe['instructions'];
?>

</textarea>
            </div> <!-- instructionGroup -->
            <button type="button" id="saveButton" class="btn btn-primary">Save</button>
          </form>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- loginPanel -->
<?php require_once "footer.php" ?>
