jQuery(document).ready(function(){
	
	//mobile screen:
	if ($(window).width() <= 768) {

		$( "input.qty" ).prop( "disabled", true );

		$( "#main .item >a>img").click(function(e){
			e.preventDefault();
			return false;
		});


	}


});