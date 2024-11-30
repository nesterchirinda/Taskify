<?php

session_start(); // Start the session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST["submit"])) {

    require_once("includes/functions.inc.php");

    $name = $_POST["name"];
    $password = $_POST["password"];

    // Set session variables
    $_SESSION['name'] = $name;
    $_SESSION['password'] = $password;

    // Check for empty input fields
    if (emptyInputSignup($name, $password)) {
        header("Location: welcome.php?error=emptyinput");
        exit();
    }

    // Check if password meets requirements
    if (invalidPwd($password)) {
        header("Location: welcome.php?error=invalidpassword");
        exit();
    }

    if (!emptyInputSignup($name, $password) && !invalidPwd($password)) {
        header("Location: account.php");
        exit(); 
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>




<body>
<section class="home">

    <a href="index.php" class="logo"> 
            <img src="images/logo.png" alt="logo">
         </a>

        <p class="welcome-header">Welcome to Taskify</p>
        <p class="welcome-p">Tell us a bit about yourself.</p>
        
        <div class="welcome-div">
        <div class="image-container">
             <img src="images/welcome.png" class="welcome-img">
        </div>
        <form action="" method="post">
        
        <label for="name" class="label-name">What should we call you?</label>
        <input type="name" name="name" id="" placeholder="Enter your name">

        <label for="password" class="password">Set a password</label>
        <input type="password" name="password" id="password" placeholder="New password">
        <i class="fa-regular fa-eye" id="togglePassword"></i> 


        <?php
      if (isset($_GET["error"])){
        if ($_GET["error"] == "emptyinput"){
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center; margin:0; position: relative; bottom:10px;' > Please fill in all fields<p/>";
      }

      else if ($_GET["error"] == "invalidpassword") {
        echo "<div style='font-size: 13px; color: #c0193a; width:310px; text-align:center; position: relative; bottom:10px; margin-bottom:10px;'> Password should be minimum 8 characters, at least one uppercase letter, one lowercase letter, and one number.</div>";
    }
    
    
      
    }

    ?>



        <button class="signup-button" type="submit" name="submit">Continue</button>
        </form>
        

        <img src="images/darts.png" alt="" class="dartspng">
        <img src="images/lost.png" alt="" class="listpng">

        </div>
</section>

<script>

document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the document
    document.addEventListener('click', function(event) {

        if (event.target.id == 'togglePassword') {

            const passwordInput = document.getElementById("password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

    });
});



</script>

    
</body>
</html>