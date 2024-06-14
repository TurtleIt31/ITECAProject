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
       <ul class="nav-buttons">
        <li><a href="HomePage.php">Home</a></li>
        <li><a href="AboutUsPage.php">About Us</a></li>
        <li><a href="Contact.php">Contact</a></li>
        <li><a href="Index.php">Sign In</a></li>
      </ul>
    </nav>
</header>

<br>
    <form action="../SearchAction.php" method="GET" class=""SearchBar>
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
<!-- Display search results -->
<div id="ScrollItems">
        <?php
        // Include your database connection file
        include '../dbInfo.php'; // Adjust the path as necessary

        // Initialize variables
        $partName = isset($_GET['partName']) ? $_GET['partName'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Construct SQL query
        $sql = "SELECT PartID, PartName, Pricing, ImagePath FROM carparts WHERE 1";

        if (!empty($partName)) {
            $sql .= " AND PartName LIKE '%" . $conn->real_escape_string($partName) . "%'";
        }

        if (!empty($category)) {
            $sql .= " AND Category = '" . $conn->real_escape_string($category) . "'";
        }

        // Execute query
        $result = $conn->query($sql);

        // Display results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div>';
                echo '<h3>' . htmlspecialchars($row['PartName']) . '</h3>';
                echo '<p>Pricing: ' . htmlspecialchars($row['Pricing']) . '</p>';
                echo '<img src="' . htmlspecialchars($row['ImagePath']) . '" alt="' . htmlspecialchars($row['PartName']) . '">';
                echo '</div>';
            }
        } else {
            echo '<p>No parts found.</p>';
        }

        // Close database connection
        $conn->close();
        ?>
    </div>

</body>