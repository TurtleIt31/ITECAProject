<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to a different page
    header("Location: HomePage.php");
    exit;
}
?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign In</title>
        <link rel="stylesheet" href="/ITECAProject/Styling/CSScode.css">
    </head>

  <body>
    <header>
        <h1>Goldwagen Parts store</h1>
        <nav>
          <ul class="nav-buttons">
            <li><a href="ShopPage.php">Shop</a></li>
            <li><a href="AboutUsPage.php">About Us</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="HomePage.php">Home</a></li>
          </ul>
        </nav>
      </header>
        <main>
            <?php
                if (isset($_SESSION["errorMessage"])) {
                    ?>
                            <div class="validation-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                            <?php
                    //unset($_SESSION["errorMessage"]);
                }
                ?>
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
            <form action="../LoginAction.php" method="post" id="frmLogin"
                    onSubmit="return validate();">
                    <h2>Enter Login Details</h2>
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
                        <input type="submit" name="login" value="Login" class="button"></span>
                    </div>
                    <div class="row">
                        <button type="button" onclick="window.location.href='NewUserRegisterPage.php'" class="button">New users click here</button>
                    </div>
                    
            </form>
        </main>

    
  </body>