const MealList = (mealList, currentMeal) => {
  let ul = $(`<ul class="nav nav-tabs" id="mealListNav"></ul>`);
  mealList.forEach(meal => ul.append(Meal(meal, currentMeal)));
  return ul;
};

const Meal = (meal, currentMeal) => {
  return $(`<li class="nav-item"></li>`).append(
    $(`
      <a 
        class="nav-link ${meal.name == currentMeal.name ? "active" : ""}" 
        data-toggle="tab"
        id="meal-${meal.name}"
        href="#">${meal.name}</a>
    `).on("shown.bs.tab", e => {
      mealPageRender(meal.name);
    })
  );
};

const RecipeList = (recipeList, currentRecipe) => {
  if (recipeList == undefined) {
    return ``;
  }
  return `
    <div class="list-group">
      ${recipeList
        .map(recipe => RecipeListItem(recipe, currentRecipe))
        .join("")}
    </div>
  `;
};

const RecipeListItem = (recipe, currentRecipe) => {
  return `
    <a
    id="recipe-${recipe.id}"
    href="#"
    data-toggle="list"
    class="list-group-item list-group-item-action ${
      recipe.id == currentRecipe.id ? "active" : ""
    }">
      ${recipe.name}
    </a>
  `;
};

const Recipe = recipe => {
  return `
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <h2>${recipe.name}</h2>
          <strong>Serves: </strong>${recipe.servings}
        </div>
      </div>
      <div class="row border-top mt-3 pt-2">
        <div class="col-sm">
          <h3>ingredients</h3>
          <ul>
            ${recipe.ingredients
              .map(ingredient => "<li>" + ingredient.name + "</li>")
              .join("")}
          </ul>
        </div>
      </div>
      <div class="row border-top mt-3 pt-2">
        <div class="col-sm">
          <h3>Instructions</h3>
          <p>${recipe.instructions}</p>
        </div>
      </div>
    </div>
  `;
};

class RecipeBox {
  constructor(mealList) {
    this.mealList = mealList;
    this.currentMeal = mealList[0];
  }

  render() {
    this.mealList.forEach(meal => {});
    $("#mealTabBar").append(MealList(this.mealList, this.currentMeal));
    mealPageRender(this.currentMeal.name);
  }
}

var recipeBox;

// Here's where the code actually begins
// Once the document is loaded, we retrieve our
// list of available meals from the service
$(document).ready(() => {
  $.get(
    "api/meals",
    null,
    response => {
      console.log(response);
      recipeBox = new RecipeBox(response.content);
      recipeBox.render();
    },
    "json"
  );
  return;
});

// mealPageRender renders the recipes for a particular meal
function mealPageRender(meal) {
  recipePanelClear();
  console.log(meal);
  $.get(
    `api/meals/${meal}`,
    null,
    response => {
      if (response.content == undefined) {
        recipePanelClear();
        $("#recipeList").html();
        return;
      }
      $("#recipeList").html(RecipeList(response.content, response.content[0]));
      $("#recipeList .list-group-item").on("click", e => {
        let recipeID = e.target.id;
        recipeID = recipeID.split("-")[1];
        recipePanelRender(recipeID);
      });
      recipePanelRender(response.content[0].id);
    },
    "json"
  );
}

function recipePanelClear() {
  $("#recipePanel").html("");
}

function recipePanelRender(recipeID) {
  $.get(
    `api/recipes/${recipeID}`,
    null,
    response => {
      $("#recipePanel").html(Recipe(response.content));
    },
    "json"
  );
}
