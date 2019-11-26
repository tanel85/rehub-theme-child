<?php

add_action( 'dokan_new_seller_created', 'save_vendor_profile_extra_fields', 10, 2 );

function save_vendor_profile_extra_fields($user_id, $dokan_settings) {

	$post_data = wp_unslash( $_POST );

	$dokan_settings['contact_email'] = sanitize_text_field( wp_unslash( $post_data['email'] ) );
	$dokan_settings['main_user_name'] = sanitize_text_field( wp_unslash( $post_data['fname'] )) . " " . sanitize_text_field( wp_unslash( $post_data['lname'] ));

	update_user_meta( $user_id, 'dokan_profile_settings', $dokan_settings );

}

?>