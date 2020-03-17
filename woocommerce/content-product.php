<?php
global $product, $nasa_opt, $nasa_animated_products;
if (empty($product) || !$product->is_visible()) :
    return;
endif;

$category_ids = join(';', $product->get_category_ids());
$productId = $product->get_id();
$stock_status = $product->get_stock_status();
$stock_label = $stock_status == 'outofstock' ?
    esc_html__('Out of stock', 'elessi-theme') : esc_html__('In stock', 'elessi-theme');

$time_sale = false;
if($product->is_on_sale()) {
    $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
    $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
    $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
}

$_wrapper = (isset($wrapper) && $wrapper == 'li') ? 'li' : 'div';

$class_wrap = 'wow fadeInUp product-item grid';
$class_wrap .= $nasa_animated_products ? ' ' . $nasa_animated_products : '';
$class_wrap .= $stock_status == "outofstock" ? ' out-of-stock' : '';

if(!isset($_delay)) {
    $_delay = '0';
}

echo (!isset($wrapper) || $wrapper == 'li') ? '<li class="product-warp-item" data-category-ids=";'.$category_ids.';">' : '';
if (!empty($product->category_name)) {
    echo '<h1>' . $product->category_name . '</h1>';
}
echo '<div class="' . esc_attr($class_wrap) . '" data-wow-duration="1s" data-wow-delay="' . esc_attr($_delay) . 'ms" data-wow="fadeInUp">';

do_action('woocommerce_before_shop_loop_item');
?>

    <div class="inner-wrap<?php echo $time_sale ? ' product-deals' : ''; ?>">
        <div class="product-outner">
            <div class="product-inner">
                <div class="product-img-wrap" style="cursor: pointer">
                    <div class="product-img-wrap-inner">
                        <div class="quick-view" data-prod="<?php echo esc_attr($productId); ?>">
                            <?php do_action('woocommerce_before_shop_loop_item_title_quickview'); ?>
                        </div>
                        <?php do_action('woocommerce_before_shop_loop_item_title'); ?>
                    </div>
                </div>

                <div class="product-info-wrap" style="cursor: pointer">
                    <div class="info quick-view" data-prod="<?php echo esc_attr($productId); ?>">
                        <?php do_action('woocommerce_shop_loop_item_title'); ?>
                        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
                    </div>
                </div>

                <!-- Clone Group btns for layout List -->
                <div class="hidden-tag nasa-list-stock-wrap">
                </div>
                <div class="group-btn-in-list-wrap hidden-tag"><div class="group-btn-in-list"></div></div>
            </div>
        </div>
    </div>
<?php

do_action('woocommerce_after_shop_loop_item');
echo '</div>';
echo (!isset($wrapper) || $wrapper == 'li') ? '</li>' : '';
