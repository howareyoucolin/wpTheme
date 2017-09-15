<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>

<?php $user = wp_get_current_user(); ?>

<div class="woocommerce-billing-fields">

		<h3>Pick a Pick-up Location</h3>
		
		<?php $lines = preg_split('/<br[^>]*>/i', nl2br(get_option('zz_locations')));?>
		<?php foreach($lines AS $line): $line=trim($line);?> 
			<div class="radio">
			  <label><input type="radio" name="location" value="<?php echo $line;?>" ><?php echo $line;?></label>
			</div>
		<?php endforeach;?>

		
		<div class="clear"></div>

</div>

<div class="woocommerce-billing-fields">

		<h3><?php _e( 'Customer Details', 'woocommerce' ); ?></h3>

		<p class="form-row form-row-first" id="first_name_field"><label for="first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="first_name" id="first_name" placeholder="" value="<?php echo $user->firstname;?>"></p>
	
		<p class="form-row form-row-last" id="last_name_field"><label for="last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="last_name" id="last_name" placeholder="" value="<?php echo $user->lastname;?>"></p>
	
		<p class="form-row form-row-first" id="email_field"><label for="email" class="">Email Address <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="email" id="email" placeholder="" value="<?php echo $user->user_email;?>"></p>
	
		<p class="form-row form-row-last" id="phone_field"><label for="phone" class="">Phone <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="phone" id="phone" placeholder="" value="<?php echo $user->phone;?>"></p>
		
		<div class="clear"></div>

</div>
