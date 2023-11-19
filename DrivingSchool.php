<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$DSName = $CertRegNumber = $Manager = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $DSName = mysqli_real_escape_string($mysqli, $_POST["DSName"]);
    $CertRegNumber = mysqli_real_escape_string($mysqli, $_POST["CertRegNumber"]);
    $Manager = mysqli_real_escape_string($mysqli, $_POST["Manager"]);

    // Insert data into the database
    $query = "INSERT INTO DrivingSchool (DSName, CertRegNumber, Manager) 
              VALUES ('$DSName', '$CertRegNumber', '$Manager')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $DSName = $CertRegNumber = $Manager = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}       
         
// Fetch all records from the DrivingSchool table
$resultDrivingSchool = $mysqli->query("SELECT * FROM DrivingSchool");
$rowsDrivingSchool = $resultDrivingSchool->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Driving School Data</title>
</head>
<body>

    <h2>Insert Driving School Data</h2>

    <form method="post" action="">
        <label for="DSName">Driving School Name:</label>
        <input type="text" name="DSName" value="<?php echo $DSName; ?>" required><br>

        <label for="CertRegNumber">Certificate Registration Number:</label>
        <input type="text" name="CertRegNumber" value="<?php echo $CertRegNumber; ?>" required><br>

        <label for="Manager">Manager:</label>
        <input type="text" name="Manager" value="<?php echo $Manager; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Driving School Data List</h2>

    <ul>
        <?php if (isset($rowsDrivingSchool) && is_array($rowsDrivingSchool)): ?>
            <?php foreach ($rowsDrivingSchool as $row): ?>
                <li><?php echo "Driving School: {$row['DSName']} - Cert Reg Number: {$row['CertRegNumber']}, Manager: {$row['Manager']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
<!--
    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
    <a href="updateDrivingSchool.php">
        <button type="button">Update Driving School Data</button>
    </a>
    <a href="deleteDrivingSchool.php">
        <button type="button">Delete Driving School Data</button>
    </a>
            -->
</body>
</html>
