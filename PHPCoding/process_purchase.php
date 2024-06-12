<?php

include 'dbInfo.php';

// Temporary variables
$shopping_cart_id = 1;
$partId = 1;
$quantity = 2;
$amount_paid = 49.98; // Assume each item costs 24.99

// Start transaction
$conn->begin_transaction();

try {
    // 1. Insert the purchased item into ShoppingCartItems
    $stmt = $conn->prepare("INSERT INTO ShoppingCartItems (ShoppingCartID, PartID, Quantity, AmountPaid) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed for insert: (" . $conn->errno . ") " . $conn->error);//error handling
    }
    $stmt->bind_param("iiid", $shopping_cart_id, $item_id, $quantity, $amount_paid);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed for execute:(" . $stmt->errno . ") " . $stmt->error);//error handling
    }

    // 2. Update the inventory count for the purchased item
    $stmt = $conn->prepare("UPDATE carparts SET Inventory = Inventory - ? WHERE PartID = ?");
    if (!$stmt) {
        throw new Exception("Prepare failed when update: (" . $conn->errno . ") " . $conn->error);//error handling
    }
    $stmt->bind_param("ii", $quantity, $partId);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed when update: (" . $stmt->errno . ") " . $stmt->error);//error handling
    }


    // Commit transaction
    $conn->commit();
    echo "Transaction completed successfully.";
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Failed: " . $e->getMessage();//see what message it is throwing
}

// Close the connection
$conn->close();
?>
