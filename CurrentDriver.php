<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$ApplicationNumber = '';
$PersonSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $ApplicationNumber = mysqli_real_escape_string($mysqli, $_POST["ApplicationNumber"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);

    // Insert data into the LicenseRequestor table
    $query = "INSERT INTO LicenseRequestor (ApplicationNumber, PersonSSN) 
              VALUES ('$ApplicationNumber', '$PersonSSN')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $ApplicationNumber = $PersonSSN = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}       

// Fetch data from LicenseRequestor and join with Person
$query = "SELECT LicenseRequestor.ApplicationNumber, Person.PersonFname, Person.PersonLname, Person.PersonSSN, Person.PersonDOB
          FROM LicenseRequestor
          JOIN Person ON LicenseRequestor.PersonSSN = Person.PersonSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsLicenseRequestor = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Insert License Requestor Data</title>
</head>
<body>

    <h2>Insert License Requestor Data</h2>

    <form method="post" action="">
        <label for="ApplicationNumber">Application Number:</label>
        <input type="text" name="ApplicationNumber" value="<?php echo $ApplicationNumber; ?>" required><br>

        <label for="PersonSSN">Person SSN:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>License Requestor Data List</h2>

    <ul>
        <?php if (isset($rowsLicenseRequestor) && is_array($rowsLicenseRequestor)): ?>
            <?php foreach ($rowsLicenseRequestor as $row): ?>
                <li><?php echo "Application Number: {$row['ApplicationNumber']}, Name: {$row['PersonFname']} {$row['PersonLname']}, SSN: {$row['PersonSSN']}, DOB: {$row['PersonDOB']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
</body>
</html>
