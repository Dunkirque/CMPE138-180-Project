<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from ApplicationEmp and join with Employee
$query = "SELECT ApplicationEmp.EmpSSN, Employee.EmpLname, Employee.EmpFname, Employee.EmpNumber
          FROM ApplicationEmp
          JOIN Employee ON ApplicationEmp.EmpSSN = Employee.EmpSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsApplicationEmp = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Application Employee Data List</title>
</head>
<body>

    <h2>Application Employee Data List</h2>

    <ul>
        <?php if (isset($rowsApplicationEmp) && is_array($rowsApplicationEmp)): ?>
            <?php foreach ($rowsApplicationEmp as $row): ?>
                <li><?php echo "SSN: {$row['EmpSSN']}, 
                             Name: {$row['EmpFname']} {$row['EmpLname']}, 
                             Employee Number: {$row['EmpNumber']}"; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>

</body>
</html>
