<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$ApplicationNumber = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $ApplicationNumber = mysqli_real_escape_string($mysqli, $_POST["ApplicationNumber"]);

    // Insert data into the database
    $query = "INSERT INTO ExternalAgency (ApplicationNumber) 
              VALUES ('$ApplicationNumber')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $ApplicationNumber = '';
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
        <label for="ApplicationNumber">Application Number:</label>
        <input type="text" name="ApplicationNumber" value="<?php echo $ApplicationNumber; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>External Agency Data List</h2>

    <ul>
        <?php if (isset($rowsExternalAgency) && is_array($rowsExternalAgency)): ?>
            <?php foreach ($rowsExternalAgency as $row): ?>
                <li><?php echo "Application Number: {$row['ApplicationNumber']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
</body>
</html>
