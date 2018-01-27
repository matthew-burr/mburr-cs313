<!doctype html>
<html>
  <head>
    <?php require 'header_include.php' ?>
    <title>Shopping Cart</title>
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
                <th scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Giant Widget</td>
                <td>A widget for your biggest machines.</td>
                <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="giant-widget" /></td>
              </tr>
              <tr>
                <td>Large Widget</td>
                <td>A widget for your bigger machines.</td>
                <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="large-widget" /></td>
              </tr>
              <tr>
                <td>Standard Widget</td>
                <td>A widget for your most common machines.</td>
                <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="standard-widget" /></td>
              </tr>
              <tr>
                <td>Small Widget</td>
                <td>A widget for your smaller machines.</td>
                <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="small-widget" /></td>
              </tr>
              <tr>
                <td>Tiny Widget</td>
                <td>A widget for your smallest machines.</td>
                <td class="text-right"><input type="button" value="Add to cart" class="btn btn-primary add-to-cart-btn" id="tiny-widget" /></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm text-right">
          <input type="submit" class="btn btn-secondary" value="View Cart" />
        </div>
      </div>
    </div>
    <?php require 'script_include.php' ?>
  </body>
</html>
