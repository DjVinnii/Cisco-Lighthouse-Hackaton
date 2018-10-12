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
  // Show all parties to vote
  try {
    $stmt = $conn->prepare('SELECT * FROM party');
    $stmt->execute();
    $result= $stmt->fetchAll();
    echo "<form action='votePerson.php' method='POST'>";
    foreach ($result as $row) {
      echo "<input type='radio' name='party' value='".$row['ID']."'>".$row['name']."</input><br>";
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
?>

</body>
</html>
