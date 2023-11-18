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

    // Check if PersonSSN already exists in LicenseRequestor
    $checkQueryLicense = "SELECT * FROM LicenseRequestor WHERE PersonSSN = '$PersonSSN'";
    $checkResultLicense = $mysqli->query($checkQueryLicense);

    // Check if PersonSSN already exists in CurrentDriver
    $checkQueryCurrentDriver = "SELECT * FROM CurrentDriver WHERE PersonSSN = '$PersonSSN'";
    $checkResultCurrentDriver = $mysqli->query($checkQueryCurrentDriver);

    // Check if PersonSSN already exists in VehicleRegRequestor
    $checkQueryVehicleRegRequestor = "SELECT * FROM VehicleRegRequestor WHERE PersonSSN = '$PersonSSN'";
    $checkResultVehicleRegRequestor = $mysqli->query($checkQueryVehicleRegRequestor);

    // If PersonSSN is not found in any of the tables, insert data
    if (
        $checkResultLicense->num_rows === 0 &&
        $checkResultCurrentDriver->num_rows === 0 &&
        $checkResultVehicleRegRequestor->num_rows === 0
    ) {
        // Insert data into the CurrentDriver table
        $query = "INSERT INTO CurrentDriver (DLNumber, InsurancePolicyNumber, DLExpDate, PersonSSN) 
                  VALUES ('$DLNumber', '$InsurancePolicyNumber', '$DLExpDate', '$PersonSSN')";

        if ($mysqli->query($query) === TRUE) {
            echo "Record inserted successfully";

            // Clear form fields after successful insertion
            $DLNumber = $InsurancePolicyNumber = $DLExpDate = $PersonSSN = '';
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
        }
    } else {
        // Display error message if PersonSSN already exists
        echo "Error: SSN '$PersonSSN' is already used. Please try a different one.";
    }
}

// Fetch data from CurrentDriver and join with Person
$query = "SELECT CurrentDriver.DLNumber, CurrentDriver.InsurancePolicyNumber, CurrentDriver.DLExpDate, 
                 Person.PersonFname, Person.PersonLname, Person.PersonSSN, Person.PersonDOB
          FROM CurrentDriver
          JOIN Person ON CurrentDriver.PersonSSN = Person.PersonSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsCurrentDriver = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the case where the query failed
    echo "Error: " . $mysqli->error;
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
    <title>Insert Current Driver Data</title>
</head>
<body>

    <h2>Insert Current Driver Data</h2>

    <form method="post" action="CurrentDriver.php">
        <label for="DLNumber">DL Number:</label>
        <input type="text" name="DLNumber" value="<?php echo $DLNumber; ?>" required><br>

        <label for="InsurancePolicyNumber">Insurance Policy Number:</label>
        <input type="text" name="InsurancePolicyNumber" value="<?php echo $InsurancePolicyNumber; ?>" required><br>

        <label for="DLExpDate">DL Expiry Date:</label>
        <input type="date" name="DLExpDate" value="<?php echo $DLExpDate; ?>" required><br>

        <label for="PersonSSN">Person SSN:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Current Driver Data List</h2>

    <ul>
        <?php if (isset($rowsCurrentDriver) && is_array($rowsCurrentDriver)): ?>
            <?php foreach ($rowsCurrentDriver as $row): ?>
                <li><?php echo "DL Number: {$row['DLNumber']}, 
                             Insurance Policy Number: {$row['InsurancePolicyNumber']}, 
                             DL Expiry Date: {$row['DLExpDate']},
                             Name: {$row['PersonFname']} {$row['PersonLname']}, 
                             SSN: {$row['PersonSSN']}, 
                             DOB: {$row['PersonDOB']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
</body>
</html>
