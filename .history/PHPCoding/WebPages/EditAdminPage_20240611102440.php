<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to a different page
    header("Location: HomePage.php");
    exit;
}

// Database connection
include '../dbInfo.php';


$sql = "SELECT UserID,UserType,EmailAddress FROM user";//remeber to remove the passwords
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch column names
    $columns = array();
    while ($field = $result->fetch_field()) {
        $columns[] = $field->name;
    }
}

// Close the database connection
$conn->close();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>

<body>
    <header>
        <h1>Goldwagen Parts store</h1>
        <nav>
          <ul>
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
        <Label class="Table-Header">Users Table</Label>
    <table class="sql-table">
        
        <?php
            // Display user data
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columns as $column) {
                    echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="..\EditAdminAction.php" method="post" onsubmit="return Validate();">
        <br>
        <div class="row">
            <!-- User ID-->
            <label>Please enter the User Id you want to change to admin</label>
            <input name="user_ID" id="User_ID" type="number" min='0'>
        </div>
        <div class="row">
            <button type="submit" class="button">Change</button>
        </div>
    </form>
    <!-- make the form a drop down thingy should the user wish to add a new administrator -->
    <form action="..\RegisterNewAdmin.php" method="post" onsubmit="return Validate();">
        <br>
        <div class="row">
            <!-- UserEmail -->
            <label>Please enter the new user Email for an administrator</label>
            <input name="user_Email" id="user_Email" type="text">
        </div>
            <br>
        <div class="row">
            <!-- UserPassword -->
            <label>Please enter the password for the new administrator</label>
            <input name="user_Password" id="user_Password" type="text">
        </div>
        <div class="row">
        <button type="submit" class="button">Register</button><!-- you dont need href because you are not redirecting to another page you are submitting the info-->
        </div>


    </form>

    <form action="..\DeleteUserAction.php" method="post" onsubmit="return Validate();">
        <br>
        <div class="row">
            <!-- UserEmail -->
            <label>Please enter user Email you want to delete</label>
            <input name="user_Email" id="user_Email" type="text">
        </div>
        <div class="row">
        <button type="submit" class="button">Delete</button><!-- you dont need href because you are not redirecting to another page you are submitting the info-->
        </div>


    </form>




</body>