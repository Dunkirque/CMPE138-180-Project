<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from VehicleManu and join with ExternalAgency
$query = "SELECT VehicleManu.EAName, VehicleManu.VehicleManuCode, ExternalAgency.EAType, ExternalAgency.POC, ExternalAgency.AdminInCharge
          FROM VehicleManu
          JOIN ExternalAgency ON VehicleManu.EAName = ExternalAgency.EAName";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsVehicleManu = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>VehicleManu Data List</title>
</head>
<body>

    <h2>VehicleManu Data List</h2>

    <ul>
        <?php if (isset($rowsVehicleManu) && is_array($rowsVehicleManu)): ?>
            <?php foreach ($rowsVehicleManu as $row): ?>
                <li><?php echo "EAName: {$row['EAName']}, 
                             VehicleManuCode: {$row['VehicleManuCode']},
                             EAType: {$row['EAType']},
                             POC: {$row['POC']}, 
                             Admin In Charge: {$row['AdminInCharge']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>

</body>
</html>
