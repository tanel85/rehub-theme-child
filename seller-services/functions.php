<?php

//--------------- Services form ------------------------------

add_action( 'add_services_content', 'add_services_content' );

add_filter( 'dokan_get_dashboard_settings_nav', 'load_services_menu' );
add_filter( 'dokan_settings_content', 'load_services_template' );
add_filter( 'dokan_dashboard_settings_heading_title', 'add_heading_title', 10, 2 );

add_filter( 'dokan_query_var_filter', 'dokan_load_services_menu' );
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_services_menu' );
add_action( 'dokan_load_custom_template', 'dokan_load_services_template' );
add_action( 'wp_ajax_dokan_seller_services', 'update_services' );

function add_services_content() {
	$profile_info = dokan_get_store_info( dokan_get_current_user_id() );
	include dirname( __FILE__ ). '/services-edit-form.php';

}

function dokan_load_services_menu( $query_vars ) {
	$query_vars['services'] = 'services';
	return $query_vars;
}

function add_heading_title( $header, $query_vars ) {
	if ( 'services' === $query_vars ) {
		$header = __( 'Services', 'dokan-lite' );
	}
	return $header;
}



function load_services_menu( $sub_settings ) {
	$sub_settings['services'] = array(
		'title'      => __( 'Services', 'dokan-lite' ),
		'icon'       => '<i class="fa fa-user"></i>',
		'url'        => dokan_get_navigation_url( 'settings/services' ),
		'pos'        => 11,
		'permission' => 'dokan_view_store_settings_menu'
	);
	return $sub_settings;
}




function dokan_add_services_menu( $urls ) {
	$urls['services'] = array(
		'title' => __( 'Services', 'dokan'),
		'icon'  => '<i class="fa fa-user"></i>',
		'url'   => dokan_get_navigation_url( 'services' ),
		'pos'   => 11
	);
	return $urls;
}

function dokan_load_services_template( $query_vars ) {
	if ( isset( $query_vars['services'] ) ) {
		require_once dirname( __FILE__ ). '/services.php';
	}
}

function load_services_template() {
	$settings = get_query_var( 'settings' );
	if ( 'services' !== $settings ) {
		return;
	}
	$profile_info = dokan_get_store_info( dokan_get_current_user_id() );
	require_once dirname( __FILE__ ). '/services-edit-form.php';
}

function update_services() {

	if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
		wp_send_json_error( __( 'Are you cheating1?', 'dokan-lite' ) );
	}

	$post_data = wp_unslash( $_POST );

	if ( ! current_user_can( 'dokan_view_store_settings_menu' ) ) {
		wp_send_json_error( __( 'Pemission denied', 'dokan-lite' ) );
	}

	if ( ! wp_verify_nonce( $post_data['_wpnonce'], 'vendor_services_nonce' ) ) {
		wp_send_json_error( __( 'Are you cheating2?', 'dokan-lite' ) );
	}

	$store_id = dokan_get_current_user_id();
	$dokan_settings = dokan_get_store_info($store_id);

	$food_options = array(
		'breakfast'   => $post_data['breakfast'],
		'lunch'   => $post_data['lunch'],
		'hot_buffet'   => $post_data['hot_buffet'],
		'cold_buffet'   => $post_data['cold_buffet'],
		'appetizer'   => $post_data['appetizer'],
		'dessert'   => $post_data['dessert']
	);
	$events = array(
		'team_breakfast'   => $post_data['team_breakfast'],
		'team_lunch'   => $post_data['team_lunch'],
		'meeting'   => $post_data['meeting'],
		'birthday'   => $post_data['birthday'],
		'company_event'   => $post_data['company_event'],
		'wedding'   => $post_data['wedding'],
		'conference'   => $post_data['conference']
	);
	$diets = array(
		'vegan'   => $post_data['vegan'],
		'vegetarian'   => $post_data['vegetarian'],
		'gluten_free'   => $post_data['gluten_free']
	);
	$additional_services = array(
		'cutlery'   => $post_data['cutlery'],
		'tables'   => $post_data['tables'],
		'servicing'   => $post_data['servicing']
	);

	$dokan_settings['food_options'] = $food_options;
	$dokan_settings['events'] = $events;
	$dokan_settings['diets'] = $diets;
	$dokan_settings['additional_services'] = $additional_services;
	update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );


	$success_msg = __( 'Your information has been saved successfully', 'dokan-lite' );

	$data = apply_filters( 'dokan_ajax_settings_response', array(
		'msg' => $success_msg,
	) );

	wp_send_json_success( $data );

}


?>