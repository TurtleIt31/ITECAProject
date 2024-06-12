<?php
include 'dbInfo.php';
// Get search inputs
$partName = isset($_GET['partName']) ? $_GET['partName'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Construct the SQL query
$sql = "SELECT PartID, PartName, Pricing, ImagePath FROM carparts WHERE 1=1";

if (!empty($partName)) {
    $sql .= " AND PartName LIKE '%" . $conn->real_escape_string($partName) . "%'";
}

if (!empty($category)) {
    $sql .= " AND Category = '" . $conn->real_escape_string($category) . "'";
}

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='part'>";
        echo "<img src='" . $row['ImagePath'] . "' alt='" . $row['PartName'] . "'>";
        echo "<h2>" . $row['PartName'] . "</h2>";
        echo "<p>Price: $" . $row['Pricing'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No results found.";
}

$conn->close();
?>