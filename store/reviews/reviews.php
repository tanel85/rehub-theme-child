<?php
$store_info             = dokan()->vendor->get( get_query_var( 'author' ) );
$dokan_template_reviews = Dokan_Pro_Reviews::init();
$reviews_list_component = Reviews_List::init();
$id                     = $store_info->id;
$post_type              = 'product';
$limit                  = 20;
$status                 = '1';
?>
    <div id="reviews">
        <div id="comments" class="dokan-single-store dokan-w8 store-reviews">

            <?php echo $reviews_list_component->add_or_edit_review(); ?>

            <h2 class="headline"><?php _e( 'Hinnangud cateringile ', 'dokan' ); echo ' '.$store_info->get_shop_name(); ?></h2>

            <ol class="commentlist">
                <?php echo $reviews_list_component->get_ratings_list($store_info->id); ?>
            </ol>

        </div>
    </div>

<?php echo $dokan_template_reviews->review_pagination( $id, $post_type, $limit, $status ); ?>