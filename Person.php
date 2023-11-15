<?php

// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$PersonLname = $PersonFname = $PersonSSN = $PersonDOB = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $PersonLname = mysqli_real_escape_string($mysqli, $_POST["PersonLname"]);
    $PersonFname = mysqli_real_escape_string($mysqli, $_POST["PersonFname"]);
    $PersonSSN = mysqli_real_escape_string($mysqli, $_POST["PersonSSN"]);
    $PersonDOB = mysqli_real_escape_string($mysqli, $_POST["PersonDOB"]);

    // Insert data into the database
    $query = "INSERT INTO Person (PersonLname, PersonFname, PersonSSN, PersonDOB) 
              VALUES ('$PersonLname', '$PersonFname', '$PersonSSN', '$PersonDOB')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $PersonLname = $PersonFname = $PersonSSN = $PersonDOB = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}

// Fetch all records from the database
$result = $mysqli->query("SELECT * FROM Person");
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Person Data</title>
</head>
<body>

    <h2>Insert Person Data</h2>

    <form method="post" action="">
        <label for="PersonLname">Last Name:</label>
        <input type="text" name="PersonLname" value="<?php echo $PersonLname; ?>" required><br>

        <label for="PersonFname">First Name:</label>
        <input type="text" name="PersonFname" value="<?php echo $PersonFname; ?>" required><br>

        <label for="PersonSSN">SSN:</label>
        <input type="text" name="PersonSSN" value="<?php echo $PersonSSN; ?>" required><br>

        <label for="PersonDOB">Date of Birth:</label>
        <input type="date" name="PersonDOB" value="<?php echo $PersonDOB; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Person Data List</h2>

    <ul>
        <?php if (isset($rows) && is_array($rows)): ?>
            <?php foreach ($rows as $row): ?>
                <li><?php echo "{$row['PersonFname']} {$row['PersonLname']} - SSN: {$row['PersonSSN']}, DOB: {$row['PersonDOB']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
</body>
</html>
