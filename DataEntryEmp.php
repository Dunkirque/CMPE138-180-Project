<?php
//SJSU CMPE 138 Fall 2023 Team 11
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$EmpSSN = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $EmpSSN = mysqli_real_escape_string($mysqli, $_POST["EmpSSN"]);

    // Check if the EmpSSN exists in the Employee table
    $checkQueryEmployee = "SELECT * FROM Employee WHERE EmpSSN = '$EmpSSN'";
    $checkResultEmployee = $mysqli->query($checkQueryEmployee);

    if ($checkResultEmployee->num_rows === 0) {
        echo "Error: Employee with SSN '$EmpSSN' does not exist. Please enter an existing Employee SSN.";
    } else {
        // Check if the EmpSSN already exists in any subclass
        $checkQuery = "SELECT * FROM AdminEmp WHERE EmpSSN = '$EmpSSN'
                       UNION ALL
                       SELECT * FROM ApplicationEmp WHERE EmpSSN = '$EmpSSN'
                       UNION ALL
                       SELECT * FROM ComplianceAgent WHERE EmpSSN = '$EmpSSN'
                       UNION ALL
                       SELECT * FROM Auditor WHERE EmpSSN = '$EmpSSN'
                       UNION ALL
                       SELECT * FROM DataEntryEmp WHERE EmpSSN = '$EmpSSN'
                       UNION ALL
                       SELECT * FROM Inspector WHERE EmpSSN = '$EmpSSN'";
        $checkResult = $mysqli->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            echo "Error: Employee SSN already used in another role.";
        } else {
            // Insert data into the DataEntryEmp table
            $insertQuery = "INSERT INTO DataEntryEmp (EmpSSN) 
                            VALUES ('$EmpSSN')";

            if ($mysqli->query($insertQuery) === TRUE) {
                echo "Record inserted successfully";

                // Clear form fields after successful insertion
                $EmpSSN = '';
            } else {
                echo "Error inserting record: " . $mysqli->error;
            }
        }
    }
}

// Fetch data from DataEntryEmp and join with Employee
$query = "SELECT Employee.EmpSSN, Employee.EmpFname, Employee.EmpLname, Employee.EmpNumber
          FROM DataEntryEmp
          JOIN Employee ON DataEntryEmp.EmpSSN = Employee.EmpSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsDataEntryEmp = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Insert Data Entry Employee Data</title>
</head>
<body>

    <h2>Insert Data Entry Employee Data</h2>

    <form method="post" action="">
        <label for="EmpSSN">Data Entry Employee SSN:</label>
        <input type="text" name="EmpSSN" value="<?php echo $EmpSSN; ?>" required><br>

        <button type="submit">Submit</button>
    </form>

    <h2>Data Entry Employee Data List</h2>

    <ul>
        <?php if (isset($rowsDataEntryEmp) && is_array($rowsDataEntryEmp)): ?>
            <?php foreach ($rowsDataEntryEmp as $row): ?>
                <li><?php echo "Data Entry Employee SSN: {$row['EmpSSN']}, Name: {$row['EmpFname']} {$row['EmpLname']}, Employee Number: {$row['EmpNumber']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
</body>
</html>
