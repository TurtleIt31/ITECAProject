<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to a different page
    header("Location: Webpages/HomePage.php");
    exit;
}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Customer</title>
  <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
</head>

<body>
    <header>
        <h1>Goldwagen Parts store</h1>
        <nav>
          <ul class="nav-buttons">
            <li><a href="ShopPage.php">Shop</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="Index.php">Sign In</a></li>
            <li><a href="HomePage.php">Home</a></li>
          </ul>
        </nav>
    </header>
    <script>
      function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";

        var userName = document.getElementById("user_name").value;
        var password = document.getElementById("password").value;
        if (userName === "") {
            document.getElementById("user_info").innerHTML = "required";
            $valid = false;
        }
        if (password === "") {
            document.getElementById("password_info").innerHTML = "required";
            $valid = false;
        }
        return $valid;
      }
    </script>
    <main>
        <form action="..\RegisterUser.php" method="post" id="frmRegister" onsubmit="return Validate();"> <!-- id is for javascript -->
          <div class="row">
            <label>Add New User Details<label><!-- remember to remove the label class or just change the name -->
          </div>
          <div class="row">
            <label class="text-left" for="userEmail">Email <span
              id="user_Email" class="validation-message"></span></label> <input
              name="user_email" id="user_email" type="text" class="full-width">
          </div>
          <div class="row">
              <label class="text-left" for="password">Password <span
                  id="password_info" class="validation-message"></span></label> <input
                  name="password" id="password" type="password" class="full-width">
          </div>
            <div class="row">
              <input type="submit" name="register" value="Register" class="button"></span>
            </div>
        </form>
    </main>
</body>

