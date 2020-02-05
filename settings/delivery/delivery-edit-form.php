<?php

$delivery = isset( $profile_info['delivery'] ) ? $profile_info['delivery'] : '';
$delivery_info = isset( $profile_info['delivery_info']) ? $profile_info['delivery_info'] : '';

?>
<form method="post" id="delivery-form"  action="" class="dokan-form-horizontal">
    <?php wp_nonce_field( 'vendor_delivery_nonce' ); ?>
    <div class="dokan-form-group">
        <label class="dokan-w3 control-label" for="delivery">
            <?php esc_html_e( 'Delivery', 'dokan-lite' ); ?>
        </label>

        <div class="dokan-w5 dokan-text-left dokan_tock_check">
            <div class="checkbox">
                <label for="delivery" class="control-label">
                    <input type="checkbox" name="delivery" id="delivery" value="yes" <?php echo $delivery == 'yes' ? 'checked': ''; ?>>
                    <?php esc_html_e( 'Offers delivery', 'dokan-lite' ); ?>
                </label>
            </div>
        </div>
    </div>

    <div class="delivery-info-container dokan-hide">
        <br />
        <header class="dokan-dashboard-header" style="text-align:left;">
            <h3 class="entry-title"><span><?php esc_attr_e( 'Delivery info', 'dokan-lite' ); ?></span></h3>
        </header>


        <div style="display: flex">
            <div class="dokan-w2">
                <label class="dokan-w3 control-label" for="">
                </label>
            </div>

            <div class="dokan-w2" style="border-left: 1px solid #008400; border-right: 1px solid #008400; padding-bottom: 20px;">
                <b><?php esc_attr_e( 'Offer delivery', 'dokan-lite' ); ?></b>
            </div>

            <div class="dokan-w2">
                <b><?php esc_attr_e( 'Delivery price', 'dokan-lite' ); ?></b>
            </div>
        </div>


        <?php foreach ( $states as $key => $value ): ?>
            <div style="display: flex">
                <div class="dokan-w2 dokan-text-left" style="border-top: 1px solid #008400; display: flex; align-items: center;">
                    <?php echo $value; ?>
                </div>

                <div class="dokan-w2" style="border-left: 1px solid #008400; border-right: 1px solid #008400; border-top: 1px solid #008400; display: flex; align-items: center; justify-content: center">
                    <div class="checkbox">
                        <label for="<?php echo $key; ?>" class="control-label">
                            <input type="checkbox" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="yes"
                                <?php echo isset( $delivery_info[$key]) && isset( $delivery_info[$key]['enabled']) && $delivery_info[$key]['enabled'] == 'yes' ? 'checked': ''; ?>>
                        </label>
                    </div>
                </div>

                <div class="dokan-w2" style="border-top: 1px solid #008400; display: flex; align-items: center; justify-content: center">
                    <input type="number" class="dokan-form-control" name="<?php echo $key; ?>_price" id="<?php echo $key; ?>_price"
                           style="max-width: 100px; margin: 10px 0;"
                           value="<?php echo isset( $delivery_info[$key]) && isset( $delivery_info[$key]['price']) ? esc_attr( $delivery_info[$key]['price'] ) : ''; ?>" />
                </div>
            </div>
        <?php endforeach; ?>


    </div>


        <div class="dokan-form-group" style="padding-top: 20px">
            <div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
                <input type="submit" id="update_delivery" name="update_delivery" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Delivery info', 'dokan-lite' ); ?>">
            </div>
        </div>
</form>
<script type="text/javascript">
    jQuery( document ).ready( function ( $ ) {
        $('#update_delivery').click(function () {
            var self = $("form#delivery-form"),
                form_data = self.serialize() + '&action=dokan_seller_delivery';

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
        $( '#delivery' ).on( 'change', function() {
            toggle_delivery_info();

        } );
        function toggle_delivery_info() {
            if ($( '#delivery' ).is(":checked")) {
                $( '.delivery-info-container' ).removeClass('dokan-hide');
            } else {
                $( '.delivery-info-container' ).addClass('dokan-hide');
            }
        }

        toggle_delivery_info();
    });
</script>
