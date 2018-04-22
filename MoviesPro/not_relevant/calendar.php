<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Calendar</title>
</head>
<body>
  <form action="calendar.php" method="post">
    <?php # Script 2.6 - calendar.php

      // This script makes 3 pull down menus
      // for an HTML form: months, days, years.

      // Make the months array
      $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December');

      // Make the months pull-down menu:
      echo '<select name="month">';
      foreach ($months as $key => $value) {
        echo "<option value=\"$key\">$value</option>\n";
      }
      echo '</select>';

      //Make the days pull-down menu:
      echo '<select name="days">';
      for ($day = 1; $day <= 31; $day++){
        echo "<option value =\"$day\">$day</option>\n";
      }
      echo '</select>';

      //Make the years pull-down menu:
      echo '<select name="years">';
      for ($year = 2011; $year <= 2021; $year++){
        echo "<option value =\"$year\">$year</option>\n";
      }
      echo '</select>';
    ?>
  </form>
</body>
</html>
