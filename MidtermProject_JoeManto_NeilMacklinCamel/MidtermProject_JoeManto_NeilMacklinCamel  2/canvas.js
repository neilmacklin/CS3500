
var canvas = document.querySelector('canvas');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
var c = canvas.getContext('2d');

var numCicles = 10;

var colors = [new CANColor(255,235,59,1),
			  new CANColor(66,65,245,1),
			  new CANColor(255,112,67,1),
			  new CANColor(120,144,156,1),
			  new CANColor(255,167,38,1),
			  new CANColor(102,187,106,1)
			  ];

var mouse = {
	x: undefined,
	y: undefined
}

var c1 = new Circle(window.innerWidth/2,innerHeight/2,10,30);



function CANColor(r,g,b,a){
    this.r = r;
    this.g = g;
    this.b = b;
    this.a = a;
    this.getColor = function(){
        return "rgba("+this.r+","+this.g+","+this.b+","+this.a+")";
    }
}

function Circle(x,y,dy,size){

	this.dy = dy;
	this.x = x;
	this.y = y;
	this.size = size;
	var dx = 0;
	var grav = 1;
	var fric = 1;
	var color = colors[getRandomWithRange(0,colors.length-1)];

    this.draw = function(){
    	c.fillStyle = color.getColor();
    	c.arc(this.x, this.y, this.size, 0, 2 * Math.PI, false);
    	c.fill();
   		
    }
    this.update = function(){

    	if(this.x - this.size < 0){
    		dx = 2;
    	}else if(this.x+this.size > innerWidth){
    		dx = -2;
    	}
    
    	if(this.y+this.size >= canvas.height){
    		this.dy = -this.dy * fric;
   			dx = getRandomWithRange(-2,2);
    	}else{
    		this.dy+=grav;
    	}
    	this.y += this.dy;
    	this.x += dx;
  
        color.a = this.y/700;
 
        color.r = 255;
        color.g = 255;
        color.b = 255;

    	this.draw();

    }

    this.changeColor = function(){
    	color = colors[getRandomWithRange(0,colors.length-1)];
    }

    this.scale = function(sacleFactor){
    	if(mouse.x > this.x - this.size && mouse.x < this.x + this.size+20){
    		if(mouse.y > this.y - this.size && mouse.y < this.y + this.size+20){
    			if(this.size < 100){
    				this.sacleFactor = sacleFactor;
					this.size+=this.sacleFactor;
				}
    		}
    	}
    }
}

 window.addEventListener('mousemove', function(e) {
  		mouse.x = e.x;
  		mouse.y = e.y;
  });

 window.addEventListener('resize',function(e){

 	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
 	circles = [];
 	for(var i = 0;i<numCicles;i++){
		circles.push(new Circle(getRandomWithRange(50,innerWidth-50),getRandomWithRange(50,innerHeight-200),10,30));
	}

 });
 window.addEventListener('mouseup', function(e) {
  		c1.changeColor();
  });


function getRandomWithRange(min,max){
	return Math.floor(Math.random()*(max-min+1)+min);
}

var circles = [];

for(var i = 0;i<numCicles;i++){
	circles.push(new Circle(getRandomWithRange(50,innerWidth-50),getRandomWithRange(50,innerHeight-200),60,60));
}


function animate(){
	requestAnimationFrame(animate);
	
	c.clearRect(0,0,innerWidth,innerHeight);
	for(var i = 0;i<numCicles;i++){
		c.beginPath();
		circles[i].update();
	}


}

animate();