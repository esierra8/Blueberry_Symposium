<?php
	$path = $_SERVER['DOCUMENT_ROOT'].'/php/'; // The path to the included php files
	$title = "SIPS"; // The page/navigation bar title
	$index2 = "active"; // Set the first index in the navigation to 'active'
	
	// Include the database access variables
	include $path.'__db.php';

	// Connect to the database
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);
	
	
	// Read all of the recipients from the database
	if(isset($_GET["game"])) {
		$sql = "SELECT * FROM games
						WHERE id = '{$_GET["game"]}' ";
		$game = $conn->query($sql);
		$row = $game->fetch_assoc();
		
		$title = $row['name'];
		
		$sql = "SELECT * FROM reviews
						WHERE game_id = '{$_GET["game"]}' 
						ORDER BY up-down DESC";
		$reviews = $conn->query($sql);
		$reviews_rendered = 0;
		
		$sql = "SELECT name, max(score) as score, category FROM highscores 
						WHERE game_id = '{$_GET["game"]}'
						GROUP BY name, category
						ORDER BY max(score) DESC";
		$scores = $conn->query($sql);
	} else {
		die("No Game Selected");
	}
	
	$conn->close(); 
	
	// Kill the page if nobody is found, it should not happen in our demos
	if ($game->num_rows == 0)
		die("Could not find the desired game");
?>

<html>
	<head>
		<?php include $path.'__head.php'; ?> <!-- Include the global document header -->
		<style>
			.carousel .carousel-item {
				margin-top: -20px !important;
				width: 50% !important;
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
			
		</style>
	</head>
	<body>
		<header>
			<?php include $path.'__js.php'; ?> <!-- Load the Javascript Libraries -->
		</header>

		<nav>
			<?php include $path.'__navbar.php'; ?> <!-- Load the navigation bar -->
		</nav>
		
		<!-- Used to make the "more reviews" button work -->
		<script>
			function save_scroll() {
				localStorage.setItem('scrollTop', $(window).scrollTop());
			}
			
			function play() {
				$.ajax({
						type:"GET",
						data: {'id':'<?php echo $row['id']; ?>'},
						crossDomain: false,
						url: "/api/add_download.php",
						success:function(data) {
							location = "/downloads/<?php echo $row['id'].'.'.$row['dld']; ?>"; 
						}
				});	
			}
			
			function update() {
				save_scroll()
				location.reload(false)
			}
			
			function expand_reviews(){
				var hiddenReviews = document.getElementsByClassName("hidden");
				for(var i = 0; i < hiddenReviews.length; i++){
				 	hiddenReviews.item(i).className = "";
				}
				if(hiddenReviews.length == 0 ) {
					document.getElementById("more_button").className = "hide";
				}
			}
			
			var scores = [];
			function fill_scores() {
				<?php
						echo "\n";
						while($score = $scores->fetch_assoc()) {
							echo "if(!scores['{$score["category"]}']) scores['{$score["category"]}'] = new Array(); \n";
							echo "scores['{$score["category"]}'].push(['{$score['name']}', '{$score['score']}']);\n";
						}
				?>
			}
			$(document).ready(function(){
				// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
				$('.modal').modal();
				var hiddenReviews = document.getElementsByClassName("hidden");
				if(hiddenReviews.length == 0 ) {
					document.getElementById("more_button").className = "hide";
				}
				
				
				
				var scrollTop = localStorage.getItem('scrollTop');
				if (scrollTop !== null) {
						$(window).scrollTop(Number(scrollTop));
						localStorage.removeItem('scrollTop');
				}
			});
		</script>
		
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
		
		<!--Review card -->
		<div class="row valign">		
			<div class="col s12 m10 offset-m1 l4 offset-l2">	

				<!--Game card-->
				<div class="card" style="margin-top: 20px">
					<div class="card-image">
						<!-- Load the game's picture -->
						<?php echo "<img src='/images/{$row['id']}.{$row['ext']}' alt=''>"; ?>
					</div>
					<div class="card-content">
						<span class="card-title activator grey-text text-darken-4"><?php echo $row['name']; ?></span>
						<p><?php echo $row['description']; ?></p>
						<div class="fixed-action-btn toolbar">
							<a class="btn-floating btn-large blue">
								<i class="large material-icons blue">more_horiz</i>
							</a>
							<ul>
								<li class="waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Play this Game">
									<a onclick="play()" ><i class="small material-icons">games</i></a>
								</li>
								<li class="waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comment on this Game">
									<a href="#modal1"><i class="small material-icons">comment</i></a>
								</li>
								<li class="waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Share this Game">
									<a class="fb-xfbml-parse-ignore" target="_blank" 
											 href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Funcommonhacks.com%2F&amp;src=sdkpreparse">
										<i class="small material-icons">share</i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col s12 m10 offset-m1 l4">	
				<div class="row no-margin-row">
					<div class="carousel" id="scores">
						<div class="carousel-item">
							<ul class="collection with-header">
								<li class="collection-header purple lighten-4"><h5>Statistics</h5></li>
								
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s6 valign-wrapper">
										<i style="margin-left: -20px" class="material-icons">videogame_asset</i>
										<span style="font-size: 20px; padding-left: 10px;" class = "valign">Plays</span>
									</div>
									<div class="col s6 right-align" style="font-size: 15px;"><?php echo $row['plays']; ?></div>
								</li>
								
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s8 valign-wrapper">
										<i style="margin-left: -20px" class="material-icons">file_download</i>
										<span style="font-size: 20px; padding-left: 10px;" class = "valign">Downloads</span>
									</div>
									<div class="col s4 right-align" style="font-size: 15px;"><?php echo $row['downloads']; ?></div>
								</li>
								
							</ul>
						</div>
						
						<div class="carousel-item">
							<ul class="collection with-header">
								<li class="collection-header orange lighten-3"><h5>Details</h5></li>
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s6 valign-wrapper">
										<i style="margin-left: -20px" class="material-icons">person</i>
										<span style="font-size: 15px; padding-left: 10px;" class = "valign">Author</span>
									</div>
									<div class="col s6 right-align" style="font-size: 15px;"><?php echo $row['author']; ?></div>
								</li>
								
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s6 valign-wrapper">
										<i style="margin-left: -20px"  class="material-icons">library_books</i>
										<span style="font-size: 15px; padding-left: 10px;" class = "valign">Version</span>
									</div>
									<div class="col s6 right-align" style="font-size: 15px;"><?php echo $row['version']; ?></div>
								</li>
								
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s4 valign-wrapper">
										<i  style="margin-left: -20px" class="material-icons">date_range</i>
										<span style="font-size: 15px; padding-left: 10px;" class="valign">Date</span>
									</div>
									<div class="col s8 right-align" style="font-size: 15px;"><?php echo $row['date']; ?></div>
								</li>
								
								<li class="row collection-item" style="margin-right: -20px;">
									<div class="col s4 valign-wrapper">
										<i  style="margin-left: -20px" class="material-icons">memory</i>
										<span style="font-size: 15px; padding-left: 10px;" class="valign">Language</span>
									</div>
									<div class="col s8 right-align" style="font-size: 15px;"><?php echo $row['lang']; ?></div>
								</li>
							</ul>
						</div>
						
					</div>		
				</div>
				
				<script>
					$(document).ready(function(){
						fill_scores();
						var str = ""
						var cards = 0
						for (var i in scores) {
							cards += 1
							var item = document.createElement("div");
							item.className = "carousel-item";

							var ul_header = document.createElement("ul");
							ul_header.className = "collection with-header";

							var li_header = document.createElement("li");
							li_header.className = "collection-header yellow lighten-3";

							var header = document.createElement("h5");
							header.innerHTML = i;
							
							li_header.appendChild(header);
							ul_header.appendChild(li_header);
							
							for (var j in scores[i]) {
								var row = document.createElement("li");
								row.className = "row collection-item";
								row.style.marginRight = "-20px";

								var one = document.createElement("div");
								one.className = "col s8 valign-wrapper";
								if(j == 0) one.innerHTML += "<i style='margin-left: -20px' class='material-icons topthree yellow accent-4'>looks_one</i>\n";
								if(j == 1) one.innerHTML += "<i style='margin-left: -20px' class='material-icons topthree grey lighten-2'>looks_two</i>\n";
								if(j == 2) one.innerHTML += "<i style='margin-left: -20px' class='material-icons topthree brown lighten-2'>looks_3</i>\n"
								if(j == 3) one.innerHTML += "<i style='margin-left: -20px' class='material-icons '>looks_4</i>\n"
								if(j == 4) one.innerHTML += "<i style='margin-left: -20px' class='material-icons '>looks_5</i>\n";
								one.innerHTML += "<span style='font-size: 15px; padding-left: 10px;' class = 'valign'>"+scores[i][j][0]+"</span>\n";
								row.appendChild(one);
								
								var two = document.createElement("div");
								two.className = "col s4 right-align";
								two.style.fontSize = "20px";
								two.innerHTML = scores[i][j][1];
								row.appendChild(two);
								ul_header.appendChild(row);
							}
							
							item.appendChild(ul_header);
							document.getElementById("scores").insertBefore(item, document.getElementById("scores").firstChild);
						}

						if(cards == 0) {
							
							var item = document.createElement("div");
							item.className = "carousel-item";

							var ul_header = document.createElement("ul");
							ul_header.className = "collection with-header";

							var li_header = document.createElement("li");
							li_header.className = "collection-header yellow lighten-3";

							var header = document.createElement("h5");
							header.innerHTML = "No highscores yet"
							
							li_header.appendChild(header);
							ul_header.appendChild(li_header);
			
							
							item.appendChild(ul_header);
							document.getElementById("scores").insertBefore(item, document.getElementById("scores").firstChild);
							
						}
						
						$('.carousel').carousel({full_width: false});
					})
				</script>
			</div>
			<div class="row">
				<div class="col s12 m10 offset-m1 l4"

				<!--Reviews card-->
				<ul class="collection">
					<?php if($reviews->num_rows == 0) { ?>
							<li class="collection-item grey lighten-5">
								<span style="font-size: 25px">No reviews yet</span>
							</li>
						<?php }
						
						// If there are reviews
						while($row = $reviews->fetch_assoc()) { 
							$hide = "";
							if($reviews_rendered >= 4) {
								$hide = "hide hidden";
							}
							$reviews_rendered += 1;
							
							$color = "green";
							if($row["up"]-$row["down"] < 0) {
								$color = "red";
							} ?>
							<span class="<?php echo $hide; ?>">
								<li class="collection-item <?php echo $color; ?> lighten-5">
									<span class="right tooltipped" data-position="top" data-delay="50" data-tooltip="Report this">
										 <a class="waves-effect waves-light" href="#modal2"><i class="material-icons grey-text text-lighten-2">security</i></a>
									</span>
									<span style="font-size: 25px"><?php echo $row["author"]; ?></span>
									<p><?php echo $row["content"]; ?></p>
									<span class="<?php echo $color; ?>-text" style="font-size: 30"><?php echo $row["up"]-$row["down"]; ?></span>
									<span class="right">
										<a style="margin-top: -40px" class="btn-floating btn-medium waves-effect waves-light green"
										   href="/api/thumb.php?id=<?php echo $row["id"]; ?>&thumb=up" onclick="save_scroll()">
											<i class="material-icons">thumb_up</i>
										</a>
										<a style="margin-top: -40px" class="btn-floating btn-medium waves-effect waves-light red"
										   href="/api/thumb.php?id=<?php echo $row["id"]; ?>&thumb=down" onclick="save_scroll()">
											<i class="material-icons">thumb_down</i>
										</a>
									</span>
								</li>
							</span>
					<?php } ?>		
				</ul>
				
				<span id="more_button" class='center'>
					<div class="card-action">
						<a class='btn-floating btn-medium waves-effect waves-light grey lighten-2' onclick="expand_reviews();">
							<i class='material-icons'>expand_more</i> 
						</a>
					</div>
				</span>

				<!-- Add Review -->
				<div id="modal1" class="modal bottom-sheet">
					<form action="/api/add_review.php" method="post" enctype="multipart/form-data"> 
						<div class="modal-content">
								<div class="row">
									<div class="col s12">
										<div class="input-field col s12">
											<input placeholder="Your Name" name="name" id="name" type="text" class="validate">
											<label for="name">Name</label>
										</div>
										
										<input name="id" id="id" type="hidden" value="<?php echo $_GET["game"]; ?>">
										<div class="input-field col s12">
											<textarea name="content" id="textarea1" class="materialize-textarea"></textarea>
											<label for="textarea1">Thoughts, bugs, or suggested improvments...</label>
										</div>
									</div>
								</div>
							
						</div>
						<div class="modal-footer">
							<button type="submit" class="right modal-action modal-close waves-effect waves-red btn-floating blue">
								<i class="material-icons">send</i>
							</button>
						</div>
					</form>
				</div>
				
				<!-- The model displayed once the report button is clicked -->
				<div id="modal2" class="modal">
					<div class="modal-content">
						<h4>Thank you!</h4>
						<p>Moderators have been alerted and will readily address this situation!</p>
					</div>
					<div class="modal-footer">
						<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Continue</a>
					</div>
				</div>

			</div>
		</div>
	</body>
</html>