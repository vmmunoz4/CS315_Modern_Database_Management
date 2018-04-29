<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Multidimensional Arrays</title>
</head>
<body>
  <p>Some North American States, Provinces, and Territories:</p>
  <?php # Script 2.7 - multi.php
    // Create one array:
    $mexico = array(
      'YU' => 'Yucatan',
      'BC' => 'Baja California',
      'OA' => 'Oaxaca'
    );

    // Create another array:
    $us = array(
      'MD' => 'Maryland',
      'IL' => 'Illinois',
      'PA' => 'Pennsylvania',
      'IA' => 'Iowa'
    );

    // Create a third array:
    $canada = array(
      'QC' => 'Quebec',
      'AB' => 'Alberta',
      'NT' => 'Northwestern Territories',
      'YT' => 'Yukon',
      'PE' => 'Prince Edward Island'
    );

    // Combine the arrays:
    $n_america = array(
      'Mexico' => $mexico,
      'United States' => $us,
      'Canada' => $canada
    );

    // Loop through the countries:
    foreach ($n_america as $country => $list){

      // Print a heading:
      echo "<h2>$country</h2><ul>";

      // Print each state, province, or territory:
      foreach ($list as $k => $v) {
        echo "<li>$k - $v</li>\n";
      }

      //Close the list:
      echo '</ul>';

    } // End of main FOREACH

  ?>
</body>
</html>
