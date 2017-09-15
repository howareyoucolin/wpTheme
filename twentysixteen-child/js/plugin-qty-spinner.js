jQuery(document).ready(function($){

	$('.zz_plus').click(function(e){

		var qty = $(this).closest('.zcart').find('input[name="quantity"]').val();
		$(this).closest('.zcart').find('input[name="quantity"]').val(qty*1+1*1);
		
		e.preventDefault();
		return false;
		
	});

	$('.zz_minus').click(function(e){
	
		var qty = $(this).closest('.zcart').find('input[name="quantity"]').val();
		if(qty > 1){
			$(this).closest('.zcart').find('input[name="quantity"]').val(qty*1-1*1);
		}else{
			//DO NOTHING;
		}
		
		e.preventDefault();
		return false;
		
	});

});
	