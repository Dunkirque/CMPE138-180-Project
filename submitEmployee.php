<?php
// Include the database connection file
require_once('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EmpSSN = mysqli_real_escape_string($mysqli, $_POST["EmpSSN"]);
    $EmpLname = mysqli_real_escape_string($mysqli, $_POST["EmpLname"]);
    $EmpFname = mysqli_real_escape_string($mysqli, $_POST["EmpFname"]);
    $EmpNumber = mysqli_real_escape_string($mysqli, $_POST["EmpNumber"]);

    // Insert data into the database
    $query = "INSERT INTO Employee (EmpSSN, EmpLname, EmpFname, EmpNumber) 
              VALUES ('$EmpSSN', '$EmpLname', '$EmpFname', '$EmpNumber')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>
