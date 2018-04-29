<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Form Feedback</title>
  <style type="text/css" title="text/css" media="all">
    .error {
      font-weight: bold;
      color: #C00;
    }
  </style>
</head>
<body>
  <?php # Script 2.4 - handle_form2.php

    // Validate the name:
    if (!empty($_REQUEST['name'])){
      $name = $_REQUEST['name'];
    } else {
      $name = NULL;
      echo '<p class="error">You forgot to enter your name!</p>';
    }

    // Validate the email:
    if (!empty($_REQUEST['email'])){
      $email = $_REQUEST['email'];
    } else {
      $email = NULL;
      echo '<p class="error">You forgot to enter your email address!</p>';
    }

    // Validate the comments:
    if (!empty($_REQUEST['comments'])){
      $comments = $_REQUEST['comments'];
    } else {
      $comments = NULL;
      echo '<p class="error">You forgot to enter your comments!</p>';
    }

    // Validate the gender:
    if (isset($_REQUEST['gender'])){
      $gender = $_REQUEST['gender'];

      if ($gender == 'M') {
        echo '<p><b>Good day, Sir!</b></p>';
      } elseif ($gender == 'F') {
        echo '<p><b>Good day, Madam!</b></p>';
      } else { //Unacceptable value.
        $gender = NULL;
        echo '<p class="error">Gender should be either "M" or "F"!</p>';
      }
    } else { // $_REQUEST['gender'] is not set.
      $gender = NULL;
      echo '<p class="error">You forgot to select your gender</p>';
    }

    // If everything is OK, print the message:
    if ($name && $email && $gender && $comments) {
      echo "<p>Thank you, <b>$name</b>, for the following comments:<br \>
      <tt>$comments</tt></p>
      <p>We will reply to you at <i>$email</i>.</p>\n";

    } else {
      echo '<p class="error">Please go back and fill out the form again.</p>';
    }
  ?>
</body>
</html>
