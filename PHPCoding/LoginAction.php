<?php
session_start();

include 'dbInfo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['user_email'];
    $password = $_POST['password'];

    // Input sanitization
    $userEmail = $conn->real_escape_string($userEmail);
    $password = $conn->real_escape_string($password);

    // Query to check if the user exists
    
    $sql = "SELECT UserID, UserType, Passwords FROM user WHERE EmailAddress = '$userEmail'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc(); // Fetch the first row
        if ($row) {
            // Output the contents of the $row array
            var_dump($row);
            // Verify password
            if (password_verify($password, $row['Passwords'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['UserID'];
                $_SESSION['user_email'] = $userEmail;
                $_SESSION['user_type'] = $row['UserType']; // Assigning UserType to the session variable
            
                // Redirect to a logged-in page
                header("Location: Webpages/Index.php");
                exit; // Terminate script execution after redirection
            } else {
                echo "Invalid password.";
                header("Location: Webpages/Index.php");
            }
        } else {
            echo "No user found with that email.";
        }
    } else {
        echo "Query failed.";
    }
}

$conn->close();
?>