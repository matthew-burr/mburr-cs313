$(document).ready(function() {
  wireUpAddIngredient();
  wireUpDeleteButtons();
  wireUpSaveButton();
  $("#mealSelect").focus();
});

const addAction = (function() {
  let ingredientNumber = 0;
  return function() {
    addIngredient(ingredientNumber);
    ingredientNumber++;
  };
})();

function wireUpAddIngredient() {
  addAction();
  $("#addIngredientButton").click(addAction);
}

function wireUpSaveButton() {
  let btn = document.getElementById("saveButton");
  btn.addEventListener("click", function(event) {
    validateAll()
      .then(saveRecipe)
      .catch(err => {
        let msg = document.getElementById("mainError");
        msg.innerHTML = err;
      });
  });
}

function wireUpDeleteButtons() {
  $(".delete-button").click(event => {
    $(event.target)
      .closest("div.row")
      .remove();
  });
}

async function saveRecipe() {
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

  let response = await fetch(
    "api/recipes/add.php",
    headers("POST", JSON.stringify(recipe))
  );
  if (!response.ok) throw new Error("Trouble saving the recipe");
  location = "index.php";
}

function addIngredient(ingredientNumber) {
  // The row
  let ingRow = $("<div class='row'></div>");

  // The ingredient col
  let ingCol = $("<div class='col-sm-10'></div>");
  let newIngredient = $("<input></input>", {
    type: "text",
    id: `ingredient-${ingredientNumber}`,
    name: "ingredient[]",
    class: "ingredient form-control mb-3 errorable",
    "data-error": `ingredient-${ingredientNumber}-error`,
    placeholder: "Name of an ingredient",
    required: true
  });
  newIngredient.on("keypress", function(event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      addAction();
    }
  });
  ingCol.append(newIngredient);

  // The error message
  let errorMessage = $("<span></span>", {
    id: `ingredient-${ingredientNumber}-error`,
    class: "formError",
    "data-message": "Ingredients must have a name"
  });
  ingCol.append(errorMessage);
  ingRow.append(ingCol);

  // The button col
  let btnCol = $("<div class='col-sm-2'></div>");
  let deleteButton = $("<button></button>", {
    class: "btn btn-outline-danger",
    tabindex: "-1",
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
