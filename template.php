<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Template"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	// Read all of the recipients from the database
	$sql = "SELECT name FROM games";
	$result = $conn->query($sql);
	$conn->close(); 
	
	// Kill the page if nobody is found, it should not happen in our demos
	//if ($result->num_rows == 0)
	//	die("No Games Found");
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>
		
		<div class="row">
		
			<!-- This is the sample card dimensions-->
			<div class='col s12 m10 offset-m1 l6'>
				<div class="card blue-grey darken-1">
					<div class="card-content white-text">
						<span class="card-title">Template</span>
						<p>I am a very simple card. I am good at containing small bits of information.
						I am convenient because I require little markup to use effectively.</p>
					</div>
				</div>
			</div>
			<!-- End of card -->
			
		</div>
				

	</body>
</html>