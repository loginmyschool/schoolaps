<?php
$HOST = "al-ameen.in";
$USER = "alameen_multi";
$PASS = "@#Alameen123@#";
$DB = "dbsystem";

// Create connection
$conn = new mysqli($HOST, $USER, $PASS);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
