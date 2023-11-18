<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = $EAType = $POC = $AdminInCharge = $CAGECode= '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and SSN is provided, fetch the data
if ($action == 'update' && isset($_GET['eaName'])) {
    $EANameToUpdate = mysqli_real_escape_string($mysqli, $_GET['eaName']);
    $CAGECodeToUpdate = mysqli_real_escape_string($mysqli, $_GET['cageCode']);
    $query = "SELECT * FROM GovAgencies
              JOIN ExternalAgency ON GovAgencies.EAName = ExternalAgency.EAName
              WHERE GovAgencies.EAName = '$EANameToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $EAName = $row['EAName'];
        $EAType = $row['EAType'];
        $POC = $row['POC'];
        $AdminInCharge = $row['AdminInCharge'];
        $CAGECode = $row['CAGECode'];
       
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
    $CAGECode = mysqli_real_escape_string($mysqli, $_POST["CAGECode"]);


    // Update data in the GovAgencies and ExternalAgency tables
    $updateQuery = "UPDATE GovAgencies 
                    SET CAGECode = '$CAGECode'
                    WHERE EAName = '$EAName'";

    $updateQueryExternalAgency = "UPDATE ExternalAgency 
                          SET EAType = '$EAType', POC = '$POC', AdminInCharge = '$AdminInCharge'
                          WHERE EAName = '$EAName'";

    if ($mysqli->query($updateQuery) === TRUE && $mysqli->query($updateQueryExternalAgency) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mysqli->error;
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
    <title>Update Government Agency Data</title>
</head>
<body>

    <h2>Update Government Agency Data</h2>

    <form method="post" action="">
        <label for="EAName">Government Agency Name to Update:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <label for="CAGECode">CAGE Code:</label>
        <input type="text" name="CAGECode" value="<?php echo $CAGECode; ?>" required><br>

        <label for="EAType">Type:</label>
        <input type="text" name="EAType" value="<?php echo $EAType; ?>" required><br>

        <label for="AdminInCharge">Admin In Charge:</label>
        <input type="text" name="AdminInCharge" value="<?php echo $AdminInCharge; ?>" required><br>

        <label for="POC">POC:</label>
        <input type="text" name="POC" value="<?php echo $POC; ?>" required><br>


        <button type="submit">Update</button>
    </form>

    <a href="ExternalAgency.php">
        <button type="button">Go back to External Agency Data</button>
    </a>

</body>
</html>
