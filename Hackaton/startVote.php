<html>
  <head>
    <title>Elections for the federal Chamber of Representatives</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <h1>Elections for the federal Chamber of Representatives 2019</h1>
    <p>First of all you have to fill in a secret key.
      This key is neccesary to check your vote later on.
      This secret key won't be saved on any server.</p>
<?php
session_start();

if (isset($_SESSION['UID'])) {
  // echo "Click <a href='voteParty.php'>here</a> to continue to the voting";
  header('Location: voteParty.php');
} else {
  ?>
  <form action='api/getUID.php' method='POST'>
  <p>Choose a secret code:</p><input type='text' name='code'><br><br>
  <input type='submit' value='Go to the voting'></form>
  <?php
}
?>
<body>
</html>
