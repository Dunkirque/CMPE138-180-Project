<?php
// Include the database connection file
require_once('db_connect.php');

// Initialize variables
$username = '';
$password = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data (sanitize input as needed)
    $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
    $password = mysqli_real_escape_string($mysqli, $_POST["password"]);

    // Fetch user data from RegistrationAdminPage
    $query = "SELECT RegPassword, RegRole FROM RegistrationAdminPage WHERE RegUsername = '$username'";
    $result = $mysqli->query($query);

    // Check if the query was successful
    if ($result) {
        // Fetch the first row as an associative array
        $row = $result->fetch_assoc();

        /*// Debugging: Print values for troubleshooting
        echo "Debug: ";
        var_dump($row); // Check what $row contains
        var_dump(password_verify($password, $row['RegPassword'])); // Check the password verification
        */
        
        // Verify password and redirect based on role
        if ($row && password_verify($password, $row['RegPassword'])) {
            // Redirect based on RegRole
            $role = $row['RegRole'];
            switch ($role) {
                case 'Person':
                    header("Location: HomePersonPage.php");
                    exit();
                case 'DrivingSchool':
                    header("Location: HomeDrivingSchool.php");
                    exit();
                case 'Admin':
                    header("Location: HomeAdminPage.php");
                    exit();
                case 'ApplicationEmp':
                    header("Location: HomeApplicationEmpPage.php");
                    exit();
                case 'Auditor':
                    header("Location: HomeAuditorPage.php");
                    exit(); 
                case 'ComplianceAgent':
                    header("Location: HomeComplianceAgentPage.php");
                    exit();
                case 'DataEntryEmp':
                    header("Location: HomeDataEntryEmpPage.php");
                    exit();
                case 'Inspector':
                    header("Location: HomeInspectorPage.php");
                    exit();
                case 'GovAgencies':
                    header("Location: HomeGovAgenciesPage.php");
                    exit();
                case 'LawAgencies':
                    header("Location: HomeLawAgenciesPage.php");
                    exit();
                case 'VehicleManu':
                    header("Location: HomeVehicleManuPage.php");
                    exit();               
                // Add other role cases as needed
                default:
                    echo "Invalid role for this login.";
            }
        } else {
            echo "Invalid username or password.";
        }
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
    <title>Login Page</title>
</head>
<body>

    <h2>Login Page</h2>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required><br>

        <label for="password">Password(Max 10 characters):</label>
        <input type="password" name="password" maxlength="10" required><br>

        <button type="submit">Login</button>
    </form>
    <a href="HomePage.php">
        <button type="button">Go Back to Home Page</button>
    </a>
</body>
</html>
