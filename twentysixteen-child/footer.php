<div id="footer">
		<div class="container">
		<div class="row mobile-hide">
			<div class="col-md-6">
				<div class="infobox">
					<table>
						<tr>
							<td><img src="<?php echo get_stylesheet_directory_uri();?>/images/truck.png" /></td>
							<td>
								<h4>Free Shipping</h4>
								<p>Free shipping to Multiple Locations everyday at 5:00 PM</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<div class="infobox">
					<table>
						<tr>
							<td><img src="<?php echo get_stylesheet_directory_uri();?>/images/cell.png" /></td>
							<td>
								<h4>Call us: (800) 2345-6789</h4>
								<p>Call us anytime if you have any questions.</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<p>&copy; 2016, designed and developed by <a style="color:#FFA811;" href="//369usa.com">369USA.COM</a> & <a style="color:#FFA811;" href="//ny1hotel.com">纽约家庭旅馆</a>. All right reserved.</p>
		</div>
	</div><!-- FOOTER -->
	
	
	<!-- Cart Modal -->
	<div id="cartModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-header">
			<p>
			<img style="cursor:pointer;" onclick="window.location='<?php echo get_site_url();?>/mycart';" src="<?php echo get_stylesheet_directory_uri();?>/images/shoppingcart.png">
			Mini Shopping Cart
			</p>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-main">
			<div class="success-added">Added successfully!</div>
			<div class="fail-added"></div>
			<div id="zz_cart_2">
				<div class="loader">
					<img src="<?php echo get_stylesheet_directory_uri();?>/images/loading.gif" />
				</div>
			</div>
			<div id="checkout-btn">
				<button onclick="window.location='<?php echo get_site_url();?>/mycart';" class="btn btn-warning">Check Out</button>
			</div>
		</div>
	  </div>
	</div>
	
	<script>
	$(document).ready(function(){
	
		$('button.add').click(function(){
			
			var cartAction = [];
			var obj = {
				type : 'ADD',
				var1 : $(this).data('itemid'),
				var2 : $(this).closest('.item').find('input[name="qty"]').val()
			};
			cartAction[0] = obj;
			var cartActionJson = JSON.stringify(cartAction);
			
			$("#cartModal").modal();
			$('#zz_cart_2').html('<div class="loader">'
					+'<img src="<?php echo get_stylesheet_directory_uri();?>/images/loading.gif" />'
				+'</div>');
			// This does the ajax request to get server data:
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				data: {
					'action':'actions_cart_ajax_request',
					 'cartActions':cartActionJson
				},
				success:function(data) {
					
					//Display Cart:
					$.ajax({
						url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
						data: {
							'action':'load_cart_ajax_request'
						},
						success:function(data) {
							// This outputs the result of the ajax request
							$('#zz_cart_2').html(data);
						},
						error: function(errorThrown){
							console.log('error:'+errorThrown);
						}
					});
					
				},
				error: function(errorThrown){
					console.log('error:'+errorThrown);
				}
			}); 
		});//END
		
		$('body').on('click','#zz_cart_2 .zcart-remove',function(){
		
			var cartAction = [];
			var obj = {
				type : 'REMOVE',
				var1 : $(this).closest('tr').data('productid'),
			};
			cartAction[0] = obj;
			var cartActionJson = JSON.stringify(cartAction);
			
			$('#zz_cart_2').html('<div class="loader">'
					+'<img src="<?php echo get_stylesheet_directory_uri();?>/images/loading.gif" />'
				+'</div>');
			// This does the ajax request to get server data:
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				data: {
					'action':'actions_cart_ajax_request',
					 'cartActions':cartActionJson
				},
				success:function(data) {
					
					//Display Cart:
					$.ajax({
						url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
						data: {
							'action':'load_cart_ajax_request'
						},
						success:function(data) {
							// This outputs the result of the ajax request
							$('#zz_cart_2').html(data);
						},
						error: function(errorThrown){
							console.log('error:'+errorThrown);
						}
					});
					
				},
				error: function(errorThrown){
					console.log('error:'+errorThrown);
				}
			}); 
		});//END
		
		$('body').on('click','#mycart .zcart-remove',function(){

			var cartAction = [];
			var obj = {
				type : 'REMOVE',
				var1 : $(this).closest('tr').data('productid'),
			};
			cartAction[0] = obj;
			var cartActionJson = JSON.stringify(cartAction);
			
			$('#mycart').html('<div class="loader">'
					+'<img src="<?php echo get_stylesheet_directory_uri();?>/images/loading.gif" />'
				+'</div>');
			// This does the ajax request to get server data:
			$.ajax({
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				data: {
					'action':'actions_cart_ajax_request',
					 'cartActions':cartActionJson
				},
				success:function(data) {
					
					//Display Cart:
					$.ajax({
						url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
						data: {
							'action':'load_cart_ajax_request'
						},
						success:function(data) {
							// This outputs the result of the ajax request
							$('#mycart').html(data);
						},
						error: function(errorThrown){
							console.log('error:'+errorThrown);
						}
					});
					
				},
				error: function(errorThrown){
					console.log('error:'+errorThrown);
				}
			}); 
		});//END
		
	});
	</script>
	
	<?php wp_footer();?>
	
	<div id="processing">
		<img src="<?php echo get_stylesheet_directory_uri();?>/images/processing.gif" />
	</div>
	
</body>	
	
