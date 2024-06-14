<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}

include '..\dbInfo.php';

$userID = $_SESSION['user_id'];

$sql = "SELECT carparts.PartName, carparts.Pricing, ShoppingCartItems.PartsBought
        FROM ShoppingCartItems
        JOIN carparts ON ShoppingCartItems.partID = carparts.PartID
        WHERE ShoppingCartItems.userID = ? AND ShoppingCartItems.purchased = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>
<body>
<header>
    <h1>Your Cart</h1>
    <nav>
       <ul class="nav-buttons">
        <li><a href="HomePage.php">Home</a></li>
        <li><a href="ShopPage.php">Shop</a></li>
        <li><a href="Checkout.php">Checkout</a></li>
      </ul>
    </nav>
</header>

<br>
<div id="CartItems">
    <?php
    if ($result->num_rows > 0) {
        $totalAmount = 0;
        while ($row = $result->fetch_assoc()) {
            $amount = $row['Pricing'] * $row['PartsBought'];
            $totalAmount += $amount;
            echo '<div>';
            echo '<h3>' . htmlspecialchars($row['PartName']) . '</h3>';
            echo '<p>Pricing: ' . htmlspecialchars($row['Pricing']) . '</p>';
            echo '<p>Quantity: ' . htmlspecialchars($row['PartsBought']) . '</p>';
            echo '<p>Amount: ' . htmlspecialchars($amount) . '</p>';
            echo '</div>';
        }
        echo '<div><h2>Total Amount: ' . htmlspecialchars($totalAmount) . '</h2></div>';
    } else {
        echo '<p>Your cart is empty.</p>';
    }

    $stmt->close();
    $conn->close();
    ?>
</div>

</body>
</html>