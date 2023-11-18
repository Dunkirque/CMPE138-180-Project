<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$PersonLname = $PersonFname = $PersonSSN = $PersonDOB = $ApplicationNumber = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and SSN is provided, fetch the data
if ($action == 'update' && isset($_GET['ssn'])) {
    $PersonSSNToUpdate = mysqli_real_escape_string($mysqli, $_GET['ssn']);
    $ApplicationNumberToUpdate = mysqli_real_escape_string($mysqli, $_GET['applicationNumber']);
    $query = "SELECT * FROM LicenseRequestor
              JOIN Person ON LicenseRequestor.PersonSSN = Person.PersonSSN
              WHERE LicenseRequestor.PersonSSN = '$PersonSSNToUpdate' 
                AND LicenseRequestor.ApplicationNumber = '$ApplicationNumberToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $PersonLname = $row['PersonLname'];
        $PersonFname = $row['PersonFname'];
        $PersonSSN = $row['PersonSSN'];
        $PersonDOB = $row['PersonDOB'];
        $ApplicationNumber = $row['ApplicationNumber'];
    } else {
        echo "Error: Record not found.";
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);
    $ApplicationNumber = mysqli_real_escape_string($mysqli, $_POST["ApplicationNumber"]);
    $PersonLname = mysqli_real_escape_string($mysqli, $_POST["PersonLname"]);
    $PersonFname = mysqli_real_escape_string($mysqli, $_POST["PersonFname"]);
    $PersonDOB = mysqli_real_escape_string($mysqli, $_POST["PersonDOB"]);

    // Update data in the LicenseRequestor and Person tables
    $updateQuery = "UPDATE LicenseRequestor 
                    SET ApplicationNumber = '$ApplicationNumber'
                    WHERE PersonSSN = '$PersonSSN'";

    $updateQueryPerson = "UPDATE Person 
                          SET PersonLname = '$PersonLname', PersonFname = '$PersonFname', PersonDOB = '$PersonDOB'
                          WHERE PersonSSN = '$PersonSSN'";

    if ($mysqli->query($updateQuery) === TRUE && $mysqli->query($updateQueryPerson) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update License Requestor Data</title>
</head>
<body>

    <h2>Update License Requestor Data</h2>

    <form method="post" action="">
        <label for="PersonSSN">License Requestor SSN to Update:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <label for="ApplicationNumber">Application Number:</label>
        <input type="text" name="ApplicationNumber" value="<?php echo $ApplicationNumber; ?>" required><br>

        <label for="PersonLname">Last Name:</label>
        <input type="text" name="PersonLname" value="<?php echo $PersonLname; ?>" required><br>

        <label for="PersonFname">First Name:</label>
        <input type="text" name="PersonFname" value="<?php echo $PersonFname; ?>" required><br>

        <label for="PersonDOB">Date of Birth:</label>
        <input type="date" name="PersonDOB" value="<?php echo $PersonDOB; ?>" required><br>

        <button type="submit">Update</button>
    </form>

    <a href="Person.php">
        <button type="button">Go back to Person Data</button>
    </a>

</body>
</html>
