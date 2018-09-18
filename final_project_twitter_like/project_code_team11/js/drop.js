



	
var isShowingNewDrop = false;




$(document).ready(function(){


		var newDropView = $("#newDropItems");
		$("#exit").click(function(){
			if(isShowingNewDrop){
				newDropView.removeClass(newDropView.attr('class'));
				newDropView.addClass("black hideNewDrop");
				isShowingNewDrop = false;
			}
		})

		$("#newDrop").click(function(){
			console.log("hello");
			if(isShowingNewDrop){
				newDropView.removeClass(newDropView.attr('class'));
				newDropView.addClass("black hideNewDrop");
				isShowingNewDrop = false;
			}else{
				newDropView.removeClass(newDropView.attr('class'));
				newDropView.addClass("black showNewDrop");
				isShowingNewDrop = true;
			}

		})

		$("#dropTag-1").click(function(){
			$("#tagValue").attr('value','1');
		})
		$("#dropTag-2").click(function(){
			$("#tagValue").attr('value','2');
		})
		$("#dropTag-3").click(function(){
			$("#tagValue").attr('value','3');
		})

			
		

	
});


