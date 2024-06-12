<?php
session_start();

include 'dbInfo.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if (is_numeric($_POST['part_ID'])) {
        $partID = $_POST['part_ID'];
    }
    else {
        die('Invalid part ID');
    }

    if (is_numeric($_POST['part_Price'])) {
        $partPrice = $_POST['part_Price'];
    }
    else {
        die('Invalid part price ');
    }
    $Sql = "SELECT * FROM carparts WHERE PartID ='$partID'";
    $result = $conn->query($Sql);

    if ($result->num_rows == 1) {
        //Update sql
        $updateSQl="UPDATE carparts SET Pricing='$partPrice' WHERE PartID='$partID'";

        if ($conn->query($updateSQl) === true) {
            echo "User type updated successfully";
            header("Location: Webpages/EditPricePage.php");
        }
        else {
            echo "Error updating record: " . $conn->error;
            //header("Location: Webpages/EditAdminPage.php");
        }
    }


    

    
}
?>