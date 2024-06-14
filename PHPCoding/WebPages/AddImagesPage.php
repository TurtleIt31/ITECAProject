<?php
// Start session
session_start();

//$_SESSION['loggedin'] = true;// this is for testing purposes
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
} else {
  // User is not logged in, redirect to the login page
  header("Location: /ITECAProject/PHPCoding/WebPages/Index.php");
  exit();

}

include '../dbInfo.php';

// Define columns to select
$columns = ["PartID", "PartName", "Pricing", "VehicleTYpe", "Inventory", "ImagePath"];

// Construct column names for SQL query
$columnNames = implode(", ", $columns);

$sql = "SELECT $columnNames FROM carparts";
$result = $conn->query($sql);

// Close the database connection
$conn->close();

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Images edit</title>
  <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>

<body>
    <header>
        <h1>Goldwagen Parts store</h1>
        <nav>
            <ul class="nav-buttons">
            <li><a href="ShopPage.php">Shop</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="HomePage.php">Home</a></li>
            <?php
            echo '<li>Welcome, ' . htmlspecialchars($_SESSION['user_email']) . '</li>';
            ?>
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

        <form action="..\UploadPicture.php" method="post" enctype="multipart/form-data">
            <br>
            <div class="row">
            <!-- Part ID-->
            <label>Please enter the part Id you want to upload the picture for</label>
            <input name="part_ID" id="part_ID" type="text">
            </div>
           <div class="row">
            <!-- Part Picture-->
            <label>Please select the picture you wish to upload</label>
            <input name="part_Picture" id="part_Picture" type="file">
           </div>
           
           
           <div class="row">
                <button type="submit" class="button">Upload Picture</button>
           </div>
        </form>

</body>


