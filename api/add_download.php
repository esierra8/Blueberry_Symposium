<?php
	// Include the database access variables
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	$sql = "SELECT * FROM games
	        WHERE id = '{$_GET["id"]}'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	$sql = "UPDATE games
					SET downloads = downloads+1
	        WHERE id = '{$_GET["id"]}'";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;

?>