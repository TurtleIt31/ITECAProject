<?php
session_start();

include 'dbInfo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate part_ID
    if (isset($_POST['part_ID'])) {
        $partID = $_POST['part_ID'];
    } else {
        die('Invalid part ID');
    }

    // Validate and handle file upload
    $target_dir = "PartImages/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create uploads directory if it doesn't exist
    }

    $target_file = $target_dir . basename($_FILES["part_Picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["part_Picture"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (optional)
    if ($_FILES["part_Picture"]["size"] > 5000000) { // 5000KB
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");//ensure no file attacks
    }

    // Move uploaded file
    if (move_uploaded_file($_FILES["part_Picture"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO carparts (PartID, ImagePath) VALUES (?, ?) ON DUPLICATE KEY UPDATE ImagePath=?");
        $stmt->bind_param("iss", $partID, $target_file, $target_file);//ensure no file attacks

        if ($stmt->execute() === true) {
            header("Location: Webpages/AddImagesPage.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    } else {
        die("Sorry, there was an error uploading your file.");
    }
}

var_dump($_FILES);

$conn->close();
?>