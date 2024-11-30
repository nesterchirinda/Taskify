<?php
session_start(); // Start the session
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

        <p class="signup-code-header">Sign Up</p>
        
        <div class="signupcode-div">
        <form action="" method="post">

        <label for="email" class="label-email">Work Email</label>
        <input type="email" name="email" id="" placeholder="Enter your email address..." value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">

        <div class="signup-instruction">
        <p class="signup-txt">Please check your email for a temporary sign up code and paste it below.</p>

        </div>

        <label for="signup-code" class="label-email">Sign up code</label>
        <input type="signup_code" name="signup_code" id="">


        <button class="signup-button" type="submit" name="submit">Continue</button>

        </form>

        <?php 
        
        $verificationCode = "";
        
        if (isset($_POST['submit'])){
            
            $user_code = trim($_POST['signup_code']); // Trim user input
            $verificationCode = trim($_SESSION['verification_code']); // Trim verification code
            
            if ($user_code === $verificationCode){
                
                header('Location: welcome.php');
                
                exit();
             }
             
             else{
                
                echo "<div class='error-message'>Wrong Code, Try again!</div>";;
            
            }
        }

        if (isset($_GET["error"])){
            if ($_GET["error"] == "emptyinput"){
                echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Please fill in all fields<p/>";
          }
          
          else if ($_GET["error"] == "invalidpassword") {
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Password should be minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character<p/>";
          }}
        
        
        
        ?>

        <button class="google-signup2"><img src="images/google-icon.png" class="fab fa-google"></i>Continue with Google</button>
        <button class="apple-signup2"><i class="fa-brands fa-apple"></i>Continue with Apple</button>

        </div>

        <img src="images/clock.png" alt="" class="clockimg">
        <p class="decor-text2">Ipsum dolor sit amet</p>

</section>

    
</body>
</html>