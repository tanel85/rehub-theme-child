<?php
add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
add_filter( 'default_checkout_billing_state', 'set_default_checkout_state' );
add_action( 'woocommerce_after_checkout_billing_form', 'init_delivery_date' );

//TODO: this disables shipping in checkout process. After we figure out how shipping is done, it's probably needed to remove this
add_filter( 'woocommerce_cart_needs_shipping', function() {return false;});



function default_values_checkout_fields( $fields ) {
    $fields['billing']['billing_delivery']['default'] = get_session_value('store_filter_delivery_option', '1');
    $fields['billing']['billing_state']['required'] = 1;
    $fields['billing']['billing_delivery_date']['autocomplete'] = '';
    return $fields;
}

function set_default_checkout_state() {
    return get_session_value('store_filter_dokan_seller_state', 'EE1');
}

function get_session_value($name, $default) {
    if (session_id() == '' ) {
        session_start();
    }
    return !empty( $_SESSION[$name] ) ? $_SESSION[$name] : null;
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

?>