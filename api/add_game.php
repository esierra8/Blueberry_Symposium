<?php
	// Include the database access variables
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	// Provide *minimal* error checking for the uploaded image
	$target_dir = $_SERVER["DOCUMENT_ROOT"]."/images/";
	$imageFileType = pathinfo($target_dir.basename($_FILES["pic"]["name"]),PATHINFO_EXTENSION);
	if(getimagesize($_FILES["pic"]["tmp_name"]) === false)
			die("Your image does not seem to be valid");
		
	// Provide *minimal* error checking for the uploaded file
	$file_target_dir = $_SERVER["DOCUMENT_ROOT"]."/downloads/";
	$fileType = pathinfo($file_target_dir.basename($_FILES["zip"]["name"]),PATHINFO_EXTENSION);
		
	$date = date("F j, Y");
	$sql = "INSERT INTO games (name, description, author, version, date, plays, downloads, ext, dld)
	        VALUES ('{$_POST["name"]}', '{$_POST["desc"]}', '{$_POST["author"]}', '{$_POST["version"]}', 
					        '{$date}', '0', '0', '{$imageFileType}', '{$fileType}')";
	if ($conn->query($sql) != TRUE) 
			echo "Error: " . $sql . "<br>" . $conn->error;
		
	$sql = "SELECT * FROM games
	        WHERE name = '{$_POST["name"]}' AND description = '{$_POST["desc"]}' ";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$target_file = $target_dir.$row["id"].'.'.$imageFileType;
	$id = $row["id"];
	move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
	
	$target_file = $file_target_dir.$row["id"].'.'.$fileType;
	move_uploaded_file($_FILES["zip"]["tmp_name"], $target_file);
	
	header('Location: /index.php');
?>