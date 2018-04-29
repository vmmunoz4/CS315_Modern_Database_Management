<?php # Script - purchase.php
session_start();
// This page will check that the user is logged in
// FOR SOME REASON THE LOGIN PAGE DOES NOT SET THE ADMINISTRATOR VALUE CORRECTLY! UNLESS IT'S DEFAULTING TO TRUE THIS PAGE DOES NOT WORK FOR ADMINS!!!
$page_title = 'Purchase Tickets';
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
    for ($i = 0; $i < $qu; $i++){
      $q3 = "INSERT INTO tickets (movie_id, theater_id, price) VALUES ($mo, $th, 10.00)";
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
      <p>You have purchased a ticket to see $result at $result2!</p><p><br /></p>";
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

<div class="purchase_page">
  <div class="purchase">
  <h1>Purchase Tickets</h1><br /><br />
    <form action="purchase.php" method="post">
      <label for="theater">Theater: </label>
      <select name="theater">
        <?php
          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<option value="' . $row['theater_id'] . '">' . $row['theater_name'] . '</option>';
          }
        ?>
      </select><br /><br />

      <label for="movie">Movie: </label>
      <select name="movie">
        <?php
          while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
            echo '<option value="' . $row2['movie_id'] . '">' . $row2['movie_title'] . '</option>';
          }
        ?>
      </select><br /><br />
      <label for="num_tickets">Quantity: </label>
      <input type="number" name="num_tickets"><br /><br />
      <input type="submit" name="purchase" value="Purchase" class="btn btn-default" />

      <?php
        //echo "<h3> PHP List All Session Variables</h3>";
        //foreach ($_SESSION as $key=>$val)
        //echo $key." ".$val."<br/>";
      ?>
    </form>
  </div>

  <?php
    if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == true) {
  ?>

  <div class="purchase">
  <h1>Gift Tickets</h1><br /><br />
    <form action="gift.php" method="post">
      <label for="theater">Theater: </label>
      <select name="theater">
        <?php
          $q = "SELECT * FROM theaters";
          $r = @mysqli_query($dbc, $q); // Run the query
          $q2 = "SELECT * FROM movies";
          $r2 = @mysqli_query($dbc, $q2); // Run the query
          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<option value="' . $row['theater_id'] . '">' . $row['theater_name'] . '</option>';
          }
        ?>
      </select><br /><br />

      <label for="movie">Movie: </label>
      <select name="movie">
        <?php
          while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
            echo '<option value="' . $row2['movie_id'] . '">' . $row2['movie_title'] . '</option>';
          }
        ?>
      </select><br /><br />
      <label for="num_tickets">Quantity: </label>
      <input type="number" name="num_tickets"><br /><br />

      <label for="email">User Email: </label>
      <input type="text" name="email" size="20" maxlength="60" /><br /><br />
      <input type="submit" name="gift" value="Gift" class="btn btn-default" />

    </form>
  </div>

  <div class="purchase">
  <h1>Update Tickets</h1><br /><br />
    <form action="updatetickets.php" method="post">
      <label for="theater">Theater: </label>
      <select name="theater" id="theater">
        <?php
        $q = "SELECT * FROM theaters";
        $r = @mysqli_query($dbc, $q); // Run the query
          while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            echo '<option value="' . $row['theater_id'] . '">' . $row['theater_name'] . '</option>';
          }
        ?>
      </select><br /><br />

      <label for="new_total_seats">New Total Seats: </label>
      <input type="number" name="new_total_seats">
      </select><br /><br />

    <!-- Find a way to validate that this is a price (regex?) -->
      <label for="new_price">New Price: </label>
      <input type="text" name="new_price" pattern="\d{1,3}(?:[.,]\d{3})*(?:[.,]\d{2})"><br /><br />
      <input type="submit" name="update" value="Update" class="btn btn-default" />


    </form>
  </div>
</div>
<?php } ?>
<br /><br /><br />
<?php
mysqli_close($dbc);
include ('includes/footer.html');
?>
