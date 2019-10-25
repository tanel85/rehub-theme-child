<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}


/*Extra field on the seller settings and show the value on the store banner -Dokan*/

// Add extra field in seller settings

add_filter( 'dokan_settings_after_store_name', 'extra_fields', 10, 2);

function extra_fields( $current_user, $profile_info ){
$min_order= isset( $profile_info['min_order'] ) ? $profile_info['min_order'] : '';
?>
 <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="min_order">
            <?php _e( 'Minimum order value', 'dokan' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <input type="number" class="dokan-form-control" name="min_order" id="min_order" value="<?php echo esc_attr( $min_order ); ?>" />
        </div>
    </div>
    <?php
}
    //save the field value
add_action( 'dokan_store_profile_saved', 'save_extra_fields', 15 );
function save_extra_fields( $store_id ) {
    $dokan_settings = dokan_get_store_info($store_id);
    if ( isset( $_POST['min_order'] ) ) {
        $dokan_settings['min_order'] = $_POST['min_order'];
    }
 update_user_meta( $store_id, 'dokan_profile_settings', $dokan_settings );
}


add_action( 'dokan_seller_search_form', 'add_state_dropdown_in_seller_search_form' );

/**
 * Add store category dropdown in seller search form
 *
 * @since 2.9.2
 *
 * @return void
 */
function add_state_dropdown_in_seller_search_form() {
	$state_query = ! empty( $_GET['dokan_seller_state'] ) ? sanitize_text_field( $_GET['dokan_seller_state'] ) : null;

        $country_obj   = new WC_Countries();
        $states        = $country_obj->states['EE'];

	$args = array(
		'state_query' => $state_query,
                'states' => $states
	);

        dokan_get_template_part( 'seller-search-form-categories', '', $args );
}

add_action( 'dokan_store_list_args', 'apply_seller_custom_filters', 30, 2 );

function is_seller_state($seller) {
  $dokan_seller_state = sanitize_text_field( $_REQUEST['dokan_seller_state'] );
  $dokan_settings = get_user_meta( $seller->ID, 'dokan_profile_settings', true );
  return $dokan_settings['address']['state'] == $dokan_seller_state;
}

function apply_seller_custom_filters( $args ) {
  if ( !empty( $_REQUEST['dokan_seller_state'] ) ) {
		$sellers_filtered = array_filter($args['sellers']['users'], "is_seller_state");
		$args['sellers'] = array(
			'users' => $sellers_filtered,
			'count' => count($sellers_filtered)
		);
  }
  return $args;
}

/**
 * Add or modify States
 */
add_filter( 'woocommerce_states', 'custom_woocommerce_states' );

function custom_woocommerce_states( $states ) {

  $states['EE'] = array(
    'EE1' => 'Harjumaa', 
    'EE2' => 'Tartumaa'
  );

  return $states;
}

?>