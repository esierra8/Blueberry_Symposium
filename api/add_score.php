<?php
	// Include the database access variables
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	$sql = "INSERT INTO highscores (game_id, category, name, score)
	        VALUES ('{$_GET["game"]}', '{$_GET["category"]}', '{$_GET["name"]}', '{$_GET["score"]}')";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;
?>