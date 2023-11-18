<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from VehicleRegRequestor and join with Person
$query = "SELECT VehicleRegRequestor.VehicleNumber, 
                 Person.PersonFname, Person.PersonLname, Person.PersonSSN, Person.PersonDOB
          FROM VehicleRegRequestor
          JOIN Person ON VehicleRegRequestor.PersonSSN = Person.PersonSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsVehicleRegRequestor = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Vehicle Registration Requestor Data List</title>
</head>
<body>

    <h2>Vehicle Registration Requestor Data List</h2>

    <ul>
        <?php if (isset($rowsVehicleRegRequestor) && is_array($rowsVehicleRegRequestor)): ?>
            <?php foreach ($rowsVehicleRegRequestor as $row): ?>
                <li><?php echo "Vehicle Number: {$row['VehicleNumber']}, 
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
