<?php require_once "login_check.php"; ?>
<?php require_once "header.php"; ?>
    <div class="container mt-5" id="loginPanel">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <span class="formError larger" id="mainError"></span>
          <h2>Describe your recipe</h2>
        </div> <!-- col -->
      </div> <!-- row -->
      <div class="row justify-content-center">
        <div class="col-sm-6 border rounded p-4">
          <!-- Form modeled from examples at http://getbootstrap.com/docs/4.0/components/forms/ -->
          <form id="addForm">
            <div class="form-group" id="mealgroup">
              <label for="mealSelect">Meal</label>
              <select id="mealSelect" class="form-control" name="meal">
<?php 
require_once "api/service.php";
require_once "api/database.php";
require_once "api/meals/common.php";

$meals = getMeals();

foreach($meals as $meal) {
  $name = $meal['name'];
  echo "<option value='$name'>$name</option>";
}
?>
              </select>
            </div>
            <div class="form-group" id="nameGroup">
              <label for="nameInput">Recipe Name</label>
              <input type="text" class="form-control errorable" data-error="nameError" id="nameInput" placeholder="Name of the recipe" required />
              <span class="formError" data-message="Name is required" id="nameError" />
              <small id="nameHelp" class="form-text text-muted">Provide a name for the recipe</small>
            </div> <!-- nameGroup -->
            <div class="form-group" id="servingsGroup">
              <label for="servingsInput">Servings</label>
              <input type="number" min="1" class="form-control errorable" data-error="servingsError" id="servingsInput" placeholder="Enter number" required />
              <span class="formError" data-message="Servings are required" id="servingsError" />
              <small id="servingsHelp" class="form-text text-muted">How many people does it serve</small>
            </div> <!-- nameGroup -->
            <div class="form-group" id="ingredientGroup">
              <label>Ingredients</label>
              <div id="ingredients">
              <!-- Ingredients will be added here -->
              </div>
              <small id="ingredientsHelp" class="form-text text-muted">Click Add Ingredient to add more</small>
              <button class="btn btn-secondary mt-3" id="addIngredientButton" type="button">Add Ingredient</button>
            </div> <!-- ingredientGroup -->
            <div class="form-group" id="instructionGroup">
              <label for="instructionInput">Instructions</label><br />
              <textarea class="form-control" id="instructionInput" cols="60" rows="10" placeholder="Enter instructions for the recipe"></textarea>
            </div> <!-- instructionGroup -->
            <button type="button" id="saveButton" class="btn btn-primary">Save</button>
          </form>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- loginPanel -->
    <script src="scripts/add.js"></script>
<?php require_once "footer.php"; ?>
