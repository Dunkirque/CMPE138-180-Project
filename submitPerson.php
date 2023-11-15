<?php

// Include the database connection file
require_once('db_connect.php');
// Add this before the data retrieval
var_dump($_POST);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $PersonLname = mysqli_real_escape_string($mysqli, $_POST["PersonLname"]);
    $PersonFname = mysqli_real_escape_string($mysqli, $_POST["PersonFname"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);
    $PersonDOB = mysqli_real_escape_string($mysqli, $_POST["PersonDOB"]);
    //$role = mysqli_real_escape_string($mysqli, $_POST["role"]);

    // Insert data into the database
    //Replace your_table_name with the actual table it goes in
    //This may require multiple submit forms for the diff tables
    //In this case, table name depends on Person subclass from role chosen
    /*$query = "INSERT INTO your_table_name (PersonFname, PersonLname, PersonSSN, PersonDOB, role) 
              VALUES ('$firstName', '$lastName', '$ssn', '$dob', '$role')";*/
    $query = "INSERT INTO Person(PersonLname, PersonFname, PersonSSN, PersonDOB) 
              VALUES ('$PersonLname', '$PersonFname', '$PersonSSN', '$PersonDOB')";         
        //Omitting 'role' for now in '$PersonDOB','$role'
    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}

?>
