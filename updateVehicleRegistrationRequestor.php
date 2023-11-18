<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$PersonSSN = $PersonLname = $PersonFname = $PersonDOB = $VehicleNumber = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and SSN is provided, fetch the data
if ($action == 'update' && isset($_GET['ssn'])) {
    $PersonSSNToUpdate = mysqli_real_escape_string($mysqli, $_GET['ssn']);
    $VehicleNumberToUpdate = mysqli_real_escape_string($mysqli, $_GET['vehicleNumber']);
    $query = "SELECT * FROM VehicleRegRequestor
              JOIN Person ON VehicleRegRequestor.PersonSSN = Person.PersonSSN
              WHERE VehicleRegRequestor.PersonSSN = '$PersonSSNToUpdate' 
                AND VehicleRegRequestor.VehicleNumber = '$VehicleNumberToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $PersonSSN = $row['PersonSSN'];
        $PersonLname = $row['PersonLname'];
        $PersonFname = $row['PersonFname'];
        $PersonDOB = $row['PersonDOB'];
        $VehicleNumber = $row['VehicleNumber'];
    } else {
        echo "Error: Record not found.";
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);
    $PersonLname = mysqli_real_escape_string($mysqli, $_POST["PersonLname"]);
    $PersonFname = mysqli_real_escape_string($mysqli, $_POST["PersonFname"]);
    $PersonDOB = mysqli_real_escape_string($mysqli, $_POST["PersonDOB"]);
    $VehicleNumber = mysqli_real_escape_string($mysqli, $_POST["VehicleNumber"]);

    // Update data in the VehicleRegRequestor and Person tables
    $updateQueryVehicle = "UPDATE VehicleRegRequestor 
                           SET VehicleNumber = '$VehicleNumber'
                           WHERE PersonSSN = '$PersonSSN'";

    $updateQueryPerson = "UPDATE Person 
                          SET PersonLname = '$PersonLname', PersonFname = '$PersonFname', PersonDOB = '$PersonDOB'
                          WHERE PersonSSN = '$PersonSSN'";

    if (
        $mysqli->query($updateQueryVehicle) === TRUE &&
        $mysqli->query($updateQueryPerson) === TRUE
    ) {
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
    <title>Update VehicleRegRequestor Data</title>
</head>
<body>

    <h2>Update Vehicle Registration Requestor Data</h2>

    <form method="post" action="">
        <label for="PersonSSN">Vehicle Registration Requestor SSN to Update:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <label for="VehicleNumber">Vehicle Number:</label>
        <input type="text" name="VehicleNumber" value="<?php echo $VehicleNumber; ?>" required><br>

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
