<?php # Script - updatetickets.php
session_start();
// This page will confirm that an administrator has made changes to a theater's number of available tickets
$page_title = 'Gift Tickets';
include ('includes/header.html');
require_once('../mysqli_connect.php'); // Connect to the db.

$q = "SELECT * FROM theaters";
$r = @mysqli_query($dbc, $q); // Run the query
$q2 = "SELECT * FROM movies";
$r2 = @mysqli_query($dbc, $q2); // Run the query
$query_num_seats = "SELECT seats_purchased FROM movies_theaters WHERE movie_id = $mo AND theater_id = $th";
$res = @mysqli_query($dbc, $query_num_seats);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = array();

  // Check for theater
  if (empty($_POST['theater'])) {
    $errors[] = 'You forgot to choose your theater.';
  } else {
    $th = mysqli_real_escape_string($dbc, trim($_POST['theater']));
  }

  // Check for movie
  if (empty($_POST['movie'])) {
    $errors[] = 'You forgot to choose your movie.';
  } else {
    $mo = mysqli_real_escape_string($dbc, trim($_POST['movie']));
  } //echo "$mo";

  // Check for ticket quantity
  if (empty($_POST['new_total_seats'])) {
    $errors[] = 'You forgot to specify the new number of seats for this theater.';
  } else {
    $nts = mysqli_real_escape_string($dbc, trim($_POST['new_total_seats']));
  } //echo "$th";

  if (empty($_POST['new_price'])) {
    $errors[] = 'You forgot to specify the new price for this theater.';
  } else {
    $np = mysqli_real_escape_string($dbc, trim($_POST['new_price']));
  }

  if ($res > $_POST['new_total_seats']) {
    $errors[] = 'The number of purchased tickets is already greater than the new number of available seats.';
  }


  if (empty($errors)) { // Postback and all clear

    // Make an update query'
    for ($i = 0; $i < $_POST['num_tickets']; $i++){

      $q3 = "UPDATE theaters SET seats_per_theater = $nts, price = $np WHERE theater_id = $th";
      $r3 = @mysqli_query($dbc, $q3); // Create a ticket record
    }
    if ($r3) { // If the query worked.
      $q4 = "SELECT movie_title FROM movies WHERE movie_id = $mo";
      $r4 = @mysqli_query($dbc, $q4);
      $result = mysqli_fetch_array($r4);
      $result = $result['movie_title'];

      $q5 = "SELECT theater_name FROM theaters WHERE theater_id = $th";
      $r5 = @mysqli_query($dbc, $q5);
      $result2 = mysqli_fetch_array($r5);
      $result2 = $result2['theater_name'];
      // Print a message:
      echo "<h1>Thank You!</h1>
      <p>You have gifted tickets to see $result at $result2 to $e!</p><p><br /></p>";
    } else { // If the query failed

      echo '<h1>System Error</h1>
      <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

      // Debugging message:
      echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
    }

    mysqli_close($dbc);

    include ('includes/footer.html');
    exit();

  } else { // Report the errors.

    echo '<h1>Error!</h1>
    <p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) { //Print each error.
      echo " - $msg<br />\n";
    }
    echo '</p><p>Please try again.</p><p><br /></p>';
  } // End of if (empty($errors)) IF

} // End of main Submit Conditional.
?>
