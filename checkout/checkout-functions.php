<?php
add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
add_filter( 'default_checkout_billing_state', 'get_default_checkout_state' );
add_action( 'woocommerce_after_checkout_billing_form', 'init_delivery_date' );
add_filter( 'woocommerce_shipping_rate_label', 'localize_shipping_rate_label' );
add_filter( 'wcss_display_share_button', 'remove_button_class_from_share_button' );
add_action( 'woocommerce_form_field_text','add_checkout_custom_headers', 10, 2 );
add_action( 'woocommerce_form_field_textarea','add_checkout_custom_headers', 10, 2 );



function default_values_checkout_fields( $fields ) {
    //TODO: siin saab aadressi kohustuslikkust dünaamiliselt muuta
    $fields['billing']['billing_delivery']['default'] = get_session_value('store_filter_delivery_option', '1');
    $fields['billing']['billing_state']['required'] = 1;
    $fields['billing']['billing_delivery_date']['autocomplete'] = '';

    $fields['billing']['billing_country']['default'] = 'EE';
    $fields['billing']['billing_country']['class'] = ['display_none'];

    return $fields;
}

function get_default_checkout_state() {
    return get_session_value('store_filter_seller_state', null);
}

function get_session_value($name, $default) {
    if (session_id() == '' ) {
        session_start();
    }
    return !empty( $_SESSION[$name] ) ? $_SESSION[$name] : $default;
}


function init_delivery_date() {
    $session_value = !empty( $_SESSION['store_filter_delivery_date'] ) ? $_SESSION['store_filter_delivery_date'] : 'undefined';
    echo '
    <script>
        jQuery( document ).ready( function ( $ ) {
            
            let deliveryDateField = jQuery("#billing_delivery_date");
            deliveryDateField.datetimepicker({
                dateFormat: "dd.mm.yy",
                stepMinute: 30,
                oneLine: true,
                minDateTime: getMinDate()
            });
    
            function getMinDate() {
                var minDate = new Date();
                minDate.setMilliseconds(0);
                minDate.setSeconds(0);
                minDate.setMinutes(Math.ceil(minDate.getMinutes() / 30) * 30);
                return minDate;
            }
            
            var dateFromSession = "'.$session_value.'";
            if (dateFromSession !== "undefined") {
                deliveryDateField.val(dateFromSession);
            }
        });
    </script>';
}

function localize_shipping_rate_label($label) {
    return _e($label, 'dokan');
}

function remove_button_class_from_share_button($share_button) {
    return str_replace('button wcss-btn', 'wcss-btn', $share_button);
}

function add_checkout_custom_headers( $field, $key ){
    if ( is_checkout() ) {
        if ($key == 'billing_address_1') {
            $field .= '<h3>' . __('Millal') . '</h3>';
        }
        if ($key == 'billing_delivery_date') {
            $field .= '<h3>' . __('Lisainfo') . '</h3>';
        }
        if ($key == 'billing_order_comments') {
            $field .= '<h3>' . __('Arveldus') . '</h3>';
        }
    }
    return $field;
}

?>
