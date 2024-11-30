<?php 

// EMAIL FUNCTION
function invalidEmail($email) {
    $result = false;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
}

else {
    $result = false;

}
return $result;
}





// EMPTY INPUTS FUNCTION
function emptyInputSignup($name, $password) {
    $result = false;
    if(empty($name) || empty($password)) {
        $result = true;
}

else {
    $result = false;

}
return $result;
}



function invalidPwd($password) {
    // Check if password length is at least 8 characters
    if (strlen($password) < 8) {
        return true;
    }

    // Check if password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return true;
    }

    // Check if password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return true;
    }

    // Check if password contains at least one number
    if (!preg_match('/\d/', $password)) {
        return true;
    }

    // If all requirements are met, return false
    return false;
}



function emailRegistered($connection, $email) {
    $sql = "SELECT * FROM users WHERE usersEmail = ?";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Error handling if SQL statement preparation fails
        return false; // Return false on failure
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Email is found in database, fetch and return user data
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt); // Close the statement
        return $row;
    } else {
        // Email is not found in database, return false
        mysqli_stmt_close($stmt); // Close the statement
        return false;
    }
}




// Function to create a user
function createUser($connection, $name, $email, $password, $accountType) {
    // Check if connection is valid
    if ($connection === null) {
        error_log('Database connection is null.', 3, 'error.log');
        header("Location: signup.php?error=db_connection_failed");
        exit();
    }

    // SQL statement to insert user data into the database
    $sql = "INSERT INTO users (usersName, usersEmail, usersPassword, accountType) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log('SQL Error: ' . mysqli_error($connection), 3, 'error.log');
        header("Location: signup.php?error=stmt_failed");
        exit();
    }

    // Hash the password
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPwd, $accountType);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}



function emptyInputLogin($email, $password) {
    if (empty($email) || empty($password)) {
        return true; // Return true if either email or password is empty
    } else {
        return false; // Return false if both email and password are not empty
    }
}

function getTeamIdForAdmin($connection, $userId) {
    $sql = "SELECT teamId FROM group_admins WHERE usersId = ?";
    $stmt = mysqli_stmt_init($connection);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Error handling if SQL statement preparation fails
        return null; // Return null on failure
    }
    
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $teamId);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $teamId;
}



function loginUser($connection, $email, $password) {
    // Check if the user exists
    $userExists = emailRegistered($connection, $email);

    if ($userExists === false) {
        header("Location: ../login.php?error=userdoesnotexist");
        exit();
    }

    // Retrieve the hashed password from the database
    $pwdHashed = $userExists["usersPassword"];

    // Verify the entered password against the hashed password
    if (password_verify($password, $pwdHashed)) {
        // If password verification succeeds, start a session and set session variables
        session_start();
        $_SESSION["userid"] = $userExists["usersId"];
        $_SESSION["email"] = $userExists["usersEmail"];
        $_SESSION["name"] = $userExists["usersName"];
        $_SESSION["account-type"] = $userExists["accountType"];

        // Check if the user is an admin
        if ($_SESSION["account-type"] === 'admin-user') {
            // Get the teamId for the admin
            $teamId = getTeamIdForAdmin($connection, $userExists["usersId"]);
            // Set teamId in session variable
            $_SESSION["teamId"] = $teamId;
        }

        // Redirect to the appropriate dashboard based on the account type
        switch ($_SESSION["account-type"]) {
            case 'basic-user':
                header("Location: ../individual-user-dashboard.php");
                exit();
            case 'team-user':
                header("Location: ../team-member-dashboard.php");
                exit();
            case 'admin-user':
                header("Location: ../admin-dashboard.php");
                exit();
            default:
                // Redirect to a default page if the account type is not recognized
                header("Location: ../index.php?error=invalid_account_type");
                exit();
        }
    } else {
        // If password verification fails, redirect with an error message
        header("Location: ../login2.php?error=wronglogin");
        exit();
    }
}




function setProfilePicture() {
    $string = $_SESSION["name"];
    $firstLetter = strtolower($string[0]); // Convert the first letter to lowercase

    switch ($firstLetter){

        case 'a':
            $imagePath = "images/[A] Black - Jade Sky Blue.png";
            break;

        case 'b':
            $imagePath = "images/[B] White - Jade Sky Blue.png";
            break;
            
        case 'c':
            $imagePath = "images/[C] White - Jade Sky Blue.png";
            break;

        case 'd':
            $imagePath = "images/[D] White - Jade Sky Blue.png";
            break;
        
        case 'e':
            $imagePath = "images/[E] White - Jade Sky Blue.png";
            break;
                
        case 'f':
            $imagePath = "images/[F] White - Jade Sky Blue.png";
            break;

        case 'g':
            $imagePath = "images/[A] White - Jade Sky Blue.png";
            break;
            
        case 'h':
            $imagePath = "images/[H] White - Jade Sky Blue.png";
            break;
                    
        case 'i':
            $imagePath = "images/[I] White - Jade Sky Blue.png";
            break;

        case 'j':
            $imagePath = "images/[J] White - Jade Sky Blue.png";
            break;
            
        case 'k':
            $imagePath = "images/[K] White - Jade Sky Blue.png";
            break;
                    
        case 'l':
            $imagePath = "images/[L] White - Jade Sky Blue.png";
            break;
                            
        case 'm':
            $imagePath = "images/[M] White - Jade Sky Blue.png";
            break;

        case 'n':
            $imagePath = "images/[N] White - Jade Sky Blue.png";
            break;
                        
        case 'o':
            $imagePath = "images/[O] White - Jade Sky Blue.png";
            break;
                            
        case 'p':
            $imagePath = "images/[P] White - Jade Sky Blue.png";
            break;
                                    
        case 'q':
            $imagePath = "images/[Q] White - Jade Sky Blue.png";
            break;
                        
        case 'r':
            $imagePath = "images/[R] White - Jade Sky Blue.png";
            break;
                                
        case 's':
            $imagePath = "images/[S] White - Jade Sky Blue.png";
            break;
                                        
        case 't':
            $imagePath = "images/[T] White - Jade Sky Blue.png";
            break;
                        
        case 'u':
            $imagePath = "images/[U] White - Jade Sky Blue.png";
            break;
                                
        case 'v':
            $imagePath = "images/[V] White - Jade Sky Blue.png";
            break;
                                        
        case 'w':
            $imagePath = "images/[W] White - Jade Sky Blue.png";
            break;
                                                
        case 'x':
            $imagePath = "images/[X] White - Jade Sky Blue.png";
            break;    
            
        case 'y':
            $imagePath = "images/[Y] White - Jade Sky Blue.png";
            break;
                                                        
        case 'z':
            $imagePath = "images/[Z] White - Jade Sky Blue.png";
            break;

        default:
            // Default image path if the first letter doesn't match any case
            $imagePath = "default_image_path.png";
            break;
    }

    return $imagePath;
}





function getTasksByStatus(){

}