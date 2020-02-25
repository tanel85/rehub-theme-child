<?php

add_filter('dokan_get_order_status_translated', 'get_order_status_translated', 10, 2);
add_filter('dokan_get_order_status_class', 'get_order_status_class', 10, 2);
add_filter('woocommerce_admin_order_actions', 'add_order_action_icons', 101, 2);
add_filter( 'wc_order_statuses', 'remove_wc_default_statuses', 9 );
add_filter( 'woocommerce_reports_order_statuses', 'add_custom_report_statuses' );
//add_action( 'woocommerce_order_details_before_order_table', 'add_chat_button');

function get_order_status_translated($default_value, $order_status) {
    if ($order_status == 'approval-waiting') {
        return __('Ootab kinnitust', 'dokan');
    }
    if ($order_status == 'approved') {
        return __('Kinnitatud', 'dokan');
    }
    if ($order_status == 'rejected') {
        return __('Tagasi lükatud', 'dokan');
    }
    return $default_value;
}

function get_order_status_class($default_value, $order_status) {
    if ($order_status == 'approval-waiting') {
        return 'danger';
    }
    if ($order_status == 'approved') {
        return 'warning';
    }
    if ($order_status == 'rejected') {
        return 'default';
    }
    return $default_value;
}

function add_order_action_icons($actions, $order) {
    foreach ($actions as $key => $action) {
        if ($key == 'approval-waiting') {
            $actions[$key]['icon'] = '<i class="fa fa-hourglass-2">&nbsp;</i>';
            $actions[$key]['name'] = 'Ootab kinnitust';
        }
        if ($key == 'approved') {
            $actions[$key]['icon'] = '<i class="fa fa-thumbs-up">&nbsp;</i>';
            $actions[$key]['name'] = 'Kinnitatud';
        }
        if ($key == 'rejected') {
            $actions[$key]['icon'] = '<i class="fa fa-thumbs-down">&nbsp;</i>';
            $actions[$key]['name'] = 'Tagasi lükatud';
        }
    }
    if ( $order->has_status( array( 'approved' ) ) ) {
        $actions['complete'] = array(
            'url' => wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $order->get_id()), 'woocommerce-mark-order-status'),
            'name' => __('Completed', 'woocommerce'),
            'title' => __('Change order status to completed', 'woocommerce'),
            'action' => 'complete',
            'icon' => '<i class="fa fa-check">&nbsp;</i>'
        );
    }
    if ( $order->has_status( array( 'approved', 'completed' ) ) ) {
        unset($actions["approval-waiting"]);
        unset($actions["rejected"]);
    }
    if ( $order->has_status( array( 'completed' ) ) ) {
        unset($actions["approved"]);
    }
    return $actions;
}

function remove_wc_default_statuses() {
    $order_statuses = array(
        'wc-completed'  => _x( 'Completed', 'Order status', 'woocommerce' ),
        'wc-refunded'   => _x( 'Refunded', 'Order status', 'woocommerce' ),
    );


    return $order_statuses;
}

function add_custom_report_statuses ($statuses) {
    array_push($statuses, 'wc-approved');
    return $statuses;
}

//function add_chat_button($order) {
//    echo $order->get_meta('_dokan_vendor_id');
//    echo Dokan_Live_Chat_Start::init()->dokan_render_live_chat_button($order->get_meta('_dokan_vendor_id'));
// TODO: Dokan_Live_Chat_Start get_customer_seller_chat_js võtab vale $store_user-i
//}

?>