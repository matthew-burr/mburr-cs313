<?php
session_start();
require_once "api/database.php";
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $email = $_POST['email'];
    $pWord = $_POST['password'];

    $pWord = password_hash($pWord, PASSWORD_DEFAULT);

    $response = getRows('SELECT COUNT(*) AS match FROM recipe_box.user WHERE email = :email',
      array(":email" => $email));

    if ($response[0]['match'] >= 1) {
      throw new Exception("Unable to complete your request. Try again.");
    }

    $response = getRows('
      INSERT INTO recipe_box.user(email, password, first_name, last_name)
      VALUES(:email, :password, :first_name, :last_name)
      RETURNING id;
    ', array(
      ":email" => $email,
      ":password" => $pWord,
      ":first_name" => $fName,
      ":last_name" => $lName
      ));

    $id = $response[0]['id'];
    $_SESSION['USER_ID'] = $id;

    header('Location: index.php');
  } catch (Exception $error) {
    $errorMessage = $error->getMessage();
  }
}

?>

<?php require_once "header.php"; ?>

<div id="newUserTitle" class="row justify-content-center">
  <div class="col-sm-6">
    <span class="formError larger"><?php echo $errorMessage; ?></span>
    <h2>Please enter account details below</h2>
  </div>
</div>
<div id="newUserWindow" class="row justify-content-center">
  <form id="newUserForm" class="col-sm-6 border rounded p-4" method="post" novalidate>
    <div class="row" id="nameSection">
      <div class="form-group col" id="firstNameGroup">
        <label for="firstNameInput">Your first name</label>
        <input type="text" class="form-control errorable" data-error="firstNameError" id="firstNameInput" name="firstName" placeholder="First name" required />
        <span class="formError" id="firstNameError" data-message="First name is required"></span>
      </div> <!-- firstNameGroup -->
      <div class="form-group col" id="lastNameGroup">
        <label for="lastNameInput">Your last name</label>
        <input type="text" class="form-control errorable" data-error="lastNameError" id="lastNameInput" name="lastName" placeholder="Last name" required />
        <span class="formError" id="lastNameError" data-message="Last name is required"></span>
      </div> <!-- lastNameGroup -->
    </div> <!-- nameGroup -->
    <div class="row" id="emailSection">
      <div class="form-group col" id="emailGroup">
        <label for="emailInput">Your email address</label>
        <input type="email" class="form-control errorable" data-error="emailError" id="emailInput" name="email" placeholder="me@email.com" required />
        <small class="form-text text-muted">Your email address also serves as your user id</small>
        <span id="emailError" class="formError" data-message="You must enter a valid email"></span>
      </div> <!-- emailGroup -->
    </div> <!-- row -->
    <div class="row" id="passwordSection">
      <div class="form-group col" id="passwordGroup">
        <label for="passwordInput">Your new password</label>
        <input type="password" class="form-control errorable" data-error="passwordError" id="passwordInput" name="password" placeholder="Password" required />
        <span id="passwordError" class="formError" data-message="A password is required"></span>
      </div> <!-- passwordGroup -->
    </div> <!-- passwordSection -->
    <div class="row" id="confirmSection">
      <div class="form-group col" id="confirmGroup">
        <label for="confirmInput">Confirm your new password</label>
        <input type="password" class="form-control errorable" data-error="confirmError" id="confirmInput" name="confirm" placeholder="Password" required />
        <span id="confirmError" data-message="You must confirm your password" class="formError"></span>
      </div> <!-- confirmGroup -->
    </div> <!-- confirmSection -->
    <div class="row" id="buttonSection">
      <div class="col-sm">
        <input type="submit" class="btn btn-primary" id="submitButton" value="Create" />
        <input type="reset" class="btn btn-outline-secondary" id="resetButton" value="Clear" />
      </div>
    </div>
  </form>
</div>
<script src="scripts/new-user.js"></script>
<?php require_once "footer.php"; ?>
