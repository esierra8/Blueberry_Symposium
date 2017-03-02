<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "Add A Game"; // The page/navigation bar title
	$index2 = "active"; // Set the first index in the navigation to 'active'
	
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
		<script src='https://www.google.com/recaptcha/api.js'></script> <!-- Include Captcha JS -->
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>
		
		<div class="row">
		
			<form action="/api/add_game.php" method="post" enctype="multipart/form-data"> 
			
				<!-- The genreral game information -->
				<div class='col s12 m10 offset-m1 l6 offset-l3'>
					<div class="card-panel">
						<center><p class="flow-text">General Information</p><hr></center>
						<div class="row">
							<div class="input-field col s12 m6">
								<i class="material-icons prefix blue-text">person</i>
								<input name='author' id='author' type='text'>
								<label for="author">What is your name?</label>
							</div>
							<div class="input-field col s12 m6">
								<i class="material-icons prefix blue-text">library_books</i>
								<input name='version' id='version' type='text'>
								<label for="version">Program's version number?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">label</i>
								<input name='name' id='name' type='text'>
								<label for="name">What is the name of your game?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix blue-text">insert_comment</i>
								<input name='desc'  id='desc' type='text'>
								<label for="desc">Could you give a brief description of your game?</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field file-field col s12">
									<div class="btn blue">
										<span>Upload</span>
										<input type="file" name="pic">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path" id="pic" value="Screenshot" type="text">
									</div>
								</div>
						</div>
						<div class="row">
							<div class="input-field file-field col s12">
									<div class="btn blue">
										<span>Upload</span>
										<input type="file" name="zip">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path" id="zip" value="Program (zipped)" type="text">
									</div>
								</div>
						</div>
						
						<div class="row">
							<div class="col s10">
								<div class="g-recaptcha" data-sitekey="6Lfo2BEUAAAAANHwf2rdl6iwdXANNLnALgi-_IbR"></div>
							</div>
							<div class="col s2 right-align">
								<button class="btn-floating btn-large waves-effect waves-light blue" type="submit"><i class="material-icons">send</i></button>
							</div>
						</div>
					</div>
				</div>
			
			</form>
			
		</div>
	</body>
</html>