<?php
	// Include the database access variables
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	$sql = "SELECT * FROM reviews
	        WHERE id = '{$_GET["id"]}'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if($_GET["thumb"] == "up") {
		$row["up"] += 1;
	} else if($_GET["thumb"] == "down") {
		$row["down"] += 1;
	}
	
	$sql = "UPDATE reviews
					SET up = '{$row["up"]}', down = '{$row["down"]}'
	        WHERE id = '{$_GET["id"]}'";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;

	header('Location: '.$_SERVER['HTTP_REFERER']);
?>