<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: Webpages/HomePage.php"); // Redirect to the login page or any other appropriate page
exit;
?>