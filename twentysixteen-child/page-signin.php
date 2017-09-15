<?php get_header();?>

	<div id="main">
	
		<div class="container">
		
		<?php wc_print_notices(); ?>
		
			<div id="hint" class="row">
				<div class="panel panel-info">
					<div class="panel-heading">
					Please login here.
					</div>
				</div>
			</div>
			
			<form method="post" class="login">

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="username"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<label for="dummy"></label>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
			</p>
			
			<p class="woocommerce-LostPassword lost_password">
				<label for="dummy"></label>
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>
			
			<p>
				<label for="dummy"></label>
			If you are not already a member, please <a href="<?php echo get_site_url();?>/signup">click here</a> to sign up.
			</p>

			</form>

		</div>		
	
	</div><!-- WRAP -->
	
<?php get_footer();?>