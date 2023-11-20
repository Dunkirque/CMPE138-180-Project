<?php
//SJSU CMPE 138 Fall 2023 Team 11

// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);

    // Check if EAName already exists in ExternalAgency
    $checkQueryExternalAgency = "SELECT * FROM ExternalAgency WHERE EAName = '$EAName'";
    $checkResultExternalAgency = $mysqli->query($checkQueryExternalAgency);

    // If EAName is found in ExternalAgency, insert data into LawAgencies
    if ($checkResultExternalAgency->num_rows > 0) {
        // Check if EAName already exists in LawAgencies
        $checkQueryLawAgencies = "SELECT * FROM LawAgencies WHERE EAName = '$EAName'";
        $checkResultLawAgencies = $mysqli->query($checkQueryLawAgencies);

        // Check if EAName already exists in GovAgencies
        $checkQueryGovAgencies = "SELECT * FROM GovAgencies WHERE EAName = '$EAName'";
        $checkResultGovAgencies = $mysqli->query($checkQueryGovAgencies);

        // Check if EAName already exists in VehicleManu
        $checkQueryVehicleManu = "SELECT * FROM VehicleManu WHERE EAName = '$EAName'";
        $checkResultVehicleManu = $mysqli->query($checkQueryVehicleManu);

        // If EAName is not found in any of the tables, insert data into LawAgencies
        if (
            $checkResultLawAgencies->num_rows === 0 &&
            $checkResultGovAgencies->num_rows === 0 &&
            $checkResultVehicleManu->num_rows === 0
        ) {
            // Insert data into the LawAgencies table
            $query = "INSERT INTO LawAgencies (EAName) 
                      VALUES ('$EAName')";

            if ($mysqli->query($query) === TRUE) {
                echo "Record inserted successfully";

                // Clear form fields after successful insertion
                $EAName = '';
            } else {
                echo "Error: " . $query . "<br>" . $mysqli->error;
            }
        } else {
            // Display error message if EAName already exists in other tables
            echo "Error: Agency with name '$EAName' already exists in other tables. Please try a different one.";
        }
    } else {
        // Display error message if EAName does not exist in ExternalAgency
        echo "Error: Agency with name '$EAName' does not exist in ExternalAgency. Please enter an existing External Agency Name.";
    }
}

// Fetch data from LawAgencies and join with ExternalAgency
$query = "SELECT LawAgencies.EAName, 
                 ExternalAgency.EAType, ExternalAgency.POC, ExternalAgency.AdminInCharge
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
    <title>Insert Law Agency Data</title>
</head>
<body>

    <h2>Insert Law Agency Data</h2>

    <form method="post" action="">
        <label for="EAName">Law Agency Name:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Law Agency Data List</h2>

    <ul>
        <?php if (isset($rowsLawAgencies) && is_array($rowsLawAgencies)): ?>
            <?php foreach ($rowsLawAgencies as $row): ?>
                <li><?php echo "Name: {$row['EAName']}, 
                             Type: {$row['EAType']},
                             POC: {$row['POC']},
                             Admin In Charge: {$row['AdminInCharge']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
</body>
</html>
