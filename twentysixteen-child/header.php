<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GriFresh</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<link rel="icon" href="img/favicon.ico" sizes="16x16">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<!-- fonts -->	
	<script src="<?php echo get_stylesheet_directory_uri();?>/js/plugin-qty-spinner.js"></script>
	<script src="<?php echo get_stylesheet_directory_uri();?>/js/mobile.js"></script>
	<?php wp_head();?>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/style.css?18" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/woo.css?8" />
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/mobile.css?1" />
	<script src="<?php echo get_stylesheet_directory_uri();?>/js/woo.js"></script>
</head>
<body>

	<div id="top" class="mobile-hide">
		<div id="overtop">
			<div class="container">
				<a href="<?php echo get_site_url();?>/about">About</a>
				<a href="<?php echo get_site_url();?>/contact">Contact</a>
				<a class="pull-right shopcart" href="<?php echo get_site_url();?>/cart"><img src="<?php echo get_stylesheet_directory_uri();?>/images/shoppingcart.png" /></a>
				<?php if(is_user_logged_in()):?>
					<a class="pull-right" href="<?php echo wp_logout_url( get_site_url() ); ?> ">Logout</a>
					<a class="pull-right" href="<?php echo get_site_url();?>/my-account">My Account</a>
				<?php else:?>
					<a class="pull-right" href="<?php echo get_site_url();?>/signup">Signup</a>
					<a class="pull-right" href="<?php echo get_site_url();?>/signin">Login</a>
				<?php endif;?>
			</div>
		</div><!-- OVERTOP -->
		
		<div class="container" class="mobile-hide">
			<div id="logo">
				<img onclick="window.location='<?php echo get_site_url();?>';" src="<?php echo get_stylesheet_directory_uri();?>/images/logoGri2.png" />
			</div>
			<!--<div id="searchbar">
				<input class="form-control" type="text" placeholder=" Search for ... " />
				<button class="btn btn-warning"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> </button>
			</div>-->
		</div>
		<div id="nav" class="mobile-hide">
			<div class="container">
				<ul>
				<li><a <?php if(is_page('home')) echo 'class="active"';?> href="<?php echo get_site_url();?>">Home</a></li>
				<?php

				$taxonomy     = 'product_cat';
				$orderby      = 'term_id';  
				$show_count   = 0;      // 1 for yes, 0 for no
				$pad_counts   = 0;      // 1 for yes, 0 for no
				$hierarchical = 1;      // 1 for yes, 0 for no  
				$title        = '';  
				$empty        = 0;

				$args = array(
					 'taxonomy'     => $taxonomy,
					 'orderby'      => $orderby,
					 'show_count'   => $show_count,
					 'pad_counts'   => $pad_counts,
					 'hierarchical' => $hierarchical,
					 'title_li'     => $title,
					 'hide_empty'   => $empty
				);
				$all_categories = get_categories( $args );
				foreach ($all_categories as $cat) {
					if($cat->category_parent == 0) {
						$category_id = $cat->term_id;       
						echo '<li><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>';
					}       
				}
				?>
				</ul>
			</div>
		</div>
		
	</div><!-- TOP -->
	
	<div id="m-nav" class="mobile-only">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <img onclick="window.location='<?php echo get_site_url();?>';" src="<?php echo get_stylesheet_directory_uri();?>/images/logoGri2.png" />
			</div>
			<div>
			<ul>
			  <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<span class="glyphicon glyphicon-search icon" aria-hidden="true"></span>
					<span class="explain">Categories</span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo get_site_url();?>/shop">All</a></li>
				  <?php

					$taxonomy     = 'product_cat';
					$orderby      = 'term_id';  
					$show_count   = 0;      // 1 for yes, 0 for no
					$pad_counts   = 0;      // 1 for yes, 0 for no
					$hierarchical = 1;      // 1 for yes, 0 for no  
					$title        = '';  
					$empty        = 0;

					$args = array(
						 'taxonomy'     => $taxonomy,
						 'orderby'      => $orderby,
						 'show_count'   => $show_count,
						 'pad_counts'   => $pad_counts,
						 'hierarchical' => $hierarchical,
						 'title_li'     => $title,
						 'hide_empty'   => $empty
					);
					$all_categories = get_categories( $args );
					foreach ($all_categories as $cat) {
						if($cat->category_parent == 0) {
							$category_id = $cat->term_id;       
							echo '<li><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a></li>';
						}       
					}
					?>
				</ul>
			  </li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-plus icon" aria-hidden="true"></span>
						<span class="explain">More</span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo get_site_url();?>/about">About</a></li>
						<li><a href="<?php echo get_site_url();?>/contact">Contact</a></li>
						<?php if(is_user_logged_in()):?>
							<li><a href="<?php echo wp_logout_url( get_site_url() ); ?> ">Logout</a></li>
							<li><a href="<?php echo get_site_url();?>/my-account">My Account</a></li>
						<?php else:?>
							<li><a href="<?php echo get_site_url();?>/signup">Signup</a></li>
							<li><a href="<?php echo get_site_url();?>/signin">Login</a></li>
						<?php endif;?>
					</ul>
				  </li>
				
				 <li><a href="<?php echo get_site_url();?>/cart">
					<span class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/images/shoppingcart.png" /></span>
					<span class="explain">My Cart</span></a>
				</li>
			  
			</ul>
			</div>
		  </div>
		</nav>
	</div>
	
	<div id="m-nav-dummy" class="mobile-only">
		<!-- I am an empty dummy-->
	</div>
	