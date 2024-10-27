<?php

// sessions.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
require('connect.php');

if (isset($_POST['user2']) && isset($_POST['person2'])) {


  $user2 = intval($_POST['user2']);
  $person2 = intval($_POST['person2']);

  $stmt = $con->prepare("DELETE FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $user2);

  if($stmt->execute()) {
    $stmt->close();

    $stmt2 = $con->prepare("DELETE FROM person WHERE person_id = ?");
    $stmt2->bind_param("i", $person2);

    if($stmt2->execute()) {
        $stmt2->close();
        header('Location: users.php');
    }
  }
}
?>
