<?php
// Include the database connection file
require_once('db_connect.php');

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
    <title>Current Driver Data List</title>
</head>
<body>

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

</body>
</html>
