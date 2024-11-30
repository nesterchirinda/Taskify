<?php
session_start(); // Start the session
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
    <form action="./includes/login.inc.php" method="post">
        <label for="email" class="label-email">Work Email</label>
        <input type="email" name="email" id="" placeholder="Enter your email address..." value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">

        <label for="password" class="label-password">Password</label>
        <input type="password" name="password" id="" placeholder="Enter your password...">

        <button class="signup-button" type="submit" name="submit">Login</button>
    </form>

    <?php
    // Check if there are any errors and display them
    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        if ($error == "emptyinput") {
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Please fill in all fields</p>";
        } else if ($error == "wronglogin") {
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Incorrect password please try again</p>";
        } else if ($error == "userdoesnotexist") {
            echo "<p style='font-size: 13px; color: #c0193a; text-align:center;'>Incorrect email please try again</p>";
        }
    }
    ?>
</div>

<img src="images/clock.png" alt="" class="clockimg">
<p class="decor-text2">Ipsum dolor sit amet</p>

</section>
</body>
</html>
