<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$DLNumber = $InsurancePolicyNumber = $DLExpDate = $PersonSSN = $PersonLname = $PersonFname = $PersonDOB = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and SSN is provided, fetch the data
if ($action == 'update' && isset($_GET['ssn'])) {
    $PersonSSNToUpdate = mysqli_real_escape_string($mysqli, $_GET['ssn']);
    $DLNumberToUpdate = mysqli_real_escape_string($mysqli, $_GET['dlNumber']);
    $query = "SELECT * FROM CurrentDriver
              JOIN Person ON CurrentDriver.PersonSSN = Person.PersonSSN
              WHERE CurrentDriver.PersonSSN = '$PersonSSNToUpdate' 
                AND CurrentDriver.DLNumber = '$DLNumberToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $DLNumber = $row['DLNumber'];
        $InsurancePolicyNumber = $row['InsurancePolicyNumber'];
        $DLExpDate = $row['DLExpDate'];
        $PersonSSN = $row['PersonSSN'];
        $PersonLname = $row['PersonLname'];
        $PersonFname = $row['PersonFname'];
        $PersonDOB = $row['PersonDOB'];
    } else {
        echo "Error: Record not found.";
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $DLNumber = mysqli_real_escape_string($mysqli, $_POST["DLNumber"]);
    $InsurancePolicyNumber = mysqli_real_escape_string($mysqli, $_POST["InsurancePolicyNumber"]);
    $DLExpDate = mysqli_real_escape_string($mysqli, $_POST["DLExpDate"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);
    $PersonLname = mysqli_real_escape_string($mysqli, $_POST["PersonLname"]);
    $PersonFname = mysqli_real_escape_string($mysqli, $_POST["PersonFname"]);
    $PersonDOB = mysqli_real_escape_string($mysqli, $_POST["PersonDOB"]);

    // Update data in the CurrentDriver and Person tables
    $updateQuery = "UPDATE CurrentDriver 
                    SET DLNumber = '$DLNumber', InsurancePolicyNumber = '$InsurancePolicyNumber', DLExpDate = '$DLExpDate'
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
    <title>Update Current Driver Data</title>
</head>
<body>

    <h2>Update Current Driver Data</h2>

    <form method="post" action="">
        <label for="PersonSSN">Current Driver SSN to Update:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <label for="DLNumber">Driver's License Number:</label>
        <input type="text" name="DLNumber" value="<?php echo $DLNumber; ?>" required><br>

        <label for="InsurancePolicyNumber">Insurance Policy Number:</label>
        <input type="text" name="InsurancePolicyNumber" value="<?php echo $InsurancePolicyNumber; ?>" required><br>

        <label for="DLExpDate">Driver's License Expiration Date:</label>
        <input type="date" name="DLExpDate" value="<?php echo $DLExpDate; ?>" required><br>

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
