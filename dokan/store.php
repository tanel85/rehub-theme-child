<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();

get_header( 'shop' );

if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>
<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_appearance', 'off' ) == 'off' ) { ?>
    <div id="dokan-secondary" class="dokan-clearfix dokan-w3 dokan-store-sidebar" role="complementary" style="margin-right:3%;">
        <div class="dokan-widget-area widget-collapse">
            <?php do_action( 'dokan_sidebar_store_before', $store_user->data, $store_info ); ?>
            <?php
            if ( ! dynamic_sidebar( 'sidebar-store' ) ) {
                $args = array(
                    'before_widget' => '<aside class="widget dokan-store-widget %s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h3 class="widget-title">',
                    'after_title'   => '</h3>',
                );

                if ( class_exists( 'Dokan_Store_Location' ) ) {
                    the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Product Category', 'dokan-lite' ) ), $args );

                    if ( dokan_get_option( 'store_map', 'dokan_appearance', 'on' ) == 'on'  && !empty( $map_location ) ) {
                        the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'dokan-lite' ) ), $args );
                    }

                    if ( dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' ) == 'on' ) {
                        the_widget( 'Dokan_Store_Open_Close', array( 'title' => __( 'Store Time', 'dokan-lite' ) ), $args );
                    }

                    if ( dokan_get_option( 'contact_seller', 'dokan_appearance', 'on' ) == 'on' ) {
                        the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Vendor', 'dokan-lite' ) ), $args );
                    }
                }
            }
            ?>

            <?php do_action( 'dokan_sidebar_store_after', $store_user->data, $store_info ); ?>
        </div>
    </div><!-- #secondary .widget-area -->
    <?php
} else {
    get_sidebar( 'store' );
}
?>
<div class="row">
    <div id="dokan-primary" class="dokan-single-store" style="padding-bottom: 20px;">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' ); ?>

            <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

                <div class="seller-items">
                    <div id="product-loop" style="min-width: 80%">
                        <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop. ?>

                        <?php woocommerce_product_loop_end(); ?>
                    </div>

                    <?php
                        $seller_id = $store_user->id;
                        global $wpdb;
                        $categories = get_transient( 'dokan-store-categories-'.$seller_id );

                        if ( false === $categories ) {
                            $categories = $wpdb->get_results( $wpdb->prepare( "SELECT t.term_id,t.name FROM $wpdb->terms as t
                                LEFT JOIN $wpdb->term_taxonomy as tt on t.term_id = tt.term_id
                                LEFT JOIN $wpdb->term_relationships AS tr on tt.term_taxonomy_id = tr.term_taxonomy_id
                                LEFT JOIN $wpdb->posts AS p on tr.object_id = p.ID
                                WHERE tt.taxonomy = 'product_cat'
                                AND p.post_type = 'product'
                                AND p.post_status = 'publish'
                                AND p.post_author = %d
                                GROUP BY t.term_id
                                ORDER BY t.name ", $seller_id
                            ) );
                            set_transient( 'dokan-store-categories-'.$seller_id , $categories, 3600 );
                        }
                        if (!empty($categories)) {
                        ?>
                        <div class="product-category-select" style="padding-top: 20px; padding-left: 20px; min-width: 20%;">
                            <div style="border: 1px solid #eeeeee; padding-left: 30px; padding-top: 20px; position: sticky; top: 0;">
                                <h4>Kategooria</h4>
                                <ul style="list-style: none">
                                    <li style="margin-bottom: 2px;">
                                        <a class="product-category product-category-selected" data-category-id="0" data-store="<?php echo $store_user->data->user_nicename ?>">
                                            <span style="color: #008400">Kõik</span>
                                        </a>
                                    </li>
                                    <?php foreach ($categories as $category) {?>
                                        <li style="margin-bottom: 2px;">
                                            <a class="product-category" data-category-id="<?php echo $category->term_id ?>" data-store="<?php echo $store_user->data->user_nicename ?>">
                                                <span style="color: #008400"><?php echo $category->name ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                     <?php } ?>

                </div>

                <?php dokan_content_nav( 'nav-below' ); ?>

            <?php } else { ?>

                <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'dokan-lite' ); ?></p>

            <?php } ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'include_store_reviews' ); ?>
    <?php do_action( 'woocommerce_after_main_content' ); ?>
</div>
<?php get_footer( 'shop' ); ?>
<script>
    jQuery( document ).ready( function ( $ ) {
        $(".product-category").click(function() {
            $(".product-category").each(function( index ) {
                $( this ).removeClass("product-category-selected");
            });
            $( this ).addClass( "product-category-selected" );
            var category_id = $(this).data('category-id');
            $(".product-warp-item").each(function( index ) {
                $( this ).removeClass("display_none");
                var product_category_ids = $(this).data('category-ids');
                if (category_id != '0' && !product_category_ids.includes(';'+category_id+';')) {
                    $( this ).addClass( "display_none" );
                }
            });
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".seller-items").offset().top
            }, 1000);
        });
    } );
</script>
