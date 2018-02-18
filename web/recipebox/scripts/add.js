// When the document loads, we need to add entry
// for an ingredient
$(document).ready(function() {
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
        location = "index.php";
      })
      .catch(error => {
        console.log(error);
      });
  });
});

// addIngredient adds a new ingredient text box to the form
function addIngredient(ingredientNumber) {
  // The row
  let ingRow = $("<div class='row'></div>");

  // The ingredient col
  let ingCol = $("<div class='col-sm-10'></div>");
  let newIngredient = $("<input></input>", {
    type: "text",
    id: `ingredient-${ingredientNumber}`,
    name: "ingredient[]",
    class: "ingredient form-control mb-3",
    placeholder: "Name of an ingredient"
  });
  ingCol.append(newIngredient);
  ingRow.append(ingCol);

  // The button col
  let btnCol = $("<div class='col-sm-2'></div>");
  let deleteButton = $("<button></button>", {
    class: "btn btn-outline-danger",
    "data-toggle": "tooltip",
    "data-placement": "below",
    "data-original-title": "Remove this ingredient"
  })
    .click(() => {
      ingRow.remove();
    })
    .text("X");
  btnCol.append(deleteButton);
  ingRow.append(btnCol);

  $("#ingredients").append(ingRow);

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
