<?php

$event_laste_synnipaev = isset( $profile_info['events']['laste_synnipaev'] ) ? $profile_info['events']['laste_synnipaev'] : '';
$event_kohvipaus = isset( $profile_info['events']['kohvipaus'] ) ? $profile_info['events']['kohvipaus'] : '';
$event_yhine_louna = isset( $profile_info['events']['yhine_louna'] ) ? $profile_info['events']['yhine_louna'] : '';
$event_firma_pidu = isset( $profile_info['events']['firma_pidu'] ) ? $profile_info['events']['firma_pidu'] : '';
$event_hommikusook = isset( $profile_info['events']['hommikusook'] ) ? $profile_info['events']['hommikusook'] : '';
$event_grillpidu = isset( $profile_info['events']['grillpidu'] ) ? $profile_info['events']['grillpidu'] : '';
$event_synnipaev = isset( $profile_info['events']['synnipaev'] ) ? $profile_info['events']['synnipaev'] : '';
$event_peielaud = isset( $profile_info['events']['peielaud'] ) ? $profile_info['events']['peielaud'] : '';
$event_pidulik_ohtusook = isset( $profile_info['events']['pidulik_ohtusook'] ) ? $profile_info['events']['pidulik_ohtusook'] : '';
$event_konverents = isset( $profile_info['events']['konverents'] ) ? $profile_info['events']['konverents'] : '';
$event_bankett = isset( $profile_info['events']['bankett'] ) ? $profile_info['events']['bankett'] : '';
$event_pulm = isset( $profile_info['events']['pulm'] ) ? $profile_info['events']['pulm'] : '';

?>
<form method="post" id="services-form"  action="" class="dokan-form-horizontal">
	<?php wp_nonce_field( 'vendor_services_nonce' ); ?>

<!--    Events -->
    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
		    <?php esc_html_e( 'Sündmused', 'dokan-lite' ); ?>
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="laste_synnipaev" class="control-label">
                    <input type="checkbox" name="laste_synnipaev" id="laste_synnipaev" value="yes" <?php echo $event_laste_synnipaev == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Laste sünnipäev', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="kohvipaus" class="control-label">
                    <input type="checkbox" name="kohvipaus" id="kohvipaus" value="yes" <?php echo $event_kohvipaus == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Kohvipaus', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="yhine_louna" class="control-label">
                    <input type="checkbox" name="yhine_louna" id="yhine_louna" value="yes" <?php echo $event_yhine_louna == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Ühine lõuna', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="firma_pidu" class="control-label">
                    <input type="checkbox" name="firma_pidu" id="firma_pidu" value="yes" <?php echo $event_firma_pidu == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Firma pidu', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="hommikusook" class="control-label">
                    <input type="checkbox" name="hommikusook" id="hommikusook" value="yes" <?php echo $event_hommikusook == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Hommikusöök', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="grillpidu" class="control-label">
                    <input type="checkbox" name="grillpidu" id="grillpidu" value="yes" <?php echo $event_grillpidu == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Grillpidu', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="synnipaev" class="control-label">
                    <input type="checkbox" name="synnipaev" id="synnipaev" value="yes" <?php echo $event_synnipaev == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Sünnipäev', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="peielaud" class="control-label">
                    <input type="checkbox" name="peielaud" id="peielaud" value="yes" <?php echo $event_peielaud == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Peielaud', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="pidulik_ohtusook" class="control-label">
                    <input type="checkbox" name="pidulik_ohtusook" id="pidulik_ohtusook" value="yes" <?php echo $event_pidulik_ohtusook == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Pidulik õhtusöök', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="konverents" class="control-label">
                    <input type="checkbox" name="konverents" id="konverents" value="yes" <?php echo $event_konverents == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Konverents', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="bankett" class="control-label">
                    <input type="checkbox" name="bankett" id="bankett" value="yes" <?php echo $event_bankett == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Bankett', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="pulm" class="control-label">
                    <input type="checkbox" name="pulm" id="pulm" value="yes" <?php echo $event_pulm == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Pulm', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

	<div class="dokan-form-group">
		<div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
			<input type="submit" id="update_services" name="update_services" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Salvesta sündmused', 'dokan-lite' ); ?>">
		</div>
	</div>
</form>

<style>
    .service-group {
        margin-bottom: 0px;
    }
</style>
<script type="text/javascript">
    jQuery( document ).ready( function ( $ ) {
        $('#update_services').click(function () {
            var self = $("form#services-form"),
                form_data = self.serialize() + '&action=dokan_seller_services';

            self.find('.ajax_prev').append('<span class="dokan-loading"> </span>');
            $.post(dokan.ajaxurl, form_data, function (resp) {

                self.find('span.dokan-loading').remove();
                $('html,body').animate({scrollTop: 100});

                if (resp.success) {
                    // Harcoded Customization for template-settings function
                    $('.dokan-ajax-response').html($('<div/>', {
                        'class': 'dokan-alert dokan-alert-success',
                        'html': '<p>' + resp.data.msg + '</p>',
                    }));

                    $('.dokan-ajax-response').append(resp.data.progress);

                } else {
                    $('.dokan-ajax-response').html($('<div/>', {
                        'class': 'dokan-alert dokan-alert-danger',
                        'html': '<p>' + resp.data + '</p>'
                    }));
                }
            });
            return false;
        });
    });
</script>