<?php

add_action( 'woocommerce_shipping_init', 'comecater_shipping_method' );
add_action('woocommerce_cart_calculate_fees', 'set_shipping_fee');
add_filter( 'woocommerce_shipping_methods', 'add_comecater_shipping_method' );
add_filter( 'woocommerce_cart_shipping_method_full_label', 'hide_shipping_title' );

function comecater_shipping_method() {
    if ( ! class_exists( 'Comecater_Shipping_Method' ) ) {
        class Comecater_Shipping_Method extends WC_Shipping_Method {
            /**
             * Constructor for your shipping class
             *
             * @access public
             * @return void
             */
            public function __construct() {
                $this->id                 = 'comecater';
                $this->method_title       = __( 'Comecater Shipping', 'comecater' );
                $this->method_description = __( 'Custom Shipping Method for comecater', 'comecater' );

                $this->init();

                $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Comecater Shipping', 'comecater' );
            }

            /**
             * Init your settings
             *
             * @access public
             * @return void
             */
            function init() {
                // Load the settings API
                $this->init_form_fields();
                $this->init_settings();
                $this->calculate_shipping();

                // Save settings in admin if you have any defined
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            /**
             * Define settings field for this shipping
             * @return void
             */
            function init_form_fields() {

                // We will add our settings here

            }

            /**
             * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
             *
             * @access public
             * @param mixed $package
             * @return void
             */
            public function calculate_shipping( $package = array() ) {
//                global $woocommerce, $post;
//
//                $order = new WC_Order($post->ID);
//
////to escape # from order id
//
//                $order_id = trim(str_replace('#', '', $order->get_order_number()));
//                error_log($order_id);
//                global $wp;
//                error_log(print_r($wp->query_vars['order-received'], true));
//                error_log(print_r($package, true));
//                error_log(!empty($package));
                $shipping_cost = $this->get_shipping_cost($package);
                $rate = array(
                    'id' => $this->id,
                    'label' => 'Hind',
                    'cost' => $shipping_cost
                );
                $this->add_rate( $rate );
            }

            function get_shipping_cost($package) {
                $shipping_cost = 0;

                $delivery_state = isset($_POST['state']) ? $_POST['state'] : $this->get_session_value('store_filter_seller_state');
                if (!isset($delivery_state) && !empty($package) && !empty($package['destination']) && isset($package['destination']['state'])) {
                    $delivery_state = $package['destination']['state'];
                }
                if (!isset($delivery_state)) {
                    return $shipping_cost;
                }
                $vendor_ids = $this->get_vendor_ids();

                foreach ($vendor_ids as $vendor_id) {
                    $vendor_info = dokan_get_store_info( $vendor_id );
                    if (isset( $vendor_info['delivery_info'])) {
                        $delivery_info = $vendor_info['delivery_info'];
                        if (isset( $delivery_info[$delivery_state])) {
                            $delivery_info_for_state = $delivery_info[$delivery_state];
                            if ($delivery_info_for_state['enabled'] = 'yes' && !empty($delivery_info_for_state['price'])) {
                                $shipping_cost += $delivery_info_for_state['price'];
                            }
                        }
                    }
                }
                return $shipping_cost;
            }

            function get_session_value($name) {
                if (session_id() == '' ) {
                    session_start();
                }
                return !empty( $_SESSION[$name] ) ? $_SESSION[$name] : null;
            }

            function get_vendor_ids() {
                $product_ids = $this->get_product_ids();
                $vendor_ids = [];
                foreach ($product_ids as $product_id) {
                    array_push($vendor_ids, get_post( $product_id )->post_author);
                }
                return array_unique($vendor_ids);
            }

            function get_product_ids () {
                global $woocommerce;
                $product_ids = [];
                foreach ( $woocommerce->cart->cart_contents as $key => $value ) {
                    array_push($product_ids, $value['product_id']);
                }
                return array_unique($product_ids);
            }
        }
    }
}


function set_shipping_fee () {
    foreach ( WC()->cart->get_shipping_packages() as $package_key => $package ) {
        $session_package_shipping = WC()->session->get('shipping_for_package_' . $package_key);
        if (isset($session_package_shipping)) {
            $session_package_shipping['package_hash'] = '';
            WC()->session->set('shipping_for_package_' . $package_key, $session_package_shipping);
        }
    }

    WC()->cart->calculate_shipping();
}

function add_comecater_shipping_method( $methods ) {
    $methods[] = 'Comecater_Shipping_Method';
    return $methods;
}


function hide_shipping_title( $label ) {
    $pos = strpos( $label, ': ' );
    if (!$pos) {
        return _e('Transpordi hinna nägemiseks vali maakond.', 'dokan');
    }
    return substr( $label, ++$pos );
}