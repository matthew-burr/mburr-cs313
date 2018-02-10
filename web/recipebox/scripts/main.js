// Here's where the code actually begins
// Once the document is loaded, we retrieve our
// list of available meals from the service
$(document).ready(() => {
  $.get(
    "api/meals",
    null,
    response => {
      console.log(response);
      $("#mealTabBar").html(mealListRender(response.content));
      $("#mealTabBar a[data-toggle='tab']").on("shown.bs.tab", e => {
        let meal = e.target.id;
        meal = meal.split("-")[1];
        mealPageRender(meal);
      });
    },
    "json"
  );
  return;
});

// mealListRender draws our tab bar of meals
function mealListRender(mealList) {
  let isCurrent = true;
  return `
    <ul class="nav nav-tabs" id="mealListNav">
      ${mealList
        .map(meal => {
          let mealTag = mealRender(meal, isCurrent);
          isCurrent = false;
          return mealTag;
        })
        .join("")}
    </ul>
  `;
}

// mealRender renders an individual meal
function mealRender(meal, isActive) {
  if (isActive) {
    mealPageRender(meal.name);
  }
  return `
    <li class="nav-item">
      <a 
        class="nav-link ${isActive ? "active" : ""}" 
        data-toggle="tab"
        id="meal-${meal.name}"
        href="#">${meal.name}</a>
    </li>
  `;
}

// mealPageRender renders the recipes for a particular meal
function mealPageRender(meal) {
  recipePanelClear();
  console.log(meal);
  $.get(
    `api/meals/${meal}`,
    null,
    response => {
      $("#recipeList").html(recipeListRender(response.content));
      $("#recipeList .list-group-item").on("click", e => {
        let recipeID = e.target.id;
        recipeID = recipeID.split("-")[1];
        recipePanelRender(recipeID);
      });
    },
    "json"
  );
}

// recipeListRender draws the list of recipes
function recipeListRender(recipeList) {
  if (recipeList == undefined) {
    return ``;
  }
  isActive = true;
  return `
    <div class="list-group">
      ${recipeList
        .map(recipe => {
          let content = recipeListItemRender(recipe, isActive);
          isActive = false;
          return content;
        })
        .join("")}
    </div>
  `;
}

// recipeListItemRender draws an individual recipe in a list
function recipeListItemRender(recipe, isActive) {
  if (isActive) {
    recipePanelRender(recipe.id);
  }
  return `
    <a
    id="recipe-${recipe.id}"
    href="#"
    data-toggle="list"
    class="list-group-item list-group-item-action ${isActive ? "active" : ""}">
      ${recipe.name}
    </a>
  `;
}

function recipePanelClear() {
  $("#recipePanel").html("");
}

function recipePanelRender(recipeID) {
  $.get(
    `api/recipes/${recipeID}`,
    null,
    response => {
      $("#recipePanel").html(recipeRender(response.content));
    },
    "json"
  );
}

function recipeRender(recipe) {
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
}
