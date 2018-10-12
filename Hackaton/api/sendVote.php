<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require('php/start.php');

session_start();

$conn = db();
?>

<html>
<head>
  <head>
    <title>Elections for the federal Chamber of Representatives</title>
    <link rel="stylesheet" href="../css/style.css">
  </head>
</head>
<body>
  <h1>Elections for the federal Chamber of Representatives 2019</h1>
  <h1>Success</h1>

  <?php

  // Check if UID exists, otherwise back to index
  if (isset($_SESSION['UID'])){
    $UID = $_SESSION['UID'];
  } else {
    header('Location: ../index.php');
  }

  if (isset($_POST['vote'])){
    $vote = $_POST['vote'];
  } else {
    header('Location: ../vote.php');
  }

  // Check if params aren't empty
  if(empty($vote)){
    echo "Params are empty";
  } else {
    // Check if UID exists and vote is empty
    try {
      $stmt = $conn->prepare("SELECT * FROM votes WHERE hash = ? AND vote = ?");
      $stmt->execute(array($_SESSION['hash'], 0));
      $count = $stmt->rowCount();
      if($count == 1){
        // Insert vote into DB
        try {
          $stmt = $conn->prepare("UPDATE votes SET vote=? WHERE hash = ?");
          $stmt->execute(array($vote, $_SESSION['hash']));

          echo "Your vote has succesfully been send. If you like you could check your vote by scanning the QR code<br><br>";
          // Request QR code
          echo "<img src='https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://10.110.131.235/hackaton/api/getVote.php?UID=$UID'/><br><br>";
          echo "Click <a href='../index.php'>here</a> to return to Start";



          // Destroy session if vote has been send
          session_destroy();

        } catch(PDOException $e){
          echo $e;
          die();
        }
      } else {
        echo "UID not in DB or already voted";
        die();
      }
    } catch (PDOException $e){
      echo $e;
      die();
    }
  }
  ?>
</body>
</html>
