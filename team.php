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
            <button onclick="window.location.href='admin-personal-dashboard.php'" id="workspaceButton" class="panel-btn-mytasks"><i class="fa-regular fa-user"></i>My Tasks</button>
            <!-- Today Button -->
            <button id="workspaceButton" class="panel-btn-workspace"><i class="fa-solid fa-people-group"></i>Team Workspace</button>
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
            // Check if the user is logged in
            if(isset($_SESSION["userid"])) {
                include_once "includes/db.inc.php"; 

                // Prepare a SQL statement to select the team name based on the user's ID
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
                        echo "<p class='user-greeting'>" . $teamName . "</p>";
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
                <form id="add-team-member-form" method="post" action="">
                    <p>Add a new team member</p>
                    <input type="text" id="new-member-email" class="input-member" placeholder="Enter user email">
                    <button type="submit" id="add-member-btn" class="add-member-btn">+</button>
                </form>
            </div>
        
        </div>
    </section>


</body>
</html>
