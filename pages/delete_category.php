<?php

// sessions.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
require('connect.php');

if (isset($_POST['cat2'])) {

  $category_id = intval($_POST['cat2']);

  $stmt = $con->prepare("DELETE FROM categories WHERE category_id = ?");
  $stmt->bind_param("i", $category_id);

  if($stmt->execute()) {
    $stmt->close();
    header('Location: categories.php');
  }
}
?>
