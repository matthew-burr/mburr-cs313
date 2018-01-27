<!doctype html>
<html>
  <head>
    <?php require 'header_include.php' ?>
    <title>Catalog</title>
  </head>
  <body>
    <?php require 'navigation_include.php' ?>
    <div class="container">
       <div class="row">
        <div class="col-sm">
          <h1 class="mt-2">Catalog</h1>
        </div>
      </div>
        <div class="row">
          <div class="col-sm">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Item</th>
                  <th scope="col">Description</th>
                  <th scope="col">Unit Price</th>
                  <th scope="col">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Giant Widget</td>
                  <td>A widget for your biggest machines.</td>
                  <td>$10.00</td>
                  <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="giant-widget" /></td>
                </tr>
                <tr>
                  <td>Large Widget</td>
                  <td>A widget for your bigger machines.</td>
                  <td>$7.50</td>
                  <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="large-widget" /></td>
                </tr>
                <tr>
                  <td>Standard Widget</td>
                  <td>A widget for your most common machines.</td>
                  <td>$5.00</td>
                  <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="standard-widget" /></td>
                </tr>
                <tr>
                  <td>Small Widget</td>
                  <td>A widget for your smaller machines.</td>
                  <td>$2.50</td>
                  <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="small-widget" /></td>
                </tr>
                <tr>
                  <td>Tiny Widget</td>
                  <td>A widget for your smallest machines.</td>
                  <td>$1.00</td>
                  <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="tiny-widget" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-sm text-right">
            <a href="cart.php" class="btn btn-secondary">View Cart</a>
          </div>
        </div>
      </div>
      <div class="alert alert-success fixed-bottom" id="success-alert" />
      <div class="alert alert-danger" id="failure-alert" />
    <?php require 'script_include.php' ?>
    <script src="browse.js"></script>
  </body>
</html>
