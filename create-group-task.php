<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("includes/functions.inc.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get main task data
    $taskName = $_POST["task-name"];
    $taskDescription = $_POST["task-description"];
    $dueDate = $_POST["due-date"];
    $priority = $_POST["priority"];
    $assignedEmail = $_POST["user-email"];
    $isImportant = isset($_POST["important"]) ? 1 : 0; // Convert to 1 for checked, 0 for unchecked

    // Include database connection
    include_once("includes/db.inc.php");

    // Ensure $_SESSION["teamid"] is set
    if (!isset($_SESSION["teamId"])) {
        // Redirect to an error page or handle the error
        exit("Team ID is not set in the session.");
    }

    // Get the user id based on the email
    $userId = getUserIdByEmail($assignedEmail, $connection);

    // Prepare SQL statement to insert main task into the database
    $sql = "INSERT INTO group_tasks (groupTaskName, groupTaskDescription, teamId, groupTaskDeadline, groupTaskStatus, isImportant) VALUES (?, ?, ?, ?, 'Not Started', ?)";
    $stmt = mysqli_stmt_init($connection);

    // Execute the SQL statement for the main task
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssisi", $taskName, $taskDescription, $_SESSION["teamId"], $dueDate, $isImportant);
        mysqli_stmt_execute($stmt);

        // Get the ID of the inserted main task
        $taskId = mysqli_insert_id($connection);

        // Close statement
        mysqli_stmt_close($stmt);

        // Insert task assignment into task_assignments table
        if ($userId !== null) {
            $taskAssignmentSql = "INSERT INTO task_assignments (groupTaskId, assignedUsersId) VALUES (?, ?)";
            $taskAssignmentStmt = mysqli_stmt_init($connection);
            if (mysqli_stmt_prepare($taskAssignmentStmt, $taskAssignmentSql)) {
                mysqli_stmt_bind_param($taskAssignmentStmt, "ii", $taskId, $userId);
                mysqli_stmt_execute($taskAssignmentStmt);
                mysqli_stmt_close($taskAssignmentStmt);
            }
        }

        // Handle subtasks (if any)
        if (isset($_POST["subtask"])) {
            // Prepare SQL statement to insert subtasks into the database
            $subtaskSql = "INSERT INTO sub_tasks (groupTaskId, subtaskName, taskId, isDone) VALUES (?, ?, 0, 'No')";
            $subtaskStmt = mysqli_stmt_init($connection);

            // Execute the SQL statement for each subtask
            foreach ($_POST["subtask"] as $subtaskName) {
                // Check if subtask name is not empty
                if (!empty($subtaskName)) {
                    mysqli_stmt_prepare($subtaskStmt, $subtaskSql);
                    mysqli_stmt_bind_param($subtaskStmt, "is", $taskId, $subtaskName);
                    mysqli_stmt_execute($subtaskStmt);
                }
            }
            mysqli_stmt_close($subtaskStmt);
        }
    }

    mysqli_close($connection);

    header("Location: admin-dashboard.php");
    exit();
}

function getUserIdByEmail($userEmail, $connection) {
    $userId = null;
    $sql = "SELECT usersId FROM users WHERE usersEmail = ?";
    $stmt = mysqli_stmt_init($connection);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
    return $userId;
}


