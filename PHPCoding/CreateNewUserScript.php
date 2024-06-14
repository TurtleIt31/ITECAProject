
<?php

include 'dbInfo.php';
// New user details
$userEmail = "newuser@example.com";
$userPassword = "password";

// Hash the password
$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

// Insert query
$sql = "INSERT INTO user (EmailAddress, Password) VALUES ('$userEmail', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "New user inserted successfully";
    header('Location: Webpages/HomePage.php?success=New user Inserted');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header('Location: Webpages/HomePage.php?fail=User fail to be created');
}

// Close connection
$conn->close();
?>