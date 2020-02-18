<?php

//--------------- Services form ------------------------------

add_filter( 'dokan_get_dashboard_settings_nav', 'load_services_menu' );
add_filter( 'dokan_settings_content', 'load_services_template' );
add_filter( 'dokan_dashboard_settings_heading_title', 'add_heading_title', 10, 2 );
add_action( 'wp_ajax_dokan_seller_services', 'update_services' );

function load_services_menu( $sub_settings ) {
	$sub_settings['services'] = array(
		'title'      => __( 'Sündmused', 'dokan-lite' ),
		'icon'       => '<i class="fa fa-user"></i>',
		'url'        => dokan_get_navigation_url( 'settings/services' ),
		'pos'        => 31,
		'permission' => 'dokan_view_store_settings_menu'
	);
	return $sub_settings;
}

function load_services_template() {
	$settings = get_query_var( 'settings' );
	if ( 'services' !== $settings ) {
		return;
	}
	$profile_info = dokan_get_store_info( dokan_get_current_user_id() );
	require_once dirname( __FILE__ ). '/services-edit-form.php';
}


function add_heading_title( $header, $query_vars ) {
	if ( 'services' === $query_vars ) {
		$header = __( 'Sündmused', 'dokan-lite' );
	}
	return $header;
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

    $events = array(
		'laste_synnipaev'   => $post_data['laste_synnipaev'],
        'kohvipaus'   => $post_data['kohvipaus'],
        'yhine_louna'   => $post_data['yhine_louna'],
		'firma_pidu'   => $post_data['firma_pidu'],
		'hommikusook'   => $post_data['hommikusook'],
		'grillpidu'   => $post_data['grillpidu'],
		'synnipaev'   => $post_data['synnipaev'],
		'peielaud'   => $post_data['peielaud'],
		'pidulik_ohtusook'   => $post_data['pidulik_ohtusook'],
		'konverents'   => $post_data['konverents'],
		'bankett'   => $post_data['bankett'],
		'pulm'   => $post_data['pulm']
	);

	$dokan_settings['events'] = $events;
	update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );


	$success_msg = __( 'Your information has been saved successfully', 'dokan-lite' );

	$data = apply_filters( 'dokan_ajax_settings_response', array(
		'msg' => $success_msg,
	) );

	wp_send_json_success( $data );

}


?>