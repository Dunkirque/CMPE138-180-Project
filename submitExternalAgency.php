<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = $Type = $POC = $AdminInCharge = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);
    $Type = mysqli_real_escape_string($mysqli, $_POST["Type"]);
    $POC = mysqli_real_escape_string($mysqli, $_POST["POC"]);
    $AdminInCharge = mysqli_real_escape_string($mysqli, $_POST["AdminInCharge"]);

    // Insert data into the database
    $query = "INSERT INTO ExternalAgency (EAName, Type, POC, AdminInCharge) 
              VALUES ('$EAName', '$Type', '$POC', '$AdminInCharge')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
