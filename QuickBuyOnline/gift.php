<?php # Script - gift.php
session_start();
// This page will confirm that an administrator has gifted tickets. It will show an error if there is a failure of any kind. This will also eventually validate the number of tickets against the number of tickets available
$page_title = 'Gift Tickets';
include ('includes/header.html');
require_once('../mysqli_connect.php'); // Connect to the db.

$q = "SELECT * FROM theaters";
$r = @mysqli_query($dbc, $q); // Run the query
$q2 = "SELECT * FROM movies";
$r2 = @mysqli_query($dbc, $q2); // Run the query

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
  if (empty($_POST['num_tickets'])) {
    $errors[] = 'You forgot to specify the number of tickets.';
  } else {
    $qu = mysqli_real_escape_string($dbc, trim($_POST['num_tickets']));
  } //echo "$th";

  if (empty($_POST['email'])) {
    $errors[] = 'You forgot to specify to whom the tickets will be gifted.';
  } else {
    $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
  }

  $purchased_seats = "SELECT seats_purchased FROM movies_theaters WHERE movie_id = $mo AND theater_id = $th";
  $purchased_seats_results = @mysqli_query($dbc, $purchased_seats);
  $purchased_seats_num = mysqli_fetch_array($purchased_seats_results);
  $total_seats = "SELECT seats_per_theater FROM theaters WHERE theater_id = $th";
  $total_seats_results = @mysqli_query($dbc, $total_seats); // Should be 100
  $total_seats_num = mysqli_fetch_array($total_seats_results);
  $test_seats = $purchased_seats_num[0] + $_POST['num_tickets'];
// DEBUGGING MESSAGE
  /*echo "<h1>These are my Variables!</h1><p>$th, $mo, $total_seats_num[0], $purchased_seats_num[0], $test_seats</p>";*/
  if ($test_seats > $total_seats_num[0]) {
    $errors[] = 'There are not enough seats available at this theater please choose a different amount';
  }

  if (empty($errors)) { // Postback and all clear

    // Make an update query'
    for ($i = 0; $i < $_POST['num_tickets']; $i++){
      $q3 = "INSERT INTO tickets (movie_id, theater_id, price) VALUES ($mo, $th, 0.00)";
      $r3 = @mysqli_query($dbc, $q3); // Create a ticket record
      $query_update_seats = "UPDATE movies_theaters SET seats_purchased = $test_seats WHERE movie_id = $mo AND theater_id = $th";
      $res = @mysqli_query($dbc, $query_update_seats);
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
