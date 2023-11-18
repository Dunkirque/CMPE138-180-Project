<?php
// Include the database connection file
require_once('db_connect.php');

// Fetch data from AdminEmp and join with Employee
$query = "SELECT AdminEmp.EmpSSN, Employee.EmpLname, Employee.EmpFname, Employee.EmpNumber
          FROM AdminEmp
          JOIN Employee ON AdminEmp.EmpSSN = Employee.EmpSSN";

$result = $mysqli->query($query);

// Check if the query was successful
if ($result) {
    // Fetch all records as an associative array
    $rowsAdminEmp = $result->fetch_all(MYSQLI_ASSOC);
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
    <title>Admin Employee Data List</title>
</head>
<body>

    <h2>Admin Employee Data List</h2>

    <ul>
        <?php if (isset($rowsAdminEmp) && is_array($rowsAdminEmp)): ?>
            <?php foreach ($rowsAdminEmp as $row): ?>
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
