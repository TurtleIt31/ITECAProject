<?php
session_start();

include 'dbInfo.php';


if ($_SERVER["REQUEST_METHOD"]=="POST") {
    // Admin user details
    $userEmail = $_POST['user_Email'];
    $password = $_POST['user_Password'];

    // Input sanitization
    $userEmail = $conn->real_escape_string($userEmail);
    $password = $conn->real_escape_string($password);

    // Check if the admin user already exists
    $sql = "SELECT * FROM user WHERE EmailAddress = '$userEmail' AND UserType = 'Admin'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        // Admin user does not exist, insert the admin user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $adminUserType = 'Admin';
        $insert_sql = "INSERT INTO user (EmailAddress, Passwords, UserType) VALUES ('$userEmail', '$hashedPassword', '$adminUserType')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "Admin user created successfully";
            header("Location: Webpages/EditAdminPage.php");
            exit;
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error; // Error handling
            //header("Location: Webpages/EditAdminPage.php");
            exit;
        }
    } else {
        echo "Admin user already exists";
        //header("Location: Webpages/EditAdminPage.php");
        exit;
    }
}


$conn->close();
?>