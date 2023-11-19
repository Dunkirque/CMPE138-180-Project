<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$oldEAName = '';
$newEAName = '';
$newVehicleManuCode = '';
$newEAType = '';
$newPOC = '';
$newAdminInCharge = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $oldEAName = mysqli_real_escape_string($mysqli, $_POST["oldEAName"]);
    $newEAName = mysqli_real_escape_string($mysqli, $_POST["newEAName"]);
    $newVehicleManuCode = mysqli_real_escape_string($mysqli, $_POST["newVehicleManuCode"]);
    $newEAType = mysqli_real_escape_string($mysqli, $_POST["newEAType"]);
    $newPOC = mysqli_real_escape_string($mysqli, $_POST["newPOC"]);
    $newAdminInCharge = mysqli_real_escape_string($mysqli, $_POST["newAdminInCharge"]);

    // Check if the old EAName exists in the VehicleManu table
    $checkQueryVehicleManu = "SELECT * FROM VehicleManu WHERE EAName = '$oldEAName'";
    $checkResultVehicleManu = $mysqli->query($checkQueryVehicleManu);

    if ($checkResultVehicleManu->num_rows > 0) {
        // Check if the new EAName already exists in the ExternalAgency table
        $checkQueryNewEA = "SELECT * FROM ExternalAgency WHERE EAName = '$newEAName'";
        $checkResultNewEA = $mysqli->query($checkQueryNewEA);

        if ($checkResultNewEA->num_rows === 0) {
            // Update data in the VehicleManu table
            $updateQueryVehicleManu = "UPDATE VehicleManu 
                                       SET EAName = '$newEAName', 
                                           VehicleManuCode = '$newVehicleManuCode' 
                                       WHERE EAName = '$oldEAName'";
            if ($mysqli->query($updateQueryVehicleManu) === TRUE) {
                // Update data in the ExternalAgency table
                $updateQueryExternalAgency = "UPDATE ExternalAgency 
                                             SET EAName = '$newEAName', 
                                                 EAType = '$newEAType', 
                                                 POC = '$newPOC', 
                                                 AdminInCharge = '$newAdminInCharge' 
                                             WHERE EAName = '$oldEAName'";
                if ($mysqli->query($updateQueryExternalAgency) === TRUE) {
                    echo "Records updated successfully";

                    // Clear form fields after successful update
                    $oldEAName = $newEAName = $newVehicleManuCode = $newEAType = $newPOC = $newAdminInCharge = '';
                } else {
                    echo "Error updating records in ExternalAgency table: " . $mysqli->error;
                }
            } else {
                echo "Error updating records in VehicleManu table: " . $mysqli->error;
            }
        } else {
            // Display error message if new EAName already exists
            echo "Error: New Agency Name '$newEAName' already exists. Please choose a different one.";
        }
    } else {
        // Display error message if old EAName does not exist in VehicleManu table
        echo "Error: Agency with name '$oldEAName' does not exist in VehicleManu. Please enter an existing Vehicle Manufacturer Name.";
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
    <title>Update Vehicle Manufacturer Data</title>
</head>
<body>

    <h2>Update Vehicle Manufacturer Data</h2>

    <form method="post" action="">
        <label for="oldEAName">Enter Existing Vehicle Manufacturer Name to Update:</label>
        <input type="text" name="oldEAName" value="<?php echo $oldEAName; ?>" required><br>

        <label for="newEAName">Enter New Vehicle Manufacturer Name:</label>
        <input type="text" name="newEAName" value="<?php echo $newEAName; ?>" required><br>

        <label for="newVehicleManuCode">Enter New Vehicle Manufacturer Code:</label>
        <input type="text" name="newVehicleManuCode" value="<?php echo $newVehicleManuCode; ?>" required><br>

        <label for="newEAType">Enter New Manufacturer Type:</label>
        <input type="text" name="newEAType" value="<?php echo $newEAType; ?>" required><br>

        <label for="newPOC">Enter New Point of Contact:</label>
        <input type="text" name="newPOC" value="<?php echo $newPOC; ?>" required><br>

        <label for="newAdminInCharge">Enter New Admin In Charge:</label>
        <input type="text" name="newAdminInCharge" value="<?php echo $newAdminInCharge; ?>" required><br>

        <button type="submit">Update Records</button>
    </form>


</body>
</html>
