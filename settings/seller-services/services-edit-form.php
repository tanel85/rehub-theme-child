<?php

//hommikusöök, lõuna, soe buffee, külm buffee, suupisted, magus

$food_option_breakfast = isset( $profile_info['food_options']['breakfast'] ) ? $profile_info['food_options']['breakfast'] : '';
$food_option_lunch = isset( $profile_info['food_options']['lunch'] ) ? $profile_info['food_options']['lunch'] : '';
$food_option_hot_buffet = isset( $profile_info['food_options']['hot_buffet'] ) ? $profile_info['food_options']['hot_buffet'] : '';
$food_option_cold_buffet = isset( $profile_info['food_options']['cold_buffet'] ) ? $profile_info['food_options']['cold_buffet'] : '';
$food_option_appetizer = isset( $profile_info['food_options']['appetizer'] ) ? $profile_info['food_options']['appetizer'] : '';
$food_option_dessert = isset( $profile_info['food_options']['dessert'] ) ? $profile_info['food_options']['dessert'] : '';

$event_seminar = isset( $profile_info['events']['seminar'] ) ? $profile_info['events']['seminar'] : '';
$event_laste_synnipaev = isset( $profile_info['events']['laste_synnipaev'] ) ? $profile_info['events']['laste_synnipaev'] : '';
$event_kohvipaus = isset( $profile_info['events']['kohvipaus'] ) ? $profile_info['events']['kohvipaus'] : '';
$event_grill = isset( $profile_info['events']['grill'] ) ? $profile_info['events']['grill'] : '';
$event_konverents = isset( $profile_info['events']['konverents'] ) ? $profile_info['events']['konverents'] : '';
$event_synnipaev = isset( $profile_info['events']['synnipaev'] ) ? $profile_info['events']['synnipaev'] : '';
$event_louna_kontoris = isset( $profile_info['events']['louna_kontoris'] ) ? $profile_info['events']['louna_kontoris'] : '';

$diet_vegan = isset( $profile_info['diets']['vegan'] ) ? $profile_info['diets']['vegan'] : '';
$diet_vegetarian = isset( $profile_info['diets']['vegetarian'] ) ? $profile_info['diets']['vegetarian'] : '';
$diet_gluten_free = isset( $profile_info['diets']['gluten_free'] ) ? $profile_info['diets']['gluten_free'] : '';

$additional_service_cutlery = isset( $profile_info['additional_services']['cutlery'] ) ? $profile_info['additional_services']['cutlery'] : '';
$additional_service_tables = isset( $profile_info['additional_services']['tables'] ) ? $profile_info['additional_services']['tables'] : '';
$additional_service_servicing = isset( $profile_info['additional_services']['servicing'] ) ? $profile_info['additional_services']['servicing'] : '';
?>
<form method="post" id="services-form"  action="" class="dokan-form-horizontal">
	<?php wp_nonce_field( 'vendor_services_nonce' ); ?>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
			<?php esc_html_e( 'Food options', 'dokan-lite' ); ?>
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="breakfast" class="control-label">
                    <input type="checkbox" name="breakfast" id="breakfast" value="yes" <?php echo $food_option_breakfast == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Breakfast', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="lunch" class="control-label">
                    <input type="checkbox" name="lunch" id="lunch" value="yes" <?php echo $food_option_lunch == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Lunch', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="hot_buffet" class="control-label">
                    <input type="checkbox" name="hot_buffet" id="hot_buffet" value="yes" <?php echo $food_option_hot_buffet == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Hot buffet', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="cold_buffet" class="control-label">
                    <input type="checkbox" name="cold_buffet" id="cold_buffet" value="yes" <?php echo $food_option_cold_buffet == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Cold buffet', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="appetizer" class="control-label">
                    <input type="checkbox" name="appetizer" id="appetizer" value="yes" <?php echo $food_option_appetizer == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Appetizers', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="dessert" class="control-label">
                    <input type="checkbox" name="dessert" id="dessert" value="yes" <?php echo $food_option_dessert == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Dessert', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>


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
                <label for="seminar" class="control-label">
                    <input type="checkbox" name="seminar" id="seminar" value="yes" <?php echo $event_seminar == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Seminar', 'dokan-lite' ); ?>
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
                <label for="grill" class="control-label">
                    <input type="checkbox" name="grill" id="grill" value="yes" <?php echo $event_grill == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Grill', 'dokan-lite' ); ?>
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
                <label for="synnipaev" class="control-label">
                    <input type="checkbox" name="synnipaev" id="synnipaev" value="yes" <?php echo $event_synnipaev == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Sünnipäev', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="louna_kontoris" class="control-label">
                    <input type="checkbox" name="louna_kontoris" id="louna_kontoris" value="yes" <?php echo $event_louna_kontoris == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Lõuna kontoris', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>


<!--    Diet-->
    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
	        <?php esc_html_e( 'Dietary restrictions', 'dokan-lite' ); ?>
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="vegan" class="control-label">
                    <input type="checkbox" name="vegan" id="vegan" value="yes" <?php echo $diet_vegan == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Vegan', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="vegetarian" class="control-label">
                    <input type="checkbox" name="vegetarian" id="vegetarian" value="yes" <?php echo $diet_vegetarian == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Vegetarian', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="gluten_free" class="control-label">
                    <input type="checkbox" name="gluten_free" id="gluten_free" value="yes" <?php echo $diet_gluten_free == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Gluten free', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>


<!--    Additional services-->
    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
	        <?php esc_html_e( 'Additional services', 'dokan-lite' ); ?>
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="cutlery" class="control-label">
                    <input type="checkbox" name="cutlery" id="cutlery" value="yes" <?php echo $additional_service_cutlery == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Cutlery', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group service-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="tables" class="control-label">
                    <input type="checkbox" name="tables" id="tables" value="yes" <?php echo $additional_service_tables == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Tables', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="">
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="servicing" class="control-label">
                    <input type="checkbox" name="servicing" id="servicing" value="yes" <?php echo $additional_service_servicing == 'yes' ? 'checked': ''; ?>>
					<?php esc_html_e( 'Servicing', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

	<div class="dokan-form-group">
		<div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
			<input type="submit" id="update_services" name="update_services" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Services', 'dokan-lite' ); ?>">
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