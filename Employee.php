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

    // Check if EmpSSN already exists in AdminEmp
    $checkQueryAdminEmp = "SELECT * FROM AdminEmp WHERE EmpSSN = '$EmpSSN'";
    $checkResultAdminEmp = $mysqli->query($checkQueryAdminEmp);

    // Check if EmpSSN already exists in ApplicationEmp
    $checkQueryApplicationEmp = "SELECT * FROM ApplicationEmp WHERE EmpSSN = '$EmpSSN'";
    $checkResultApplicationEmp = $mysqli->query($checkQueryApplicationEmp);

    // Check if EmpSSN already exists in Auditor
    $checkQueryAuditor = "SELECT * FROM Auditor WHERE EmpSSN = '$EmpSSN'";
    $checkResultAuditor = $mysqli->query($checkQueryAuditor);

    // Check if EmpSSN already exists in ComplianceAgent
    $checkQueryComplianceAgent = "SELECT * FROM ComplianceAgent WHERE EmpSSN = '$EmpSSN'";
    $checkResultComplianceAgent = $mysqli->query($checkQueryComplianceAgent);

    // Check if EmpSSN already exists in Inspector
    $checkQueryInspector = "SELECT * FROM Inspector WHERE EmpSSN = '$EmpSSN'";
    $checkResultInspector = $mysqli->query($checkQueryInspector);

    // Check if EmpSSN already exists in DataEntryEmp
    $checkQueryDataEntryEmp = "SELECT * FROM DataEntryEmp WHERE EmpSSN = '$EmpSSN'";
    $checkResultDataEntryEmp = $mysqli->query($checkQueryDataEntryEmp);

    // If EmpSSN is not found in any of the tables, insert data
    if (
        $checkResultAdminEmp->num_rows === 0 &&
        $checkResultApplicationEmp->num_rows === 0 &&
        $checkResultAuditor->num_rows === 0 &&
        $checkResultComplianceAgent->num_rows === 0 &&
        $checkResultInspector->num_rows === 0 &&
        $checkResultDataEntryEmp->num_rows === 0
    ) {
        // Insert data into the Employee table
        $query = "INSERT INTO Employee (EmpSSN, EmpLname, EmpFname, EmpNumber) 
                  VALUES ('$EmpSSN', '$EmpLname', '$EmpFname', '$EmpNumber')";

        if ($mysqli->query($query) === TRUE) {
            echo "Record inserted successfully";

            // Clear form fields after successful insertion
            $EmpSSN = $EmpLname = $EmpFname = $EmpNumber = '';
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
        }
    } else {
        // Display error message if EmpSSN already exists
        echo "Error: SSN '$EmpSSN' is already used. Please try a different one.";
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

        <!-- Add a dropdown for user role selection -->
        <label for="UserRole">Select Role:</label>
        <select name="UserRole">
            <option value="AdminEmp">Admin Employee</option>
            <option value="ApplicationEmp">Application Employee</option>
            <option value="Auditor">Auditor</option>
            <option value="ComplianceAgent">Compliance Agent</option>
            <option value="DataEntryEmp">Data Entry Employee</option>
        </select>

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

    <!-- No need for buttons related to specific roles here -->

    <a href="Person.php">
        <button type="button">Go to Person Data</button>
    </a>
    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
    <a href="updateEmployee.php">
        <button type="button">Update Employee Data</button>
    </a>
    <a href="updateAdminEmp.php">
        <button type="button">Update Admin Employee Data</button>
    </a>
    <a href="updateApplicationEmp.php">
        <button type="button">Update Application Employee Data</button>
    </a>
    <a href="updateAuditor.php">
        <button type="button">Update Auditor Employee Data</button>
    </a>
    <a href="updateComplianceAgent.php">
        <button type="button">Update Compliance Agent Employee Data</button>
    </a>
    <a href="updateDataEntryEmp.php">
        <button type="button">Update Data Entry Employee Data</button>
    </a>
    <a href="updateInspector.php">
        <button type="button">Update Inspector Employee Data</button>
    </a>
    <a href="deleteEmployee.php">
        <button type="button">Delete Employee Data</button>
    </a>
    <a href="deleteAdminEmp.php">
        <button type="button">Delete Admin Employee Data</button>
    </a>
    <a href="deleteApplicationEmp.php">
        <button type="button">Delete Application Employee Data</button>
    </a>
    <a href="deleteAuditor.php">
        <button type="button">Delete Auditor Employee Data</button>
    </a>
    <a href="deleteComplianceAgent.php">
        <button type="button">Delete Compliance Agent Employee Data</button>
    </a>
    <a href="deleteDataEntryEmp.php">
        <button type="button">Delete Data Entry Employee Data</button>
    </a>
    <a href="deleteInspector.php">
        <button type="button">Delete Inspector Employee Data</button>
    </a>
    <a href="selectAdminEmp.php">
        <button type="button">View Admin Employee Data</button>
    </a>
    <a href="selectApplicationEmp.php">
        <button type="button">View Application Employee Data</button>
    </a>
    <a href="selectAuditor.php">
        <button type="button">View Auditor Employee Data</button>
    </a>
    <a href="selectComplianceAgent.php">
        <button type="button">View Compliance Agent Employee Data</button>
    </a>
    <a href="selectDataEntryEmp.php">
        <button type="button">View Data Entry Employee Data</button>
    </a>
    <a href="selectInspector.php">
        <button type="button">View Inspector Employee Data</button>
    </a>
    
</body>
</html>
