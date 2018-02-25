$(document).ready(function() {
  wireUpSubmitValidation();
});

function wireUpSubmitValidation() {
  let frm = document.getElementById("loginForm");
  frm.addEventListener("submit", function(event) {
    validate(document.getElementById("emailInput")).catch(() =>
      event.preventDefault()
    );
    validate(document.getElementById("passwordInput")).catch(() =>
      event.preventDefault()
    );
  });
}
