<?php
session_start(); // Start the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Function to check if email is empty
function emptyInputSignup($email) {
    return empty($email);
}

// Function to check if email is invalid
function invalidEmail($email) {
    return !preg_match('/^\S+@\S+\.\S+$/', $email);
}





if (isset($_POST['submit'])) {
    // Check for empty input fields
    if (emptyInputSignup($_POST['email'])) {
        header("Location: signup.php?error=emptyinput");
        exit();
    }

    // Check for invalid email format
    if (invalidEmail($_POST['email'])) {
        header("Location: signup.php?error=invalidemail");
        exit();
    }

    // If input is valid, proceed with sending email
    $_SESSION['email'] = $_POST['email'];

    // Generate a random 6-digit code
    $verificationCode = sprintf('%06d', mt_rand(0, 999999));

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'chirindanester@gmail.com';
    $mail->Password = 'qcvsppgotznuluhg';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Sender
    $mail->setFrom('chirindanester@gmail.com');

    // Receiver
    $email = $_POST['email'];
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Taskify Sign-up code';
    $mail->Body = "Thanks for creating a Taskify account. Here's your sign up code: " . $verificationCode;

    // Send email
    if ($mail->send()) {
        header('Location: signupcode.php');
        $_SESSION['verification_code'] = $verificationCode;
    } else {
        echo "<script>alert('Failed to send verification code');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
<section class="home">
    <a href="index.php" class="logo"> 
        <img src="images/logo.png" alt="logo">
    </a>

    <p class="signup-login-header">Sign Up</p>
    
    <div class="signup-div">
        <form action="" method="post">
            <button class="google-signup"><img src="images/google-icon.png" class="fab fa-google"></i>Continue with Google</button>
            <button class="apple-signup"><i class="fa-brands fa-apple"></i>Continue with Apple</button>
            
            <label for="email" class="label-email">Work Email <Address></Address></label>
            <input type="email" name="email" id="" placeholder="Enter your email address...">

            <button class="signup-button" type="submit" name="submit">Continue with email</button>
        </form>

        <?php
      if (isset($_GET["error"])){
        if ($_GET["error"] == "emptyinput"){
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Please enter your email<p/>";
      }
      else if ($_GET["error"] == "invalidemail") {
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Invalid email format<p/>";
      }

      else if ($_GET["error"] == "emailinuse") {
        echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> This email is already in use<p/>";
      }
      elseif ($_GET["error"] == "stmtfailed") {
        echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Something went wrong <p/>" ;
    }}

    ?>

        <a class="login-link" href="login.php">Already signed up?</a>
    </div>

    <img src="images/clock.png" alt="" class="clockimg">
    <p class="decor-text2">Ipsum dolor sit amet</p>
</section>
</body>
</html>
