<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Highscore"; // The page/navigation bar title
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
		<style>
			.carousel {
				height: 600px !important;
			}
			.carousel .carousel-item {
				width:300px !important;
				margin-top: -140px !important;

			}
			.no-margin-h1 {
				margin-top:10px;
				padding-bottom: -40px;
			}
			.no-margin-row {
				margin-bottom: -30px;
				margin-top: -20px;
			}
			
			.topthree {
				border-radius: 3px;
			}
			
			.topfive {
				
			}
		</style>
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>

		<script>
		$(document).ready(function(){
				$('.carousel').carousel({full_width: false});
		});
		</script>

		<div class="row no-margin-row">
			<span class="grey-text text-darken-4"><h1 class="center-align">Lunar Turrets</h1></span>
			<div class="carousel">
				<div class="carousel-item">
					<ul class="collection with-header">
						<li class="collection-header green lighten-3"><h4>Most Points</h4></li>
						
						<li class="row collection-item" style="margin-right: -20px;">
							<div class="col s6 valign-wrapper">
								<i style="margin-left: -20px" class="material-icons topthree yellow accent-4">looks_one</i>
								<span style="font-size: 20px; padding-left: 10px;" class = "valign">Kendal</span>
							</div>
							<div class="col s6 right-align" style="font-size: 20px;">271,289</div>
						</li>
						
						<li class="row collection-item" style="margin-right: -20px;">
							<div class="col s8 valign-wrapper">
								<i style="margin-left: -20px"  class="material-icons topthree grey lighten-2">looks_two</i>
								<span style="font-size: 20px; padding-left: 10px;" class = "valign">Kylie</span>
							</div>
							<div class="col s4 right-align" style="font-size: 20px;">93,745</div>
						</li>
						
						<li class="row collection-item" style="margin-right: -20px;">
							<div class="col s8 valign-wrapper">
								<i  style="margin-left: -20px" class="material-icons topthree brown lighten-1">looks_3</i>
								<span style="font-size: 20px; padding-left: 10px;" class = "valign">Kim</span>
							</div>
							<div class="col s4 right-align" style="font-size: 20px;">92,184</div>
						</li>
						
						<li class="row collection-item" style="margin-right: -20px;">
							<div class="col s8 valign-wrapper">
								<i  style="margin-left: -20px" class="material-icons topfive">looks_4</i>
								<span style="font-size: 20px; padding-left: 10px;" class = "valign">Kim</span>
							</div>
							<div class="col s4 right-align" style="font-size: 20px;">92,184</div>
						</li>
						
						<li class="row collection-item" style="margin-right: -20px;">
							<div class="col s8 valign-wrapper">
								<i  style="margin-left: -20px" class="material-icons topfive">looks_5</i>
								<span style="font-size: 20px; padding-left: 10px;" class = "valign">Kim</span>
							</div>
							<div class="col s4 right-align" style="font-size: 20px;">92,184</div>
						</li>
						
					</ul>
				</div>
			</div>		
		</div>


	</body>
</html>