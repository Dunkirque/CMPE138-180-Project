<?php
//SJSU CMPE 138 Fall 2023 Team 11

// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$oldEmpSSN = '';
$newEmpSSN = '';
$newEmpFname = '';
$newEmpLname = '';
$newEmpNumber = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $oldEmpSSN = mysqli_real_escape_string($mysqli, $_POST["oldEmpSSN"]);
    $newEmpSSN = mysqli_real_escape_string($mysqli, $_POST["newEmpSSN"]);
    $newEmpFname = mysqli_real_escape_string($mysqli, $_POST["newEmpFname"]);
    $newEmpLname = mysqli_real_escape_string($mysqli, $_POST["newEmpLname"]);
    $newEmpNumber = mysqli_real_escape_string($mysqli, $_POST["newEmpNumber"]);

    // Check if the old EmpSSN exists in the Employee table
    $checkQueryEmployee = "SELECT * FROM Employee WHERE EmpSSN = '$oldEmpSSN'";
    $checkResultEmployee = $mysqli->query($checkQueryEmployee);

    if ($checkResultEmployee->num_rows === 0) {
        echo "Error: Employee with SSN '$oldEmpSSN' does not exist. Please enter an existing Employee SSN.";
    } else {
        // Check if the new EmpSSN already exists in the Employee table
        $checkQueryNewEmployee = "SELECT * FROM Employee WHERE EmpSSN = '$newEmpSSN'";
        $checkResultNewEmployee = $mysqli->query($checkQueryNewEmployee);

        if ($checkResultNewEmployee->num_rows > 0) {
            echo "Error: New Employee SSN '$newEmpSSN' already exists. Please choose a different one.";
        } else {
            // Update data in the ComplianceAgent table
            $updateQueryComplianceAgent = "UPDATE ComplianceAgent SET EmpSSN = '$newEmpSSN' WHERE EmpSSN = '$oldEmpSSN'";
            if ($mysqli->query($updateQueryComplianceAgent) === TRUE) {
                // Update data in the Employee table
                $updateQueryEmployee = "UPDATE Employee 
                                       SET EmpSSN = '$newEmpSSN', 
                                           EmpFname = '$newEmpFname', 
                                           EmpLname = '$newEmpLname', 
                                           EmpNumber = '$newEmpNumber' 
                                       WHERE EmpSSN = '$oldEmpSSN'";
                if ($mysqli->query($updateQueryEmployee) === TRUE) {
                    echo "Records updated successfully";

                    // Clear form fields after successful update
                    $oldEmpSSN = $newEmpSSN = $newEmpFname = $newEmpLname = $newEmpNumber = '';
                } else {
                    echo "Error updating records in Employee table: " . $mysqli->error;
                }
            } else {
                echo "Error updating records in ComplianceAgent table: " . $mysqli->error;
            }
        }
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
    <title>Update Compliance Agent Employee Data</title>
</head>
<body>

    <h2>Update Compliance Agent Employee Data</h2>

    <form method="post" action="">
        <label for="oldEmpSSN">Enter Existing Compliance Agent Employee SSN to Update:</label>
        <input type="text" name="oldEmpSSN" value="<?php echo $oldEmpSSN; ?>" required><br>

        <label for="newEmpSSN">Enter New Compliance Agent Employee SSN:</label>
        <input type="text" name="newEmpSSN" value="<?php echo $newEmpSSN; ?>" required><br>

        <label for="newEmpFname">Enter New Compliance Agent Employee First Name:</label>
        <input type="text" name="newEmpFname" value="<?php echo $newEmpFname; ?>" required><br>

        <label for="newEmpLname">Enter New Compliance Agent Employee Last Name:</label>
        <input type="text" name="newEmpLname" value="<?php echo $newEmpLname; ?>" required><br>

        <label for="newEmpNumber">Enter New Compliance Agent Employee Number:</label>
        <input type="text" name="newEmpNumber" value="<?php echo $newEmpNumber; ?>" required><br>

        <button type="submit">Update Records</button>
    </form>

 
</body>
</html>
