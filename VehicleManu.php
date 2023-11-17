<?php
//NEED TO CHECK OVER,using as template for all subclasses
//of ExternalAgency
//NEED to add the checking for distinction in all subclasses
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$VehicleManuCode = '';
$EAName = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $VehicleManuCode = mysqli_real_escape_string($mysqli, $_POST["VehicleManuCode"]);
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);

    // Insert data into the VehicleManu table
    $query = "INSERT INTO VehicleManu (VehicleManuCode, EAName) 
              VALUES ('$VehicleManuCode', '$EAName')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $VehicleManuCode = $EAName = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}       

// Fetch data from VehicleManu and join with ExternalAgency
$query = "SELECT VehicleManu.CAGECode, 
                 ExternalAgency.EAName, ExternalAgency.Type, ExternalAgency.POC, ExternalAgency.AdminInCharge
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
    <title>Insert Vehicle Manufacturer Data</title>
</head>
<body>

    <h2>Insert Vehicle Manufacturer Data</h2>

    <form method="post" action="">
        <label for="VehicleManuCode">Vehicle Manufacturer Code:</label>
        <input type="text" name="VehicleManuCode" value="<?php echo $VehicleManuCode; ?>" required><br>

        <label for="EAName">Vehicle Manufacturer Name:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Vehicle Manufacturer Data List</h2>

    <ul>
        <?php if (isset($rowsVehicleManu) && is_array($rowsVehicleManu)): ?>
            <?php foreach ($rowsVehicleManu as $row): ?>
                <li><?php echo "Vehicle Manufacturer Code: {$row['VehicleManuCode']}, 
                             Name: {$row['EAName']}, 
                             Type: {$row['Type']}, 
                             Admin In Charge: {$row['AdminInCharge']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
</body>
</html>
