<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

if ( ! class_exists( 'Dokan_Pro_Settings' ) ) {
	require_once DOKAN_PRO_DIR . '/classes/settings.php';
}

define( 'REHUB_CHILD_DIR', dirname( __FILE__ ) );
require_once REHUB_CHILD_DIR . '/seller-services/functions.php';
require_once REHUB_CHILD_DIR . '/registration-functions.php';

//save the field value
add_action( 'dokan_store_profile_saved', 'save_extra_fields', 15 );
function save_extra_fields( $store_id ) {
    $dokan_settings = dokan_get_store_info($store_id);
    if ( isset( $_POST['min_order'] ) ) {
        $dokan_settings['min_order'] = $_POST['min_order'];
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
	if ( isset( $_POST['delivery'] ) ) {
		$dokan_settings['delivery'] = $_POST['delivery'];
	}
	$dokan_settings['address']['country'] = 'EE';
    $dokan_settings['live_chat'] = 'yes';
    $dokan_settings['dokan_store_time_enabled'] = 'yes';
    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}


add_action( 'dokan_seller_search_form', 'add_state_dropdown_in_seller_search_form' );

/**
 * Add store category dropdown in seller search form
 *
 * @since 2.9.2
 *
 * @return void
 */
function add_state_dropdown_in_seller_search_form() {
	$state_query = ! empty( $_GET['dokan_seller_state'] ) ? sanitize_text_field( $_GET['dokan_seller_state'] ) : null;

        $country_obj   = new WC_Countries();
        $states        = $country_obj->states['EE'];

	$args = array(
		'state_query' => $state_query,
                'states' => $states
	);

        dokan_get_template_part( 'seller-search-form-categories', '', $args );
}

add_action( 'dokan_store_list_args', 'apply_seller_custom_filters', 30, 2 );

function is_seller_state($seller) {
  $dokan_seller_state = sanitize_text_field( $_REQUEST['dokan_seller_state'] );
  $dokan_settings = get_user_meta( $seller->ID, 'dokan_profile_settings', true );
  return $dokan_settings['address']['state'] == $dokan_seller_state;
}

function apply_seller_custom_filters( $args ) {
  if ( !empty( $_REQUEST['dokan_seller_state'] ) ) {
		$sellers_filtered = array_filter($args['sellers']['users'], "is_seller_state");
		$args['sellers'] = array(
			'users' => $sellers_filtered,
			'count' => count($sellers_filtered)
		);
  }
  return $args;
}

/**
 * Add or modify States
 */
add_filter( 'woocommerce_states', 'custom_woocommerce_states' );

function custom_woocommerce_states( $states ) {

  $states['EE'] = array(
    'EE1' => 'Harjumaa',
    'EE2' => 'Tartumaa'
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
	unset($menus['coupons']);
	return $menus;
}

function dokan_remove_unneeded_settings_menu( $menus ) {
	unset($menus['shipping']);
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
		$help_text = __( 'Tanel: we can add help texts in menu items headers if needed.', 'dokan-lite' );
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


?>