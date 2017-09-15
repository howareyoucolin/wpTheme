<?php

function zz_get_customer_summary($order_id){
	GLOBAL $wpdb;
	$customer_output = '';
	$sql = "
		SELECT * FROM zz_woocommerce_orders
		WHERE OrderId = '$order_id'
	";
	$result = $wpdb->get_row($sql);
	$customer_output .= '<table width="100%" cellpadding="10" style="border:1px solid #DDDDDD;border-collapse: collapse; border-spacing: 0">';
	$customer_output .= '<tr height="45">';
	$customer_output .= '<td width="30%">';
	$customer_output .= 'Pickup Location';
	$customer_output .= '</td>';
	$customer_output .= '<td width="70%">';
	$customer_output .= $result->PickUpLocation;
	$customer_output .= '</td>';
	$customer_output .= '</tr>';
	$customer_output .= '<tr height="45">';
	$customer_output .= '<td width="30%">';
	$customer_output .= 'First Name';
	$customer_output .= '</td>';
	$customer_output .= '<td width="70%">';
	$customer_output .= $result->Firstname;
	$customer_output .= '</td>';
	$customer_output .= '</tr>';
	$customer_output .= '<tr height="45">';
	$customer_output .= '<td width="30%">';
	$customer_output .= 'Last Name';
	$customer_output .= '</td>';
	$customer_output .= '<td width="70%">';
	$customer_output .= $result->Lastname;
	$customer_output .= '</td>';
	$customer_output .= '</tr>';
	$customer_output .= '<tr height="45">';
	$customer_output .= '<td width="30%">';
	$customer_output .= 'Phone Number';
	$customer_output .= '</td>';
	$customer_output .= '<td width="70%">';
	$customer_output .= $result->Phone;
	$customer_output .= '</td>';
	$customer_output .= '</tr>';
	$customer_output .= '<tr height="45">';
	$customer_output .= '<td width="30%">';
	$customer_output .= 'Email Address';
	$customer_output .= '</td>';
	$customer_output .= '<td width="70%">';
	$customer_output .= $result->Email;
	$customer_output .= '</td>';
	$customer_output .= '</tr>';
	$customer_output .= '</table>';
	return $customer_output;
}

function zz_get_order_summary($order_id){
	$order_output = '';
	$order = new WC_Order($order_id);
	$order_items = $order->get_items();
	$order_output .= '<table width="100%" cellpadding="10" style="border:1px solid #DDDDDD;border-collapse: collapse; border-spacing: 0">';
	foreach( $order_items as $item ) {
		$order_output .= '<tr height="45">';
		$order_output .= '<td width="50%">';
		$order_output .= $item['name'];
		$order_output .= '</td>';
		$order_output .= '<td width="25%">';
		$order_output .= $item['qty'];
		$order_output .= '</td>';
		$order_output .= '<td width="25%">';
		$order_output .= '$'.sprintf('%0.2f',$order->get_item_total( $item ));
		$order_output .= '</td>';
		$order_output .= '</tr>';	
	}
	$order_output .= '<tr height="45">';
	$order_output .= '<td width="50%">';
	$order_output .= '</td>';
	$order_output .= '<td width="25%">';
	$order_output .= '</td>';
	$order_output .= '<td width="25%">';
	$order_output .= '$'.sprintf('%0.2f',$order->get_total());
	$order_output .= '</td>';
	$order_output .= '</tr>';
	$order_output .= '</table>';
	return $order_output;
}

remove_action( 'woocommerce_before_main_content', 
            'woocommerce_breadcrumb', 20 );
 
remove_action( 'woocommerce_single_product_summary', 
            'woocommerce_template_single_meta', 40 );
 
 
function custom_breadcrumb(){
	
	GLOBAL $post;
	echo '
	<ol class="breadcrumb">
		<li><a href="'.get_site_url().'">Home</a></li>
		<li class="active">'.get_the_title().'</li>
	</ol>';
	
}
add_action( 'woocommerce_before_main_content', 
            'custom_breadcrumb', 20 );
  
function custom_single_product_description(){
	
	GLOBAL $post;
	echo get_the_content();

}
add_action( 'woocommerce_single_product_summary', 
           'custom_single_product_description', 7 );
		   
//Override registration processor:
function custom_process_registration() {
	$nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
	$nonce_value = isset( $_POST['woocommerce-register-nonce'] ) ? $_POST['woocommerce-register-nonce'] : $nonce_value;

	if ( ! empty( $_POST['zregister'] ) && wp_verify_nonce( $nonce_value, 'woocommerce-register' ) ) {
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$firstname = trim($_POST['firstname']);
		$lastname = trim($_POST['lastname']);
		$phone = trim($_POST['phone']);
		$email    = $_POST['email'];

		try {
			$validation_error = new WP_Error();
			$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );

			if ( $validation_error->get_error_code() ) {
				throw new Exception( $validation_error->get_error_message() );
			}
			
			//Firstname & Lastname & Phone check:
			if($firstname == ''){
				throw new Exception( 'First name is required.' );
			}
			if($lastname == ''){
				throw new Exception( 'Last name is required.' );
			}
			if($phone == ''){
				throw new Exception( 'Phone number is required.' );
			}
			
			//Password mini length:
			if(strlen($password) < 8){
				throw new Exception( 'Password must be at least 8 characters long.' );
			}
			
			//Check if passwords match:
			if($password !== $password2){
				throw new Exception( 'Passwords do not match.' );
			}

			$user_id = $new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

			if ( is_wp_error( $new_customer ) ) {
				throw new Exception( $new_customer->get_error_message() );
			}

			if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
				wc_set_customer_auth_cookie( $new_customer );
			}
			
			if($user_id){
				
				$firstname   = esc_sql( wc_clean($firstname) );
				$lastname   = esc_sql( wc_clean($lastname) );
				$phone   = esc_sql( wc_clean($phone) );
				
				//Set Firstname & Lastname & Phone:
				GLOBAL $wpdb;
				$sql = "
					UPDATE wp_users 
					SET firstname = '$firstname', lastname = '$lastname', phone = '$phone' 
					WHERE ID = '$user_id'
					";
				$wpdb->query( $sql );
				
			}

			wp_safe_redirect( apply_filters( 'woocommerce_registration_redirect', wp_get_referer() ? wp_get_referer() : wc_get_page_permalink( 'myaccount' ) ) );
			exit;

		} catch ( Exception $e ) {
			wc_add_notice( '<strong>' . __( 'Error', 'woocommerce' ) . ':</strong> ' . $e->getMessage(), 'error' );
		}
	}
}
add_action( 'init', 
            'custom_process_registration', 10 );
			
/**
 * Save the password/account details and redirect back to the my account page.
 */
function custom_save_account_details() {

	if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
		return;
	}

	if ( empty( $_POST[ 'action' ] ) || 'custom_save_account_details' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'custom_save_account_details' ) ) {
		return;
	}

	$errors       = new WP_Error();
	$user         = new stdClass();

	$user->ID     = (int) get_current_user_id();
	$current_user = get_user_by( 'id', $user->ID );

	if ( $user->ID <= 0 ) {
		return;
	}

	$account_first_name = ! empty( $_POST['account_first_name'] ) ? wc_clean( $_POST['account_first_name'] ) : '';
	$account_last_name  = ! empty( $_POST['account_last_name'] ) ? wc_clean( $_POST['account_last_name'] ) : '';
	$account_email      = ! empty( $_POST['account_email'] ) ? wc_clean( $_POST['account_email'] ) : '';
	$account_phone      = ! empty( $_POST['account_phone'] ) ? wc_clean( $_POST['account_phone'] ) : '';
	$pass_cur           = ! empty( $_POST['password_current'] ) ? $_POST['password_current'] : '';
	$pass1              = ! empty( $_POST['password_1'] ) ? $_POST['password_1'] : '';
	$pass2              = ! empty( $_POST['password_2'] ) ? $_POST['password_2'] : '';
	$save_pass          = true;

	$user->first_name   = $account_first_name;
	$user->last_name    = $account_last_name;
	$user->phone    = $account_phone;
	$user->email    = $account_email;

	// Prevent emails being displayed, or leave alone.
	$user->display_name = is_email( $current_user->display_name ) ? $user->first_name : $current_user->display_name;

	// Handle required fields
	$required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
		'account_first_name' => __( 'First Name', 'woocommerce' ),
		'account_last_name'  => __( 'Last Name', 'woocommerce' ),
		'account_email'      => __( 'Email address', 'woocommerce' ),
		'account_phone'      => __( 'Phone Number', 'woocommerce' ),
	) );

	foreach ( $required_fields as $field_key => $field_name ) {
		if ( empty( $_POST[ $field_key ] ) ) {
			wc_add_notice( '<strong>' . esc_html( $field_name ) . '</strong> ' . __( 'is a required field.', 'woocommerce' ), 'error' );
		}
	}

	if ( $account_email ) {
		$account_email = sanitize_email( $account_email );
		if ( ! is_email( $account_email ) ) {
			wc_add_notice( __( 'Please provide a valid email address.', 'woocommerce' ), 'error' );
		} elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
			wc_add_notice( __( 'This email address is already registered.', 'woocommerce' ), 'error' );
		}
		$user->user_email = $account_email;
	}

	if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( __( 'Please fill out all password fields.', 'woocommerce' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
		wc_add_notice( __( 'Please enter your current password.', 'woocommerce' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && strlen( $pass1 ) < 8 ) {
		wc_add_notice( __( 'Password must be at least 8 characters long.', 'woocommerce' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( __( 'Please re-enter your password.', 'woocommerce' ), 'error' );
		$save_pass = false;
	} elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
		wc_add_notice( __( 'New passwords do not match.', 'woocommerce' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
		wc_add_notice( __( 'Your current password is incorrect.', 'woocommerce' ), 'error' );
		$save_pass = false;
	}

	if ( $pass1 && $save_pass ) {
		$user->user_pass = $pass1;
	}

	// Allow plugins to return their own errors.
	do_action_ref_array( 'woocommerce_save_account_details_errors', array( &$errors, &$user ) );

	if ( $errors->get_error_messages() ) {
		foreach ( $errors->get_error_messages() as $error ) {
			wc_add_notice( $error, 'error' );
		}
	}

	if ( wc_notice_count( 'error' ) === 0 ) {

		wp_update_user( $user ) ;
		
		GLOBAL $wpdb;
		
		//Custom SQL:
		$sql = "
			UPDATE wp_users
			SET firstname = '$user->first_name', lastname = '$user->last_name', phone = '$user->phone'
			WHERE ID = '$user->ID'
		";
		$wpdb->query($sql);

		wc_add_notice( __( 'Account details changed successfully.', 'woocommerce' ) );

		do_action( 'woocommerce_save_account_details', $user->ID );

		wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
		exit;
	}
}
add_action( 'init', 
		'custom_save_account_details', 10 );			
		
		
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	GLOBAL $wpdb;
	$id = $order->id;
	$sql = "
		SELECT * FROM zz_woocommerce_orders
		WHERE OrderId = '$id'
	";
	$result = $wpdb->get_row($sql);
	echo '<p><b>Firstname :</b><br>'.$result->Firstname.'</p>';
	echo '<p><b>Lastname :</b><br>'.$result->Lastname.'</p>';
	echo '<p><b>Phone :</b><br>'.$result->Phone.'</p>';
	echo '<p><b>Email :</b><br>'.$result->Email.'</p>';
	echo '<p><b>Pick Up Location :</b><br>'.$result->PickUpLocation.'</p>';
}		
