<div class="dokan-other-options dokan-edit-row dokan-clearfix <?php echo esc_attr( $class ); ?>">
    <div class="dokan-section-heading" data-togglehandler="dokan_other_options">
        <h2><i class="fa fa-cog" aria-hidden="true"></i> <?php esc_html_e( 'Other Options', 'dokan-lite' ); ?></h2>
        <p><?php esc_html_e( 'Set your extra product options', 'dokan-lite' ); ?></p>
        <a href="#" class="dokan-section-toggle">
            <i class="fa fa-sort-desc fa-flip-vertical" aria-hidden="true"></i>
        </a>
        <div class="dokan-clearfix"></div>
    </div>

    <div class="dokan-section-content">
        <div class="dokan-form-group content-half-part">
            <label for="post_status" class="form-label"><?php esc_html_e( 'Product Status', 'dokan-lite' ); ?></label>
            <?php if ( $post_status != 'pending' ) { ?>
                <?php $post_statuses = apply_filters( 'dokan_post_status', array(
                    'publish' => __( 'Online', 'dokan-lite' ),
                    'draft'   => __( 'Draft', 'dokan-lite' )
                ), $post ); ?>

                <select id="post_status" class="dokan-form-control" name="post_status">
                    <?php foreach ( $post_statuses as $status => $label ) { ?>
                        <option value="<?php echo esc_attr( $status ); ?>"<?php selected( $post_status, $status ); ?>><?php echo esc_html( $label ); ?></option>
                    <?php } ?>
                </select>
            <?php } else { ?>
                <?php $pending_class = $post_status == 'pending' ? '  dokan-label dokan-label-warning': ''; ?>
                <span class="dokan-toggle-selected-display<?php echo esc_attr( $pending_class ); ?>"><?php echo esc_html( dokan_get_post_status( $post_status ) ); ?></span>
            <?php } ?>
        </div>

        <div class="dokan-clearfix"></div>

        <div class="dokan-form-group">
            <label for="_purchase_note" class="form-label"><?php esc_html_e( 'Purchase Note', 'dokan-lite' ); ?></label>
            <?php dokan_post_input_box( $post_id, '_purchase_note', array( 'placeholder' => __( 'Customer will get this info in their order email', 'dokan-lite' ) ), 'textarea' ); ?>
        </div>

    </div>
</div><!-- .dokan-other-options -->
