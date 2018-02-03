$(document).ready(() => {
  $.post(
    "user.php",
    { action: "test", user_email: "matt.d.burr@gmail.com" },
    response => {
      $("#content").text(response["message"]);
    },
    "json"
  );
});
