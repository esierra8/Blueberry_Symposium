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
	$sql = "SELECT downloads, plays FROM games";
	$result = $conn->query($sql);
	$conn->close(); 
	$games_rendered = 0;

?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
		<link rel="stylesheet" type="text/css" href="/css/card_flow.css" /> <!-- Import materialize.css -->
		<link rel="stylesheet" type="text/css" href="/js/jquery.animateNumber.min.js" /> <!--IMport Nuymber counter.js -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="jquery.counterup.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<script>
		 $('#lines').animateNumber({ number: 117 });
		</script>
    	
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>

		<?php 
			$total_downloads = 0;
			$total_plays = 0;
			while($row = $result->fetch_assoc()) {
				$total_downloads += $row['downloads'];
				$total_plays += $row['plays'];
			} 
		?>
		

		<div class="row">
				<div class="col s12 m8 offset-m2 l6 offset-l3">
					<div class="card-panel">
						<div class="row">
							<div class="col s6 center-align">
				
								<h2><?php echo $total_plays; ?></h2>
								<p>Total amount of times games played</p>
							</div>
							<div class="col s6 center-align">
								<h2><?php echo $total_downloads; ?></h2>
								<p>Total amount of downloads</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		<!-- The Game Cards -->
		<!-- <div class="container">
			<div class="row">
				<div class="col s12 m10 offset-m1 l8 offset-l2">
					<div class="card light-blue lighten-5">
						<?php 

						$total_downloads = 0;
						$total_plays = 0;
						while($row = $result->fetch_assoc()) {
							// echo "downloads: {$row['downloads']} plays: {$row['plays']} ";
							$total_downloads += $row['downloads'];
							$total_plays += $row['plays'];
						} 
						?>

						<h3 class="h3 left-align">Total plays: 
							<?php echo $total_plays;?>
							 <span class="h3 right-align"> Total downloads: 
							 <?php echo $total_downloads;?> </span> </h3><hr>

						<span class="counter1">1,234,567</span>
						<span id="lines">0</span>

						<script> $('#lines').animateNumber({ number: 117 }); </script>
   						<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    					<script src="jquery.counterup.min.js"></script>
					</div>
				</div>
			</div>
		</div> -->
		
	</body>
</html>