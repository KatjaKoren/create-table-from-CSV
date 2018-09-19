<?php
// connect to database
// define database parameters
    define("SERVER_NAME", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "");
	define("DBNAME", "dbvehicles");

// connecting to the database
	$conn = new mysqli(SERVER_NAME, USERNAME, PASSWORD, DBNAME);
	if ($conn->connect_error) {
	   die("Error connecting to the database: " . $conn->connect_error);
	} 
?>