<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$username = '';
$password = '';
$role = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
    $role = mysqli_real_escape_string($mysqli, $_POST["role"]);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the RegistrationAdminPage table
    $query = "INSERT INTO RegistrationAdminPage (username, password, role) 
              VALUES ('$username', '$hashedPassword', '$role')";

    if ($mysqli->query($query) === TRUE) {
        echo "Registration successful!";
        // Clear form fields after successful registration
        $username = $password = $role = '';
    } else {
        echo "Error: " . $query . "<br>" . $mysqli->error;
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
    <title>Admin Registration Page</title>
</head>
<body>

    <h2>Admin Registration Page</h2>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="Person" <?php echo ($role == 'Person') ? 'selected' : ''; ?>>Person</option>
            <option value="DrivingSchool" <?php echo ($role == 'DrivingSchool') ? 'selected' : ''; ?>>DrivingSchool</option>
            <option value="Admin" <?php echo ($role == 'Admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="ApplicationEmp" <?php echo ($role == 'ApplicationEmp') ? 'selected' : ''; ?>>ApplicationEmp</option>
            <option value="Auditor" <?php echo ($role == 'Auditor') ? 'selected' : ''; ?>>Auditor</option>
            <option value="ComplianceAgent" <?php echo ($role == 'ComplianceAgent') ? 'selected' : ''; ?>>ComplianceAgent</option>
            <option value="DataEntryEmp" <?php echo ($role == 'DataEntryEmp') ? 'selected' : ''; ?>>DataEntryEmp</option>
            <option value="Inspector" <?php echo ($role == 'Inspector') ? 'selected' : ''; ?>>Inspector</option>
            <option value="GovAgencies" <?php echo ($role == 'GovAgencies') ? 'selected' : ''; ?>>GovAgencies</option>
            <option value="LawAgencies" <?php echo ($role == 'LawAgencies') ? 'selected' : ''; ?>>LawAgencies</option>
            <option value="VehicleManu" <?php echo ($role == 'VehicleManu') ? 'selected' : ''; ?>>VehicleManu</option>
        </select><br>

        <button type="submit">Register</button>
    </form>

</body>
</html>
