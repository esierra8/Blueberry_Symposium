<html>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript">

        // Keypress variables
        var Pause = true;// We will start off the game paused

        // Direction Variables
        var _up = 1;// The snake is moving upward
        var _down = 2;// The snake is moving downward
        var _left = 3;// The snake is moving left
        var _right = 4;// The snake is moving right

        var Direction = _right;// Holds the direction that the snake is going
        var Timeout;// The timeout variable for smoothness
        var SpeedFactor = 1;// How fast the snake is going

        var Points = 0;// How many points the person earned
        var Scale = 1;// How much to increase the points per play
        var Parts = new Array();// the list of snake parts

        // The snake-part class
        function snake(xc,yc) {
            this.x=xc;// Set the x-position
            this.y=yc;// Set the y-position
        }

        function keydown(evt) {// When a key is pushed
						if(event.keyCode == 32) Pause=!Pause;
            if(event.keyCode == 37) Direction = _left;
            if(event.keyCode == 38) Direction = _down;
            if(event.keyCode == 40) Direction = _up;
            if(event.keyCode == 39) Direction = _right;
        }

        var TempPart = new snake(2,2);// The head of the snake
        Parts.push(TempPart);// Add the head to the list

        var Food = new snake(Math.floor(Math.random()*23),Math.floor(Math.random()*15));// Make the food

				var name = null
        function youLost() {
						clearInterval(stop)
						if(name != null) {
							localStorage.setItem('name', name);
						} else {
							name = prompt("Please enter your name", "");
							localStorage.setItem('name', name);
						}
						name = prompt("Please enter your name", "");
						
						if(name != null) {
							$.ajax({
									type:"GET",
									data: {'game':'21', 'category':'Points', 'name':name, 'score':Math.floor(Points)},
									crossDomain: false,
									url: "/api/add_score.php",
							});	
						}
						location.reload();
        }

        function update() {// Updates the screen every 10ms
            if(Pause) return;
						
						var c   = document.getElementById("canvas");// Get the canvas
            var ctx = c.getContext("2d");// We are drawing in 2d
            ctx.clearRect (0,0,600,400);// Clear the screen
            ctx.strokeStyle = '#eeeeee';// The color of the grid

            var X = Parts[0].x;// Get the X position
            var Y = Parts[0].y;// Get the Y position

            // Move baised on the direciton
            if(Direction == _left) X--;// Move left
            if(Direction == _right) X++;// Move right
            if(Direction == _up) Y++;// Move up
            if(Direction == _down) Y--;// Move down

            // Check to see if you lost
            if((X<0)||(X>23)||(Y<0)||(Y>15))// Check the boundries
                youLost();// You lost

            ctx.fillStyle="blue";// Set the color
            for(var i = 0; i != Parts.length; i++) {// Make sure we didnt hit ourselfes
                if((X == Parts[i].x)&&(Y == Parts[i].y))/// Check to see if the coordintates match
                    youLost();// You lost
            }// End of for loop

            for(var i = 0; i != Parts.length; i++) {// Move the snake
                var tmpX = Parts[i].x;// Save the x position
                var tmpY = Parts[i].y;// Save the y position
                Parts[i].x = X;// Set the new position
                Parts[i].y = Y;// Set the new position
                ctx.fillRect(Parts[i].x*25,Parts[i].y*25,25,25);// Draw the rectangle
                X = tmpX;// Use the old blocks position
                Y = tmpY;// Use the old blocks position
            }// End of for loop

            if((Parts[0].x == Food.x)&&(Parts[0].y == Food.y)) {// We hit the food
                Points += Scale;// Add to the score
                Scale += 1.1;// Double the next blocks value
                var tmpPart = new snake(X,Y);// Make the new part
                Parts.push(tmpPart);// Add the part to the old spot
                Food.x = Math.floor(Math.random()*23);// New food spot
                Food.y = Math.floor(Math.random()*15);// New food spot
            }// End of for loop

            ctx.fillStyle="green";// Set the color
            ctx.fillRect(Food.x*25,Food.y*25,25,25);// Draw the rectangle

            var score = document.getElementById("score");
            score.innerHTML = ""+Math.floor(Points);
        }
				
				var stop
				function start() {
					$.ajax({
							type:"GET",
							data: {'id':'21'},
							crossDomain: false,
							url: "/api/add_play.php",
					});	
					
					stop = setInterval(function(){update();},100)
				}
    </script>
    <body onload="start()" onkeyup="keydown(event);">
        <center><h1>Snake, press space to play</h1>
        Your Score: <span id="score">0</span><br />
        <canvas id="canvas" width="600px" height="400px" style="border:1px solid #000000;"></canvas></center>
    </body>
</html>
