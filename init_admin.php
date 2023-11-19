<?php
// Include the database connection file
require_once('db_connect.php');

// Check if the form is submitted (using POST method)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["init_admin"])) {
    // Retrieve form data (sanitize input as needed)
    $username = mysqli_real_escape_string($mysqli, "Admin"); // Set the username to 'Admin'
    //$password = mysqli_real_escape_string($mysqli, $_POST["password"]);
    $password = mysqli_real_escape_string($mysqli, "Password");

    // Check if the Admin account is already initialized
    $checkQuery = "SELECT COUNT(*) as count FROM RegistrationAdminPage WHERE RegUsername = '$username'";
    $result = $mysqli->query($checkQuery);

    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            // Admin account is already initialized
            echo "Admin Account is already Initialized";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Set the role to 'Admin'
            $role = 'Admin';

            // Insert data into the RegistrationAdminPage table
            $insertQuery = "INSERT INTO RegistrationAdminPage (RegUsername, RegPassword, RegRole) 
                            VALUES ('$username', '$hashedPassword', '$role')";

            if ($mysqli->query($insertQuery) === TRUE) {
                // Registration successful
                echo "Registration successful!";
            } else {
                // Error during registration
                echo "Error during registration.";
            }
        }
    } else {
        // Error in the check query
        echo "Error: " . $checkQuery . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();

    // Provide a button to go back to HomePage.php
    echo '<br><br>';
    echo '<a href="HomePage.php"><button type="button">Go Back to Home Page</button></a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>


</body>
</html>