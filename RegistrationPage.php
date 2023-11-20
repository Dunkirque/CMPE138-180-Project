<?php
//SJSU CMPE 138 Fall 2023 Team 11

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

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set the role to 'Person'
    $role = 'Person';

    // Insert data into the RegistrationAdminPage table
    $query = "INSERT INTO RegistrationAdminPage (RegUsername, RegPassword, RegRole) 
              VALUES ('$username', '$hashedPassword', '$role')";

    if ($mysqli->query($query) === TRUE) {
        echo "Registration successful!";
        // Clear form fields after successful registration
        $username = $password = '';
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
    <title>User Registration Page</title>
</head>
<body>

    <h2>User Registration Page</h2>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required><br>

        <label for="password">Password(Max 10 characters):</label>
        <input type="password" name="password" maxlength="10" required><br>

        <button type="submit">Register</button>
    </form>
    <a href="HomePage.php">
        <button type="button">Go To Home Page</button>
    </a>
    <a href="LoginPage.php">
        <button type="button">Go To Login Page</button>
    </a>
</body>
</html>
