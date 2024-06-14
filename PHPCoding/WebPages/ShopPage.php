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
    <div class="SearchBar">
        <form action="ShopPage.php" method="GET">
            <input type="text" name="partName" placeholder="Search for car parts here.." value="<?php echo htmlspecialchars(isset($_GET['partName']) ? $_GET['partName'] : ''); ?>">
            <select name="category">
                <option value="">Select Category</option>
                <option value="Engine" <?php echo isset($_GET['category']) && $_GET['category'] == 'Engine' ? 'selected' : ''; ?>>Engine</option>
                <option value="Brakes" <?php echo isset($_GET['category']) && $_GET['category'] == 'Brakes' ? 'selected' : ''; ?>>Brakes</option>
                <option value="Suspension" <?php echo isset($_GET['category']) && $_GET['category'] == 'Suspension' ? 'selected' : ''; ?>>Suspension</option>
            </select>
            <button type="submit" class="button">Search</button>
        </form>
    </div>
    <<!-- Display search results -->
    <div id="ScrollItems">
        <?php

        session_start();
        // Include your database connection file
        include '..\dbInfo.php';

        // Retrieve search parameters
        $partName = isset($_GET['partName']) ? $_GET['partName'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Construct SQL query
        $sql = "SELECT PartID, PartName, Pricing, ImagePath FROM carparts WHERE 1";

        if (!empty($partName) && strlen($partName) >= 4) {
            $sql .= " AND PartName LIKE '%" . $conn->real_escape_string($partName) . "%'";
        } elseif (!empty($partName)) {
            echo '<p>Search term must be at least 4 characters long</p>';
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
                if (isset($_SESSION['user_id'])) {//if the user is signed in have the ability to add items to the cart
                    echo '<form action="..\AddToCart.php" method="POST">';
                    echo '<input type="hidden" name="partID" value="' . htmlspecialchars($row['PartID']) . '">';
                    echo '<button type="submit">Add to Cart</button>';
                    echo '</form>';
                }
                echo '</div>';
            }
        } else {
            if (empty($partName) || strlen($partName) >= 4) {
                echo '<p>No parts found.</p>';
            }
        }

        // Close database connection
        $conn->close();
        ?>
    </div>

</body>