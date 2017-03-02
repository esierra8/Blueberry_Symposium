<?php
	// Include the database access variables
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	$sql = "INSERT INTO reviews (game_id, author, content, up, down)
	        VALUES ('{$_POST["id"]}', '{$_POST["name"]}', '{$_POST["content"]}', 0, 0)";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;

	header('Location: /play.php?game='.$_POST["id"]);
?>