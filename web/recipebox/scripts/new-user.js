$(document).ready(function() {
  wireUpSubmitValidation();
});

async function validatePassword() {
  let password = document.getElementById("passwordInput").value;
  let confirm = document.getElementById("confirmInput").value;
  if (password === confirm) return true;

  let passwordInput = document.getElementById("passwordInput");
  let confirmInput = document.getElementById("confirmInput");
  passwordInput.value = "";
  confirmInput.value = "";

  let errorID = passwordInput.getAttribute("data-error");
  document.getElementById(errorID).innerHTML =
    "Password does not match its confirmation; try again";
  passwordInput.focus();
  throw new Error("Password confirmation failed");
}

function wireUpSubmitValidation() {
  let f = document.getElementById("newUserForm");
  f.addEventListener("submit", function(event) {
    let elemsToCheck = document.getElementsByClassName("errorable");
    Array.from(elemsToCheck).forEach(function(elem) {
      validate(elem).catch(msg => event.preventDefault());
    });

    validatePassword().catch(msg => event.preventDefault());
  });
}
