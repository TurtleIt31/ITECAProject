<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}

include '..\dbInfo.php';

$userID = $_SESSION['user_id'];

// Mark all items in the user's cart as purchased
$sql = "UPDATE ShoppingCartItems SET purchased = 1 WHERE userID = ? AND purchased = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userID);

if ($stmt->execute()) {
    // Successful purchase
    header('Location: ViewCart.php?success=Purchase completed');
} else {
    // Failed to complete purchase
    header('Location: ViewCart.php?error=Failed to complete purchase');
}

$stmt->close();
$conn->close();
?>