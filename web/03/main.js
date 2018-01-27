function displayAlert(message) {
  $("#success-alert").text(message);
  $("#success-alert").fadeIn("slow", function() {
    setTimeout(function() {
      $("#success-alert").fadeOut("slow");
    }, 1000);
  });
}
