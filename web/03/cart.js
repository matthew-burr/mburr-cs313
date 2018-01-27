$(document).ready(function() {
  $(".remove-item-btn").each(function() {
    $(this).click(function() {
      var item = $(this);
      var itm = $(item).attr("id");
      $.post("doAction.php", { action: "removeItem", item: itm }, 
        function(response) {
          var message = response["message"];
          console.log(message);
          displayAlert(message);
          $(item).closest("tr").remove();
        }, "json");
    });
  });
});
