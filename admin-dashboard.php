<?php
session_start(); // Start the session

include_once ("includes/functions.inc.php");
include_once("includes/db.inc.php");

if (isset($_GET['taskId'])) {
    $taskId = $_GET['taskId'];
    $taskDetails = array(
        'taskName' => 'Task Name',
        'taskDescription' => 'Task Description',
        'dueDate' => 'May 24',
    );
    header('Content-Type: application/json');
    echo json_encode($taskDetails);
} else {
    http_response_code(400);
    echo 'Task ID not provided';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            <button id="workspaceButton" class="panel-btn-workspace"><i class="fa-solid fa-people-group"></i>Team Workspace</button>
            
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

    // Include the database connection
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
            echo "<p class='team-tasks-p'>" . $teamName . " has 3 tasks due today</p>";
        } else {
            // If no team name is found, display a generic message
            echo "<p class='team-tasks-p'>Your team has 3 tasks due today</p>";
        }
    } else {
        // If the SQL statement preparation fails, display a generic message
        echo "<p class='team-tasks-p'>Your team has 3 tasks due today</p>";
    }
} 
?>


        
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
                    <p class="task-title">Debug user authentication system</p>
                    <p class="completion-status">0% complete</p>
                    <p class="duedate-admin">May 5th, 2024</p>
                    <img src="images/woman pfp2.png" alt="assigned user icon" class="assigned-user">
                </div>

                <?php
                    // Include database connection
                    include_once("includes/db.inc.php");

                    // Fetch tasks with status "Not Started" for the current team
                    $teamId = $_SESSION["teamId"]; 
                    $status = "Not Started";
                    $sql = "SELECT * FROM group_tasks WHERE teamId = ? AND groupTaskStatus = ?";
                    $stmt = mysqli_stmt_init($connection);

                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, "is", $teamId, $status);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        // Check if there are any tasks
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through the tasks and display them
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="task-team">';
                                echo '<p class="task-title">' . $row["groupTaskName"] . '</p>';
                                echo '<p class="completion-status">0% complete </p>';

                                $dueDate = new DateTime($row["groupTaskDeadline"]);
                                $formattedDueDate = $dueDate->format("F jS, Y");

                                echo '<p class="duedate-admin">' . "$formattedDueDate" . '</p>';
                                echo '<img src="images/woman pfp2.png" alt="assigned user icon" class="assigned-user">';
                                // You can add other task details here
                                echo '</div>';
                            }
                        } else {
                            echo "No tasks found.";
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Error preparing statement: " . mysqli_error($connection);
                    }
                    mysqli_close($connection);
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

                <div class="task-team">
                    <p class="task-title">Complete accessibilty report</p>
                    <p class="completion-status">100% complete</p>
                    <p class="duedate-admin">May 5th, 2024</p>
                    <img src="images/man pfp.png" alt="assigned user icon" class="assigned-user">
                </div>
            </div>

        </div>


     <!-- TASK POP UP -->
     <div class="task-popup" id="task-popup">
    <form action="create-group-task.php" method="post">

     <!--TASK POP UP LEFT SIDE--->
        <div class="task-popup-left">
            <input type="task-name" name="task-name" value="" class="admin-task-name" placeholder="Task name">
            <textarea name="task-description" placeholder="Task Description" class="admin-task-description"></textarea>
            
            
            <h4 class="popup-section-title-subtask">Subtasks</h4>
            
               <!--subtasks div--->
            <div class="admin-subtasks">
                <div class="subtasks-inside-div">
                  
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

             <div class="add-subtask-form">
                    <input type="text" class="subtask-input" aria-label="create new task" placeholder="add sub-task">
                    <button class="add-subtask-btn" type="button">+</button>
             </div>
             

             <button type="submit" class="save-task-btn">Save</button>

            <!--delete button--->
            <button type="button" class="delete-task-btn"><i class="fa-regular fa-trash-can"></i>Delete Task</button>
       
    </form>
</div>



<button class="add-new-task"> + </button>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var addSubtaskBtn = document.querySelector('.add-subtask-btn');
    var subtaskInput = document.querySelector('.subtask-input');
    var subtasksContainer = document.querySelector('.subtasks-inside-div');

    addSubtaskBtn.addEventListener('click', function() {
        var subtaskName = subtaskInput.value.trim();

        if (subtaskName !== '') {
            var subtaskHTML = `
                <div class="sub-task">
                    <input type="checkbox" name="sub-task" class="sub-task-checkbox">
                    <label class="subtask-lbl">${subtaskName}</label>
                </div>
            `;
            
            subtasksContainer.insertAdjacentHTML('beforeend', subtaskHTML);
            subtaskInput.value = '';
        }
    });
});
</script>



 </section>

</body>
</html>
