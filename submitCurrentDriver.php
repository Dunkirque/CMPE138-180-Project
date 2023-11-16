<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$DLNumber = '';
$InsurancePolicyNumber = '';
$DLExpDate = '';
$PersonSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $DLNumber = mysqli_real_escape_string($mysqli, $_POST["DLNumber"]);
    $InsurancePolicyNumber = mysqli_real_escape_string($mysqli, $_POST["InsurancePolicyNumber"]);
    $DLExpDate = mysqli_real_escape_string($mysqli, $_POST["DLExpDate"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);

    // Insert data into the CurrentDriver table
    $query = "INSERT INTO CurrentDriver (DLNumber, InsurancePolicyNumber, DLExpDate, PersonSSN) 
              VALUES ('$DLNumber', '$InsurancePolicyNumber', '$DLExpDate', '$PersonSSN')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
