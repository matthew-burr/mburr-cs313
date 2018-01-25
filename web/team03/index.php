<!doctype html>
<html>
  <head>
    <title>Team Assignment 03</title>
  </head>
  <body>
  <?php 
    $name = $email = $major = $comments = "";
    $continentsVisited = array();
    $showForm = true;
    $showDisplay = !$showForm;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      echo "<span style='display:none;'>Posted</span>";
      empty($_POST["Name"]) or $name = clean_input($_POST["Name"]);
      empty($_POST["Email"]) or $email = clean_input($_POST["Email"]);
      empty($_POST["Major"]) or $major = clean_input($_POST["Major"]);
      empty($_POST["Comments"]) or $comments = clean_input($_POST["Comments"]);
      $showForm = false;
      $showDisplay = true;
    }
    
    empty($_POST["continent1"]) or array_push($continentsVisited, $_POST["continent1"]);
    empty($_POST["continent2"]) or array_push($continentsVisited, $_POST["continent2"]);
    empty($_POST["continent3"]) or array_push($continentsVisited, $_POST["continent3"]);
    empty($_POST["continent4"]) or array_push($continentsVisited, $_POST["continent4"]);
    empty($_POST["continent5"]) or array_push($continentsVisited, $_POST["continent5"]);
    empty($_POST["continent6"]) or array_push($continentsVisited, $_POST["continent6"]);
    empty($_POST["continent7"]) or array_push($continentsVisited, $_POST["continent7"]);
    
    function clean_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

  ?>
    <div id="contactForm" <?php if (!$showForm) echo('style="display:none;"') ?>>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      Name: <input type="text" name="Name" value="<?php echo $name; ?>" /><br />
      Email: <input type="email" name="Email" value="<?php echo $email; ?>" /><br />
      Major:<br />
      <input id="Major1" type="radio" name="Major" value="Computer Science" <?php if($major == 'Computer Science') echo "checked"; ?>>Computer Science<br />
      <input id="Major2" type="radio" name="Major" value="Web Design and Development" <?php if($major == 'Web Design and Development') echo "checked"; ?>>Web Design and Development<br />
      <input id="Major3" type="radio" name="Major" value="Computer Information Technology" <?php if($major == 'Computer Information Technology') echo "checked"; ?>>Computer Information Technology<br />
      <input id="Major4" type="radio" name="Major" value="Computer Engineering" <?php if($major == 'Computer Engineering') echo "checked"; ?>>Computer Engineering<br />
      Continents Visited:<br />
      <input  type="checkbox" name="continent1" value="North America" <?php if(!empty($_POST["continent1"])) echo "checked"; ?>>North America</input><br />
        <input  type="checkbox" name="continent2" value="South America" <?php if(!empty($_POST["continent2"])) echo "checked"; ?>>South America</input><br />
        <input  type="checkbox" name="continent3" value="Europe" <?php if(!empty($_POST["continent3"])) echo "checked"; ?>>Europe</input><br />
        <input  type="checkbox" name="continent4" value="Asia" <?php if(!empty($_POST["continent4"])) echo "checked"; ?>>Asia</input><br />
        <input  type="checkbox" name="continent5" value="Australia" <?php if(!empty($_POST["continent5"])) echo "checked"; ?>>Australia</input><br />
        <input  type="checkbox" name="continent6" value="Africa" <?php if(!empty($_POST["continent6"])) echo "checked"; ?>>Africa</input><br />
        <input  type="checkbox" name="continent7" value="Antarctica" <?php if(!empty($_POST["continent7"])) echo "checked"; ?>>Antarctica</input><br />
      Comments:<br />
      <textarea name="Comments" rows="5" cols="40"><?php echo $comments; ?></textarea><br />
      <input type="submit" value="Submit" />
    </form>
    </div>
    <div id="contactDisplay" <?php if (!$showDisplay) echo('style="display:none;"'); ?>>
      Name: <?php echo $name ?><br />
      Email: <?php echo $email ?><br />
      Major: <?php echo $major ?><br />
      Continents Visited: <?php echo join(", ", $continentsVisited); ?><br />
      Comments: <?php echo $comments ?><br />
    </div>
  </body>
</html>
