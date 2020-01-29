<div class="dokan-w2" style="padding: 0 15px;">
    <label style="padding-bottom: 5px;"><?php echo esc_html( __( 'Asukoht', 'dokan' ) ); ?></label>
    <select
        class="dokan-select2 dokan-form-control"
        name="dokan_seller_state"
    >
        <option value=""><?php echo esc_html( __( 'Vali', 'dokan' ) ); ?></option>
        <?php foreach ( $states as $key => $value ): ?>
            <option value="<?php echo esc_attr( $key ); ?>" <?php echo ( $key === $session_value ) ? 'selected' : ''; ?>>
                <?php echo esc_html( $value ); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<script>
    jQuery( document ).ready( function ( $ ) {
        var form = $( '.dokan-seller-search-form' ),
            state = form.find( '[name="dokan_seller_state"]' );

        form.on( 'dokan_seller_search_populate_data', function ( e, data ) {
            data.seller_state = state.val();
        } );

        state.on( 'change', function () {
            form.trigger( 'dokan_seller_search' );
        } );
    } );
</script>
