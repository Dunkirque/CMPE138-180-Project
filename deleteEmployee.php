<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EmpSSNToDelete = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EmpSSNToDelete = mysqli_real_escape_string($mysqli, $_POST["EmpSSNToDelete"]);

    // Check if the EmpSSN exists in the Employee table
    $checkQuery = "SELECT * FROM Employee WHERE EmpSSN = '$EmpSSNToDelete'";
    $checkResult = $mysqli->query($checkQuery);

    // If EmpSSN is found, delete the record
    if ($checkResult->num_rows > 0) {
        $deleteQuery = "DELETE FROM Employee WHERE EmpSSN = '$EmpSSNToDelete'";
        if ($mysqli->query($deleteQuery) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $mysqli->error;
        }
    } else {
        // Display an error message if EmpSSN is not found
        echo "Error: EmpSSN '$EmpSSNToDelete' not found. Please enter a valid EmpSSN.";
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
    <title>Delete Employee Data</title>
</head>
<body>

    <h2>Delete Employee Data</h2>

    <form method="post" action="">
        <label for="EmpSSNToDelete">Enter Employee SSN to Delete:</label>
        <input type="text" name="EmpSSNToDelete" value="<?php echo $EmpSSNToDelete; ?>" required><br>

        <button type="submit">Delete Record</button>
    </form>

    <a href="Employee.php">
        <button type="button">Go back to Employee Data</button>
    </a>
</body>
</html>
