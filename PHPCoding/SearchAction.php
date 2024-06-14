<?php
include 'dbInfo.php';

// Retrieve search parameters
$partName = isset($_GET['partName']) ? $_GET['partName'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Validate and sanitize input (if necessary)

// Construct SQL query
$sql = "SELECT PartID, PartName, Pricing, ImagePath FROM carparts WHERE ";

if (!empty($partName) && strlen($partName) >= 4) {
    $sql .= "PartName LIKE '%" . $conn->real_escape_string($partName) . "%'";
} else {
    // Handle case where search term is too short or empty
    // For example, redirect back to search page with an error message
    header('Location: index.php?error=Search term must be at least 4 characters long');
    exit();
}

if (!empty($category)) {
    $sql .= " AND Category = '" . $conn->real_escape_string($category) . "'";
}

// Execute query
$result = $conn->query($sql);

// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Display each part
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