<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from LicenseRequestor and join with Person
$query = "SELECT LicenseRequestor.ApplicationNumber, 
                 Person.PersonFname, Person.PersonLname, Person.PersonSSN, Person.PersonDOB
          FROM LicenseRequestor
          JOIN Person ON LicenseRequestor.PersonSSN = Person.PersonSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsLicenseRequestor = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>License Requestor Data List</title>
</head>
<body>

    <h2>License Requestor Data List</h2>

    <ul>
        <?php if (isset($rowsLicenseRequestor) && is_array($rowsLicenseRequestor)): ?>
            <?php foreach ($rowsLicenseRequestor as $row): ?>
                <li><?php echo "Application Number: {$row['ApplicationNumber']}, 
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
