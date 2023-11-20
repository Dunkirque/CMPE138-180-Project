<?php
//SJSU CMPE 138 Fall 2023 Team 11

// Include the database connection file
require_once('db_connect.php');

// Fetch data from DataEntryEmp and join with Employee
$query = "SELECT DataEntryEmp.EmpSSN, Employee.EmpLname, Employee.EmpFname, Employee.EmpNumber
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
    <title>Data Entry Employee Data List</title>
</head>
<body>

    <h2>Data Entry Employee Data List</h2>

    <ul>
        <?php if (isset($rowsDataEntryEmp) && is_array($rowsDataEntryEmp)): ?>
            <?php foreach ($rowsDataEntryEmp as $row): ?>
                <li><?php echo "SSN: {$row['EmpSSN']}, 
                             Name: {$row['EmpFname']} {$row['EmpLname']}, 
                             Employee Number: {$row['EmpNumber']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>



</body>
</html>
