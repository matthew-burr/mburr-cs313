<!doctype html>
<html>
  <head>
  <?php require 'header_include.php' ?>
  <title>Checkout</title>
  </head>
  <body>
    <?php require 'navigation_include.php' ?>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <h1 class="mt-2">Checkout</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-sm">
          <form method="POST" action="confirmation.php">
            <div class="form-group">
              <label for="buyer-name">Name</label>
              <input class="form-control" id="buyer-name" name="buyer-name" type="text" placeholder="Your first and last name" required />
            </div>
            <div class="form-group">
              <label for="buyer-street">Street</label>
              <input class="form-control" id="buyer-street" name="buyer-street" type="text" placeholder="Your shipping street address" required />
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="buyer-city">City</label>
                <input class="form-control" id="buyer-city" name="buyer-city" type="text" placeholder="Shipping city" required />
              </div>
              <div class="form-group col-md-2">
                <label for="buyer-state">State</label>
                <input class="form-control" id="buyer-state" name="buyer-state" type="text" aria-describedby="state-help" placeholder="Shipping state" pattern="[A-Z]{2}" required />
                <small id="state-help" class="form-text text-muted">Enter your two digit state, e.g. CA</small>
              </div>
              <div class="form-group col-md-4">
                <label for="buyer-zip">Zip Code</label>
                <input class="form-control" id="buyer-zip" name="buyer-zip" type="text" placeholder="00000" pattern="\d{5}" required />
              </div>
            </div>
            <div class="form-row justify-content-end">
              <div class="form-group">
                <a href="cart.php" class="btn btn-secondary">Return to Cart</a>
                <input class="btn btn-secondary" type="submit" value="Submit" name="submit" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php require 'script_include.php'; ?>
  </body>
</html>
