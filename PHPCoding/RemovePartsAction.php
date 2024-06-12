<?php
session_start();

include 'dbInfo.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $partID = $_POST['part_Id'];

    if (is_numeric($_POST['part_ID'])) {
        $partID = $_POST['part_ID'];
    }
    else {
    die('Invalid part ID');
    }

    //delete the row containing the part id and only the part id
    $sql = "DELETE FROM carparts WHERE PartID = '$partID'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: Webpages/RemovePartsPage.php");
        exit();
    } elseif ($conn->affected_rows === 0) {

        echo "Record with product_id $product_id does not exist";
        header("Location: Webpages/RemovePartsPage.php");
        exit();
    }
    else {
        echo "Error deleting record: " . $conn->error;//error handling
        header("Location: Webpages/RemovePartsPage.php");
        exit();
    }

}

$conn->close();


?>