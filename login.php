<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once("includes/db.inc.php");

// Function to check if email is invalid
function invalidEmail($email) {
   
    return !preg_match('/^\S+@\S+\.\S+$/', $email);
}

if (isset($_POST["submit"])) {
    $email = $_POST["email"];

    // Function to check for empty input fields
    function emptyInputLogin($email) {
        if (empty($email)) {
            return true; // Return true if email is empty
        } else {
            return false; // Return false if email is not empty
        }
    }

    // Check for empty input fields
    if (emptyInputLogin($email)) {
        header("Location: login.php?error=emptyinput");
        exit();
    }

    // Check for invalid email format
    if (invalidEmail($_POST['email'])) {
        header("Location: login.php?error=invalidemail");
        exit();
    }

    // Function to check if the email is registered
    function emailRegistered($connection, $email) {
        $sql = "SELECT * FROM users WHERE usersEmail = ?";
        $stmt = mysqli_stmt_init($connection);
    
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Error handling if SQL statement preparation fails
            return false; // Return false on failure
        }
    
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($resultData)) { 
            // Email is found in database
            mysqli_stmt_close($stmt);
            return $row; // Return user data if email is found
        } else {
            // Email is not found in database
            mysqli_stmt_close($stmt);
            return false; // Return false if email is not found
        }
    }

    // Check if the user exists
    $userExists = emailRegistered($connection, $email);

    if ($userExists === false) {
        header("Location: login.php?error=userdoesnotexist");
        exit();
    } else {

        $_SESSION['email'] = $email;
        header("Location: login2.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>




<body>
<section class="home">

<a href="index.php" class="logo"> 
        <img src="images/logo.png" alt="logo">
     </a>

    <p class="signup-login-header">Log In</p>
    
    <div class="signup-div">
    <form action="" method="post">
    <button class="google-signup"><img src="images/google-icon.png" class="fab fa-google"></i>Continue with Google</button>
    <button class="apple-signup"><i class="fa-brands fa-apple"></i>Continue with Apple</button>

    
    <label for="email" class="label-email">Work Email</label>
    <input type="email" name="email" id="" placeholder="Enter your email address...">
    <button class="signup-button" type="submit" name="submit">Continue with email</button>
    </form>

    <?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p style='font-size: 13px;  color: #c0193a; text-align:center;'> Please enter your email<p/>";
    } else if ($_GET["error"] == "userdoesnotexist") {
        echo "<p style='font-size: 13px;  color: #c0193a; text-align:center'> User not registered please sign up<p/>";
    } else if ($_GET["error"] == "invalidemail") {
        echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Invalid email format<p/>";
    }
}
?>


    <a href="" class="forgotpass">Forgot your password?</a>

    </div>

    <img src="images/clock.png" alt="" class="clockimg">
    <p class="decor-text2">Ipsum dolor sit amet</p>

</section>
    




</body>
</html>