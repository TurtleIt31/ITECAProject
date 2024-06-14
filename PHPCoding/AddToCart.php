<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}

include 'dbInfo.php';

if (isset($_POST['partID'])) {
    $partID = $_POST['partID'];
    $userID = $_SESSION['user_id'];

    // Check if the part is already in the cart
    $sql_check = "SELECT * FROM ShoppingCartItems WHERE UserID = ? AND PartID = ? AND Purchased = 0";
    $stmt_check = $conn->prepare($sql_check);

    if ($stmt_check === false) {
        error_log('Prepare failed: ' . htmlspecialchars($conn->error), 3, 'error_log.txt');
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt_check->bind_param('ii', $userID, $partID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Part is already in the cart, update quantity
        $sql_update = "UPDATE ShoppingCartItems SET PartsInCart = PartsInCart + 1 WHERE UserID = ? AND PartID = ? AND Purchased = 0";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update === false) {
            error_log('Prepare failed: ' . htmlspecialchars($conn->error), 3, 'error_log.txt');
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt_update->bind_param('ii', $userID, $partID);

        if ($stmt_update->execute()) {
            // Redirect to ShopPage with success message
            header('Location: Webpages\ShopPage.php?success=Quantity updated in cart');
            exit();
        } else {
            error_log('Execute failed: ' . htmlspecialchars($stmt_update->error), 3, 'error_log.txt');
            header('<Location:>Webpages\ShopPage.php?error=Failed to update quantity in cart');
            exit();
        }

        $stmt_update->close();
    } else {
        // Part is not in the cart, insert new record
        $sql_insert = "INSERT INTO ShoppingCartItems (UserID, PartID, PartsInCart, Purchased) VALUES (?, ?, 1, 0)";
        $stmt_insert = $conn->prepare($sql_insert);

        if ($stmt_insert === false) {
            error_log('Prepare failed: ' . htmlspecialchars($conn->error), 3, 'error_log.txt');
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt_insert->bind_param('ii', $userID, $partID);

        if ($stmt_insert->execute()) {
            // Redirect to ShopPage with success message
            header('Location: Webpages\ShopPage.php?success=Part added to cart');
            exit();
        } else {
            error_log('Execute failed: ' . htmlspecialchars($stmt_insert->error), 3, 'error_log.txt');
            header('Location: Webpages\ShopPage.php?error=Failed to add part to cart');
            exit();
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $conn->close();
} else {
    header('Location: ShopPage.php');
    exit();
}
?>
