<?php
session_start();
if (isset($_SESSION['USER_ID'])) {
  header('Location: index.php');
}

require_once 'api/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the parameters
  $userName = $_POST['email'];
  $password = $_POST['password'];

  $rows = getRows('SELECT id, password FROM recipe_box.user WHERE email = :email', array(":email" => $userName));

  if (count($rows) > 0) {
    $hash = $rows[0]['password'];
    if (password_verify($password, $hash)) {
      $_SESSION['USER_ID'] = $rows[0]['id'];
      header('Location: index.php');
    }
  }

  $errorMessage = "Something is wrong with that user name or password. Try again.";
}
?>
<?php require_once "header.php"; ?>
    <div class="container mt-5" id="loginPanel">
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <span class="formError larger"><?php echo $errorMessage; ?></span>
          <h2>Please log in to your account</h2>
        </div> <!-- col -->
      </div> <!-- row -->
      <div class="row justify-content-center">
        <div class="col-sm-6 border rounded p-4">
          <!-- Form modeled from examples at http://getbootstrap.com/docs/4.0/components/forms/ -->
          <form id="loginForm" method="post" novalidate>
            <div class="form-group" id="emailgroup">
              <label for="emailInput">Email</label>
              <input type="email" class="form-control errorable" data-error="emailError" id="emailInput" name="email" placeholder="Email address" required />
              <span class="formError" id="emailError" data-message="Email is required" />
            </div> <!-- emailGroup -->
            <div class="form-group" id="passwordGroup">
              <label for="passwordInput">Password</label>
              <input type="password" class="form-control errorable" data-error="passwordError" id="passwordInput" name="password" placeholder="Password" required />
              <span class="formError" data-message="Password is required" id="passwordError" />
            </div> <!-- passwordGroup -->
            <input type="submit" id="loginButton" class="btn btn-primary" />
          </form>
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- loginPanel -->
    <script src="scripts/login.js"></script>
<?php require_once "footer.php"; ?>
