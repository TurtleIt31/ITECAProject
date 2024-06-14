<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}

include 'dbInfo.php'; // Adjust the path if necessary

$userID = $_SESSION['user_id'];

// Fetch all items in the user's cart that are not purchased yet
$sqlFetchCartItems = "SELECT PartID, PartsInCart FROM ShoppingCartItems WHERE UserID = ? AND Purchased = 0";
$stmtFetchCartItems = $conn->prepare($sqlFetchCartItems);
$stmtFetchCartItems->bind_param('i', $userID);
$stmtFetchCartItems->execute();
$result = $stmtFetchCartItems->get_result();

$itemsToUpdate = [];

while ($row = $result->fetch_assoc()) {
    $itemsToUpdate[] = $row;
}

$stmtFetchCartItems->close();

$conn->begin_transaction();

try {
    // Update inventory in the CarParts table
    $sqlUpdateInventory = "UPDATE CarParts SET Inventory = Inventory - ? WHERE PartID = ?";
    $stmtUpdateInventory = $conn->prepare($sqlUpdateInventory);

    foreach ($itemsToUpdate as $item) {
        $stmtUpdateInventory->bind_param('ii', $item['PartsInCart'], $item['PartID']);
        $stmtUpdateInventory->execute();
    }

    $stmtUpdateInventory->close();

    // Mark all items in the user's cart as purchased
    $sqlMarkPurchased = "UPDATE ShoppingCartItems SET Purchased = 1 WHERE UserID = ? AND Purchased = 0";
    $stmtMarkPurchased = $conn->prepare($sqlMarkPurchased);
    $stmtMarkPurchased->bind_param('i', $userID);

    if ($stmtMarkPurchased->execute()) {
        $conn->commit();
        // Successful purchase
        header('Location: Webpages/ViewCartPage.php?success=Purchase completed');
    } else {
        $conn->rollback();
        // Failed to complete purchase
        header('Location: <webpage>ViewCartPage.php?error=Failed to complete purchase');
    }

    $stmtMarkPurchased->close();
} catch (Exception $e) {
    $conn->rollback();
    // Failed to complete purchase
    header('Location: /ViewCartPage.php?error=Failed to complete purchase');
}

$conn->close();
?>
