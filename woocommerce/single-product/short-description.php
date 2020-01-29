<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $post;

$short_description = $post->post_excerpt;
$additional_info_label = esc_html( __( 'Lisainfo', 'dokan' ) );
if (!empty($post->post_content)) {
    $short_description = $short_description.'<h4><b>'.$additional_info_label.'</b></h4>'.$post->post_content;
}

$short_description = apply_filters( 'woocommerce_short_description', $short_description );

if ( ! $short_description ) {
    return;
}

?>
<div class="woocommerce-product-details__short-description">
    <?php echo $short_description; // WPCS: XSS ok. ?>
</div>
