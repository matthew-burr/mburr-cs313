// When the document loads, we need to add entry
// for an ingredient

$(document).ready(function() {
  let ingredientNumber = 0;
  addIngredient(ingredientNumber);
  $("#addIngredientButton").click(function() {
    ingredientNumber++;
    addIngredient(ingredientNumber);
  });

  $("#saveButton").click(function(e) {
    fetch("api/recipes/add.php", {
      method: "POST",
      credentials: "same-origin",
      redirect: "follow",
      headers: new Headers({
        "Content-Type": "application/json",
        Accept: "application/json"
      })
    })
      .then(response => {
        if (response.ok) {
          location = "index.html";
        }

        throw new Error(response.statusText);
      })
      .catch(error => {
        console.log(error);
      });
  });
});

// addIngredient adds a new ingredient text box to the form
function addIngredient(ingredientNumber) {
  $("#ingredients").append(
    $("<input></input>", {
      type: "text",
      id: `ingredient-${ingredientNumber}`,
      name: "ingredient[]",
      class: "form-control mb-3",
      placeholder: "Name of an ingredient"
    })
  );
}
