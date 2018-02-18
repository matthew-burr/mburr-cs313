<?php
require_once "api/service.php";
require_once "api/database.php";
require_once "api/recipes/common.php";

$recipeID = $_GET['id'];
$recipe = getRecipeByID($recipeID);

?>
<!doctype html>
<html>
  <head>
    <title>Recipe Box</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheets/main.css" />
  </head>
  <body>
    <div class="container-fluid" id="header">
      <div id="recipeBoxHeader" class="row">
        <div class="col-sm">
          <h1>Recipe Box</h1>
        </div> <!-- col -->
      </div> <!-- recipeBoxHeader -->
    </div> <!-- header -->
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="scripts/common.js"></script>
    <script src="scripts/edit.js"></script>
  </body>
</html>

