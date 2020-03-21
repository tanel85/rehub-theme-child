<?php
/**
 * Dokan Dashboard Settings Store Form Template
 *
 * @since 2.4
 */
?>
<?php
$gravatar_id    = ! empty( $profile_info['gravatar'] ) ? $profile_info['gravatar'] : 0;
$banner_id      = ! empty( $profile_info['banner'] ) ? $profile_info['banner'] : 0;
$storename      = isset( $profile_info['store_name'] ) ? $profile_info['store_name'] : '';
$phone          = isset( $profile_info['phone'] ) ? $profile_info['phone'] : '';

$address         = isset( $profile_info['address'] ) ? $profile_info['address'] : '';
$address_street1 = isset( $profile_info['address']['street_1'] ) ? $profile_info['address']['street_1'] : '';
$address_city    = isset( $profile_info['address']['city'] ) ? $profile_info['address']['city'] : '';
$address_zip     = isset( $profile_info['address']['zip'] ) ? $profile_info['address']['zip'] : '';
$address_country = 'EE';
$address_state   = isset( $profile_info['address']['state'] ) ? $profile_info['address']['state'] : '';

$map_location   = isset( $profile_info['location'] ) ? $profile_info['location'] : '';
$map_address    = isset( $profile_info['find_address'] ) ? $profile_info['find_address'] : '';
$dokan_category = isset( $profile_info['dokan_category'] ) ? $profile_info['dokan_category'] : '';
$enable_tnc     = isset( $profile_info['enable_tnc'] ) ? $profile_info['enable_tnc'] : '';
$store_tnc      = isset( $profile_info['store_tnc'] ) ? $profile_info['store_tnc'] : '';

if ( is_wp_error( $validate ) ) {
	$get_data = wp_unslash( $_POST );

	$storename    = sanitize_text_field( $get_data['dokan_store_name'] ); // WPCS: CSRF ok, Input var ok.
	$map_location = sanitize_text_field( $get_data['location'] );         // WPCS: CSRF ok, Input var ok.
	$map_address  = sanitize_text_field( $get_data['find_address'] );     // WPCS: CSRF ok, Input var ok.

	$posted_address = wc_clean( $get_data['dokan_address'] ); // WPCS: CSRF ok, Input var ok.

	$address_street1 = sanitize_text_field( $posted_address['street_1'] );
	$address_street2 = sanitize_text_field( $posted_address['street_2'] );
	$address_city    = sanitize_text_field( $posted_address['city'] );
	$address_zip     = sanitize_text_field( $posted_address['zip'] );
	$address_country = 'EE';
	$address_state   = sanitize_text_field( $posted_address['state'] );
}

$dokan_appearance         = dokan_get_option( 'store_header_template', 'dokan_appearance', 'default' );
$show_store_open_close    = 'on';
$dokan_days               = array( 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' );
$all_times                = isset( $profile_info['dokan_store_time'] ) ? $profile_info['dokan_store_time'] : '';
$dokan_store_time_enabled = isset( $profile_info['dokan_store_time_enabled'] ) ? $profile_info['dokan_store_time_enabled'] : '';
$dokan_store_open_notice  = isset( $profile_info['dokan_store_open_notice'] ) ? $profile_info['dokan_store_open_notice'] : '';
$dokan_store_close_notice = isset( $profile_info['dokan_store_close_notice'] ) ? $profile_info['dokan_store_close_notice'] : '';

$main_user_name          = isset( $profile_info['main_user_name'] ) ? $profile_info['main_user_name'] : '';
$contact_email          = isset( $profile_info['contact_email'] ) ? $profile_info['contact_email'] : '';
$min_order          = isset( $profile_info['min_order'] ) ? $profile_info['min_order'] : '';
$min_reservation_time_open          = isset( $profile_info['min_reservation_time_open'] ) ? $profile_info['min_reservation_time_open'] : '';
$min_reservation_time_closed          = isset( $profile_info['min_reservation_time_closed'] ) ? $profile_info['min_reservation_time_closed'] : '';

?>
<?php do_action( 'dokan_settings_before_form', $current_user, $profile_info ); ?>

<form method="post" id="store-form"  action="" class="dokan-form-horizontal">

	<?php wp_nonce_field( 'dokan_store_settings_nonce' ); ?>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="dokan_store_name"><?php esc_html_e( 'Store Name', 'dokan-lite' ); ?></label>

        <div class="dokan-w5 dokan-text-left">
            <input id="dokan_store_name" required value="<?php echo esc_attr( $storename ); ?>" name="dokan_store_name" placeholder="<?php esc_attr_e( 'store name', 'dokan-lite' ); ?>" class="dokan-form-control" type="text">
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="main_user_name">
			<?php esc_html_e( 'Peakasutaja nimi', 'dokan-lite' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <input type="text" class="dokan-form-control" required name="main_user_name" id="main_user_name" placeholder="<?php esc_attr_e( 'Mainuser Name', 'dokan-lite' ); ?>" value="<?php echo esc_attr( $main_user_name ); ?>" />
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="contact_email">
			<?php esc_html_e( 'Email', 'dokan-lite' ); ?>
        </label>
        <div class="dokan-w5 dokan-text-left">
            <input type="text" class="dokan-form-control" required name="contact_email" id="contact_email" placeholder="<?php esc_attr_e( 'abc@def.ee', 'dokan-lite' ); ?>" value="<?php echo esc_attr( $contact_email ); ?>" />
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="setting_phone"><?php esc_html_e( 'Phone No', 'dokan-lite' ); ?></label>
        <div class="dokan-w5 dokan-text-left">
            <input id="setting_phone" required value="<?php echo esc_attr( $phone ); ?>" name="setting_phone" placeholder="<?php esc_attr_e( '1234567', 'dokan-lite' ); ?>" class="dokan-form-control input-md" type="text">
        </div>
    </div>

	<?php do_action( 'dokan_settings_after_store_name', $current_user, $profile_info ); ?>

    <br />
    <header class="dokan-dashboard-header" style="text-align:left;">
        <h1 class="entry-title"><span><?php esc_attr_e( 'Profiili info', 'dokan-lite' ); ?></span></h1>
    </header>

    <div class="dokan-banner">

        <div class="image-wrap<?php echo $banner_id ? '' : ' dokan-hide'; ?>">
			<?php $banner_url = $banner_id ? wp_get_attachment_url( $banner_id ) : ''; ?>
            <input type="hidden" class="dokan-file-field" value="<?php echo $banner_id; ?>" name="dokan_banner">
            <img class="dokan-banner-img" src="<?php echo esc_url( $banner_url ); ?>">

            <a class="close dokan-remove-banner-image">&times;</a>
        </div>

        <div class="button-area<?php echo $banner_id ? ' dokan-hide' : ''; ?>">
            <i class="fa fa-cloud-upload"></i>

            <a href="#" class="dokan-banner-drag dokan-btn dokan-btn-info dokan-theme"><?php esc_html_e( 'Upload banner', 'dokan-lite' ); ?></a>
            <p class="help-block">
				<?php
				/**
				 * Filter `dokan_banner_upload_help`
				 *
				 * @since 2.4.10
				 */
				$general_settings = get_option( 'dokan_general', [] );
				$banner_width     = dokan_get_option( 'store_banner_width', 'dokan_appearance', 625 );
				$banner_height    = dokan_get_option( 'store_banner_height', 'dokan_appearance', 300 );

				$help_text = sprintf(
					__('Upload a banner for your store. Banner size is (%sx%s) pixels.', 'dokan-lite' ),
					$banner_width, $banner_height
				);

				echo esc_html( apply_filters( 'dokan_banner_upload_help', $help_text ) );
				?>
            </p>
        </div>
    </div>
    <!-- .dokan-banner -->

	<?php do_action( 'dokan_settings_after_banner', $current_user, $profile_info ); ?>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="dokan_gravatar"><?php esc_html_e( 'Profile Picture', 'dokan-lite' ); ?></label>

        <div class="dokan-w5 dokan-gravatar">
            <div class="dokan-left gravatar-wrap<?php echo $gravatar_id ? '' : ' dokan-hide'; ?>">
				<?php $gravatar_url = $gravatar_id ? wp_get_attachment_url( $gravatar_id ) : ''; ?>
                <input type="hidden" class="dokan-file-field" value="<?php echo esc_attr( $gravatar_id ); ?>" name="dokan_gravatar">
                <img class="dokan-gravatar-img" src="<?php echo esc_url( $gravatar_url ); ?>">
                <a class="dokan-close dokan-remove-gravatar-image">&times;</a>
            </div>
            <div class="gravatar-button-area<?php echo esc_attr( $gravatar_id ) ? ' dokan-hide' : ''; ?>">
                <a href="#" class="dokan-pro-gravatar-drag dokan-btn dokan-btn-default"><i class="fa fa-cloud-upload"></i> <?php esc_html_e( 'Upload Photo', 'dokan-lite' ); ?></a>
            </div>
        </div>
    </div>

	<?php do_action( 'dokan_settings_after_profile_picture', $current_user, $profile_info ); ?>

	<?php
	$verified = false;

	if ( isset( $profile_info['dokan_verification']['info']['store_address']['v_status'] ) ) {
		if ( $profile_info['dokan_verification']['info']['store_address']['v_status'] == 'approved' ){
			$verified = true;
		}
	}

	dokan_seller_address_fields_custom( $verified );

	?>
    <!--address-->

<!--vajalik geolocationi mapsi jaoks-->
<!--    <div class="dokan-form-group">-->
<!--        <label class="dokan-w3 dokan-control-label" for="setting_map">--><?php //esc_html_e( 'Map', 'dokan-lite' ); ?><!--</label>-->
<!---->
<!--        <div class="dokan-w6 dokan-text-left">-->
<!--            --><?php
//            dokan_get_template( 'maps/dokan-maps-with-search.php', array(
//                'map_location' => $map_location,
//                'map_address'  => $map_address,
//            ) );
//            ?>
<!--        </div> <!-- col.md-4 -->
<!--    </div> <!-- .dokan-form-group -->


    <!--terms and conditions enable or not -->
	<?php
	$tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );
	if ( $tnc_enable == 'on' ) :
		?>
        <div class="dokan-form-group">
            <label class="dokan-w3 dokan-control-label"><?php esc_html_e( 'Terms and Conditions', 'dokan-lite' ); ?></label>
            <div class="dokan-w5 dokan-text-left dokan_tock_check">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="dokan_store_tnc_enable" value="on" <?php echo $enable_tnc == 'on' ? 'checked':'' ; ?> name="dokan_store_tnc_enable"> <?php esc_html_e( 'Show terms and conditions in store page', 'dokan-lite' ); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="dokan-form-group" id="dokan_tnc_text">
            <label class="dokan-w3 dokan-control-label" for="dokan_store_tnc"><?php esc_html_e( 'TOC Details', 'dokan-lite' ); ?></label>
            <div class="dokan-w8 dokan-text-left">
				<?php
				$settings = array(
					'editor_height' => 200,
					'media_buttons' => false,
					'teeny'         => true,
					'quicktags'     => false
				);
				wp_editor( $store_tnc, 'dokan_store_tnc', $settings );
				?>
            </div>
        </div>

	<?php endif;?>

    <br />
    <header class="dokan-dashboard-header" style="text-align:left;">
        <h1 class="entry-title"><span><?php esc_attr_e( 'Lahtioleku ajad', 'dokan-lite' ); ?></span></h1>
    </header>

	<?php if ( $show_store_open_close == 'on' ) : ?>

        <div class="dokan-form-group store-open-close">
            <label class="dokan-w3 control-label"></label>
            <div class="dokan-w6" style="width: auto">
				<?php foreach ( $dokan_days as $key => $day ) : ?>
					<?php
					$status = isset( $all_times[$day]['status'] ) ? $all_times[$day]['status'] : '';
					$status = isset( $all_times[$day]['open'] ) ? $all_times[$day]['open'] : $status;
					?>
                    <div class="dokan-form-group">
                        <label class="day control-label" for="<?php echo esc_attr( $day ) ?>-opening-time">
							<?php echo esc_html( dokan_get_translated_days( $day ) ); ?>
                        </label>
                        <label for="">
                            <select name="<?php echo esc_attr( $day ) ?>_on_off" class="dokan-on-off dokan-form-control">
                                <option value="close" <?php ! empty( $status ) ? selected( $status, 'close' ) : '' ?> >
									<?php esc_html_e( 'Close', 'dokan-lite' ); ?>
                                </option>
                                <option value="open" <?php ! empty( $status ) ? selected( $status, 'open' ) : '' ?> >
									<?php esc_html_e( 'Open', 'dokan-lite' ); ?>
                                </option>
                            </select>
                        </label>
                        <label for="opening-time" class="time" style="visibility: <?php echo isset( $status ) && $status == 'open' ? 'visible' : 'hidden' ?>" >
                            <input type="text" class="dokan-form-control" name="<?php echo esc_attr( strtolower( $day ) ); ?>_opening_time" id="<?php echo esc_attr( $day ) ?>-opening-time" placeholder="<?php echo date_i18n( get_option( 'time_format', 'g:i a' ), current_time( 'timestamp' ) ); ?>" value="<?php echo isset( $all_times[$day]['opening_time'] ) ? esc_attr( $all_times[$day]['opening_time'] ) : '' ?>" >
                        </label>
                        <label for="closing-time" class="time" style="visibility: <?php echo isset( $status ) && $status == 'open' ? 'visible' : 'hidden' ?>" >
                            <input type="text" class="dokan-form-control" name="<?php echo esc_attr( $day ) ?>_closing_time" id="<?php echo esc_attr( $day ) ?>-closing-time" placeholder="<?php echo date_i18n( get_option( 'time_format', 'g:i a' ), current_time( 'timestamp' ) ); ?>" value="<?php echo isset( $all_times[$day]['closing_time'] ) ? esc_attr( $all_times[$day]['closing_time'] ) : '' ?>">
                        </label>
                    </div>
				<?php endforeach; ?>
            </div>
        </div>

	<?php endif; ?>


    <br />
    <header class="dokan-dashboard-header" style="text-align:left;">
        <h1 class="entry-title"><span><?php esc_attr_e( 'Tellimuste andmed', 'dokan-lite' ); ?></span></h1>
    </header>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="min_order">
            <?php esc_html_e( 'Minimaalne tellimuse väärtus', 'dokan-lite' ); ?>
        </label>
        <div class="dokan-w3 dokan-text-left">
            <input placeholder="<?php esc_html_e( 'eurodes', 'dokan-lite' ); ?>" type="number" class="dokan-form-control" name="min_order" id="min_order" value="<?php echo esc_attr( $min_order ); ?>" />
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="min_reservation_time_open">
            <?php esc_html_e( 'Minimaalne ettetellimise aeg lahtioleku aegadel', 'dokan-lite' ); ?>
        </label>
        <div class="dokan-w3 dokan-text-left">
            <input placeholder="<?php esc_html_e( 'tundides', 'dokan-lite' ); ?>" type="number" class="dokan-form-control" name="min_reservation_time_open" id="min_reservation_time_open" value="<?php echo esc_attr( $min_reservation_time_open ); ?>" />
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 dokan-control-label" for="min_reservation_time_closed">
            <?php esc_html_e( 'Minimaalne ettetellimise aeg väljaspool tööaega', 'dokan-lite' ); ?>
        </label>
        <div class="dokan-w3 dokan-text-left">
            <input placeholder="<?php esc_html_e( 'tundides', 'dokan-lite' ); ?>" type="number" class="dokan-form-control" name="min_reservation_time_closed" id="min_reservation_time_closed" value="<?php echo esc_attr( $min_reservation_time_closed ); ?>" />
        </div>
    </div>

    <br />
    <header class="dokan-dashboard-header" style="text-align:left;">
        <h1 class="entry-title"><span><?php esc_attr_e( 'Tellimuste peatamine', 'dokan-lite' ); ?></span></h1>
    </header>

	<?php do_action( 'dokan_settings_form_bottom', $current_user, $profile_info ); ?>

    <div class="dokan-form-group">

        <div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
            <input type="submit" name="dokan_update_store_settings" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Settings', 'dokan-lite' ); ?>">
        </div>
    </div>
</form>

<style>
    .dokan-settings-content .dokan-settings-area .dokan-banner {
        width: <?php echo esc_attr( $banner_width ) . 'px'; ?>;
        height: <?php echo esc_attr( $banner_height ) . 'px'; ?>;
    }

    .dokan-settings-content .dokan-settings-area .dokan-banner .dokan-remove-banner-image {
        height: <?php echo esc_attr( $banner_height ) . 'px'; ?>;
    }
    .store-open-close .dokan-form-group {
        text-align: left;
        display: flex;
    }
    .store-open-close .dokan-w6 {
        width: 50% !important;
    }
    .store-open-close label.day {
        width: 200px;
    }
    .store-open-close label.time {
        padding-left: 5px;
    }
    .store-open-close select.dokan-form-control {
        width: auto;
    }
    @media only screen and ( max-width: 415px ) {
        .store-open-close label:first-child {
            width: 100%;
            text-align: left;
        }
        .store-open-close  .time input {
            width: 75px;
        }
        .store-open-close .dokan-form-group:first-child {
            margin-top: 50px
        }
        .store-open-close label.day.control-label {
            width: 0;
            padding-right: 85px;
        }
    }

</style>
<script type="text/javascript">

    (function($) {

        $( '.dokan-on-off' ).on( 'change', function() {
            var self = $(this);

            if ( self.val() == 'open' ) {
                self.closest('.dokan-form-group').find('.time').css({'visibility': 'visible'});
                self.closest('.store-open-close').find('.dokan-w6').addClass('dokan-text-left');
                self.closest('.store-open-close').find('.dokan-w6').css({'width': '50%'});
            } else {
                self.closest('.dokan-form-group').find('.time').css({'visibility': 'hidden'});
                self.closest('.store-open-close').find('.dokan-w6').removeClass('dokan-text-left');
                self.closest('.store-open-close').find('.dokan-w6').css({'width': 'auto'});
            }

        } );
        $( '.time .dokan-form-control' ).timepicker({
            scrollDefault: 'now',
            timeFormat: '<?php echo get_option( 'time_format' ); ?>',
            step: <?php echo 'h' === strtolower( get_option( 'time_format' ) ) ? '60' : '30'; ?>
        });
        // dokan store open close scripts end //

        $(function() {

            $('#setting_phone').keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 91, 107, 109, 110, 187, 189, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }

                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

        });
    })(jQuery);
</script>
