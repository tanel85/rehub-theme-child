<?php
/**
 * Show users all comments and process all bulk action
 *
 * @author Asaquzzaman
 */
class Reviews_List {

    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Reviews_List();
        }

        return $instance;
    }

    function add_or_edit_review() {

        $seller_id = get_userdata( get_query_var( 'author' ) )->ID;

        //check if valid customer to proceed
        if ( !DSR_View::init()->check_if_valid_customer( $seller_id, get_current_user_id() ) ) {
            return;
        }
        //show add review or edit review

        $args = array(
            'post_type'   => 'dokan_store_reviews',
            'meta_key'    => 'store_id',
            'meta_value'  => $seller_id,
            'author'      => get_current_user_id(),
            'post_status' => 'publish'
        );

        $query = new WP_Query( $args );
        ob_start();

        if ( $query->posts ) {
            ?>
            <h3><?php _e( 'Your Review', 'dokan' ) ?></h3>
            <ol class="commentlist" id="dokan-store-review-single">
                <?php echo $this->render_review_list( $query->posts, __( 'No Reviews found', 'dokan' ) );?>
            </ol>
            <?php

        } else {
            DSR_View::init()->render_add_review_button( $seller_id );
        }

        ob_get_flush();
        wp_reset_postdata();
    }

    function get_ratings_list( $store_id ) {

        $args = array(
            'post_type'      => 'dokan_store_reviews',
            'meta_key'       => 'store_id',
            'meta_value'     => $store_id,
            'post_status'    => 'publish',
            'author__not_in' => array( get_current_user_id(), $store_id )
        );

        $query = new WP_Query( $args );
        $no_review_msg = apply_filters( 'dsr_no_review_found_msg', 'No Reviews found' );
        ob_start();

        $this->render_review_list( $query->posts, $no_review_msg );

        wp_reset_postdata();

        return ob_get_clean();
    }

    function render_review_list( $posts, $msg ) {

        if ( count( $posts ) == 0 ) {
            echo '<span colspan="5">' . __( $msg, 'dokan' ) . '</span>';
            return;
        }
        foreach ( $posts as $review ) {

            $review_date       = get_the_time( 'd.m.Y H:i', $review );
            $rating = get_post_meta( $review->ID, 'rating', true );
            ?>
            <div class="review-item">
                <div class="review-item-rating">
                    <div style="margin-top: 0.2em; white-space: nowrap;">
                        <?php echo $review_date;?>
                    </div>
                    <div class="dokan-rating">
                        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'dokan' ), $rating ) ?>">
                            <span style="width:<?php echo ( intval( $rating ) / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'dokan' ); ?></span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4><?php echo $review->post_title ?></h4>
                    <p><?php echo $review->post_content ?></p>
                    <?php
                    if ( get_current_user_id() == $review->post_author ) {
                        $seller_id = get_post_meta( $review->ID, 'store_id', true );
                        ob_start();
                        DSR_View::init()->render_edit_review_button( $seller_id, $review->ID );
                        ob_get_flush();
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
}
