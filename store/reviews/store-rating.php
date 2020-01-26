<?php

class Store_Rating {

    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new Store_Rating();
        }

        return $instance;
    }

    public function __construct() {
        add_action( 'dokan_after_store_tabs', array( $this, 'render_add_rating_button' ), 1 );
    }

    function render_add_rating_button($seller_id) {
        $seller_id = get_userdata( get_query_var( 'author' ) )->ID;

        //check if valid customer to proceed
        if ( !DSR_View::init()->check_if_valid_customer( $seller_id, get_current_user_id() ) ) {
            return;
        }

        $args = array(
            'post_type'   => 'dokan_store_reviews',
            'meta_key'    => 'store_id',
            'meta_value'  => $seller_id,
            'author'      => get_current_user_id(),
            'post_status' => 'publish'
        );

        $query = new WP_Query( $args );

        if ( $query->posts ) {
            return;
        }

        ?>
        <li class="dokan-share-btn-wrap dokan-right">
            <div class="dokan-review-wrapper">
                <button class='dokan-btn dokan-btn-sm dokan-btn-theme add-review-btn' style="margin-top: 3px;" data-store_id ='<?php echo $seller_id ?>' ><?php _e(' Write a Review ', 'dokan' ) ?></button>
            </div>
        </li>
        <?php
    }

    function get_readable_rating($seller_id, $number_only = false) {
        $vendor = dokan()->vendor->get( $seller_id );
        $rating = $vendor->get_rating();
        if ( ! $rating['count'] ) {
            $html = __( 'No reviews found yet!', 'dokan-lite' );
        } else {
            $review_text = '';
            if ($number_only == true) {
                $review_text = $rating['rating'];
            } else {
                $long_text   = _n( '%s rating from %d review', '%s rating from %d reviews', $rating['count'], 'dokan-lite' );
                $review_text = sprintf( $long_text, $rating['rating'], $rating['count'] );
            }
            $width = (intval($rating['rating']) / 5) * 100;
            $html = '<a id="rating-link" class="rating-link"><div class="dokan-rating" style="display: flex;">
                        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" style="margin-top: 4px;">
                            <span style="width:' . $width . '%"></span>
                        </div>
                        '.$review_text.'
                    </div></a>';
        }
        return $html;
    }
}