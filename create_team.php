<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include_once "includes/db.inc.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the team name is provided
    if (isset($_POST['team-name']) && !empty($_POST['team-name'])) {
        $teamName = $_POST['team-name'];

        // Insert the team name into the teams table
        $sqlInsertTeam = "INSERT INTO teams (teamName) VALUES (?)";
        $stmtInsertTeam = mysqli_stmt_init($connection);
        if (mysqli_stmt_prepare($stmtInsertTeam, $sqlInsertTeam)) {
            mysqli_stmt_bind_param($stmtInsertTeam, "s", $teamName);
            mysqli_stmt_execute($stmtInsertTeam);

            // Get the auto-generated teamId
            $teamId = mysqli_insert_id($connection);

            // Close the statement
            mysqli_stmt_close($stmtInsertTeam);

            $_SESSION['team_name'] = $teamName;

            // If the user is an admin-user, insert their user ID into the group_admins table
            if ($_SESSION['account-type'] === "admin-user") {
                $userId = $_SESSION["userid"]; 

                // Insert the user ID and team ID into the group_admins table
                $sqlInsertAdmin = "INSERT INTO group_admins (usersId, teamId) VALUES (?, ?)";
                $stmtInsertAdmin = mysqli_stmt_init($connection);
                if (mysqli_stmt_prepare($stmtInsertAdmin, $sqlInsertAdmin)) {
                    mysqli_stmt_bind_param($stmtInsertAdmin, "ii", $userId, $teamId);
                    mysqli_stmt_execute($stmtInsertAdmin);
                    mysqli_stmt_close($stmtInsertAdmin);
                } else {
                    echo "Error inserting user into group admins: " . mysqli_error($connection);
                }
            }

            // Redirect the user to the login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error inserting team name: " . mysqli_error($connection);
        }
    } else {
        // Handle empty team name input
        header("Location: create_team.php?error=emptyinput");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
<section class="home">
    <div class="container">
        <p class="account-header">Create your team's workspace</p>
        <form action="" method="post" class="create-team-form"> 
            <div class="team-name-container">
                <label for="team-name">Team Name</label>
                <input type="text" id="team-name" name="team-name" placeholder="e.g 'Dev Team'">
            </div>

            <?php
            if (isset($_GET["error"]) && $_GET["error"] == "emptyinput") {
                echo "<p style='font-size: 13px; color: #c0193a; text-align:center'> Please enter your team name</p>";
            }
            ?>
            
            <button class="continue-button create-team-btn" type="submit" name="submit">Create Team</button>
        </form>
    </div>
</section>
</body>
</html>
