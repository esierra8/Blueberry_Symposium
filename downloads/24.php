<html>
    <head>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <title>The Run, by Nate</title>
        <script type="text/javascript">
            // Variables
            var TopSpeed = 0;// Mph
            var TopDst = 0;
            var Speed = 10;// Mph
            var Distance = 0;// Meters
            var Jump = 0;// Pixels
            var Height = 0;// Pixels
            var Lost = false;// Have we lost the game
            var FirstUpdate = true;// the first time we update
            var Pause = false;// Have we paused the game
            var Src = "http://www.quadrathell.cn.ua/_fr/0/7967038.png";
            var Index = 0;
            var TimeSinceUpdate = 0;

            var velocityY = 0;// the Y velocity
            var gravity = 0.4;// Acceleration of gravity
            var time = 0.1;// Time between each update (seconds)
            var cloudCount = 40;// We want 20 clouds
            var Jumping = 0;

            function cloud(x,y,r) {
                this.x = x;
                this.y = y;
                this.r = r;
            }
            var Clouds = new Array();
            for(var i = 0; i != cloudCount; i++) {
                var C = new cloud(Math.floor(Math.random()*1000),Math.floor(Math.random()*100),Math.floor(Math.random()*50+20));
                Clouds.push(C);
            }

            function square(x,y,w,h) {
                this.x = x;
                this.y = y;
                this.w = w;
                this.h = h;
            }
            var Squares = new Array();

            var BrowserDetect = {
                init: function () {
                    this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
                    this.version = this.searchVersion(navigator.userAgent)
                        || this.searchVersion(navigator.appVersion)
                        || "an unknown version";
                    this.OS = this.searchString(this.dataOS) || "an unknown OS";
                },
                searchString: function (data) {
                    for (var i=0;i<data.length;i++)	{
                        var dataString = data[i].string;
                        var dataProp = data[i].prop;
                        this.versionSearchString = data[i].versionSearch || data[i].identity;
                        if (dataString) {
                            if (dataString.indexOf(data[i].subString) != -1)
                                return data[i].identity;
                        }
                        else if (dataProp)
                            return data[i].identity;
                    }
                },
                searchVersion: function (dataString) {
                    var index = dataString.indexOf(this.versionSearchString);
                    if (index == -1) return;
                    return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
                },
                dataBrowser: [
                    {
                        string: navigator.userAgent,
                        subString: "Chrome",
                        identity: "Chrome"
                    },
                    { 	string: navigator.userAgent,
                        subString: "OmniWeb",
                        versionSearch: "OmniWeb/",
                        identity: "OmniWeb"
                    },
                    {
                        string: navigator.vendor,
                        subString: "Apple",
                        identity: "Safari",
                        versionSearch: "Version"
                    },
                    {
                        prop: window.opera,
                        identity: "Opera",
                        versionSearch: "Version"
                    },
                    {
                        string: navigator.vendor,
                        subString: "iCab",
                        identity: "iCab"
                    },
                    {
                        string: navigator.vendor,
                        subString: "KDE",
                        identity: "Konqueror"
                    },
                    {
                        string: navigator.userAgent,
                        subString: "Firefox",
                        identity: "Firefox"
                    },
                    {
                        string: navigator.vendor,
                        subString: "Camino",
                        identity: "Camino"
                    },
                    {		// for newer Netscapes (6+)
                        string: navigator.userAgent,
                        subString: "Netscape",
                        identity: "Netscape"
                    },
                    {
                        string: navigator.userAgent,
                        subString: "MSIE",
                        identity: "Explorer",
                        versionSearch: "MSIE"
                    },
                    {
                        string: navigator.userAgent,
                        subString: "Gecko",
                        identity: "Mozilla",
                        versionSearch: "rv"
                    },
                    { 		// for older Netscapes (4-)
                        string: navigator.userAgent,
                        subString: "Mozilla",
                        identity: "Netscape",
                        versionSearch: "Mozilla"
                    }
                ],
                dataOS : [
                    {
                        string: navigator.platform,
                        subString: "Win",
                        identity: "Windows"
                    },
                    {
                        string: navigator.platform,
                        subString: "Mac",
                        identity: "Mac"
                    },
                    {
                           string: navigator.userAgent,
                           subString: "iPhone",
                           identity: "iPhone/iPod"
                    },
                    {
                        string: navigator.platform,
                        subString: "Linux",
                        identity: "Linux"
                    }
                ]

            };
            BrowserDetect.init();
            if(BrowserDetect.browser == "Mozila")
                alert("This game does not work on your browser");

            function keyPress(event) {
                var key = event.keyCode || event.which;
                if(key == 32) {
                    if(FirstUpdate) FirstUpdate = false;
                    else if(Lost) {
                        Speed = 10;// Mph
                        Distance = 0;// Meters
                        Jump = 0;// Pixels
                        Height = 0;// Pixels
                        Lost = false;// Have we lost the game
                        FirstUpdate = false;// the first time we update
                        Pause = false;// Have we paused the game
                        velocityY = 0;// the Y velocity
                        Squares.splice(0,Squares.length);
                        Jumping = false;
												$.ajax({
														type:"GET",
														data: {'id':'24'},
														crossDomain: false,
														url: "/api/add_play.php",
												});	
                    }
                } else if(key == 80) {
                    Pause = !Pause;
                } else if(key == 38) {
                    if(Jumping != 2) {
                        if(BrowserDetect.browser == "Chrome") velocityY += 8.0;
                        else velocityY += 8;
                        Jumping++;
                    }
                }
                //alert(key);
            }

            window.addEventListener("keydown", function(e) {
                // space and arrow keys
                if([32, 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
                    e.preventDefault();
                }
            }, false);

            function inSquare(x, y, index) {
                if((x > Squares[index].x)&&(x < Squares[index].x+Squares[index].w)&&
                   (y > Squares[index].y)&&(y < Squares[index].y+Squares[index].h)) return true;
                else return false;
            }

            var circleSquare = 20;
            if(navigator.onLine) circleSquare*=2;

            function DistToTime(d) { return d/4.4704; }
            function TimeToDist(t) { return t*4.4704; }

            function TimeToSped(t) { return (0.8*t)+10; }
            function SpedToTime(s) { return (s-10)/0.8; }

            function addBlocks() {
                if(!(FirstUpdate||Pause||Lost)) {
                    var choose = Math.floor(Math.random()*9);
                    if(choose == 0) {
                        var S = new square(1000,400,50,50);
                        Squares.push(S);
                    } else if(choose == 1) {
                        var S1 = new square(1000,400,300,50);
                        Squares.push(S1);
                    } else if(choose == 2) {
                        var S1 = new square(1000,400,450,50);
                        var S2 = new square(1400,350,50,50);
                        Squares.push(S1,S2);
                    } else if(choose == 3) {
                        var S1 = new square(1000,400,500,50);
                        var S2 = new square(1250,0,200,350);
                        Squares.push(S1,S2);
                    } else if(choose == 4) {
                        var S1 = new square(1000,400,500,50);
                        var S2 = new square(1200,350,400,50);
                        var S4 = new square(1500,0,200,250);
                        Squares.push(S1,S2,S4);
                    } else if(choose == 5) {
                        var S1 = new square(1000,400,500,50);
                        var S2 = new square(1200,350,50,50);
                        var S4 = new square(1400,350,250,50);
                        Squares.push(S1,S2,S4);
                    } else if(choose == 6) {
                        var S1 = new square(1000,350,150,50);
                        var S2 = new square(1300,400,150,50);
                        var S3 = new square(1500,350,150,50);
                        Squares.push(S1,S2,S3);
                    } else if(choose == 7) {
                        var S1 = new square(1000,350,350,50);
                        var S2 = new square(1350,300,350,50);
                        var S3 = new square(1700,300,50,150);
                        Squares.push(S1,S2,S3);
                    } else if(choose == 8) {
                        var S1 = new square(1000,400,50,50);
                        var S2 = new square(1000,0,50,300);
                        Squares.push(S1,S2);
                    }
                }
            }

            function changePic() {
                if(Jump == 0) Index=(Index+1)%30;
            }

            ctx.lineWidth = 0;
            function update() {
                var c=document.getElementById("canvas");
                var ctx=c.getContext("2d");
                ctx.clearRect(0,0,1000,600);

                if(Lost) {
                    ctx.font="72px Arial";
                    ctx.fillStyle="#FF0000";
                    ctx.fillText("YOU LOST",350,280);
                    ctx.fillStyle="#AAAAAA";
                    ctx.fillText("Press SPACE to try again",100,360);
                } else if(FirstUpdate) {
                    ctx.font="italic bold 100px Courier";
                    var grd=ctx.createLinearGradient(20,190,20,240);
                    grd.addColorStop(0,"green");
                    grd.addColorStop(1,"white");
                    ctx.fillStyle=grd;
                    ctx.fillText("THE RUN",20,240);

                    ctx.font="60px Arial";
                    ctx.fillStyle="#AAAAAA";
                    ctx.fillText("Press SPACE to start",250,300);
                    ctx.font="30px Arial";
                    ctx.fillStyle="#000000";
                    ctx.fillText("Use UP ARROW to jump",350,380);
                } else if(Pause) {
                    ctx.font="72px Arial";
                    ctx.fillStyle="#AAAAAA";
                    ctx.fillText("Press \"P\" to resume",150,300);
                }

                if(!(FirstUpdate||Pause||Lost)) {
                    var jSpeed = 15;
                    if(BrowserDetect.browser == "Chrome") jSpeed = 15;
                    else jSpeed = 22;
                    if(Jump > 0) velocityY -= gravity * time *jSpeed;
                    Speed += time*0.08;
                    Distance += 0.44704 * time;
                    Jump += velocityY * time * jSpeed;
                    if(Jump < 0) {
                        velocityY = 0;
                        Jump = 0;
                        Jumping =0;
                    }
                }
                changePic();

                for(var i = 0; i != cloudCount; i++) {
                    var grd = ctx.createRadialGradient(Clouds[i].x,Clouds[i].y,Clouds[i].r/2,Clouds[i].x,Clouds[i].y,Clouds[i].r);
                    grd.addColorStop(0,"gray");
                    grd.addColorStop(1,"white");

                    // Fill with gradient
                    ctx.fillStyle = grd;
                    ctx.beginPath();
                    ctx.arc(Clouds[i].x,Clouds[i].y,Clouds[i].r,0,2*Math.PI);
                    ctx.fill();

                    Clouds[i].x-=Speed/50;
                    if(Clouds[i].x < 0) Clouds[i].x = Math.floor(Math.random()*50+1000);
                }

                if(!(FirstUpdate||Pause||Lost)) {
                    ctx.fillStyle="#000000";
                    var onTopOfSquare = false;
                    for(var i = 0; i != Squares.length; i++) {
                        ctx.fillRect(Squares[i].x,Squares[i].y,Squares[i].w,Squares[i].h);
                        if(inSquare(50+circleSquare,410-Height-Jump+(circleSquare-20),i)) {
                            Lost = true;
														name = prompt("Please enter your name", "");
						
														if(name != null) {
															$.ajax({
																	type:"GET",
																	data: {'game':'24', 'category':'Speed(mph)', 'name':name, 'score':Math.floor(Speed)},
																	crossDomain: false,
																	url: "/api/add_score.php",
															});	
														}
                        }
                        if(inSquare(50+circleSquare-20,410-Height-Jump+(circleSquare),i)) {
                            Jump = 0;
                            Height = 450-Squares[i].y;
                            onTopOfSquare = true;
                        }
                        if(BrowserDetect.browser == "Chrome") Squares[i].x-=Speed*0.5;
                        else Squares[i].x-=(Speed+15)*0.5;
                        if(Squares[i].x+Squares[i].w < -100)
                            Squares.splice(i,1);
                    }
                    if(onTopOfSquare == false) {
                        Jump += Height;
                        Height = 0;
                    }

                    ctx.font="72px Arial";
                    ctx.fillStyle="#CCCCCC";
                    ctx.fillText((Math.floor(Speed))+" mph",400,300);

                    if(!navigator.onLine) {
                        ctx.beginPath();
                        ctx.arc(50,430-Height-Jump,20,0,2*Math.PI);
                        ctx.stroke();
                    } else {
                        var Img = new Image();
                        Img.src = Src;
			xs = 85, ys = 102
                        ctx.drawImage(Img,(Index%6)*xs,(Math.floor(Index/6))*ys,xs,ys,30,410-Height-Jump,40,40);
                    }
                }

                var grd=ctx.createLinearGradient(0,450,0,600);
                grd.addColorStop(0,"black");
                grd.addColorStop(1,"gray");

                if(Speed>TopSpeed) TopSpeed = Speed;
                if(Distance>TopDst) TopDst = Distance;

                // Fill with gradient
                ctx.fillStyle=grd;
                ctx.fillRect(0,450,1000,150);

                ctx.font="35px Arial";
                ctx.fillStyle="#CCCCCC";
                ctx.fillText("Distance run: "+(Math.round(Distance))+" meters",40,500);

                ctx.font="35px Arial";
                ctx.fillStyle="#CCCCCC";
                ctx.fillText("Speed: "+(Math.round(Speed*10)/10)+" mph",40,560);

                ctx.font="35px Arial";
                ctx.fillStyle="#44FF44";
                ctx.fillText("Longest run: "+(Math.round(TopDst))+" meters",500,500);

                ctx.font="35px Arial";
                ctx.fillStyle="#44FF44";
                ctx.fillText("Top Speed: "+(Math.round(TopSpeed*10)/10)+" mph",500,560);
            }
        </script>
    </head>
    <body onload="setInterval(function(){addBlocks()},2000);setInterval(function(){update()},time*100);" onkeydown="keyPress(event)">
        <h1>The Run, by <b>Nate</b> v(1.1)</h1>
        <canvas id="canvas" width="1000px" height="600px" style="border:1px solid #000000;"></canvas>
        <p><b>Record:</b><br />
        <pre>
        #1      (203m, 46.4mph) by Nate
        #2      (36m, 16mph) by Blake Leonard
        #3      ...
        </pre>
    </body>
</html>
