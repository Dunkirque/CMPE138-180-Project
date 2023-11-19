<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$DSNameToDelete = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $DSNameToDelete = mysqli_real_escape_string($mysqli, $_POST["DSNameToDelete"]);

    // Check if the DSName exists in the DrivingSchool table
    $checkQuery = "SELECT * FROM DrivingSchool WHERE DSName = '$DSNameToDelete'";
    $checkResult = $mysqli->query($checkQuery);

    // If DSName is found, delete the record
    if ($checkResult->num_rows > 0) {
        $deleteQuery = "DELETE FROM DrivingSchool WHERE DSName = '$DSNameToDelete'";
        if ($mysqli->query($deleteQuery) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $mysqli->error;
        }
    } else {
        // Display an error message if DSName is not found
        echo "Error: DSName '$DSNameToDelete' not found. Please enter a valid DSName.";
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
    <title>Delete Driving School Data</title>
</head>
<body>

    <h2>Delete Driving School Data</h2>

    <form method="post" action="">
        <label for="DSNameToDelete">Enter Driving School Name to Delete:</label>
        <input type="text" name="DSNameToDelete" value="<?php echo $DSNameToDelete; ?>" required><br>

        <button type="submit">Delete Record</button>
    </form>


</body>
</html>
