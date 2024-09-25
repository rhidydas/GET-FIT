<?php
// Database connection
$servername = "localhost";
$username = "root";  // Change according to your database setup
$password = "";      // Change according to your database setup
$dbname = "getfit";  // Replace with your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
echo "Connection Established to the database: " . $dbname;
?>
