<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require('api/php/start.php');

$conn = db();

session_start();

?>

<html>
<head>
  <title>Elections for the federal Chamber of Representatives</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <h1>Elections for the federal Chamber of Representatives 2019</h1>
  <h1>Party</h1>
  <h2>Vote for your party</h2>
  <div id="pollContainer">
    <div id="pollSection">
      <div id="pollButtons">

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
            echo "<br><input type='submit' value='Submit'></input></form>";
          }
          catch (PDOException $e) {
            echo $e;
            die();
          }
        } else {
          header('Location: index.php');
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
