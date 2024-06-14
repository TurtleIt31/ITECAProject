<?php
session_start();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>
<body>
  <header>
    <h1>Goldwagen Parts store</h1>
    <nav>
    <nav>
       <ul class="nav-buttons">
        <li><a href="ShopPage.php">Home</a></li>
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
    <ul>
      <?php if (isset($_SESSION['user_id'])) : ?>
          <?php if ($_SESSION['user_type'] === 'Admin') : ?>
              <li><a href="../LogoutAction.php">Logout</a></li>
              <li class="dropdown">
                  <a href="#" class="dropbtn">Admin Actions</a>
                  <div class="dropdown-content">
                      <a href="/ITECAProject/PHPCoding/WebPages/AdminAddPartPage.php">Add new inventory</a>
                      <a href="/ITECAProject/PHPCoding/WebPages/RemovePartsPage.php">View and remove Parts</a>
                      <a href="/ITECAProject/PHPCoding/WebPages/EditAdminPage.php">Edit and add new administrators</a>
                      <a href="/ITECAProject/PHPCoding/WebPages/EditPricePage.php">Edit Prices and add parts</a>
                      <a href="/ITECAProject/PHPCoding/WebPages/AddImagesPage.php">Link Images to part names</a>
                  </div>
              </li>
          <?php endif; ?>
          <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
          <li><a href="../LogoutAction.php">Logout</a></li>
          <?php else : ?>
          <li>Please Sign in!</li>
          <li><a href="Index.php">Sign In</a></li>
      <?php endif; ?>
    </ul>
    </nav>
  </header>

  
  <section class="banner">
    <h2>Welcome to Our Car Parts Store</h2>
    <p>Find the parts you need to keep your car running smoothly.</p>
    <?php
    //var_dump($_SESSION['loggedin']) error handling code
    ?>
  </section>
  <footer>
    <p>&copy; 2024 Car Parts Store. All rights reserved.</p>
  </footer>

  <script src="/ITECAProject/Javascript/Javascriptcode.js"></script>
</body>
