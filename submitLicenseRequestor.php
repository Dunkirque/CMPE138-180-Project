<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$ApplicationNumber = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $ApplicationNumber = mysqli_real_escape_string($mysqli, $_POST["ApplicationNumber"]);
    
    // Insert data into the database
    $query = "INSERT INTO LicenseRequestor (ApplicationNumber) 
              VALUES ('$ApplicationNumber')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
