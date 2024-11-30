<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  require_once("./db.inc.php");
  require_once("./functions.inc.php");

  // Check for empty input fields
  if (emptyInputLogin($email, $password)) {
      header("Location: ../login2.php?error=emptyinput");
      exit();
  }

  // Attempt to log in user
  loginUser($connection, $email, $password);
  
} else {
  header("location: ../login.php");
  exit();
}