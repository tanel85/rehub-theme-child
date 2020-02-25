<?php
$store_user               = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info               = $store_user->get_shop_info();
$social_info              = $store_user->get_social_profiles();
$store_tabs               = dokan_get_store_tabs( $store_user->get_id() );
$social_fields            = dokan_get_social_profile_fields();
$store_min_order          = $store_user->get_min_order();

$dokan_appearance         = get_option( 'dokan_appearance' );
$profile_layout           = empty( $dokan_appearance['store_header_template'] ) ? 'default' : $dokan_appearance['store_header_template'];
$store_address            = dokan_get_seller_short_address( $store_user->get_id(), false );

$dokan_store_time_enabled = isset( $store_info['dokan_store_time_enabled'] ) ? $store_info['dokan_store_time_enabled'] : '';
$store_open_notice        = isset( $store_info['dokan_store_open_notice'] ) && ! empty( $store_info['dokan_store_open_notice'] ) ? $store_info['dokan_store_open_notice'] : __( 'Store Open', 'dokan-lite' );
$store_closed_notice      = isset( $store_info['dokan_store_close_notice'] ) && ! empty( $store_info['dokan_store_close_notice'] ) ? $store_info['dokan_store_close_notice'] : __( 'Store Closed', 'dokan-lite' );
$show_store_open_close    = dokan_get_option( 'store_open_close', 'dokan_appearance', 'on' );

$general_settings         = get_option( 'dokan_general', [] );
$banner_width             = dokan_get_option( 'store_banner_width', 'dokan_appearance', 625 );

if ( ( 'default' === $profile_layout ) || ( 'layout2' === $profile_layout ) ) {
    $profile_img_class = 'profile-img-circle';
} else {
    $profile_img_class = 'profile-img-square';
}

if ( 'layout3' === $profile_layout ) {
    unset( $store_info['banner'] );

    $no_banner_class      = ' profile-frame-no-banner';
    $no_banner_class_tabs = ' dokan-store-tabs-no-banner';

} else {
    $no_banner_class      = '';
    $no_banner_class_tabs = '';
}

?>
<div style="padding-bottom: 20px"><i class="arrow right"></i><a class="comecater-info-link" href="/stores">Tagasi otsingusse</a></div>
<div class="profile-frame<?php echo esc_attr( $no_banner_class ); ?>">

    <div class="profile-info-box profile-layout-<?php echo esc_attr( $profile_layout ); ?>">
        <?php if ( $store_user->get_banner() ) { ?>
            <img src="<?php echo esc_url( $store_user->get_banner() ); ?>"
                 alt="<?php echo esc_attr( $store_user->get_shop_name() ); ?>"
                 title="<?php echo esc_attr( $store_user->get_shop_name() ); ?>"
                 class="profile-info-img">
        <?php } else { ?>
            <div class="profile-info-img dummy-image">&nbsp;</div>
        <?php } ?>

        <div class="profile-info-summery-wrapper dokan-clearfix">
            <div class="profile-info-summery">
                <div class="profile-info-head">
                    <div class="profile-img <?php echo esc_attr( $profile_img_class ); ?>">
                        <img src="<?php echo esc_url( $store_user->get_avatar() ) ?>"
                             alt="<?php echo esc_attr( $store_user->get_shop_name() ) ?>"
                             size="150">
                    </div>
                    <?php if ( ! empty( $store_user->get_shop_name() ) && 'default' === $profile_layout ) { ?>
                        <h1 class="store-name"><?php echo esc_html( $store_user->get_shop_name() ); ?></h1>
                    <?php } ?>
                </div>

                <div class="profile-info">
                    <div class="profile-info-inner-first">
                        <?php if ( ! empty( $store_user->get_shop_name() ) && 'default' !== $profile_layout ) { ?>
                            <h1 class="store-name"><?php echo esc_html( $store_user->get_shop_name() ); ?></h1>
                        <?php } ?>

                        <?php if ( ! empty( $store_user->get_vendor_biography() )) { ?>
                            <?php echo $store_user->get_vendor_biography(); ?>
                        <?php } ?>
                    </div>
                    <div class="profile-info-inner-second">
                        <ul class="dokan-store-info">

                            <li class="dokan-store-rating store_header_details" style="margin-left: -20px;">
                                <?php echo Store_Rating::init()->get_readable_rating( $store_user->get_id() ); ?>
                            </li>

                            <?php if ( isset( $store_address ) && !empty( $store_address ) ) { ?>
                                <li class="dokan-store-address store_header_details" style="padding-bottom: 0px;"><i style="margin-left: -20px;" class="fa fa-map-marker"></i>
                                    <?php echo $store_address; ?>
                                </li>
                            <?php } ?>

                            <?php if ( isset( $store_min_order ) && !empty( $store_min_order ) ) { ?>
                                <li class="dokan-store-address store_header_details"><i style="margin-left: -20px;" class="fa fa-eur"></i>
                                    <?php echo __('Min. tellimus', 'dokan') . ' ' . $store_min_order . '€'; ?>
                                </li>
                            <?php } ?>

                            <?php do_action( 'dokan_store_header_info_fields',  $store_user->get_id() ); ?>
                        </ul>

                        <?php if ( $social_fields ) { ?>
                            <div class="store-social-wrapper">
                                <ul class="store-social">
                                    <?php foreach( $social_fields as $key => $field ) { ?>
                                        <?php if ( !empty( $social_info[ $key ] ) ) { ?>
                                            <li>
                                                <a href="<?php echo esc_url( $social_info[ $key ] ); ?>" target="_blank"><i class="fa fa-<?php echo esc_attr( $field['icon'] ); ?>"></i></a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>

                    </div>

                </div> <!-- .profile-info -->
                <?php do_action( 'dokan_after_store_tabs', $store_user->get_id() ); ?>
            </div><!-- .profile-info-summery -->
        </div><!-- .profile-info-summery-wrapper -->
    </div> <!-- .profile-info-box -->
</div> <!-- .profile-frame -->

<?php if ( $store_tabs ) { ?>
    <div class="dokan-store-tabs<?php echo esc_attr( $no_banner_class_tabs ); ?>">
        <ul class="dokan-list-inline">
            <?php foreach( $store_tabs as $key => $tab ) { ?>
                <?php if ( $tab['url'] ): ?>
                    <li><a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo esc_html( $tab['title'] ); ?></a></li>
                <?php endif; ?>
            <?php } ?>
            <?php do_action( 'dokan_after_store_tabs', $store_user->get_id() ); ?>
        </ul>
    </div>
<?php } ?>

<script>
    jQuery( document ).ready( function ( $ ) {
        $("#rating-link").click(function() {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#reviews").offset().top
            }, 1000);
        });
    } );
</script>
