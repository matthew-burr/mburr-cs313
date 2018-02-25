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

function redirectToHome() {
  location = "index.php";
}

function validate(elem) {
  let errorID = elem.getAttribute("data-error");
  let error = document.getElementById(errorID);
  if (elem.validity.valid) {
    error.innerHTML = "";
    return true;
  }
  let errorMessage = error.getAttribute("data-message");
  error.innerHTML = errorMessage;
  throw new Error(errorMessage);
}

async function validateAll() {
  let anyInvalid = false;
  let elemsToCheck = document.getElementsByClassName("errorable");
  Array.from(elemsToCheck).forEach(function(elem) {
    try {
      validate(elem);
    } catch (err) {
      anyInvalid = true;
    }
  });
  if (anyInvalid) throw new Error("At least one invalid element");
  return;
}
