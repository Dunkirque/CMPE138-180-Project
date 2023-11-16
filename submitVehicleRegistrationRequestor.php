<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$VehicleNumber = '';
$PersonSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $VehicleNumber = mysqli_real_escape_string($mysqli, $_POST["VehicleNumber"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);

    // Insert data into the VehicleRegistrationRequestor table
    $query = "INSERT INTO VehicleRegistrationRequestor (VehicleNumber, PersonSSN) 
              VALUES ('$VehicleNumber', '$PersonSSN')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
