// When the document loads, we need to add entry
// for an ingredient
$(document).ready(function() {
  fetch("api/meals/list.php", headers("GET"))
    .then(response => {
      if (response.ok) {
        return response.json();
      }
      throw new Error(response.json());
    })
    .then(mealsJson => {
      let meals = mealsJson.content;
      $("#mealSelect").append(
        meals.map(meal => {
          return $("<option></option>", {
            value: meal.name
          }).text(meal.name);
        })
      );
    })
    .catch(error => {
      console.log(error);
    });

  let ingredientNumber = 0;
  addIngredient(ingredientNumber);
  $("#addIngredientButton").click(function() {
    ingredientNumber++;
    addIngredient(ingredientNumber);
  });
  $("#mealSelect").focus();

  $("#saveButton").click(function(e) {
    let recipe = {
      name: $("#nameInput").val(),
      servings: $("#servingsInput").val(),
      instructions: $("#instructionInput").val(),
      meal: $("#mealSelect")
        .find(":selected")
        .val(),
      ingredients: []
    };
    $(".ingredient").each(function(index, elem) {
      recipe.ingredients.push($(elem).val());
    });
    fetch("api/recipes/add.php", {
      method: "POST",
      credentials: "same-origin",
      redirect: "follow",
      body: JSON.stringify(recipe),
      headers: new Headers({
        "Content-Type": "application/json",
        Accept: "application/json"
      })
    })
      .then(response => {
        if (response.ok) {
          return response.json();
        }

        throw new Error(response.statusText);
      })
      .then(resJson => {
        console.log(resJson);
        location = "index.html";
      })
      .catch(error => {
        console.log(error);
      });
  });
});

// addIngredient adds a new ingredient text box to the form
function addIngredient(ingredientNumber) {
  let newIngredient = $("<input></input>", {
    type: "text",
    id: `ingredient-${ingredientNumber}`,
    name: "ingredient[]",
    class: "ingredient form-control mb-3",
    placeholder: "Name of an ingredient"
  });

  $("#ingredients").append(newIngredient);

  newIngredient.focus();
}

function headers(method, body) {
  return {
    method: method,
    credentials: "same-origin",
    redirect: "follow",
    body: body,
    headers: new Headers({
      "Content-Type": "application/json",
      Accept: "application/json"
    })
  };
}
