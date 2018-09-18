

$(document).ready(function(){

	$("#SignUp").click(function(){
		var canSignUp = checkSignUpValues();
		console.log(canSignUp);
		if(canSignUp){
			$("#canSignUp").attr('value','1');
			$("#canSignIn").attr('value','0');
			$("#userForm").submit();
		}
	});
	$("#SignIn").click(function(){
        var canSignIn = checkSignInValues();
        
        if(canSignIn){
        	$("#canSignIn").attr('value','1');
        	$("#canSignUp").attr('value','0');
        	$("#userForm").submit();
        }
   	 }); 
	
	for(var i = 1;i<=6;i++){
		$("#textField-"+i).click(function(){
			$(this).removeClass($(this).attr('class'));
			$(this).addClass("strech");
		})
		$("#textField-"+i).mouseover(function(){
			$(this).removeClass($(this).attr('class'));
			$(this).addClass("strech");
			
		})
		$("#textField-"+i).mouseleave(function(){
			if($(this).val() == "" && !$(this).is(":focus")){
				$(this).removeClass($(this).attr('class'));
				$(this).addClass("shrink");
			}
		})
	}
});


checkSignInValues = function(){
	var canSign = true;
	if($("#textField-1").val().length == 0){
		addError("#textField-1");
		canSign = false;
	}
	if($("#textField-2").val().length == 0){
		addError("#textField-2");
		canSign = false;
	}
	return canSign;
}

checkSignUpValues = function(){

	var canSign = true;

	if(($("#textField-3").val().length == 0) || $("#textField-5").val().length == 0){
		addError("#textField-3");
		canSign = false;
	}

	//passwords matching
	if($("#textField-5").val() != $("#textField-6").val()){
		addError("#textField-5");
		addError("#textField-6");
		canSign = false;
	}

	//email
	var emailField = $("#textField-4").val();
	if(!( (emailField.indexOf('.') != -1) && (emailField.indexOf('@') != -1) )){

		addError("#textField-4");
		canSign=false;
	}

	return canSign
}

function addError(id){

	$(''+id).css({
		"color":"#FF5757",
		"font-style": "italic",
		"border-bottom": "solid 1px #FF5757"
	});
}