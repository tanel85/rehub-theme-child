<?php

//--------------- Services form ------------------------------

add_filter( 'dokan_get_dashboard_settings_nav', 'load_delivery_menu' );
add_filter( 'dokan_settings_content', 'load_delivery_template' );
add_filter( 'dokan_dashboard_settings_heading_title', 'add_delivery_heading_title', 10, 2 );
add_action( 'wp_ajax_dokan_seller_delivery', 'update_delivery' );

function load_delivery_menu( $sub_settings ) {
    $sub_settings['delivery'] = array(
        'title'      => __( 'Delivery', 'dokan-lite' ),
        'icon'       => '<i class="fa fa-bus"></i>',
        'url'        => dokan_get_navigation_url( 'settings/delivery' ),
        'pos'        => 32,
        'permission' => 'dokan_view_store_settings_menu'
    );
    return $sub_settings;
}

function load_delivery_template() {
    $settings = get_query_var( 'settings' );
    if ( 'delivery' !== $settings ) {
        return;
    }
    $profile_info = dokan_get_store_info( dokan_get_current_user_id() );
    $country_obj   = new WC_Countries();
    $states        = $country_obj->states['EE'];
    require_once dirname( __FILE__ ). '/delivery-edit-form.php';
}


function add_delivery_heading_title( $header, $query_vars ) {
    if ( 'delivery' === $query_vars ) {
        $header = __( 'Delivery', 'dokan-lite' );
    }
    return $header;
}

function update_delivery() {

    if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
        wp_send_json_error( __( 'Are you cheating1?', 'dokan-lite' ) );
    }

    $post_data = wp_unslash( $_POST );

    if ( ! current_user_can( 'dokan_view_store_settings_menu' ) ) {
        wp_send_json_error( __( 'Pemission denied', 'dokan-lite' ) );
    }

    if ( ! wp_verify_nonce( $post_data['_wpnonce'], 'vendor_delivery_nonce' ) ) {
        wp_send_json_error( __( 'Are you cheating2?', 'dokan-lite' ) );
    }

    $store_id = dokan_get_current_user_id();
    $dokan_settings = dokan_get_store_info($store_id);

    if ( isset( $_POST['delivery'] ) ) {
        $dokan_settings['delivery'] = $_POST['delivery'];
        $dokan_settings['delivery_info'] = get_delivery_info();
    } else {
        $dokan_settings['delivery'] = '';
        $dokan_settings['delivery_info'] = null;
    }

    update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );

    $success_msg = __( 'Your information has been saved successfully', 'dokan-lite' );

    $data = apply_filters( 'dokan_ajax_settings_response', array(
        'msg' => $success_msg,
    ) );

    wp_send_json_success( $data );

}

function get_delivery_info() {
    $delivery_info = [];

    $country_obj   = new WC_Countries();
    $states        = $country_obj->states['EE'];
    foreach ( $states as $key => $value ):
        if ( isset( $_POST[$key] ) ) {
            $delivery_info[$key] = array(
                'enabled' => $_POST[$key],
                'price' => $_POST[$key.'_price'],
            );
        }
    endforeach;
    return $delivery_info;
}


?>