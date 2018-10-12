<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

require('php/start.php');
$conn = db();

if(isset($_POST['code'])){
  $code = $_POST['code'];

} else {
  header('Location: ../index.php');
}

  // Generate UID
  $UID = uniqid();

  // Generate Hashed UID
  $hash = openssl_encrypt($UID, 'AES-128-CBC', $code);

  // Insert UID into DB

  try {
    // $stmt = $conn->prepare("INSERT INTO votes (UID, hash) VALUES (?, ?)");
    // $stmt->execute(array($UID, $hash));

    // Insert the hased UID into the DB
    $stmt = $conn->prepare("INSERT INTO votes (hash) VALUES (?)");
    $stmt->execute(array($hash));
    header('Location: ../startVote.php');
    $_SESSION['UID'] = $UID;
    $_SESSION['hash'] = $hash;
  } catch(PDOException $e){
    echo $e;
    die();
  }
?>
