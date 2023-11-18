<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EANameToDelete = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EANameToDelete = mysqli_real_escape_string($mysqli, $_POST["EANameToDelete"]);

    // Check if the EAName exists in the VehicleManu table
    $checkQuery = "SELECT * FROM VehicleManu WHERE EAName = '$EANameToDelete'";
    $checkResult = $mysqli->query($checkQuery);

    // If EAName is found, delete the records
    if ($checkResult->num_rows > 0) {
        $deleteQuery = "DELETE FROM VehicleManu WHERE EAName = '$EANameToDelete'";
        if ($mysqli->query($deleteQuery) === TRUE) {
            echo "Records deleted successfully";
        } else {
            echo "Error deleting records: " . $mysqli->error;
        }
    } else {
        // Display an error message if EAName is not found
        echo "Error: Vehicle Manufacturer with name '$EANameToDelete' not found in VehicleManu table. Please enter a valid EAName.";
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
    <title>Delete Vehicle Manufacturer Data</title>
</head>
<body>

    <h2>Delete Vehicle Manufacturer Data</h2>

    <form method="post" action="">
        <label for="EANameToDelete">Enter Vehicle Manufacturer Name to Delete Records:</label>
        <input type="text" name="EANameToDelete" value="<?php echo $EANameToDelete; ?>" required><br>

        <button type="submit">Delete Records</button>
    </form>

    <a href="ExternalAgency.php">
        <button type="button">Go back to External Agency Data</button>
    </a>
</body>
</html>
