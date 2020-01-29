<div class="dokan-w2" style="padding: 0 15px;">
    <label style="padding-bottom: 5px;"><?php echo esc_html( __( 'Kuna', 'dokan' ) ); ?></label>
    <input class="delivery_date" name="delivery_date" id="delivery_date" type="text" style="position: relative; height: 33px;">
</div>

<script>
    jQuery( document ).ready( function ( $ ) {

        var form = $( '.dokan-seller-search-form' ),
            deliveryDate = form.find( '[name="delivery_date"]' );

        jQuery('.delivery_date').datetimepicker({
            dateFormat: 'dd.mm.yy',
            stepMinute: 30,
            oneLine: true,
            minDateTime: getMinDate(),
            onClose: function (selectedDateTime){
                form.trigger( 'dokan_seller_search' );
            }
        });

        function getMinDate() {
            var minDate = new Date();
            minDate.setMilliseconds(0);
            minDate.setSeconds(0);
            minDate.setMinutes(Math.ceil(minDate.getMinutes() / 30) * 30);
            return minDate;
        }

        var dateFromSession = "<?php echo $session_value; ?>";
        if (dateFromSession !== undefined) {
            deliveryDate.val(dateFromSession);
        }

        form.on( 'dokan_seller_search_populate_data', function ( e, data ) {
            data.delivery_date = deliveryDate.val();
        } );
    } );
</script>