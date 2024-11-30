<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 

include_once ("includes/functions.inc.php");
include_once "includes/db.inc.php";

// Function to update team ID for a team member
function updateTeamIDForTeamMember($teamMemberEmail, $teamId, $connection) {
 
    $userData = emailRegistered($connection, $teamMemberEmail);
    if ($userData !== false) {
        $teamMemberId = $userData['usersId'];
        
        // Update the team ID for the team member
        $sql = "UPDATE team_members SET teamId = ? WHERE usersId = ?";
        $stmt = mysqli_stmt_init($connection);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $teamId, $teamMemberId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return true;
        } else {
            return false;
        }
    } else {
        header("Location: manage-team.php?error=not_registered");
        exit();
    }
}


// Function to get user ID by email
function getUserIdByEmail($email, $connection) {
    $sql = "SELECT usersId FROM users WHERE usersEmail = ?";
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $userId;
    } else {
        return false;
    }
}

// Check if the form is submitted
if(isset($_POST["submit"])) {
    // Get the logged-in user's email from the session (group admin's email)
    $loggedInUserEmail = $_SESSION["email"];
    
    // Retrieve the user ID of the logged-in user (group admin)
    $loggedInUserId = getUserIdByEmail($loggedInUserEmail, $connection);
    
    // Check if the team ID is retrieved successfully
if ($loggedInUserId !== false) {
    // Retrieve the team ID associated with the logged-in user
    $sql = "SELECT teamId FROM group_admins WHERE usersId = ?";
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $loggedInUserId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $teamId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Debugging: Check the value of $teamId
        echo "Team ID: " . $teamId;

        // Set the teamId session variable
        $_SESSION['teamId'] = $teamId;

        // Debugging: Check if $_SESSION['teamId'] is set
        if(isset($_SESSION['teamId'])) {
            echo "Session Team ID: " . $_SESSION['teamId'];
        } else {
            echo "Session Team ID is not set.";
        }

        // Get the team member email from the form input
        $teamMemberEmail = $_POST["email"];

        // Update the team ID for the team member
        $success = updateTeamIDForTeamMember($teamMemberEmail, $teamId, $connection);
        if($success) {
            header("Location: manage-team.php?error=none");
            exit();
        } else {
            header("Location: manage-team.php?error=failedtoupdate");
        }
    } else {
        header("Location: manage-team.php?error=teamidfail");
    }
} else {
    echo "Logged-in user does not exist.";
}

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Team</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="js/script.js"></script>
    <script src="js/task.js"></script>
</head>

<body>
    <section class="dashboard">
        <!-- Side Panel -->
        <div class="side-panel">
            <div class="profile">
                <!-- Profile Picture -->
                <div class="profile-pic">
                    <img src="<?php echo setProfilePicture(); ?>" alt="Profile Picture">
                </div>
                <!-- Name -->
                <div class="name">
                <?php
                    echo "<p>" . $_SESSION["email"] . "</p>";
                    ?>
                </div>
            </div>
            <button onclick="window.location.href='admin-dashboard.php'" id="workspaceButton" class="panel-btn-workspace"><i class="fa-solid fa-people-group"></i>Team Workspace</button>

            <button onclick="window.location.href='admin-personal-dashboard.php'" id="workspaceButton" class="panel-btn-mytasks"><i class="fa-regular fa-user"></i>My Tasks</button>
            <!-- Important Button -->
            <button id="importantButton" class="panel-btn-important"><i class="fa-regular fa-star"></i>Important</button>
            <!-- Settings Button -->
            <button id="toggleButton" class="panel-btn-settings"><i class="fa-solid fa-gear"></i>Settings</button>

            <button onclick="window.location.href='manage-team.php'" id="workspaceButton" class="panel-btn-team"><i class="fa-solid team-icon fa-user-plus"></i>Manage Team</button>

            <!-- Lists Button -->
            <p class="panel-btn-projects"> Team Projects</p>
                
            <button id="add-to-list"><i class="fa-solid fa-plus add-list"></i></button>
            
            <button id="drop-down"><i class="fa-solid fa-chevron-right"></i></button></p>



            <!-- Settings -->
            <div class="settings">
                <div class="theme-btn">
                    <input type="checkbox" name="" id="theme-one-toggle" class="input-toggle">
                    <label for="theme-one-toggle" class="label-toggle"><i class="fa-solid fa-toggle-off"></i><span class="toggle-txt">Theme 1</span></label>
                </div>
                <div class="theme-btn">
                    <input type="checkbox" name="" id="theme-two-toggle" class="input-toggle">
                    <label for="theme-two-toggle" class="label-toggle"><i class="fa-solid fa-toggle-off"></i><span class="toggle-txt">Theme 2</span></label>
                </div>
                <div class="theme-btn">
                    <input type="checkbox" name="" id="darkmode-toggle" class="input-toggle">
                    <label for="darkmode-toggle" class="label-toggle3"><i class="fa-solid fa-toggle-off"></i><span class="toggle-txt">Dark mode</span></label>
                </div>
                <a href="includes/logout.inc.php"><button class="logout">Log out</button></a>
            </div>
        </div>


    <div class="right-half">
    <!-- Rest of the Dashboard Content -->

    <?php
if(isset($_SESSION["userid"])) {
    include_once "includes/db.inc.php"; 


    $sql = "SELECT teamName FROM teams WHERE teamId IN (SELECT teamId FROM group_admins WHERE usersId = ?)";
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $teamName);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($teamName) {
            // If a team name is found, display it
            echo "<p class='user-greeting'>" . $teamName . " Members</p>";
        } 
    } 
} 
?>

<p class="taks-p">Manage your team</p>


        
        <div class="top-section">
        <button class="message"><i class="fa-regular fa-message"></i></button>
        <button class="notifications"><i class="fa-regular fa-bell"></i></button>
        <?php
        echo "<span class='date'>" . date("F j, Y") . "</span>";
        ?>
        </div>


        <div class="team-members">
        <div class="team-member-list">
            <?php


if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    // Retrieve tasks from the database for the current user
    $sql = "SELECT taskId, taskName, taskStatus FROM tasks WHERE usersId = ?";
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $taskId, $taskName, $taskStatus);

        // Check if there are any tasks
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Loop through each task and display it
            while (mysqli_stmt_fetch($stmt)) {
                echo "<div class='task'>";
                echo "<input type='checkbox' id='task{$taskId}' class='checkbox'>";
                echo "<label for='task{$taskId}'>{$taskName}</label>";
                echo "<button class='progress-button'>{$taskStatus}</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No tasks found.</p>";
        }

        mysqli_stmt_close($stmt);
    }
} else {
    echo "User ID is not set.";
}
?>

        </div>


             <form id="add-team-member-form" method="post" action="">
                <p>Add a new team member</p>
                <input type="text" id="new-member-email" name="email" class="input-member" placeholder="Enter user email">
                <button type="submit" name="submit" id="add-member-btn" class="add-member-btn">+</button>
            </form>
            
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "not_registered") {
                        echo "<p style='font-size: 13px; color: #c0193a; position:relative; bottom:430px; left:560px;'> User not registered<p/>";
                    }}
            ?>

        </div>




 </section>


</body>
</html>
