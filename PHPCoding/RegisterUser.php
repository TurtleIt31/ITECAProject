
<?php
session_start();

include 'dbInfo.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userEmail = $_POST['user_email'];
    $password = $_POST['password'];

    // Input sanitization
    $userEmail = $conn->real_escape_string($userEmail);
    $password = $conn->real_escape_string($password);

    //query to create a new user if the user does not already exist
    $sql = "SELECT * FROM user WHERE EmailAddress = '$userEmail'";
    $result = $conn->query($sql);
    if ($stmt->num_rows > 0) {
        // User already exists
        $_SESSION['error_message'] = "User already exists";
        header("Location: Webpages/RegisterUser.php"); // Redirect to the registration page
        exit;
    }else {
        //user does not exist insert the data into the table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO user (EmailAddress, Passwords) VALUES ('$user_email', '$hashed_password')";//does the hashing for you

        if ($conn->query($insert_sql) === TRUE) {//check that the insert worked
            echo "New record created successfully";
            header("Location: Webpages/HomePage.php");
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;//error handling

        }
    }

}
$conn->close();
?>