<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sorting Arrays</title>
</head>
<body>
  <table border="0", cellspacing="3", cellpadding="3", align="center">
    <tr>
      <td><h2>Rating</td></h2>
      <td><h2>Title</td></h2>
    </tr>
    <?php # Script 2.8 - sorting.php

      // Create the array:
      $movies = array(
        'Casablanca' => 10,
        'To Kill a Mockingbird' => 10,
        'The English Patient' => 2,
        'Stranger than Fiction' => 9,
        'Story of the Weeping Camel' => 5,
        'Donnie Darko' => 7
      );

      // Display the movies in their original order:
      echo '<tr><td colspan="2"><b>In their original order:</b></td></tr>';
      foreach ($movies as $title => $rating) {
        echo "<tr><td>$rating</td>
        <td>$title</td></tr>\n";
      }

      // Display the movies sorted by title:
      ksort($movies);
      echo '<tr><td colspan="2"><b>Sorted by title:</b></td></tr>';
      foreach ($movies as $title => $rating) {
        echo "<tr><td>$rating</td>
        <td>$title</td></tr>\n";
      }

      // Display the movies sorted by rating:
      arsort($movies);
      echo '<tr><td colspan="2"><b>Sorted by rating:</b></td></tr>';
      foreach ($movies as $title => $rating) {
        echo "<tr><td>$rating</td>
        <td>$title</td></tr>\n";
      }
      
    ?>
  </table>
</body>
</html>
