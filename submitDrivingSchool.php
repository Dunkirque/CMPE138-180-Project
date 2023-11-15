<?php

// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$DSName = $CertRegNumber = $Manager = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $DSName = mysqli_real_escape_string($mysqli, $_POST["DSName"]);
    $CertRegNumber = mysqli_real_escape_string($mysqli, $_POST["CertRegNumber"]);
    $Manager = mysqli_real_escape_string($mysqli, $_POST["Manager"]);

    // Insert data into the database
    $query = "INSERT INTO DrivingSchool (DSName, CertRegNumber, Manager) 
              VALUES ('$DSName', '$CertRegNumber', '$Manager')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $DSName = $CertRegNumber = $Manager = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}

?>
