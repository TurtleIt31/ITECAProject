<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page</title>
    <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>
<body>
<header>
    <h1>Goldwagen Parts store</h1>
    <nav>
      <ul>
        <li><a href="HomePage.php">Home</a></li>
        <li><a href="AboutUsPage.php">About Us</a></li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="Index.php">Sign In</a></li>
      </ul>
    </nav>
</header>
<div class="SearchBar">
    <input type="text" placeholder="Search for car parts here..">
</div>
<br>
<div class="Categories"></div>

<div id="ScrollItems">
    <?php
    include '../dbInfo.php';

    // SQL query to retrieve all parts
    $sql = "SELECT PartID, PartName, Pricing, ImagePath FROM carparts";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Display each part
        while ($row = $result->fetch_assoc()) {
            echo '<div class="part-item">';
            echo '<img src="../' . htmlspecialchars($row['ImagePath']) . '" alt="' . htmlspecialchars($row['PartName']) . '">';
            echo '<div class="part-details">';
            echo '<p><strong>Part Name:</strong> ' . htmlspecialchars($row['PartName']) . '</p>';
            echo '<p><strong>Price:</strong> R' . htmlspecialchars($row['Pricing']) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No parts found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

</body>