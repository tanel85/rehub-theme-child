<?php
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

function enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/assets/jquery-ui-timepicker-addon.js', array(), false, true );
    wp_enqueue_style('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/assets/jquery-ui-timepicker-addon.css',array());
    wp_enqueue_style('jquery-ui',get_stylesheet_directory_uri().'/css/jquery-ui.css',array());
}

add_action( 'dokan_enqueue_scripts', 'enqueue_dokan_scripts', 31 );

function enqueue_dokan_scripts() {
    wp_enqueue_style( 'dokan-social-style' );
    wp_enqueue_style( 'dokan-social-theme-flat' );
}

if ( ! class_exists( 'Dokan_Pro_Settings' ) ) {
	require_once DOKAN_PRO_DIR . '/classes/settings.php';
}

define( 'ELESSI_CHILD_DIR', dirname( __FILE__ ) );
require_once ELESSI_CHILD_DIR . '/settings/seller-services/functions.php';
require_once ELESSI_CHILD_DIR . '/settings/orders/order-functions.php';
require_once ELESSI_CHILD_DIR . '/registration-functions.php';
require_once ELESSI_CHILD_DIR . '/product-functions.php';
require_once ELESSI_CHILD_DIR . '/store/store-functions.php';
require_once ELESSI_CHILD_DIR . '/checkout/checkout-functions.php';
require_once ELESSI_CHILD_DIR . '/store-list/store-list-functions.php';

// Override elementor Menu_Cart widget to open the Elessi sidebar
add_action( 'elementor/widget/render_content', function( $content, $widget ) {
    if ( 'woocommerce-menu-cart' === $widget->get_name() ) {
        if ( null === WC()->cart ) {
            return '';
        }
        $product_count = WC()->cart->get_cart_contents_count();
        $sub_total = WC()->cart->get_cart_subtotal();
        $counter_attr = 'data-counter="' . $product_count . '"';
        $content =
            '<div class="elementor-menu-cart__wrapper">'.
            	'<div class="elementor-menu-cart__toggle elementor-button-wrapper">'.
			        '<a id="elementor-menu-cart__toggle_button1" href="javascript:void(0)" rel="nofollow" class="add_to_cart_button">'.
                        '<span class="elementor-button-text">'.$sub_total.'</span>'.
                        '<span class="elementor-button-icon" '.$counter_attr.'>'.
                            '<i class="eicon" aria-hidden="true"></i>'.
                        '</span>'.
                    '</a>'.
                '</div>'.
            '</div>'
        ;
    }
    return $content;
}, 10, 2 );


//save the field value
add_action( 'dokan_store_profile_saved', 'save_extra_fields', 15 );
function save_extra_fields( $store_id ) {
    $dokan_settings = dokan_get_store_info($store_id);
    if ( isset( $_POST['min_order'] ) ) {
        $dokan_settings['min_order'] = $_POST['min_order'];
    }
    if ( isset( $_POST['min_reservation_time_open'] ) ) {
        $dokan_settings['min_reservation_time_open'] = $_POST['min_reservation_time_open'];
    }
    if ( isset( $_POST['min_reservation_time_closed'] ) ) {
        $dokan_settings['min_reservation_time_closed'] = $_POST['min_reservation_time_closed'];
    }
    if ( isset( $_POST['main_user_name'] ) ) {
        $dokan_settings['main_user_name'] = $_POST['main_user_name'];
    }
    if ( isset( $_POST['contact_email'] ) ) {
        $dokan_settings['contact_email'] = $_POST['contact_email'];
    }
	if ( isset( $_POST['official_name'] ) ) {
		$dokan_settings['official_name'] = $_POST['official_name'];
	}
	if ( isset( $_POST['reg_code'] ) ) {
		$dokan_settings['reg_code'] = $_POST['reg_code'];
	}
	$dokan_settings['address']['country'] = 'EE';
    $dokan_settings['live_chat'] = 'yes';
    $dokan_settings['dokan_store_time_enabled'] = 'yes';
    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}

/**
 * Add or modify States
 */
add_filter( 'woocommerce_states', 'custom_woocommerce_states' );

function custom_woocommerce_states( $states ) {

  $states['EE'] = array(
    'EE10' => 'Tallinn',
    'EE11' => 'Harju maakond',
    'EE20' => 'Tartu linn',
    'EE21' => 'Tartu maakond',
    'EE30' => 'Ida-Viru maakond',
    'EE40' => 'Pärnu maakond',
    'EE50' => 'Lääne-Viru maakond',
    'EE60' => 'Viljandi maakond',
    'EE70' => 'Rapla maakond',
    'EE80' => 'Võru maakond',
    'EE90' => 'Saare maakond',
    'EE100' => 'Jõgeva maakond',
    'EE110' => 'Järva maakond',
    'EE120' => 'Valga maakond',
    'EE130' => 'Põlva maakond',
    'EE140' => 'Lääne maakond',
    'EE150' => 'Hiiu maakond'
  );

  return $states;
}

function dokan_seller_address_fields_custom( $verified = false, $required = false ) {

	$disabled = $verified ? 'disabled' : '';

	/**
	 * Filter the seller Address fields
	 *
	 * @since 2.2
	 *
	 * @param array $dokan_seller_address
	 */
	$seller_address_fields = apply_filters( 'dokan_seller_address_fields', array(
			'street_1' => array(
				'required' => $required ? 1 : 0,
			),
			'city'     => array(
				'required' => $required ? 1 : 0,
			),
			'zip'      => array(
				'required' => $required ? 1 : 0,
			),
			'state'    => array(
				'required' => $required ? 1 : 0,
			),
			'country'  => array(
				'required' => $required ? 1 : 0,
			),
		)
	);

	$profile_info = dokan_get_store_info( dokan_get_current_user_id() );

	dokan_get_template_part( 'settings/address-form', '', array(
		'disabled'              => $disabled,
		'seller_address_fields' => $seller_address_fields,
		'profile_info'          => $profile_info,
	) );
}

/**
 * Remove option to enable chat from seller store form
 */
if (class_exists('Dokan_Live_Chat_Seller_Settings')) {
	remove_action( 'dokan_settings_form_bottom', array(
		Dokan_Live_Chat_Seller_Settings::init(),
		'dokan_live_chat_seller_settings'
	), 15 );
	remove_action( 'dokan_store_profile_saved', array(
		Dokan_Live_Chat_Seller_Settings::init(),
		'dokan_live_chat_save_seller_settings'
	), 15 );
}

/**
 * Remove progress bar from store form
 */
if (class_exists('Dokan_Pro_Settings')) {
	remove_action( 'dokan_settings_load_ajax_response', array(
		Dokan_Pro_Settings::init(),
		'render_pro_settings_load_progressbar'
	), 25 );
	remove_action( 'dokan_settings_form_bottom', array(
		Dokan_Pro_Settings::init(),
		'render_biography_form'
	), 10 );
	remove_action( 'dokan_ajax_settings_response', array(
		Dokan_Pro_Settings::init(),
		'add_progressbar_in_settings_save_response'
	), 10 );

	add_action( 'dokan_settings_after_profile_picture', 'render_biography_form' );
}

/**
 * Remove default help text from vendor settings
 */
if (class_exists('Dokan_Template_Settings')) {
	remove_action( 'dokan_settings_content_area_header', array(
		Dokan_Template_Settings::init(),
		'render_settings_help'
	), 15 );
}

function render_biography_form() {
	$seller_id   = dokan_get_current_user_id();
	$store_info = dokan_get_store_info( $seller_id );
	Dokan_Pro_Settings::init()->render_biography_form($seller_id, $store_info);
}


function dokan_remove_unneeded_vendor_menu( $menus ) {
	unset($menus['withdraw']);
	return $menus;
}

function dokan_remove_unneeded_settings_menu( $menus ) {
//	unset($menus['shipping']);
	unset($menus['social']);
	unset($menus['seo']);
	return $menus;
}

add_filter( 'dokan_get_dashboard_nav', 'dokan_remove_unneeded_vendor_menu', 100 );
add_filter( 'dokan_get_dashboard_settings_nav', 'dokan_remove_unneeded_settings_menu', 100 );


add_action( 'dokan_settings_content_area_header', 'set_vendor_settings_help_texts', 20 );


function set_vendor_settings_help_texts() {
	global $wp;

	$help_text = '';

	if ( isset( $wp->query_vars['settings'] ) && $wp->query_vars['settings'] == 'payment' ) {
//		$help_text = __( 'Tanel: we can add help texts in menu items headers if needed.', 'dokan-lite' );
	}

	if ( $help_text = apply_filters( 'dokan_dashboard_settings_helper_text', $help_text, $wp->query_vars['settings'] ) ) {
		dokan_get_template_part( 'global/dokan-help', '', array(
			'help_text' => $help_text
		) );
	}
}

// Override chat endpoint. WIthout this vendor dashboard inbox link gives 404
add_filter( 'dokan_query_var_filter', 'dokan_add_endpoint' );

function dokan_add_endpoint( $query_var ) {
	$query_var['inbox'] = 'inbox';

	return $query_var;
}
// End override chat endpoint

// register nonce check is done in theme function. Switch it out in Dokan.
add_filter('dokan_register_nonce_check', 'register_nonce_check');

function register_nonce_check() {
    return false;
}

function add_login_logout_register_menu( $items, $args ) {

    if ( !is_user_logged_in() ) {
        $items = preg_replace('/<li.*my-account.*li>/', '', $items);
        $label = '' . __( 'Log In' ) . '';
        $items.= '' . '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1046"><a href="https://comecater.ee/my-account/" data-enable="1" class="elementor-item nasa-login-register-ajax">'.$label.'</a></li>' . '';
    }

    return $items;
}

add_filter( 'wp_nav_menu_items', 'add_login_logout_register_menu', 199, 2 );

?>