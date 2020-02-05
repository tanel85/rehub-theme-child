<?php

require_once ELESSI_CHILD_DIR . '/store/reviews/reviews-list.php';
require_once ELESSI_CHILD_DIR . '/store/reviews/store-rating.php';

add_filter( 'dokan_store_tabs', 'remove_store_tabs', 100 );
add_filter( 'dokan_get_seller_review_url', 'remove_review_url' );
add_action( 'include_store_reviews', 'get_store_reviews_template' );
add_action( 'init', 'replace_loop_product_content_thumbnail', 11);
add_action( 'init', 'replace_product_description', 11);

// Remove share button from store page
if (class_exists('Dokan_Pro_Store_Share')) {
    remove_action('dokan_after_store_tabs', array(
        Dokan_Pro_Store_Share::init(),
        'render_share_button'
    ), 1);
}

function remove_store_tabs( ) {
    return null;
}

function get_store_reviews_template() {
    return require_once ELESSI_CHILD_DIR . '/store/reviews/reviews.php';
}

function remove_review_url() {
    return '';
}

function replace_loop_product_content_thumbnail() {
    remove_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_thumbnail', 10);
    add_action('woocommerce_before_shop_loop_item_title_quickview', 'elessi_loop_product_content_thumbnail', 10);
}

function replace_product_description() {
    remove_action('woocommerce_after_shop_loop_item_title', 'elessi_loop_product_description', 15);
    add_action('woocommerce_after_shop_loop_item_title', 'add_loop_product_description', 15);
}

if(!function_exists('add_loop_product_description')) :
    function add_loop_product_description() {
        global $post;
        $read_additional_info = empty($post->post_content) ? '' : esc_html( __( 'Loe lisainfot', 'dokan' ) );
        echo
            '<div class="info_main product-des-wrap">' .
                '<hr class="nasa-list-hr hidden-tag" />' .
                '<div class="product-des">' .
                    apply_filters('woocommerce_short_description', $post->post_excerpt) .
                    '<div class="product-additional-info comecater-info-link">' .
                        $read_additional_info.
                    '</div>' .
                '</div>' .
            '</div>';
    }
endif;

?>