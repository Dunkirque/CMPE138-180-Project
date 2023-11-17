<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = $Type = $POC = $AdminInCharge = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);
    $Type = mysqli_real_escape_string($mysqli, $_POST["Type"]);
    $POC = mysqli_real_escape_string($mysqli, $_POST["POC"]);
    $AdminInCharge = mysqli_real_escape_string($mysqli, $_POST["AdminInCharge"]);

    // Insert data into the database
    $query = "INSERT INTO ExternalAgency (EAName, Type, POC, AdminInCharge) 
              VALUES ('$EAName', '$Type', '$POC', '$AdminInCharge')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $EAName = $Type = $POC = $AdminInCharge = '';

        // Redirect based on selected role
        if (isset($_POST["SubmitRole"])) {
            $selectedRole = $_POST["SubmitRole"];
            switch ($selectedRole) {
                case 'GovAgencies':
                    header("Location: GovAgencies.php");
                    exit();
                case 'LawAgencies':
                    header("Location: LawAgencies.php");
                    exit();
                case 'VehicleManu':
                    header("Location: VehicleManu.php");
                    exit();
            }
        }
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}

// Fetch all records from the ExternalAgency table
$resultExternalAgency = $mysqli->query("SELECT * FROM ExternalAgency");
$rowsExternalAgency = $resultExternalAgency->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert External Agency Data</title>
</head>
<body>

    <h2>Insert External Agency Data</h2>

    <form method="post" action="">
        <label for="EAName">External Agency Name:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <label for="Type">Type:</label>
        <input type="text" name="Type" value="<?php echo $Type; ?>" required><br>

        <label for="POC">Point of Contact:</label>
        <input type="text" name="POC" value="<?php echo $POC; ?>" required><br>

        <label for="AdminInCharge">Admin In Charge:</label>
        <input type="text" name="AdminInCharge" value="<?php echo $AdminInCharge; ?>" required><br>

        <label for="SubmitRole">Select Role:</label>
        <select name="SubmitRole" required>
            <option value="GovAgencies">Government Agencies</option>
            <option value="LawAgencies">Law Enforcement Agencies</option>
            <option value="VehicleManu">Vehicle Manufacturers</option>
        </select><br>

        <button type="submit">Submit</button>
    </form>

    <h2>External Agency Data List</h2>

    <ul>
        <?php if (isset($rowsExternalAgency) && is_array($rowsExternalAgency)): ?>
            <?php foreach ($rowsExternalAgency as $row): ?>
                <li><?php echo "External Agency: {$row['EAName']} - Type: {$row['Type']}, POC: {$row['POC']}, Admin In Charge: {$row['AdminInCharge']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
</body>
</html>
