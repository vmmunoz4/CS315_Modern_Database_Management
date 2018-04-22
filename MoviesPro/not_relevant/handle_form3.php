<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form Feedback</title>
</head>
<body>
  <?php # Script 2.5 - handle_form3.php

    // Print the submitted information:
    if ( !empty($_POST['name']) && !empty($_POST['comments']) && !empty($_POST['email']) )
    {
      echo "<p>Thank You, <b>{$_POST['name']}</b>, for the following comments:
        <br /> <tt>{$_POST['comments']}</tt></p>
        <p>We will reply to you at <i>{$_POST['email']}</i>.</p>\n";
    } else { // Missing form value.
      echo '<p>Please go back and fill out the form again.</p>';
    }
  ?>
</body>
</html>
