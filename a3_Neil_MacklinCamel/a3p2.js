$(document).ready(function () {

	$('#signMeUp').click(function()
	{
    	if( !$('#firstName').val() ) {
        	$('#firstNameLabel').css('color', 'red');
  			$('#firstNameLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#lastName').val() ) {
        	$('#lastNameLabel').css('color', 'red');
  			$('#lastNameLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#email').val() ) {
        	$('#emailLabel').css('color', 'red');
  			$('#emailLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#pass1').val() ) {
        	$('#pass1Label').css('color', 'red');
  			$('#pass1Label').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( $('#pass1').val().length < 6 || $('#pass1').val().length > 12) {
    		alert('password must be 6 - 12 characters');
        	$('#pass2Label').css('color', 'red');
  			$('#pass2Label').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#pass2').val() ) {
        	$('#pass2Label').css('color', 'red');
  			$('#pass2Label').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if ($("#pass1").val() != $("#pass2").val()) {
    		alert('passwords do not match!');
    		$('#pass1Label').css('color', 'red');
  			$('#pass1Label').css('font-style', 'italic');
  			$('#pass2Label').css('color', 'red');
  			$('#pass2Label').css('font-style', 'italic');
    		stopSubmit();
    	}
    	if( !$('#address').val() ) {
        	$('#addressLabel').css('color', 'red');
  			$('#addressLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#city').val() ) {
        	$('#cityLabel').css('color', 'red');
  			$('#cityLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#state').val() ) {
        	$('#stateLabel').css('color', 'red');
  			$('#stateLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#zip').val() ) {
        	$('#zipLabel').css('color', 'red');
  			$('#zipLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#phone').val() ) {
        	$('#phoneLabel').css('color', 'red');
  			$('#phoneLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	if( !$('#date').val() ) {
        	$('#dateLabel').css('color', 'red');
  			$('#dateLabel').css('font-style', 'italic');
  			stopSubmit();
    	}
    	$('#terms').change(function () {
    		$('#signMeUp').prop("disabled", !this.checked);
		}).change()
    	
	});    
});


function stopSubmit() {
	$("form").submit(function(e){
        e.preventDefault(e);
    });
}