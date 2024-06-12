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

<br>
    <form action="search.php" method="GET" class=""SearchBar>
        <input type="text" name="partName" placeholder="Search for car parts here..">
        <select name="category">
            <option value="">Select Category</option>
            <!-- Add options dynamically or manually -->
            <option value="Engine">Engine</option>
            <option value="Brakes">Brakes</option>
            <option value="Suspension">Suspension</option>
            <!-- More categories as needed -->
        </select>
        <button type="submit">Search</button>
    </form>
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