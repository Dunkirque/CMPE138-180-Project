<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$oldEAName = '';
$newEAName = '';
$newEAType = '';
$newPOC = '';
$newAdminInCharge = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $oldEAName = mysqli_real_escape_string($mysqli, $_POST["oldEAName"]);
    $newEAName = mysqli_real_escape_string($mysqli, $_POST["newEAName"]);
    $newEAType = mysqli_real_escape_string($mysqli, $_POST["newEAType"]);
    $newPOC = mysqli_real_escape_string($mysqli, $_POST["newPOC"]);
    $newAdminInCharge = mysqli_real_escape_string($mysqli, $_POST["newAdminInCharge"]);

    // Check if the old EAName exists in the LawAgencies table
    $checkQueryLawAgencies = "SELECT * FROM LawAgencies WHERE EAName = '$oldEAName'";
    $checkResultLawAgencies = $mysqli->query($checkQueryLawAgencies);

    if ($checkResultLawAgencies->num_rows > 0) {
        // Check if the new EAName already exists in the ExternalAgency table
        $checkQueryNewEA = "SELECT * FROM ExternalAgency WHERE EAName = '$newEAName'";
        $checkResultNewEA = $mysqli->query($checkQueryNewEA);

        if ($checkResultNewEA->num_rows === 0) {
            // Update data in the LawAgencies table
            $updateQueryLawAgencies = "UPDATE LawAgencies SET EAName = '$newEAName' WHERE EAName = '$oldEAName'";
            if ($mysqli->query($updateQueryLawAgencies) === TRUE) {
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
                    $oldEAName = $newEAName = $newEAType = $newPOC = $newAdminInCharge = '';
                } else {
                    echo "Error updating records in ExternalAgency table: " . $mysqli->error;
                }
            } else {
                echo "Error updating records in LawAgencies table: " . $mysqli->error;
            }
        } else {
            // Display error message if new EAName already exists
            echo "Error: New Agency Name '$newEAName' already exists. Please choose a different one.";
        }
    } else {
        // Display error message if old EAName does not exist in LawAgencies table
        echo "Error: Agency with name '$oldEAName' does not exist in LawAgencies. Please enter an existing Law Agency Name.";
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
    <title>Update Law Agency Data</title>
</head>
<body>

    <h2>Update Law Agency Data</h2>

    <form method="post" action="">
        <label for="oldEAName">Enter Existing Law Agency Name to Update:</label>
        <input type="text" name="oldEAName" value="<?php echo $oldEAName; ?>" required><br>

        <label for="newEAName">Enter New Law Agency Name:</label>
        <input type="text" name="newEAName" value="<?php echo $newEAName; ?>" required><br>

        <label for="newEAType">Enter New Law Agency Type:</label>
        <input type="text" name="newEAType" value="<?php echo $newEAType; ?>" required><br>

        <label for="newPOC">Enter New Point of Contact:</label>
        <input type="text" name="newPOC" value="<?php echo $newPOC; ?>" required><br>

        <label for="newAdminInCharge">Enter New Admin In Charge:</label>
        <input type="text" name="newAdminInCharge" value="<?php echo $newAdminInCharge; ?>" required><br>

        <button type="submit">Update Records</button>
    </form>

    <a href="LawAgencies.php">
        <button type="button">Go back to Law Agency Data</button>
    </a>
</body>
</html>
