<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EmpSSN = $EmpLname = $EmpFname = $EmpNumber = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EmpSSN = mysqli_real_escape_string($mysqli, $_POST["EmpSSN"]);
    $EmpLname = mysqli_real_escape_string($mysqli, $_POST["EmpLname"]);
    $EmpFname = mysqli_real_escape_string($mysqli, $_POST["EmpFname"]);
    $EmpNumber = mysqli_real_escape_string($mysqli, $_POST["EmpNumber"]);

    // Insert data into the database
    $query = "INSERT INTO Employee (EmpSSN, EmpLname, EmpFname, EmpNumber) 
              VALUES ('$EmpSSN', '$EmpLname', '$EmpFname', '$EmpNumber')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record inserted successfully";

        // Clear form fields after successful insertion
        $EmpSSN = $EmpLname = $EmpFname = $EmpNumber = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
    }
}       

// Fetch all records from the Employee table
$resultEmployee = $mysqli->query("SELECT * FROM Employee");
$rowsEmployee = $resultEmployee->fetch_all(MYSQLI_ASSOC);

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Employee Data</title>
</head>
<body>

    <h2>Insert Employee Data</h2>

    <form method="post" action="">
        <label for="EmpSSN">Employee SSN:</label>
        <input type="text" name="EmpSSN" value="<?php echo $EmpSSN; ?>" required><br>

        <label for="EmpLname">Last Name:</label>
        <input type="text" name="EmpLname" value="<?php echo $EmpLname; ?>" required><br>

        <label for="EmpFname">First Name:</label>
        <input type="text" name="EmpFname" value="<?php echo $EmpFname; ?>" required><br>

        <label for="EmpNumber">Employee Number:</label>
        <input type="text" name="EmpNumber" value="<?php echo $EmpNumber; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Employee Data List</h2>

    <ul>
        <?php if (isset($rowsEmployee) && is_array($rowsEmployee)): ?>
            <?php foreach ($rowsEmployee as $row): ?>
                <li><?php echo "Employee: {$row['EmpFname']} {$row['EmpLname']} - SSN: {$row['EmpSSN']}, Emp Number: {$row['EmpNumber']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
</body>
</html>
