<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

	<div class="col-md-2 item">
					<a href="<?php the_permalink();?>"><img src="<?php echo the_post_thumbnail_url('thumbnail');?>" /></a>
					<p class="title"><?php the_title();?></p>
					<p class="price">$<?php echo number_format($product->get_regular_price(),2);?>/<?php echo get_field('price_unit');?></p>
						<?php if ( $product->is_in_stock() ) : ?>

						<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

						<form class="cart zcart mobile-only" method="post" enctype='multipart/form-data'>
							<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
							<button class="minus zz_minus"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
							<?php
							/*
								if ( ! $product->is_sold_individually() ) {
									woocommerce_quantity_input( array(
										'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
										'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
										'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
									) );
								}
							*/
							?>
							<input class="qty" type="text" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric">
							<button class="plus zz_plus"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>

							<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

							<div class="clr"></div>
							
							<button type="submit" class="btn btn-default single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

							<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
						</form>

						<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

						<?php endif; ?>
				
					<div class="mobile-only divide-line"></div>
					<div class="item-pop">
						<a href="<?php the_permalink();?>"><img src="<?php echo the_post_thumbnail_url('thumbnail');?>" /></a>
						<p class="title"><?php the_title();?></p>
						<p class="price">$<?php echo number_format($product->get_regular_price(),2);?>/<?php echo get_field('price_unit');?></p>
						<div class="add-to-cart">
							<p>
								<?php if ( $product->is_in_stock() ) : ?>

								<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

								<form class="cart zcart" method="post" enctype='multipart/form-data'>
									<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
									<button class="minus zz_minus"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>
									<?php
									/*
										if ( ! $product->is_sold_individually() ) {
											woocommerce_quantity_input( array(
												'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
												'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
												'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
											) );
										}
									*/
									?>
									<input class="qty" type="text" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="[0-9]*" inputmode="numeric">
									<button class="plus zz_plus"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>

									<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

									<div class="clr"></div>
									
									<button type="submit" class="btn btn-warning single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

									<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
								</form>

								<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

								<?php endif; ?>
							</p>
							
						</div>
					</div>
					<div onclick="window.location='<?php the_permalink();?>';" class="view-details mobile-only"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
				</div><!-- ITEM -->
