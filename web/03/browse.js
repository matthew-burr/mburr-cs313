$(document).ready(function() {
  $(".add-to-cart-btn").each(function() {
    $(this).click(function() {
      var itm = $(this).attr("id");
      $.post("doAction.php", { action: "addItem", item: itm }, 
        function(response) {
          var message = response["message"];
          console.log(message);
          displayAlert(message);
        }, "json");
    });
  });
});

