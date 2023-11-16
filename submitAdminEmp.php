<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EmpSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EmpSSN = mysqli_real_escape_string($mysqli, $_POST["EmpSSN"]);

    // Insert data into the AdminEmp table
    $query = "INSERT INTO AdminEmp (EmpSSN) 
              VALUES ('$EmpSSN')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
