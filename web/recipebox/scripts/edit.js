$(document).ready(() => {
  let ingredientNumber = 99;
  $("#addIngredientButton").click(function() {
    ingredientNumber++;
    addIngredient(ingredientNumber);
  });

  $(".delete-button").click(event => {
    $(event.target)
      .closest("div.row")
      .remove();
  });

  $("#saveButton").click(function(e) {
    let recipe = {
      id: $("#recipeID").val(),
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

    fetch("api/recipes/update.php", headers("PUT", JSON.stringify(recipe)))
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
