<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EAName = $Type = $POC = $AdminInCharge = '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// If the action is 'update' and EAName is provided, fetch the data
if ($action == 'update' && isset($_GET['eaName'])) {
    $EANameToUpdate = mysqli_real_escape_string($mysqli, $_GET['eaName']);
    $query = "SELECT * FROM ExternalAgency WHERE EAName = '$EANameToUpdate'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $EAName = $row['EAName'];
        $Type = $row['Type'];
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
    $Type = mysqli_real_escape_string($mysqli, $_POST["Type"]);
    $POC = mysqli_real_escape_string($mysqli, $_POST["POC"]);
    $AdminInCharge = mysqli_real_escape_string($mysqli, $_POST["AdminInCharge"]);

    // Update data in the ExternalAgency table
    $updateQuery = "UPDATE ExternalAgency 
                    SET Type = '$Type', POC = '$POC', AdminInCharge = '$AdminInCharge'
                    WHERE EAName = '$EAName'";

    if ($mysqli->query($updateQuery) === TRUE) {
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
    <title>Update External Agency Data</title>
</head>
<body>

    <h2>Update External Agency Data</h2>

    <form method="post" action="">
        <label for="EAName">External Agency Name to Update:</label>
        <input type="text" name="EAName" value="<?php echo $EAName; ?>" required><br>

        <label for="Type">Type:</label>
        <input type="text" name="Type" value="<?php echo $Type; ?>" required><br>

        <label for="POC">Point of Contact:</label>
        <input type="text" name="POC" value="<?php echo $POC; ?>" required><br>

        <label for="AdminInCharge">Admin In Charge:</label>
        <input type="text" name="AdminInCharge" value="<?php echo $AdminInCharge; ?>" required><br>

        <button type="submit">Update</button>
    </form>



</body>
</html>
