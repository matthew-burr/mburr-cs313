// Here's where the code actually begins
// Once the document is loaded, we retrieve our
// list of available meals from the service
let recipeID = 0;

$(document).ready(() => {
  // Enable bootstrap tooltips
  $(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  // Wire up event handlers
  $("#changeUser").on("click", () => {
    location = "logout.php";
  });

  $("#editRecipe").click(() => {
    location = `edit.php?id=${recipeID}`;
  });

  $("#mealTabBar a[data-toggle='tab']").on("shown.bs.tab", e => {
    let meal = e.target.id;
    meal = meal.split("-")[1];
    mealPageRender(meal);
  });

  // Activate the first meal tab
  $("#mealTabBar a[data-toggle='tab']:first").tab("show");

  return;
});

// mealListRender draws our tab bar of meals
function mealListRender(mealList) {
  let isCurrent = true;
  return `
    <ul class="nav nav-pills" id="mealListNav">
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
  // get the recipes for this meal from the server
  fetch(`api/meals/get_recipes.php?meal=${meal}`, {
    method: "GET",
    credentials: "same-origin",
    redirect: "follow",
    headers: new Headers({
      "Content-Type": "application/json",
      Accept: "application/json"
    })
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      }

      if (response.status == 401) {
        location = "login.php";
      }

      throw new Error("Unexpected error");
    })
    .then(resJson => {
      $("#recipeList").html(recipeListRender(resJson.content));
      $("#recipeList .list-group-item").on("click", e => {
        let recipeID = e.target.id;
        recipeID = recipeID.split("-")[1];
        recipePanelRender(recipeID);
      });
    })
    .catch(error => {
      console.log(error);
    });
}

// recipeListRender draws the list of recipes
function recipeListRender(recipeList) {
  if (recipeList == undefined) {
    recipePanelNoRecipes();
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

function recipePanelNoRecipes() {
  $("#editRecipe").hide();
  $("#recipePanel").html(
    "<h2>You don't have any recipes for this type of meal</h2>"
  );
}
function recipePanelClear() {
  $("#recipePanel").html("");
}

function recipePanelRender(recipeID) {
  fetch(`api/recipes/get_one.php?id=${recipeID}`, {
    method: "GET",
    credentials: "same-origin",
    redirect: "follow",
    headers: new Headers({
      "Content-Type": "application/json",
      Accept: "application/json"
    })
  })
    .then(response => {
      if (response.ok) {
        return response.json();
      }

      if (response.status == 401) {
        location = "login.php";
      }

      throw new Error("Unexpected response");
    })
    .then(resJson => {
      $("#recipePanel").html(recipeRender(resJson.content));
    })
    .catch(error => {
      console.log(error);
    });
}

function recipeRender(recipe) {
  $("#editRecipe").show();
  recipeID = recipe.id;
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
          <h3>Ingredients</h3>
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
