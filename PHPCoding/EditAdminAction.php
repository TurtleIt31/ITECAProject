<?php
session_start();

include 'dbInfo.php';

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    // Admin user details
    

    if (is_numeric($_POST['user_ID']) && $_POST['user_ID'] > 0) {
        $userID = (int) $_POST['user_ID'];
    } else {
        die('Invalid User ID');
    }

     // Check if the admin user exists
     $userType = "Customer";
     $newUserType = 'Admin';
     $sql = "SELECT * FROM user WHERE UserID = '$userID' AND UserType = '$userType'";
     $result = $conn->query($sql);
     if ($result->num_rows == 1){
        $update_sql = "UPDATE user SET UserType = '$newUserType' WHERE UserID = '$userID'";

        if ($conn->query($update_sql) === true) {
            echo "User type updated successfully";
            header("Location: Webpages/EditAdminPage.php");
            
        } else {
            echo "Error updating record: " . $conn->error;
            //header("Location: Webpages/EditAdminPage.php");
        }

     }

     else {
        echo "User does not exist";
     }
}
?>