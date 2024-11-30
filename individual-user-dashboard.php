<?php
session_start(); // Start the session


include_once ("includes/functions.inc.php");
include_once "includes/db.inc.php"; 
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
            <!-- Today Button -->
            <button id="todayButton" class="panel-btn-today"><i class="fa-regular fa-calendar-days"></i>My Day</button>
            <!-- Important Button -->
            <button id="importantButton" class="panel-btn-important"><i class="fa-regular fa-star"></i>Important</button>
            <!-- Settings Button -->
            <button id="toggleButton" class="panel-btn-settings"><i class="fa-solid fa-gear"></i>Settings</button>


            <!-- Lists Button -->
            <p class="panel-btn-lists">My Lists </p>
                
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
                    <input type="checkbox" name="" id="darkmode-toggle" class="input-toggle" onchange="toggleDarkMode()">
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
} 
?>
<p class="taks-p">Today you have 5 tasks</p>

        
        <div class="top-section">
            <button class="message"><i class="fa-regular fa-message"></i></button>
            <button class="notifications"><i class="fa-regular fa-bell"></i></button>
            <?php
            echo "<span class='date'>" . date("F j, Y") . "</span>";
            ?>


            
        </div>

        <div class="todo-container ">

            <!-- list 1  -->
            <div class="list1">
            <form action="create-list.php" method="post" class="list-name-form">
                    <input class="list-name" type="text" name="list-name" placeholder="Enter list name" required>
                    <button class="create-list-btn" type="submit">+</button>
            </form>

                <div class="tasks">
                <!--close task 1-->

                <div class="task">
                    <input type="checkbox" id="task2" class="checkbox">
                    <label for="task"> Revise for python exam</label>
                    <button class="progress-button">Not Started</button>
                </div>

                <?php
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    // Check if the user ID session variable is set
                    if (isset($_SESSION['userid'])) {

                        // Retrieve tasks made by the current user
                        $sql = "SELECT * FROM tasks WHERE usersId = ?";
                        $stmt = mysqli_prepare($connection, $sql);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "i", $_SESSION['userid']);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            // Check if there are any tasks
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each task and display it
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<div class='task'>";
                                    echo "<input type='checkbox' id='task{$row['taskId']}' class='checkbox'>";
                                    echo "<label for='task{$row['taskId']}'>{$row['taskName']}</label>";
                                    echo "<button class='progress-button'>{$row['taskStatus']}</button>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No tasks found.</p>";
                            }

                            // Close the statement
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "Error: Unable to prepare statement.";
                        }
                    } else {
                    
                    }
                ?>

            
                </div>
            </div>



        
            
            
        </div>
        <button class="add-new-task-individual"> + </button>




        <!-- Popup for changing progress -->
<div class="popup" id="progressPopup" style="display: none;">
    <div class="popup-content">
    <button class="progress-option notstarted">Not Started</button>
        <button class="progress-option inprogress">In Progress</button>
        <button class="progress-option done">Done</button>
    </div>
</div>




 <!-- TASK POP UP -->
 <div class="task-popup2" id="task-popup">
    <form action="create-tasks.php" method="post">

     <!--TASK POP UP LEFT SIDE--->
        <div class="task-popup-left">
        <input type="task-name" name="task-name" value="" class="admin-task-name" placeholder="Task name">
        <textarea name="task-description" placeholder="Task Description" class="task-description"></textarea>
            
            
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
             <p class="popup-section-title">Share Task</p>
            <div class="assign-task">
                <input type="user-email" name="user-email" placeholder="Enter user email" class="input-share">
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
        
    </section>

    <script src="js/task.js"></script>
    <script src="js/script.js"></script>
    <script src="js/darkmode.js"></script>
</body>
</html>
