$(document).ready(function(){


	//load imgs to memory
	var imgs = [new Image(), new Image()];
	imgs[0].src = "Icons/heart-filled.png";
	imgs[1].src = "Icons/heart_empty.png";


	//like button logic
	var likeFlag = [0,0,0,0];
	$("#btn-like-1").click(function(){
			if(likeFlag[0] == 0){
			$("#btn-like-1").html("");
			$("#btn-like-1").append("<img src = \"Icons/heart-filled.png\">");
			$("#btn-like-1").append(" 24");
			likeFlag[0] = 1;
		}else{
			$("#btn-like-1").html("");
			$("#btn-like-1").append("<img src = \"Icons/heart_empty.png\">");
			likeFlag[0] = 0;
		}
	});
		$("#btn-like-2").click(function(){
			if(likeFlag[1] == 0){
			$("#btn-like-2").html("");
			$("#btn-like-2").append("<img src = \"Icons/heart-filled.png\">");
			$("#btn-like-2").append(" 78");
			likeFlag[1] = 1;
		}else{
			$("#btn-like-2").html("");
			$("#btn-like-2").append("<img src = \"Icons/heart_empty.png\">");
			likeFlag[1] = 0;
		}
	});
	$("#btn-like-3").click(function(){
			if(likeFlag[2] == 0){
			$("#btn-like-3").html("");
			$("#btn-like-3").append("<img src = \"Icons/heart-filled.png\">");
			$("#btn-like-3").append(" 92");
			likeFlag[2] = 1;
		}else{
			$("#btn-like-3").html("");
			$("#btn-like-3").append("<img src = \"Icons/heart_empty.png\">");
			likeFlag[2] = 0;
		}
	});
	$("#btn-like-4").click(function(){
			if(likeFlag[3] == 0){
			$("#btn-like-4").html("");
			$("#btn-like-4").append("<img src = \"Icons/heart-filled.png\">");
			$("#btn-like-4").append(" 184");
			likeFlag[3] = 1;
		}else{
			$("#btn-like-4").html("");
			$("#btn-like-4").append("<img src = \"Icons/heart_empty.png\">");
			likeFlag[3] = 0;
		}
	});	

		var highest = 1;
		var lockFlag = false;
		getNumStars = function(){
			highest = 0;
			for(var i = 1;i<=5;i++){
				if($("#"+i+" img").attr("src")=="Icons/Star-filled.png"){
					highest++;
				}
			}
			if(highest == 0)
				highest = 1;
			return highest;
		}
		$("#rate-create").click(function(){
			lockFlag = !lockFlag;
			highest = getNumStars();
		})
		var childNodes = $("#rate-create").children();
		for(var i = 0; i < childNodes.length;i++){
			$("#"+childNodes[i].id).one().hover(function() {
				if(lockFlag == false){
					$("#"+this.id+" img").attr("src","Icons/Star-filled.png");
					for(var g = parseInt(this.id); g>=1;g--){
						$("#"+g+" img").attr("src","Icons/Star-filled.png");
					}
					for(var g = parseInt(this.id)+1; g<=5;g++){
						$("#"+g+" img").attr("src","Icons/Star-empty.png");
					}
				}
			});
		}

		$("#review-btn").click(function(){
			var name = $("#reviewer-name").val();
			var input = $("#review-input").val();
			highest = getNumStars();
			if(name.length > 0 && input.length > 0){
				var appendString;
             	appendString = "<li><ul id = \"outerList\" class = \"outerList\"><li> <div class=\"review\"><ul class = \"rate\"><li><h4 class =\"name\" style=\"margin-right: 30px;\">"+name+"</h4></li>";
             	for(var g = 0;g<highest;g++){
             		appendString+="<li><img src = \"Icons/Star-filled.png\"></li>";
             	}
             	for(var g = 0;g<5-highest;g++){
             		appendString+="<li><img src = \"Icons/Star-empty.png\"></li>";
             	}
             	appendString+="</ul></div></li>  <li><p class = date>Date: 10/21/17 10:35 PM</p></li><li><p class = review-text>"+input+"</p></li> </ul></li>";
             	$("#fixed").append(appendString);
			}else{
				alert("please fill out the name and text fields")
			}
		});

		for(var i = 0; i < 4;i++){
			$()
		}

	$( window ).resize(function(){
		
	});

});


