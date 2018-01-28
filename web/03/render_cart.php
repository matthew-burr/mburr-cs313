          <?php 
              require 'helper.php';

              isset($_SESSION["cart"]) or die;
              $cart = $_SESSION["cart"];

              function renderCart($withButtons) {
                renderHeader($withButtons);
                renderBody($withButtons);
                renderFooter();
              }
              function renderHeader($withButtons) {
                  echo ' <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Count</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Total Price</th>';
                  if ($withButtons) {echo '<th scope="col">&nbsp;</th>';}
                  echo '
                      </tr>
                    </thead>
                    <tbody id="cart-contents">';
                }

                function renderBody($withButtons) {
                  global $cart;
                  foreach($cart as $item => $count) {
                    $name = getName($item);
                    $price = getPrice($item);
                    $total = $price * $count;
                    $priceStr = money_format('%.2n', $price); // Per comments at http://php.net/manual/en/function.money-format.php
                    $totalStr = money_format('%.2n', $total);
                    echo "<tr><td>$item</td><td>$count</td><td>$priceStr</td><td>$totalStr</td>";
                    if ($withButtons) {
                      echo "<td><input type='button' class='btn btn-primary remove-item-btn' value='Remove' id='$item' /></td>";
                    }
                    echo "</tr>";
                  }
                  $grandTotal = array_reduce(array_keys($_SESSION["cart"]), "sumCartItems", 0);

                  $grandTotalStr = money_format('%.2n', $grandTotal);
                  echo "<tr class='table-info'><td>Grand Total</td><td>&nbsp;</td><td>&nbsp;</td><td id='grand-total-cell'>$grandTotalStr</td>";
                  if ($withButtons) {
                    echo "<td>&nbsp;</td>";
                  }
                  echo "</tr>";
                }

                function getName($item) {
                  global $catalog;
                  $itemDetail = $catalog[$item];
                  return $itemDetail["name"];
                }

                function getPrice($item) {
                  global $catalog;
                  $itemDetail = $catalog[$item];
                  return $itemDetail["unit-price"];
                }

                function renderFooter() {
                  echo '
                  </tbody>
                </table> <!-- table -->';
                }
?>

