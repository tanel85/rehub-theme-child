<div class="dokan-w2" style="padding: 0 15px 15px 15px;">
    <label style="padding-bottom: 5px;"><?php echo esc_html( __( 'Tellimus', 'dokan' ) ); ?></label>
    <select
        class="dokan-select2 dokan-form-control"
        name="delivery_option"
    >
        <option value=""><?php echo esc_html( __( 'Vali', 'dokan' ) ); ?></option>
        <option value="1" <?php echo ( '1' === $session_value ) ? 'selected' : ''; ?>>
            <?php echo esc_html( __( 'Delivery', 'dokan-lite' ) ); ?>
        </option>
        <option value="2" <?php echo ( '2' === $session_value ) ? 'selected' : ''; ?>>
            <?php echo esc_html( __( 'Takeout', 'dokan-lite' ) ); ?>
        </option>
    </select>
</div>

<script>
    jQuery( document ).ready( function ( $ ) {
        var form = $( '.dokan-seller-search-form' ),
            delivery_option = form.find( '[name="delivery_option"]' );

        form.on( 'dokan_seller_search_populate_data', function ( e, data ) {
            data.delivery_option = delivery_option.val();
        } );

        delivery_option.on( 'change', function () {
            form.trigger( 'dokan_seller_search' );
        } );
    } );
</script>
