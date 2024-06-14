
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>

<body>
    <header>
        <h1>Goldwagen Parts Store</h1>
        <nav>
            <ul class="nav-buttons">
                <li><a href="HomePage.php">Home</a></li>
                <li><a href="AboutUsPage.php">About Us</a></li>
                <li><a href="ShopPage.php">Shop</a></li>
                <?php 
                session_start();
                if (isset($_SESSION['user_id'])) : ?>
                    <li><a href="ViewCartPage.php">View Cart</a></li>
                    <li><a href="../LogoutAction.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="Index.php">Sign In</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="ContactDetails">
        <ul class="ContactDetails">
            <li>Email address: Tester@google.co.za</li>
            <li>Contact number: 011 456 8210</li>
        </ul>
    </div>
</body>

