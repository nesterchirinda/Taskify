<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


include_once "includes/db.inc.php";

$userId = $_SESSION["userid"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $taskName = isset($_POST["task-name"]) ? $_POST["task-name"] : null;
    $taskDescription = isset($_POST["task-description"]) ? $_POST["task-description"] : null;
    $dueDate = isset($_POST["due-date"]) ? $_POST["due-date"] : null;
    $priority = isset($_POST["priority"]) ? $_POST["priority"] : null;
    $important = isset($_POST["important"]) ? 1 : 0;

   
    if ($taskName !== null) {
        // Insert task details into the database
        $sql = "INSERT INTO tasks (taskName, taskDescription, taskDeadline, taskPriority, isImportant, usersId) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssii", $taskName, $taskDescription, $dueDate, $priority, $important, $userId);
            mysqli_stmt_execute($stmt);

            // Check if the task is inserted successfully
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                header("Location:  individual-user-dashboard.php");
                exit; 
            } else {
                echo "Error: Unable to create task.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to prepare statement.";
        }
    } else {
        echo "Error: Task name cannot be empty.";
    }
} else {
    echo "Error: Form not submitted.";
}


