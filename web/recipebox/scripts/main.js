// Here's where the code actually begins
// Once the document is loaded, we retrieve our
// list of available meals from the service
$(document).ready(() => {
  fetch("api/meals", {
    method: "GET",
    credentials: "same-origin",
    redirect: "follow"
  })
    .then(response => {
      if (response.status == 401) {
        // we do not appear to be logged in, so redirect to login
        location = "login.html";
        return;
      }

      // we got our meal list back, render it and set up
      // event handlers
      if (response.ok) {
        return response.json();
      }
    })
    .then(resJson => {
      console.log(resJson);
      let meals = resJson.content;
      $("#mealTabBar").html(mealListRender(meals));
      $("#mealTabBar a[data-toggle='tab']").on("shown.bs.tab", e => {
        let meal = e.target.id;
        meal = meal.split("-")[1];
        mealPageRender(meal);
      });
    });
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
  // get the recipes for this meal from the server
  fetch(`api/meals/${meal}`, {
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
        location = "login.html";
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
  fetch(`api/recipes/${recipeID}`, {
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
        location = "login.html";
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
