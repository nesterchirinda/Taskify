<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session

include_once ("includes/functions.inc.php");
include_once("includes/db.inc.php");

// Check if the user is logged in
if (isset($_SESSION["userid"])) {
    // Retrieve the user ID from the session
    $userId = $_SESSION["userid"];

    // Query to select group task IDs assigned to the user
    $sql = "SELECT groupTaskId FROM task_assignments WHERE assignedUsersId = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Create an array to store task details
        $tasks = array();

        // Fetch and store task details
        while ($row = mysqli_fetch_assoc($result)) {
            $groupId = $row['groupTaskId'];
            $groupTaskDetails = fetchGroupTaskDetails($connection, $groupId);
            $tasks[] = $groupTaskDetails;
        }
    }
}

// Function to fetch group task details for tasks that are not started
function fetchGroupTaskDetails($connection, $groupId) {
    $groupTaskDetails = array();
    $sql = "SELECT * FROM group_tasks WHERE groupTaskId = ? AND groupTaskStatus = 'Not Started'";
    $stmt = mysqli_prepare($connection, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $groupId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $groupTaskDetails = $row;
        }
        mysqli_stmt_close($stmt);
    }
    return $groupTaskDetails;
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
    <script src="js/script.js"></script>
    <script src="js/tasks.js"></script>
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
            <button onclick="window.location.href='team-member-dashboard.php'"id="workspaceButton" class="panel-btn-workspace"><i class="fa-solid fa-people-group"></i>Team Workspace</button>
            <button onclick="window.location.href='team-member-personal-dashboard.php'" id="workspaceButton" class="panel-btn-mytasks"><i class="fa-regular fa-user"></i>My Tasks</button>
            <!-- Important Button -->
            <button id="importantButton" class="panel-btn-important"><i class="fa-regular fa-star"></i>Important</button>
            <!-- Settings Button -->
            <button id="toggleButton" class="panel-btn-settings"><i class="fa-solid fa-gear"></i>Settings</button>

            <!-- Lists Button -->
            <p class="panel-btn-lists"> My Lists</p>
                
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
        <!-- Rest of the Dashboard Content -->

        <?php
// Check if the user is logged in
if(isset($_SESSION["userid"])) {
    // If logged in, display the greeting with the user's name
    $currentTime = date("H");

    if ($currentTime < 12) {
        echo "<h3 class='user-greeting'>Good Morning, " . $_SESSION["name"] . "</h3>";
    } elseif ($currentTime < 18) {
        echo "<h3 class='user-greeting'>Good Afternoon, " . $_SESSION["name"] . "</h3>";
    } else {
        echo "<h3 class='user-greeting'>Good Evening, " . $_SESSION["name"] . "</h3>";
    }
} 
?>
<p class="taks-p">Here are your assigned tasks</p>

        
        <div class="top-section">
            <button class="message"><i class="fa-regular fa-message"></i></button>
            <button class="notifications"><i class="fa-regular fa-bell"></i></button>
            <?php
        echo "<span class='date'>" . date("F j, Y") . "</span>";
        ?>
        </div>


        <div class="task-container">


        <!--NOT STARTED TASKS -->
        <div class="not-started-div status-div">
            <button class="status-btn not-started-btn"> To Do - 3</button>
            <div class="task-team">
                <p class="task-title">Update UI to fit Alex's design</>
                <p class="completion-status">100% complete</p>
                <p class="duedate-admin">May 5th, 2024</p>
            </div>

        <?php
            // Display tasks if available
            if (!empty($tasks)) {
                foreach ($tasks as $task) {
                    echo "<div class='task-team'>";
                    echo "<p class='task-title'>" . $task['groupTaskName'] . "</p>";
                    echo '<p class="completion-status">0% complete </p>';
                    
                    $deadline = new DateTime($task['groupTaskDeadline']);
                    // Format the deadline date
                    $deadlineDate = $deadline->format("F jS, Y");
                    
                    echo "<p class='duedate-admin'>" . $deadlineDate . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No new tasks assigned.</p>";
            }
        ?>


        </div>

        <!--IN PROGRESS TASKS -->
        <div class="in-progress-div status-div">
            <button class="status-btn in-progress-btn">In Progress - 1</button>
            <div class="task-team">
                <p class="task-title">Update UI to fit Alex's design</p>
                <p class="completion-status">68% complete</p>
                <p class="duedate-admin">May 5th, 2024</p>
                <img src="images/woman pfp.png" alt="assigned user icon" class="assigned-user">
            </div>
        </div>



        <!-- DONE TASKS -->
        <div class="done-div status-div">
            <button class="status-btn done-btn">Done - 2</button>
            <div class="task-team">
                <p class="task-title">Update UI to fit Alex's design</>
                <p class="completion-status">100% complete</p>
                <p class="duedate-admin">May 5th, 2024</p>
            </div>


        </div>


        <!-- TASK POP UP -->
        <div class="task-popup3" id="task-popup">
        <form action="" method="post">

        <!--TASK POP UP LEFT SIDE--->
        <div class="task-popup-left">
        <input type="task-name" name="task-name" value="Update UI to fit Alex's design" class="admin-task-name">
        <textarea name="task-description" placeholder="Task Description" class="admin-task-description"></textarea>


        <h4 class="popup-section-title-subtask">Subtasks</h4>

        <!--subtasks div--->
        <div class="admin-subtasks">
            <div class="subtasks-inside-div">
                <div class="sub-task" id="">
                    <input type="checkbox" id="" name="sub-task1" class="sub-task1">
                    <label for="sub-task1" class="subtask-lbl"> Data types</label>
                </div>
                
                <div class="sub-task" id="">
                    <input type="checkbox" id="" name="sub-task2" class="sub-task2">
                    <label for="sub-task2" class="subtask-lbl"> While loops</label>
                </div>
                
                <div class="sub-task" id="">
                    <input type="checkbox" id="" name="sub-task3" class="sub-task3">
                    <label for="sub-task3" class="subtask-lbl"> Functions</label>
                </div>
            </div>
        </div>
        </div>


        <!--due date--->
        <div class="duedate">
        <p class="duedate-title popup-section-title">Due date</p>
        <div id="date-picker-container">
            <input type="date" id="due-date" name="due-date">
        </div>

        </div>

        <div class="priority-div">
            <p class="popup-section-title">Priority</p>
            <!-- Container for the flag icons -->
            <div class="priority-icons">
            <label>
                    
                <!-- Hidden radio buttons for selection -->
                <input type="radio" name="priority" value="high">
                <!-- Flag icon -->
                <i class="fa-solid fa-flag high"></i>high
            </label>
            <label>
                <input type="radio" name="priority" value="medium">
                <i class="fa-solid fa-flag medium"></i>med
            </label>
            <label>
                <input type="radio" name="priority" value="low">
                <i class="fa-solid fa-flag low"></i>low
            </label>
        </div>
        </div>


        <!--task assignment--->
        <div class="task-assignment-div">
        <p class="popup-section-title">Assign Task</p>
        <div class="assign-task">
            <input type="user-email" name="user-email" placeholder="Enter team member email" class="input-share">
            <button type="button" id="assign-task-btn" class="search-btn"><i class="fa-solid fa-user-plus"></i></button>
        </div>
        </div>

        

        <div class="important-div">
            <input type="radio" name="important" id="important-radio">
            <label for="important-radio"><i class="fa-solid fa-star"></i></label>
        </div>



        <button type="button" class="save-task-btn">Save</button>

        </form>
        </div>



</div>
    </section>

    <script src="js/task.js"></script>
</body>
</html>
