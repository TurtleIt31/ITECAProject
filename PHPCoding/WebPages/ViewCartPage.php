<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: HomePage.php');
    exit();
}

include '../dbInfo.php'; 

$userID = $_SESSION['user_id'];

$sql = "SELECT carparts.PartName, carparts.Pricing, ShoppingCartItems.PartsInCart
        FROM ShoppingCartItems
        JOIN carparts ON ShoppingCartItems.PartID = carparts.PartID
        WHERE ShoppingCartItems.UserID = ? AND ShoppingCartItems.Purchased = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

?>


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
            <li><a href="AboutUsPage.php">About Us</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <?php 
            if (isset($_SESSION['user_id'])) : ?>
                <li><a href="ViewCartPage.php">View Cart</a></li>
                <li><a href="../LogoutAction.php">Logout</a></li>
            <?php else : ?>
                <li><a href="Index.php">Sign In</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<br>
<div class="CartItems">
    <form action="..\Checkout.php" method="POST">
        <?php
        if ($result->num_rows > 0) {
            $totalAmount = 0;
            while ($row = $result->fetch_assoc()) {
                $amount = $row['Pricing'] * $row['PartsInCart'];
                $totalAmount += $amount;
                echo '<div class="CartItem">';
                echo '<h3 class="ItemName">' . htmlspecialchars($row['PartName']) . '</h3>';
                echo '<p class="ItemPricing">Pricing: ' . htmlspecialchars($row['Pricing']) . '</p>';
                echo '<p class="ItemQuantity">Quantity: ' . htmlspecialchars($row['PartsInCart']) . '</p>';
                echo '<p class="ItemAmount">Amount: ' . htmlspecialchars($amount) . '</p>';
                echo '</div>';
            }
            echo '<div class="TotalAmount"><h2>Total Amount to pay: ' . htmlspecialchars($totalAmount) . '</h2></div>';
            echo '<div class="row">';
            echo '<input type="submit" name="Pay" value="Pay" class="button">';
            echo '</div>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>
    </form>
</div>



</body>

