<?php require_once "header.php"; ?>
    <div class="row navbar border-bottom bg-light" id="menu">
      <div id="mealTabBar">
<?php
// Here, we render the mealTabBar tabs
require_once "api/meals/common.php";

echo "<ul class='nav nav-pills' id='mealListNav'>";
$meals = getMeals();
echo implode("", 
  array_map(function($meal) {
    $name = $meal['name'];
    return "
      <li class='nav-item'>
        <a 
          class='nav-link'
          data-toggle='tab' 
          id='meal-$name' href='#'>$name</a>
      </li>";
  }, $meals)
);
echo "</ul>";
?>
      </div> <!-- mealTabBar -->
      <form id="userManagement">
        <button type="button" class="btn btn-outline-secondary" id="changeUser">Change User</button>
      </form> <!-- userManagement -->
    </div> <!-- menu -->
    <div id="mealPage" class="row mt-5">
      <div id="recipeList" class="col-sm-2">
      </div> <!-- recipeList -->
      <div id="recipeWindow" class="col-sm-10">
        <div id="recipeMenu" class="container-fluid">
            <div class="row justify-content-end">
              <button id="editRecipe" class="btn btn-outline-primary mr-1" data-toggle="tooltip" data-placement="bottom" title="Edit this recipe"><span class="fa fa-pencil"></span></button>
              <a href="add.php" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Add a new recipe"><span class="fa fa-plus"></span></a>
            </div> <!-- row -->
        </div> <!-- recipeMenu -->
        <div id="recipePanel">
        </div> <!-- recipePanel -->
      </div> <!-- recipeWindow -->
    </div> <!-- mealPage -->
<?php require_once "footer.php" ?>
