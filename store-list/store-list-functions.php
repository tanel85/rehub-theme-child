<?php

add_action( 'wp_enqueue_scripts', 'enqueue_store_list_scripts' );
add_action( 'dokan_seller_search_form', 'add_state_dropdown' );
add_action( 'dokan_seller_search_form', 'add_delivery_date_dropdown' );
add_action( 'dokan_store_list_args', 'apply_seller_custom_filters', 30, 2 );

function enqueue_store_list_scripts() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/assets/jquery-ui-timepicker-addon.js', array(), false, true );
	wp_enqueue_style('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/assets/jquery-ui-timepicker-addon.css',array());
	wp_enqueue_style('jquery-ui',get_stylesheet_directory_uri().'/css/jquery-ui.css',array());
}

function add_state_dropdown() {
	$state_query = ! empty( $_GET['dokan_seller_state'] ) ? sanitize_text_field( $_GET['dokan_seller_state'] ) : null;

	$country_obj   = new WC_Countries();
	$states        = $country_obj->states['EE'];

	$args = array(
		'state_query' => $state_query,
		'states' => $states
	);

	dokan_get_template_part( 'store-list-state', '', $args );
}

function add_delivery_date_dropdown() {
	dokan_get_template_part( 'store-list-delivery-date' );
}

function is_seller_visible($seller) {
	$store_info = dokan_get_store_info( $seller->ID );
	$filter_state = empty( $_REQUEST['dokan_seller_state'] ) || is_seller_state($store_info);
	$filter_delivery_date = empty( $_REQUEST['delivery_date'] ) || is_seller_delivery_date($store_info);
	$result = $filter_state && $filter_delivery_date;
	return $result == true;
}

function is_seller_state($store_info) {
	$dokan_seller_state = sanitize_text_field( $_REQUEST['dokan_seller_state'] );
	return $store_info['address']['state'] == $dokan_seller_state;
}

function is_seller_delivery_date($store_info) {
	if (empty($store_info['dokan_store_time'])) {
		return false;
	}
	$days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];
	$delivery_date = strtotime(sanitize_text_field( $_REQUEST['delivery_date'] ));
	$weekday = date('w', $delivery_date);
	$day = $days[$weekday];
	$store_open_day = $store_info['dokan_store_time'][$day];
	if (empty($store_open_day) || $store_open_day['status'] != 'open') {
		return false;
	}
	return $delivery_date >= strtotime($store_open_day['opening_time'], $delivery_date) &&
	       $delivery_date <= strtotime($store_open_day['closing_time'], $delivery_date);
}

function apply_seller_custom_filters( $args ) {
	if ( !empty( $_REQUEST['dokan_seller_state'] ) || !empty( $_REQUEST['delivery_date'] ) ) {
		$sellers_filtered = array_filter($args['sellers']['users'], "is_seller_visible");
		$args['sellers'] = array(
			'users' => $sellers_filtered,
			'count' => count($sellers_filtered)
		);
	}
	return $args;
}

?>