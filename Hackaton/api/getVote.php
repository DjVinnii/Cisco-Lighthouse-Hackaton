<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);

require('php/start.php');

$conn = db();

?>

<html>
  <head>
    <title>Elections for the federal Chamber of Representatives</title>
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
<?php

if(isset($_GET['UID'])){
  $UID = $_GET['UID'];
  ?>
  <h1>Elections for the federal Chamber of Representatives 2019</h1>
  <h2>Check your vote</h2>
  <?php
  echo "<form action='getVote.php'' method='POST'>
  <p>UID:</p> <input type='text' name='UID' value='$UID' readonly='readonly'><br>
  <p>Enter your secret code:</p> <input type='text' name='code'><br>
  <input type='submit' value='Check your vote'></form>";
} else {
  if(isset($_POST['code']) || isset($_POST['UID'])){
    $code = $_POST['code'];
    $UID = $_POST['UID'];
    $hash = openssl_encrypt($UID, 'AES-128-ECB', $code);

    // Check if params aren't empty
    if(empty($UID)){
      echo "Params are empty";
    } else {
      // Request vote from DB

      try {
        // Retrieve person number
        $stmt = $conn->prepare("SELECT * FROM votes WHERE hash = ?");
        $stmt->execute(array($hash));
        $result = $stmt->fetch();
        $vote = $result['vote'];

        // Retrieve name and party ID of the candidate
        $stmt = $conn->prepare("SELECT * FROM people WHERE ID = ?");
        $stmt->execute(array($vote));
        $result = $stmt->fetch();
        $name = $result['name'];
        $partyID = $result['party'];

        // Retrieve party from partyID
        // Retrieve name and party ID of the candidate
        $stmt = $conn->prepare("SELECT * FROM party WHERE ID = ?");
        $stmt->execute(array($partyID));
        $result = $stmt->fetch();
        $partyName = $result['name'];

        ?>
        <h1>Elections for the federal Chamber of Representatives 2019</h1>
        <h2>Your vote</h2>
        <?php

        // if there isn't any result the user hasn't access to the information
        if($stmt->rowCount() == 1){
          echo "You voted for " .$name. " from " .$partyName;
        } else {
          echo "Access denied!<br>";
          echo "Click <a href='getVote.php?UID=".$UID."'>here</a> to go back";
        }

      }catch(PDOException $e){
        echo $e;
        die();
      }
    }
  }
}
 ?>
</body>
</html>
