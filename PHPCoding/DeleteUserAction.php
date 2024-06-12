<?php
session_start();

include 'dbInfo.php';

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    //EmailAddress
    $userEmail = $_POST['user_Email'];
     // Check if the admin user exists
     $sql = "SELECT * FROM user WHERE EmailAddress = '$userEmail'";
     $result = $conn->query($sql);
     if ($result->num_rows == 1){
        $Deletesql = "DELETE FROM user WHERE EmailAddress='$userEmail'";

        if ($conn->query($Deletesql) === TRUE) {
            echo "User deleted successfully";
            header("Location: Webpages/EditAdminPage.php");
            
        } else {
            echo "Error updating record: " . $conn->error;
            //header("Location: Webpages/EditAdminPage.php");
        }

     }

     elseif ($result->num_rows > 1){
        echo "duplicate users exist";

     }

     else {
        echo "unkown error has occured";
     }

}
?>