<?php
session_start();

include 'dbInfo.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $partName = $_POST['part_Name'];
    $PartCategory = $_POST['part_Category'];

    //<!-- Part VinNumber-->
    $partVINNumber = $_POST['part_VIN_Number'];
    //<!-- Vehicle Type-->
    $vehicleType = $_POST['vehicle_Type'];
    

        //<!-- Part price-->
    if (is_numeric($_POST['part_Price'])) {
        $partPrice = (float) $_POST['part_Price'];
    } else {
        die('Invalid part price');
    }

    //<!-- Inventory of parts-->
    if (is_numeric($_POST['part_Inventory'])) {
        $partInventory = (int) $_POST['part_Inventory'];
    } else {
        die('Invalid part inventory');
    }


    $partName = $conn->real_escape_string($partName);
    $PartCategory = $conn->real_escape_string($PartCategory);
    $partVINNumber = $conn->real_escape_string($partVINNumber);
    $vehicleType = $conn->real_escape_string($vehicleType);

    //retrieve the vinnumbers
    $sql = "SELECT * FROM carparts WHERE VINNumber ='$partVINNumber'";
    $result = $conn->query($sql);
    // check for dupilicate vin numbers
    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "VIN Number Already exists";
        //redirect to add parts page
        header("Location: Webpages/AdminAddPartPage.php");
        exit;
        
    }
    else{
        //vin number does not exist add to the table
        $insert_sql = "INSERT INTO carparts (PartName,VehicleType,Inventory,VINNumber,Pricing) VALUES('$partName','$vehicleType','$partInventory','$partVINNumber','$partPrice')";
        if ($conn->query($insert_sql) === TRUE) {//check that the insert worked
            $_SESSION['Status message'] = "Part added succesfully";
            header("Location: Webpages/HomePage.php");
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;//error handling
            $_SESSION['error_message'] = "Error has occured";

        }

    }
    

    


}

?>