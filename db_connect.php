<?php
//SJSU CMPE 138 Fall 2023 Team 11
$host = "database-1.cfxyohrqydw8.us-west-1.rds.amazonaws.com";  // Replace with your RDS endpoint
$username = "admin";                    // Replace with your MySQL username
$password = "CarroArmato56891!";                    // Replace with your MySQL password
$database = "Project";                    // Replace with your database name

// Create a mysqli connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Set UTF-8 character set (optional, but recommended)
$mysqli->set_charset("utf8");

?>
