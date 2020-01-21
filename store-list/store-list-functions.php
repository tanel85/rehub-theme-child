<?php

add_action( 'dokan_seller_search_form', 'add_delivery_option_dropdown' );
add_action( 'dokan_seller_search_form', 'add_state_dropdown' );
add_action( 'dokan_seller_search_form', 'add_delivery_date_dropdown' );
add_action( 'dokan_store_list_args', 'apply_seller_custom_filters', 30, 2 );
add_filter( 'dokan_store_lists_filter', '__return_false' );

function add_delivery_option_dropdown() {
    $session_value = !empty( $_SESSION['store_filter_delivery_option'] ) ? $_SESSION['store_filter_delivery_option'] : null;
    $args = array(
        'session_value' => $session_value
    );
	dokan_get_template_part( 'store-list-delivery-option', '', $args );
}

function add_state_dropdown() {
    $session_value = !empty( $_SESSION['store_filter_dokan_seller_state'] ) ? $_SESSION['store_filter_dokan_seller_state'] : null;

	$country_obj   = new WC_Countries();
	$states        = $country_obj->states['EE'];

	$args = array(
		'session_value' => $session_value,
		'states' => $states
	);

	dokan_get_template_part( 'store-list-state', '', $args );
}

function add_delivery_date_dropdown() {
    $session_value = !empty( $_SESSION['store_filter_delivery_date'] ) ? $_SESSION['store_filter_delivery_date'] : null;
    $args = array(
        'session_value' => $session_value
    );
	dokan_get_template_part( 'store-list-delivery-date', '', $args );
}

function is_seller_visible($seller) {
	$store_info = dokan_get_store_info( $seller->ID );
	$filter_delivery_option = empty( get_filter_value('delivery_option') ) || is_seller_delivery_option($store_info);
	$filter_state = empty( get_filter_value('dokan_seller_state') ) || is_seller_state($store_info);
	$filter_delivery_date = empty( get_filter_value('delivery_date') ) || is_seller_delivery_date($store_info);
	return $filter_delivery_option && $filter_state && $filter_delivery_date;
}

function is_seller_delivery_option($store_info) {
	$delivery_option = get_filter_value( 'delivery_option');
    $delivery = array_key_exists('delivery', $store_info) ? $store_info['delivery'] : null;
    return $delivery_option != '1' || $delivery == 'yes';
}

function is_seller_state($store_info) {
	$dokan_seller_state = get_filter_value('dokan_seller_state');
    $address_state = array_key_exists('state', $store_info['address']) ? $store_info['address']['state'] : null;
    return $address_state == $dokan_seller_state;
}

function is_seller_delivery_date($store_info) {
	if (empty($store_info['dokan_store_time'])) {
		return false;
	}
	$delivery_date = strtotime(get_filter_value('delivery_date'));
	return is_seller_open($store_info, $delivery_date) && !is_delivery_date_on_vacation($store_info, $delivery_date)
		&& is_at_least_minimum_reservation_time($store_info, $delivery_date);
}

function is_seller_open($store_info, $delivery_date) {
	$days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];
	$weekday = date('w', $delivery_date);
	$day = $days[$weekday];
	$store_open_day = $store_info['dokan_store_time'][$day];
	if (empty($store_open_day) || $store_open_day['status'] != 'open') {
		return false;
	}
	return $delivery_date >= strtotime($store_open_day['opening_time'], $delivery_date) &&
	       $delivery_date <= strtotime($store_open_day['closing_time'], $delivery_date);
}

function is_delivery_date_on_vacation($store_info, $delivery_date) {
	if (empty($store_info['seller_vacation_schedules'])) {
		return false;
	}
	$delivery_date_wo_time = strtotime(date('Y-m-d', $delivery_date));
	foreach ( $store_info['seller_vacation_schedules'] as $vacation ) {
		if ($delivery_date_wo_time >= strtotime($vacation['from']) && $delivery_date_wo_time <= strtotime($vacation['to'])) {
			return true;
		}
	}
	return false;
}

function is_at_least_minimum_reservation_time($store_info, $delivery_date) {
	$current_time   = strtotime( date( 'Y-m-d H:i:s' ) );
	$seller_open = is_seller_open($store_info, $current_time);
	if ( $seller_open && !empty($store_info['min_reservation_time_open'])) {
		return $current_time <= $delivery_date - ( $store_info['min_reservation_time_open'] * 60 * 60);
	}
	if (!$seller_open && !empty($store_info['min_reservation_time_closed'])) {
		return $current_time <= $delivery_date - ( $store_info['min_reservation_time_closed'] * 60 * 60);
	}
	return true;
}

function apply_seller_custom_filters( $args ) {
    add_filter_values_to_state();
	if ( !empty( get_filter_value('dokan_seller_state') ) || !empty( get_filter_value('delivery_date') ) || !empty( get_filter_value('delivery_option') ) ) {
		$sellers_filtered = array_filter($args['sellers']['users'], "is_seller_visible");
		$args['sellers'] = array(
			'users' => $sellers_filtered,
			'count' => count($sellers_filtered)
		);
	}
	return $args;
}

function get_filter_value($name) {
    return !empty($_REQUEST[$name]) ? sanitize_text_field($_REQUEST[$name]) : (!empty($_SESSION['store_filter_'.$name]) ? $_SESSION['store_filter_'.$name] : null);
}

function add_filter_values_to_state() {
    if (session_id() == '' ) {
        session_start();
    }
    add_filter_value_to_state('dokan_seller_state');
    add_filter_value_to_state('delivery_date');
    add_filter_value_to_state('delivery_option');
}

function add_filter_value_to_state($name) {
    if (array_key_exists($name, $_REQUEST)) {
        $_SESSION['store_filter_'.$name] = !empty( $_REQUEST[$name] ) ? $_REQUEST[$name] : null;
    }
}

?>