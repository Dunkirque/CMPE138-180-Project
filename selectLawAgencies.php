<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from LawAgencies and join with ExternalAgency
$query = "SELECT LawAgencies.EAName, ExternalAgency.EAType, ExternalAgency.POC, ExternalAgency.AdminInCharge
          FROM LawAgencies
          JOIN ExternalAgency ON LawAgencies.EAName = ExternalAgency.EAName";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsLawAgencies = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>LawAgencies Data List</title>
</head>
<body>

    <h2>LawAgencies Data List</h2>

    <ul>
        <?php if (isset($rowsLawAgencies) && is_array($rowsLawAgencies)): ?>
            <?php foreach ($rowsLawAgencies as $row): ?>
                <li><?php echo "EAName: {$row['EAName']}, 
                             EAType: {$row['EAType']},
                             POC: {$row['POC']}, 
                             Admin In Charge: {$row['AdminInCharge']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>



</body>
</html>
