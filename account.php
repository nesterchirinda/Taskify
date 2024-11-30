<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 

include_once "includes/db.inc.php";
include_once "includes/functions.inc.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if session variables are set
    if (isset($_SESSION['name'], $_SESSION['email'], $_SESSION['password'], $_POST['account-type'])) {

        // Get session data
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        $accountType = $_POST['account-type'];

        // Process signup 
        createUser($connection, $name, $email, $password, $accountType);

        // Get auto-generated user ID
        $userId = mysqli_insert_id($connection); 

        // Store the user ID in a session variable
        $_SESSION['userid'] = $userId;

        $_SESSION['account-type'] = $accountType;

        if ($accountType === "team-user") {
            $sql = "INSERT INTO team_members (usersId) VALUES (?)";
            $stmt = mysqli_stmt_init($connection);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                // code to handle error
            }
        } elseif ($accountType === "admin-user") {
            header("Location: create_team.php");
            exit();
        }
        
        // Redirect to login.php
        header("Location: login.php");
        exit();

    } else {
        header("Location: signup.php?error=missing_session_variables");
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
    <p class="account-header">How do you want to use Taskify?</p>
    <form action="" method="post">
        <div class="options-container">
            <div class="option">
                <input type="radio" id="personal-use" name="account-type" value="basic-user">
                <label for="personal-use">
                    <i class="fa-regular fa-circle"></i> 
                    <img src="images/landing page person.png" alt="Option 3">
                    <p class="account-heading">As an individual user</p>
                    <p class="subheading">Manage your daily personal tasks and stay organized.</p>
                </label>
            </div>
            <div class="option">
                <input type="radio" id="team-use" name="account-type" value="team-user">
                <label for="team-use">
                    <i class="fa-regular fa-circle"></i> 
                    <img src="images/teams.png" alt="Option 1">
                    <p class="account-heading">As a team member</p>
                    <p class="subheading">Collaborate with team members and manage assigned projects.</p>
                </label>
            </div>
            <div class="option">
                <input type="radio" id="manage-team" name="account-type" value="admin-user">
                <label for="manage-team">
                    <i class="fa-regular fa-circle"></i> 
                    <img src="images/groupadmin.png" alt="Option 2">
                    <p class="account-heading">As a team leader</p>
                    <p class="subheading">Assign tasks to team members and track their progress.</p>
                </label>
            </div>
        </div>
        <button class="continue-button" type="submit" name="submit">Create new account</button>
    </form>
</section>

<script src="js/script.js"></script>
</body>
</html>
