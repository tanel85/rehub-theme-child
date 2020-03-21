<div id="dokan-seller-listing-wrap" class="row" style="margin-left: auto; margin-right: auto; padding-bottom: 20px;">
    <div class="large-12 columns nasa-content-page-products seller-listing-content">
        <?php if ( $sellers['users'] ) : ?>
            <ul class="products list large-block-grid-4 small-block-grid-1 medium-block-grid-2" data-columns_small="1" data-columns_medium="2">
                <?php
                foreach ( $sellers['users'] as $seller ) {
                    $vendor            = dokan()->vendor->get( $seller->ID );
                    $store_banner_id   = $vendor->get_banner_id();
                    $store_name        = $vendor->get_shop_name();
                    $store_biography   = $vendor->get_vendor_biography();
                    $store_min_order   = $vendor->get_min_order();
                    $store_url         = $vendor->get_shop_url();
//                    $store_info        = dokan_get_store_info( $seller->ID ); // vajalik geolocationi jaoks
                    $store_banner_url  = $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, 'thumbnail' ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';

                    $store_banner_url_mobile  = $store_banner_id ? wp_get_attachment_image_src( $store_banner_id, $image_size ) : DOKAN_PLUGIN_ASSEST . '/images/default-store-banner.png';
                    ?>

                    <li class="product-warp-item">
                        <div class="wow fadeInUp product-item grid hover-fade animated" data-wow-duration="1s" data-wow-delay="0ms" data-wow="fadeInUp" style="visibility: visible; animation-duration: 1s; animation-delay: 0ms; animation-name: fadeInUp;">

                            <div class="inner-wrap">
                                <div class="product-outner">
                                    <div class="product-inner" onclick="location.href='<?php echo esc_attr( $store_url ); ?>';" style="cursor: pointer;">
                                        <div class="product-img-wrap" style="cursor: pointer">
                                            <div class="product-img-wrap-inner">
                                                <a href="<?php echo esc_url( $store_url ); ?>">
                                                    <img class="comecater-store-banner-large-screen" src="<?php echo is_array( $store_banner_url ) ? esc_attr( $store_banner_url[0] ) : esc_attr( $store_banner_url ); ?>">
                                                    <img class="comecater-store-banner-small-screen" src="<?php echo is_array( $store_banner_url_mobile ) ? esc_attr( $store_banner_url_mobile[0] ) : esc_attr( $store_banner_url_mobile ); ?>">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="product-info-wrap" style="cursor: pointer">
                                            <div class="info store_list_loop comecater-store-name">
                                                <div class="name nasa-show-one-line">
                                                    <a href="<?php echo esc_attr( $store_url ); ?>"><?php echo esc_html( $store_name ); ?></a>
                                                </div>
                                            </div>
                                            <div class="info_main product-des-wrap">
                                                <hr class="nasa-list-hr">
                                                    <p><?php echo esc_html( $store_biography ); ?></p>
                                            </div>
                                        </div>

                                        <!-- Clone Group btns for layout List -->
                                        <div class="hidden-tag nasa-list-stock-wrap">
                                        </div>
                                        <div class="group-btn-in-list-wrap hidden-tag">
                                            <div class="group-btn-in-list" style="padding-top: 25px;">
                                                <div class="price-wrap">
                                                    <span class="price"><span class="woocommerce-Price-amount amount"><?php echo Store_Rating::init()->get_readable_rating( $seller->ID, true ); ?></span>
                                                    </span>
                                                </div>
                                                <p><?php echo isset($store_min_order) ? __('Min. tellimus', 'dokan') . ' ' . $store_min_order . '€' : ' ' ?></p>
                                                <div class="product-summary">
                                                    <div class="product-interactions">
                                                        <div class="add-to-cart-btn">
                                                            <div class="btn-link"><a href="<?php echo esc_attr( $store_url ); ?>" class="add-to-cart-grid"><span class="add_to_cart_text store_list_loop"><?php esc_attr_e( 'Vaata', 'dokan-lite' );?></span></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
<!--                        --><?php //do_action( 'dokan_seller_listing_footer_content', $seller, $store_info ); ?><!--vajalik geolocationi mapsi jaoks-->
                    </li>

                <?php } ?>
                <div class="dokan-clearfix"></div>
            </ul> <!-- .dokan-seller-wrap -->

            <?php
            $user_count   = $sellers['count'];
            $num_of_pages = ceil( $user_count / $limit );

            if ( $num_of_pages > 1 ) {
                echo '<div class="pagination-container clearfix">';

                $pagination_args = array(
                    'current'   => $paged,
                    'total'     => $num_of_pages,
                    'base'      => $pagination_base,
                    'type'      => 'array',
                    'prev_text' => __( '&larr; Previous', 'dokan-lite' ),
                    'next_text' => __( 'Next &rarr;', 'dokan-lite' ),
                );

                if ( ! empty( $search_query ) ) {
                    $pagination_args['add_args'] = array(
                        'dokan_seller_search' => $search_query,
                    );
                }

                $page_links = paginate_links( $pagination_args );

                if ( $page_links ) {
                    $pagination_links  = '<div class="pagination-wrap">';
                    $pagination_links .= '<ul class="pagination"><li>';
                    $pagination_links .= join( "</li>\n\t<li>", $page_links );
                    $pagination_links .= "</li>\n</ul>\n";
                    $pagination_links .= '</div>';

                    echo $pagination_links; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
                }

                echo '</div>';
            }
            ?>

        <?php else:  ?>
            <p class="dokan-error"><?php esc_html_e( 'No vendor found!', 'dokan-lite' ); ?></p>
        <?php endif; ?>
    </div>
</div>
