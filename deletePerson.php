<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variable
$deletePersonSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $deletePersonSSN = mysqli_real_escape_string($mysqli, $_POST["deletePersonSSN"]);

    // Check if the PersonSSN exists in the Person table
    $checkQueryPerson = "SELECT * FROM Person WHERE PersonSSN = '$deletePersonSSN'";
    $checkResultPerson = $mysqli->query($checkQueryPerson);

    if ($checkResultPerson->num_rows > 0) {
        // Delete the record from the Person table
        $deleteQuery = "DELETE FROM Person WHERE PersonSSN = '$deletePersonSSN'";

        if ($mysqli->query($deleteQuery) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $mysqli->error;
        }
    } else {
        echo "Error: Person with SSN '$deletePersonSSN' does not exist. Please enter a valid Person SSN.";
    }
}

// Fetch all records from the Person table
$result = $mysqli->query("SELECT * FROM Person");
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Person Data</title>
</head>
<body>

    <h2>Delete Person Data</h2>

    <form method="post" action="">
        <label for="deletePersonSSN">Enter Person SSN to delete:</label>
        <input type="text" name="deletePersonSSN" value="<?php echo $deletePersonSSN; ?>" required><br>

        <button type="submit">Delete</button>
    </form>

    <h2>Person Data List</h2>

    <ul>
        <?php if (isset($rows) && is_array($rows)): ?>
            <?php foreach ($rows as $row): ?>
                <li><?php echo "{$row['PersonFname']} {$row['PersonLname']} - SSN: {$row['PersonSSN']}, DOB: {$row['PersonDOB']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <!-- Add links to other pages as needed -->

    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
    <a href="updatePerson.php">
        <button type="button">Update Person Data</button>
    </a>
    <a href="updateLicenseRequestor.php">
        <button type="button">Update License Requestor Data</button>
    </a>
    <a href="updateCurrentDriver.php">
        <button type="button">Update Current Driver Data</button>
    </a>
    <a href="updateVehicleRegistrationRequestor.php">
        <button type="button">Update Vehicle Registration Requestor Data</button>
    </a>
</body>
</html>
