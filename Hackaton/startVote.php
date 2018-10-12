<?php
session_start();

if (isset($_SESSION['UID'])) {
  // echo "Click <a href='voteParty.php'>here</a> to continue to the voting";
  header('Location: voteParty.php');
} else {
  ?>
  <form action='api/getUID.php' method='POST'>
  <p>Choose a secret code:</p><input type='text' name='code'><br>
  <input type='submit' value='Go to the voting'></form>
  <?php
}
?>
