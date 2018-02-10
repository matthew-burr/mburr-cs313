// This file contains functionality to manage the login process

$(document).ready(() => {
  // attach an event handler to the submit button
  $("#loginButton").on("click", tryLogin);
});

// tries to login; if it succeeds, moves into the main app
// if it fails, prompts user to try again
// TODO: Make sure that this is all secure
function tryLogin() {
  let userName = $("#emailInput").val();
  let password = $("#passwordInput").val();

  fetch("api/login/do_login.php", {
    method: "POST",
    credentials: "same-origin",
    redirect: "follow",
    body: JSON.stringify({ user_name: userName, password: password }),
    headers: new Headers({
      "Content-Type": "application/json",
      Accept: "application/json"
    })
  })
    .then(response => {
      if (response.ok) {
        // login succeeded, so we move on
        return response.text();
      }
      // request failed
      throw new Error(
        "Login failed; make sure you're email and password are correct"
      );
    })
    .then(resJson => {
      redirectToMainPage();
    })
    .catch(error => {
      displayError(error);
    });
}

// redirects to the main page after a successful login attempt
function redirectToMainPage() {
  window.location = "index.html";
}

// displays an error message on log in failure
function displayError(error) {
  alert(error);
}
