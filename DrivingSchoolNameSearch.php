<?php
// Include the database connection file
require_once('db_connect.php');

$keywordsearch = $_GET("keyword");

//Search database for driving school with name = $keywordsearch

echo <h2> "Showing records with Driver School name $keywordsearch " </h2>;

$sql = "SELECT DSName, CertRegNumber, Manager FROM DrivingSchool WHERE DSName LIKE '%". $keywordsearch ."%' ";
$result = $mysqli->query($sql);



?>
