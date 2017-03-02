<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Blueberry Symposium"; // The page/navigation bar title
	$index1 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	// Read all of the recipients from the database
	$sql = "SELECT * FROM games";
	$result = $conn->query($sql);
	$conn->close(); 
	$games_rendered = 0;
	
	// Kill the page if nobody is found, it should not happen in our demos
	//if ($result->num_rows == 0)
	//	die("No Games Found");
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
		<link rel="stylesheet" type="text/css" href="/css/card_flow.css" /> <!-- Import materialize.css -->
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>
		
		<!-- The Game Cards -->
		<div class="container">
			<div class="row">
				<div class="col s12 cards-container">
					<?php while($row = $result->fetch_assoc()) { ?><!-- Go through each item read from the database -->
						<div class="card hoverable sticky-action">
							<div class="card-image waves-effect waves-block waves-light">
								<a href="/play.php?game=<?php echo $row['id']; ?>">
									<?php echo "<img src='/images/{$row['id']}.{$row['ext']}' alt=''>"; ?> <!-- Load the game's picture -->
								</a>
							</div>
							<div class="card-content">
								<span class="card-title activator grey-text text-darken-4"><?php echo $row['name']; ?><i class="material-icons right">more_vert</i></span>
							</div>
							<div class="card-reveal">
								<span class="card-title grey-text text-darken-4"><?php echo $row['name']; ?><i class="material-icons right">close</i></span>
								<p><?php echo $row['description']; ?></p>
							</div>
						</div>
					<?php 
					} 
					?>
				</div>
			</div>
		</div>
			
	</body>
</html>