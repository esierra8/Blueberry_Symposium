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
			<div class="col s12 m8 offset-m2 l4 offset-l4">
				<ul class="collapsible" data-collapsible="accordion">
					<li>
						<div class="collapsible-header"><i class="material-icons">filter_drama</i>First</div>
						<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
					</li>
					<li>
						<div class="collapsible-header"><i class="material-icons">place</i>Second</div>
						<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
					</li>
					<li>
						<div class="collapsible-header"><i class="material-icons">whatshot</i>Third</div>
						<div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
					</li>
				</ul>
			</div>
		</div>

	</body>
</html>