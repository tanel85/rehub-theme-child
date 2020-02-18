<?php

add_filter('dokan_get_order_status_translated', 'get_order_status_translated', 10, 2);
add_filter('dokan_get_order_status_class', 'get_order_status_class', 10, 2);
add_filter('woocommerce_admin_order_actions', 'add_order_action_icons', 101, 2);
add_filter( 'wc_order_statuses', 'remove_wc_default_statuses', 9 );

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
    return $actions;
}

function remove_wc_default_statuses() {
    return [];
}

?>