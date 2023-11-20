<?php
//SJSU CMPE 138 Fall 2023 Team 11
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$PersonSSNToDelete = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $PersonSSNToDelete = mysqli_real_escape_string($mysqli, $_POST["PersonSSNToDelete"]);

    // Check if the PersonSSN exists in the LicenseRequestor table
    $checkQuery = "SELECT * FROM LicenseRequestor WHERE PersonSSN = '$PersonSSNToDelete'";
    $checkResult = $mysqli->query($checkQuery);

    // If PersonSSN is found, delete the records
    if ($checkResult->num_rows > 0) {
        $deleteQuery = "DELETE FROM LicenseRequestor WHERE PersonSSN = '$PersonSSNToDelete'";
        if ($mysqli->query($deleteQuery) === TRUE) {
            echo "Records deleted successfully";
        } else {
            echo "Error deleting records: " . $mysqli->error;
        }
    } else {
        // Display an error message if PersonSSN is not found
        echo "Error: PersonSSN '$PersonSSNToDelete' not found in LicenseRequestor table. Please enter a valid PersonSSN.";
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
    <title>Delete License Requestor Data</title>
</head>
<body>

    <h2>Delete License Requestor Data</h2>

    <form method="post" action="">
        <label for="PersonSSNToDelete">Enter Person SSN to Delete Records:</label>
        <input type="text" name="PersonSSNToDelete" value="<?php echo $PersonSSNToDelete; ?>" required><br>

        <button type="submit">Delete Records</button>
    </form>


</body>
</html>
