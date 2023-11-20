<?php
// Include the database connection file
require_once('db_connect.php');

$keywordsearch = $_GET("keyword");

//Search database for driving school with name = $keywordsearch

echo <h2> "Showing records with Driver School name $keywordsearch " </h2>;

$sql = "SELECT DSName, CertRegNumber, Manager FROM DrivingSchool WHERE DSName LIKE '%". $keywordsearch ."%' ";
$result = $mysqli->query($sql);

if ($result->num_rows >0) {

  //output data of each row
  while ($row = $result->fetch_assoc() )
    {
      echo "Driving School: {$row['DSName']} - Cert Reg Number: {$row['CertRegNumber']}, Manager: {$row['Manager']}";

    }
} else {
  echo "No results matched the search";
}


?>
