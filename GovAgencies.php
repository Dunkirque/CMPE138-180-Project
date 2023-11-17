<?php
//NEED TO CHECK OVER,using as template for all subclasses
//of ExternalAgency
//NEED to add the checking for distinction in all subclasses
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$CAGECode = '';
$EAName = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $CAGECode = mysqli_real_escape_string($mysqli, $_POST["CAGECode"]);
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);

    // Insert data into the GovAgencies table
    $query = "INSERT INTO GovAgencies (CAGECode, EAName) 
              VALUES ('$CAGECode', '$EAName')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $CAGECode = $EAName = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}       

// Fetch data from GovAgencies and join with ExternalAgency
$query = "SELECT GovAgencies.CAGECode, 
                 ExternalAgency.EAName, ExternalAgency.Type, ExternalAgency.POC, ExternalAgency.AdminInCharge
          FROM GovAgencies
          JOIN ExternalAgency ON GovAgencies.EAName = ExternalAgency.EAName";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsGovAgencies = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Insert Government Agency Data</title>
</head>
<body>

    <h2>Insert Government Agency Data</h2>

    <form method="post" action="">
        <label for="CAGECode">CAGE Code:</label>
        <input type="text" name="CAGECode" value="<?php echo $CAGECode; ?>" required><br>

        <label for="EAName">Government Agency Name:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Government Agency Data List</h2>

    <ul>
        <?php if (isset($rowsGovAgencies) && is_array($rowsGovAgencies)): ?>
            <?php foreach ($rowsGovAgencies as $row): ?>
                <li><?php echo "CAGE Code: {$row['CAGECode']}, 
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
