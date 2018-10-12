<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require('api/php/start.php');

$conn = db();

session_start();

?>

<html>
<head></head>
<body>

<?php
if (isset($_SESSION['UID'])) {
  if(isset($_POST['party'])){
    $party = $_POST['party'];
    // Show all persons to vote
    try {
      $stmt = $conn->prepare('SELECT * FROM people WHERE party = ?');
      $stmt->execute(array($party));
      $result= $stmt->fetchAll();
      echo "<form action='api/sendVote.php' method='POST'>";
      foreach ($result as $row) {
        echo "<input type='radio' name='vote' value='".$row['ID']."'>".$row['name']."</input><br>";
      }
      echo "<input type='submit' value='Submit'></form>";
    }
    catch (PDOException $e) {
      echo $e;
      die();
    }
  } else {
    header('Location: index.php');
  }
} else {
  header('Location: index.php');
}
?>

</body>
</html>
