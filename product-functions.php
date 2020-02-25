<?php

/*Remove empty sku (item code) from product details page*/
add_filter( 'wc_product_sku_enabled', '__return_false' );

add_action('init', 'remove_product_action', 11);

function remove_product_action() {
    remove_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40);
    if (class_exists('Dokan_Pro_Products')) {
        remove_action( 'dokan_product_edit_after_inventory_variants', array(
            Dokan_Pro_Products::init(),
            'load_shipping_tax_content'
        ), 10, 2 );
        remove_action( 'dokan_product_edit_after_inventory_variants', array(
            Dokan_Pro_Products::init(),
            'load_variations_content'
        ), 20, 2 );
        remove_action( 'dokan_product_edit_after_inventory_variants', array(
            Dokan_Pro_Products::init(),
            'load_lot_discount_content'
        ), 25, 2 );
    }
}

/*Remove quickview icon from product list*/
if (!function_exists('elessi_quickview_in_list')) :
    function elessi_quickview_in_list(){
        global $product;
        $type = $product->get_type();
        ?>
        <div class="quick-view tip-top" data-prod="<?php echo (int) $product->get_id(); ?>" data-tip="<?php echo $type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme'); ?>" title="<?php echo $type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme'); ?>" data-product_type="<?php echo esc_attr($type); ?>" data-href="<?php the_permalink(); ?>">
        </div>
        <?php
    }
endif;

/*Display category names in product list. Elessi has similar function, but displays links.*/
if(!function_exists('elessi_loop_product_cats')) :
    function elessi_loop_product_cats() {
        echo '<div class="nasa-list-category hidden-tag">';
        echo get_product_category_names();
        echo '</div>';
    }
endif;

function get_product_category_names() {
    global $product;
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    if ( empty( $terms ) ) {
        return false;
    }
    $names = array();
    foreach ( $terms as $term ) {
        $names[] = $term->name;
    }
    return join(', ', $names);
}


?>