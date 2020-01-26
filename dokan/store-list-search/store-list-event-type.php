<div style="display: flex">
    <div style="padding: 0 15px;">
        <div id="event_type1" class="button"
             style="padding: 12px 20px; text-transform: none; border-radius: 25px; <?php echo ( !empty($session_value) ) ? 'background: #A9A9A9 !important;' : ''; ?>">
            <?php echo esc_html( __( 'Kõik', 'dokan-lite' ) ); ?></div>
    </div>
    <div style="padding: 0 15px;">
        <div id="event_type2" class="button"
             style="padding: 12px 20px; text-transform: none; border-radius: 25px; <?php echo ( 'laste_synnipaev' !== $session_value ) ? 'background: #A9A9A9 !important;' : ''; ?>">
            <?php echo esc_html( __( 'Laste sünnipäev', 'dokan-lite' ) ); ?></div>
    </div>
    <div style="padding: 0 15px;">
        <div id="event_type3" class="button"
             style="padding: 12px 20px; text-transform: none; border-radius: 25px; <?php echo ( 'seminar' !== $session_value ) ? 'background: #A9A9A9 !important;' : ''; ?>">
            <?php echo esc_html( __( 'Seminar', 'dokan-lite' ) ); ?></div>
    </div>
    <div style="padding: 0 15px;">
        <div id="event_type4" class="button"
             style="padding: 12px 20px; text-transform: none; border-radius: 25px; <?php echo ( 'kohvipaus' !== $session_value ) ? 'background: #A9A9A9 !important;' : ''; ?>">
            <?php echo esc_html( __( 'Kohvipaus', 'dokan-lite' ) ); ?></div>
    </div>
    <div style="padding: 0 15px;">
        <div id="event_type5" class="button"
             style="padding: 12px 20px; text-transform: none; border-radius: 25px; <?php echo ( 'grill' !== $session_value ) ? 'background: #A9A9A9 !important;' : ''; ?>">
            <?php echo esc_html( __( 'Grill', 'dokan-lite' ) ); ?></div>
    </div>

    <div style="padding: 0 15px;">
        <div style="overflow:hidden; border-radius: 25px; background: #A9A9A9 !important;" class="event-type-select-container">
            <select id="event_type_select"
                    class="button event-type-select"
                style="padding: 12px 20px; text-transform: none; height: 38px; border: 0; margin: 0; <?php echo ( 'konverents' !== $session_value && 'synnipaev' !== $session_value ) ? 'background: #A9A9A9 !important;' : ''; ?>"
                name="event_type_select"
            >
                <option value="" style="font-size:14px; background-color: #ffffff; color: #000000;"><?php echo esc_html( __( 'Rohkem', 'dokan-lite' ) ); ?></option>
                <option value="konverents" style="font-size:14px; background-color: #ffffff; color: #000000;" <?php echo ( 'konverents' === $session_value ) ? 'selected' : ''; ?>>
                    <?php echo esc_html( __( 'Konverents', 'dokan-lite' ) ); ?>
                </option>
                <option value="synnipaev" style="font-size:14px; background-color: #ffffff; color: #000000;" <?php echo ( 'synnipaev' === $session_value ) ? 'selected' : ''; ?>>
                    <?php echo esc_html( __( 'Sünnipäev', 'dokan-lite' ) ); ?>
                </option>
            </select>
        </div>
    </div>
    <input type="hidden" id="event_type_value" name="event_type_value" value="<?php echo esc_attr( $session_value ) ?>" />
</div>

<script>
    jQuery( document ).ready( function ( $ ) {
        var form = $( '.dokan-seller-search-form' ),
            event_type_value = $( '#event_type_value' );

        form.on( 'dokan_seller_search_populate_data', function ( e, data ) {
            data.event_type = event_type_value.val();
        } );

        function event_type_set_background(elem) {
            event_type_cancel_background('event_type1');
            event_type_cancel_background('event_type2');
            event_type_cancel_background('event_type3');
            event_type_cancel_background('event_type4');
            event_type_cancel_background('event_type5');
            event_type_cancel_background('event_type_select');
            elem.css('background', '');
            elem.attr('style', function(i,s) { return (s || '') + 'background: #008400 !important;' });
        }

        function event_type_cancel_background(elem_id) {
            var elem = $('#'+elem_id);
            elem.css('background', '');
            elem.attr('style', function(i,s) { return (s || '') + 'background: #A9A9A9 !important;' });
        }

        function event_type_clicked(element, value) {
            event_type_set_background(element);
            event_type_value.val(value);
            form.trigger( 'dokan_seller_search' );
        }

        $( '#event_type1' ).on( 'click', function () {
            event_type_clicked($( this ), '');
        } );

        $( '#event_type2' ).on( 'click', function () {
            event_type_clicked($( this ), 'laste_synnipaev');
        } );

        $( '#event_type3' ).on( 'click', function () {
            event_type_clicked($( this ), 'seminar');
        } );

        $( '#event_type4' ).on( 'click', function () {
            event_type_clicked($( this ), 'kohvipaus');
        } );

        $( '#event_type5' ).on( 'click', function () {
            event_type_clicked($( this ), 'grill');
        } );

        $( '#event_type_select' ).on( 'change', function () {
            var elem = $( this );
            event_type_clicked(elem, elem.val());
        } );
    } );
</script>
