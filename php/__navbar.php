<!-- Initialize the nav bar -->
<script type="text/javascript">
	$( document ).ready(function(){
		$(".button-collapse").sideNav();
	})
</script>

<nav>
	<div class="nav-wrapper">
		<a href="#" class="brand-logo" style="margin-left: 10px"><?php echo $title; ?></a>
		<a href="#" data-activates="mobile" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul class="hide-on-med-and-down right">
			<li class="<?php echo $index1; ?>"><a href="/index.php"><i class="material-icons left">home</i>Home</a></li>
			<li class="<?php echo $index2; ?>"><a href="/add_game.php"><i class="material-icons left">library_add</i>Add a Game</a></li>
			<li class="<?php echo $index3; ?>"><a href="/api.php"><i class="material-icons left">memory</i>API</a></li>
			<li class="<?php echo $index4; ?>"><a href="/stats.php"><i class="material-icons left">trending_up</i>Stats</a></li>
		</ul>
		<ul class="side-nav" id="mobile">
			<li class="<?php echo $index1; ?>"><a href="/index.php"><i class="material-icons left">home</i>Home</a></li>
			<li class="<?php echo $index2; ?>"><a href="/add_game.php"><i class="material-icons left">library_add</i>Add a Game</a></li>
			<li class="<?php echo $index3; ?>"><a href="/api.php"><i class="material-icons left">memory</i>API</a></li>
			<li class="<?php echo $index4; ?>"><a href="/stats.php"><i class="material-icons left">trending_up</i>Stats</a></li>
		</ul>
	</div>
</nav>