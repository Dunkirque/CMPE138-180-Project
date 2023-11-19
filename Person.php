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

    // Check if PersonSSN already exists in LicenseRequestor
    $checkQueryLicense = "SELECT * FROM LicenseRequestor WHERE PersonSSN = '$PersonSSN'";
    $checkResultLicense = $mysqli->query($checkQueryLicense);

    // Check if PersonSSN already exists in CurrentDriver
    $checkQueryCurrentDriver = "SELECT * FROM CurrentDriver WHERE PersonSSN = '$PersonSSN'";
    $checkResultCurrentDriver = $mysqli->query($checkQueryCurrentDriver);

    // Check if PersonSSN already exists in VehicleRegRequestor
    $checkQueryVehicleRegRequestor = "SELECT * FROM VehicleRegRequestor WHERE PersonSSN = '$PersonSSN'";
    $checkResultVehicleRegRequestor = $mysqli->query($checkQueryVehicleRegRequestor);

    // If PersonSSN is not found in any of the tables, insert data
    if (
        $checkResultLicense->num_rows === 0 &&
        $checkResultCurrentDriver->num_rows === 0 &&
        $checkResultVehicleRegRequestor->num_rows === 0
    ) {
        // Insert data into the Person table
        $query = "INSERT INTO Person (PersonLname, PersonFname, PersonSSN, PersonDOB) 
                  VALUES ('$PersonLname', '$PersonFname', '$PersonSSN', '$PersonDOB')";

        if ($mysqli->query($query) === TRUE) {
            // Clear form fields after successful insertion
            $PersonLname = $PersonFname = $PersonSSN = $PersonDOB = '';

            // Redirect user based on selected role
            if (isset($_POST["UserRole"])) {
                $selectedRole = $_POST["UserRole"];
                switch ($selectedRole) {
                    case 'LicenseRequestor':
                        header('Location: LicenseRequestor.php');
                        exit();
                    case 'CurrentDriver':
                        header('Location: CurrentDriver.php');
                        exit();
                    case 'VehicleRegistrationRequestor':
                        header('Location: VehicleRegistrationRequestor.php');
                        exit();
                    // Add more cases if needed for additional roles
                }
            }
        } else {
            echo "Error: " . $query . "<br>" . $mysqli->error;
        }
    } else {
        // Display error message if PersonSSN already exists
        echo "Error: SSN '$PersonSSN' is already used. Please try a different one.";
    }
}

// Fetch all records from the Person table
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

        <!-- Add a dropdown for user role selection -->
        <label for="UserRole">Select Role:</label>
        <select name="UserRole">
            <option value="LicenseRequestor">License Requestor</option>
            <option value="CurrentDriver">Current Driver</option>
            <option value="VehicleRegistrationRequestor">Vehicle Registration Requestor</option>
        </select>

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

    <!-- No need for buttons related to specific roles here -->
    <!--
    <a href="DrivingSchool.php">
        <button type="button">Go to Driving School Data</button>
    </a>
    <a href="Employee.php">
        <button type="button">Go to Employee Data</button>
    </a>
    <a href="ExternalAgency.php">
        <button type="button">Go to External Agency Data</button>
    </a>
    <a href="updatePerson.php">
        <button type="button">Update Person Data</button>
    </a>
    <a href="updateLicenseRequestor.php">
        <button type="button">Update License Requestor Data</button>
    </a>
    <a href="updateCurrentDriver.php">
        <button type="button">Update Current Driver Data</button>
    </a>
    <a href="updateVehicleRegistrationRequestor.php">
        <button type="button">Update Vehicle Registration Requestor Data</button>
    </a>
    <a href="deletePerson.php">
        <button type="button">Delete Person Data</button>
    </a>
    <a href="deleteLicenseRequestor.php">
        <button type="button">Delete License Requestor Data</button>
    </a>
    <a href="deleteCurrentDriver.php">
        <button type="button">Delete Current Driver Data</button>
    </a>
    <a href="deleteVehicleRegistrationRequestor.php">
        <button type="button">Delete Vehicle Registration Requestor Data</button>
    </a>
    <a href="selectLicenseRequestor.php">
        <button type="button">View License Requestor Data</button>
    </a>
    <a href="selectCurrentDriver.php">
        <button type="button">View Current Driver Data</button>
    </a>
    <a href="selectVehicleRegistrationRequestor.php">
        <button type="button">View Vehicle Registraton Requestor Data</button>
    </a>
            -->
</body>
</html>
