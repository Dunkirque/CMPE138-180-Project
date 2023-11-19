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

        // Verify password and redirect based on role
        if ($row && password_verify($password, $row['RegPassword'])) {
            // Redirect based on RegRole
            $role = $row['RegRole'];
            switch ($role) {
                case 'Admin':
                    header("Location: HomeAdminPage.php");
                    exit();            
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
    <title>Admin Login Page</title>
</head>
<body>

    <h2>Admin Login Page</h2>

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
