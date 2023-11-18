<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = $EAType = $POC = $AdminInCharge = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and EAName is provided, fetch the data
if ($action == 'update' && isset($_GET['eaName'])) {
    $EANameToUpdate = mysqli_real_escape_string($mysqli, $_GET['eaName']);
    $query = "SELECT * FROM LawAgencies
              JOIN ExternalAgency ON LawAgencies.
              WHERE EAName = '$EANameToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $EAName = $row['EAName'];
        $EAType = $row['EAType'];
        $POC = $row['POC'];
        $AdminInCharge = $row['AdminInCharge'];
    } else {
        echo "Error: Record not found.";
        exit();
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EAName = mysqli_real_escape_string($mysqli, $_POST["EAName"]);
    $EAType = mysqli_real_escape_string($mysqli, $_POST["EAType"]);
    $POC = mysqli_real_escape_string($mysqli, $_POST["POC"]);
    $AdminInCharge = mysqli_real_escape_string($mysqli, $_POST["AdminInCharge"]);

    // Update data in the LawAgencies table
    $updateQueryLawAgencies = "UPDATE LawAgencies 
                               SET EAName = '$EAName'
                               WHERE EAName = '$EAName'";
    $updateQuery= "UPDATE ExternalAgency
                   SET EAType = '$EAType', POC = '$POC', AdminInCharge = '$AdminInCharge'
                   WHERE EAName='$EAName'";

    if ($mysqli->query($updateQuery)=== TRUE && $mysqli->query($updateQueryLawAgencies) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>

<!DOCEAType html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Law Agencies Data</title>
</head>
<body>

    <h2>Update Law Agencies Data</h2>

    <form method="post" action="">
        <label for="EAName">Law Agency Name to Update:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <label for="EAType">Type:</label>
        <input type="text" name="EAType" value="<?php echo $EAType; ?>" required><br>

        <label for="POC">Point of Contact:</label>
        <input type="text" name="POC" value="<?php echo $POC; ?>" required><br>

        <label for="AdminInCharge">Admin In Charge:</label>
        <input type="text" name="AdminInCharge" value="<?php echo $AdminInCharge; ?>" required><br>

        <button type="submit">Update</button>
    </form>

    <a href="ExternalAgency.php">
        <button type="button">Go back to External Agency Data</button>
    </a>

</body>
</html>
