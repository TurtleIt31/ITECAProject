<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to a different page
    header("Location: HomePage.php");
    exit;
}
include '../dbInfo.php';

// Define columns to select
$columns = ["PartID", "PartName", "Pricing", "VehicleType", "Inventory"];

// Construct column names for SQL query
$columnNames = implode(", ", $columns);

$sql = "SELECT $columnNames FROM carparts";
$result = $conn->query($sql);

// Check for SQL query error
if ($conn->error) {
    die("SQL error: " . $conn->error);
}

// Close the database connection
$conn->close();
?>


<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Remove Parts</title>
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

    <br>

    <table class="sql-table">
        <thead>
            <tr>
                <?php
                // Display column headers
                foreach ($columns as $column) {
                    echo "<th>" . ucfirst($column) . "</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display car parts
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($columns as $column) {
                        echo "<td>" . $row[$column] . "</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='" . count($columns) . "'>No results found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="..\RemovePartsAction.php" method="post" onsubmit="return Validate();">
        <br>
        <div class="row">
            <!-- Part ID-->
            <label>Please enter the part Id you want to remove</label>
            <Label class="text-left" for="partName">Part ID </Label>
            <input name="part_ID" id="part_ID" type="text">
            <Br>
            <input type="submit" name="delete" value="Confirm Delete" class="button">
        </div>
    </form>
</body>

