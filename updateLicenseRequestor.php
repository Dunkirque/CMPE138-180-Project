<?php
//SJSU CMPE 138 Fall 2023 Team 11

// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$oldPersonSSN = '';
$newPersonSSN = '';
$newApplicationNumber = '';
$newPersonFname = '';
$newPersonLname = '';
$newPersonDOB = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $oldPersonSSN = mysqli_real_escape_string($mysqli, $_POST["oldPersonSSN"]);
    $newPersonSSN = mysqli_real_escape_string($mysqli, $_POST["newPersonSSN"]);
    $newApplicationNumber = mysqli_real_escape_string($mysqli, $_POST["newApplicationNumber"]);
    $newPersonFname = mysqli_real_escape_string($mysqli, $_POST["newPersonFname"]);
    $newPersonLname = mysqli_real_escape_string($mysqli, $_POST["newPersonLname"]);
    $newPersonDOB = mysqli_real_escape_string($mysqli, $_POST["newPersonDOB"]);

    // Check if the old PersonSSN exists in the LicenseRequestor table
    $checkQueryLicenseRequestor = "SELECT * FROM LicenseRequestor WHERE PersonSSN = '$oldPersonSSN'";
    $checkResultLicenseRequestor = $mysqli->query($checkQueryLicenseRequestor);

    if ($checkResultLicenseRequestor->num_rows > 0) {
        // Check if the new PersonSSN already exists in the Person table
        $checkQueryNewPersonSSN = "SELECT * FROM Person WHERE PersonSSN = '$newPersonSSN'";
        $checkResultNewPersonSSN = $mysqli->query($checkQueryNewPersonSSN);

        if ($checkResultNewPersonSSN->num_rows === 0) {
            // Update data in the LicenseRequestor table
            $updateQueryLicenseRequestor = "UPDATE LicenseRequestor 
                                           SET PersonSSN = '$newPersonSSN', 
                                               ApplicationNumber = '$newApplicationNumber' 
                                           WHERE PersonSSN = '$oldPersonSSN'";
            if ($mysqli->query($updateQueryLicenseRequestor) === TRUE) {
                // Update data in the Person table
                $updateQueryPerson = "UPDATE Person 
                                      SET PersonSSN = '$newPersonSSN', 
                                          PersonFname = '$newPersonFname', 
                                          PersonLname = '$newPersonLname', 
                                          PersonDOB = '$newPersonDOB' 
                                      WHERE PersonSSN = '$oldPersonSSN'";
                if ($mysqli->query($updateQueryPerson) === TRUE) {
                    echo "Records updated successfully";

                    // Clear form fields after successful update
                    $oldPersonSSN = $newPersonSSN = $newApplicationNumber = $newPersonFname = $newPersonLname = $newPersonDOB = '';
                } else {
                    echo "Error updating records in Person table: " . $mysqli->error;
                }
            } else {
                echo "Error updating records in LicenseRequestor table: " . $mysqli->error;
            }
        } else {
            // Display error message if new PersonSSN already exists
            echo "Error: New Person SSN '$newPersonSSN' already exists. Please choose a different one.";
        }
    } else {
        // Display error message if old PersonSSN does not exist in LicenseRequestor table
        echo "Error: Person with SSN '$oldPersonSSN' does not exist in LicenseRequestor. Please enter an existing Person SSN.";
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
    <title>Update License Requestor Data</title>
</head>
<body>

    <h2>Update License Requestor Data</h2>

    <form method="post" action="">
        <label for="oldPersonSSN">Enter Existing Person SSN to Update:</label>
        <input type="text" name="oldPersonSSN" value="<?php echo $oldPersonSSN; ?>" required><br>

        <label for="newPersonSSN">Enter New Person SSN:</label>
        <input type="text" name="newPersonSSN" value="<?php echo $newPersonSSN; ?>" required><br>

        <label for="newApplicationNumber">Enter New Application Number:</label>
        <input type="text" name="newApplicationNumber" value="<?php echo $newApplicationNumber; ?>" required><br>

        <label for="newPersonFname">Enter New Person First Name:</label>
        <input type="text" name="newPersonFname" value="<?php echo $newPersonFname; ?>" required><br>

        <label for="newPersonLname">Enter New Person Last Name:</label>
        <input type="text" name="newPersonLname" value="<?php echo $newPersonLname; ?>" required><br>

        <label for="newPersonDOB">Enter New Person Date of Birth:</label>
        <input type="date" name="newPersonDOB" value="<?php echo $newPersonDOB; ?>" required><br>

        <button type="submit">Update Records</button>
    </form>

 
</body>
</html>
