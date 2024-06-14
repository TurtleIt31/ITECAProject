<?php
// Start session
session_start();

//$_SESSION['loggedin'] = true;// this is for testing purposes
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
  //echo "Welcome, " . htmlspecialchars($_SESSION['user_email']) . "!";
} else {
  // User is not logged in, redirect to the login page
  header("Location: /ITECAProject/PHPCoding/WebPages/Index.php");
  exit();
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Admin user</title>
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

    <Main>
      <form action="..\AddNewProducts.php" method="post" onsubmit="return Validate();">
        <br>
        <div class="row">
          <!-- Part name-->
           <Label class="text-left" for="partName">Part Name </Label>
           <input name="part_Name" id="part_Name" type="text" class="full-width">
          
        </div>
        <div class="row">
          <!-- Part category-->
          <Label class="text-left" for="partName">Part Category </Label>
           <input name="part_Category" id="part_Category" type="text" class="full-width">
        </div>
        <div class="row">
          <!-- Part price-->
          <Label class="text-left" for="partPrice">Part Price </Label>
          <input name="part_Price" id="part_Price" type="number" min="0" step="0.01" class="full-width">
        </div>
        <div class="row">
          <!-- Part VinNumber-->
          <Label class="text-left" for="partVINNumber">Part VIN Number</Label>
          <input name="part_VIN_Number" id="part_VIN_Number" type="text" class="full-width">
        </div>
        <div class="row">
          <!-- Vehicle Type-->
          <Label class="text-left" for="vehicleType">Vehicle Type</Label>
          <input name="vehicle_Type" id="vehicle_Type" type="text" class="full-width">
        </div>
        <div class="row">
          <!-- Inventory of parts-->
          <Label class="text-left" for="part_Inventory">Inventory</Label>
          <input name="part_Inventory" id="part_Inventory" type="number" min="0" class="full-width">
        </div>
        <div class="row">
          <input type="submit" name="Add New Part" value="Add New Part" class="button">
        </div>
      </form>
    </Main>
</body>