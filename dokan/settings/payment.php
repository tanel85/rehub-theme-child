<?php
/**
 * Dokan Settings Payment Template
 *
 * @since 2.2.2 Insert action before payment settings form
 *
 * @package dokan
 */
do_action( 'dokan_payment_settings_before_form', $current_user, $profile_info ); ?>

	<form method="post" id="payment-form"  action="" class="dokan-form-horizontal">

		<?php wp_nonce_field( 'dokan_payment_settings_nonce' ); ?>

		<?php foreach ( $methods as $method_key ) {
	        if ($method_key == 'bank') {
				$method = dokan_withdraw_get_method( $method_key );
		        $officialname      = isset( $profile_info['official_name'] ) ? $profile_info['official_name'] : '';
		        $regcode      = isset( $profile_info['reg_code'] ) ? $profile_info['reg_code'] : '';
		        $iban           = isset( $profile_info['payment']['bank']['iban'] ) ? $profile_info['payment']['bank']['iban'] : '';
		        ?>
				<fieldset class="payment-field-<?php echo esc_attr( $method_key ); ?>">

					<div class="dokan-form-group">
						<label class="dokan-w3 dokan-control-label" for="official_name"><?php echo esc_html_e( 'Ettevõtte ametlik nimi' ) ?></label>
						<div class="dokan-w8">
							<input name="official_name" value="<?php echo esc_attr( $officialname ); ?>" class="dokan-form-control" placeholder="<?php esc_attr_e( 'Nimi', 'dokan-lite' ) ?>" type="text">
						</div>
					</div>
					<div class="dokan-form-group">
						<label class="dokan-w3 dokan-control-label" for="reg_code"><?php echo esc_html_e( 'Registrikood' ) ?></label>
						<div class="dokan-w8">
							<input name="reg_code" value="<?php echo esc_attr( $regcode ); ?>" class="dokan-form-control" placeholder="<?php esc_attr_e( '12345678', 'dokan-lite' ) ?>" type="text">
						</div>
					</div>
					<div class="dokan-form-group">
						<label class="dokan-w3 dokan-control-label" for="settings[bank][iban]"><?php echo esc_html_e( 'IBAN' ) ?></label>
						<div class="dokan-w8">
							<input name="settings[bank][iban]" value="<?php echo esc_attr( $iban ); ?>" class="dokan-form-control" placeholder="<?php esc_attr_e( 'IBAN', 'dokan-lite' ) ?>" type="text">
						</div>
					</div>

				</fieldset>
		<?php }} ?>

		<?php
		/**
		 * @since 2.2.2 Insert action on botton of payment settings form
		 */
		do_action( 'dokan_payment_settings_form_bottom', $current_user, $profile_info ); ?>

		<div class="dokan-form-group">

			<div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
				<input type="submit" name="dokan_update_payment_settings" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Update Settings', 'dokan-lite' ); ?>">
			</div>
		</div>

	</form>

<?php
/**
 * @since 2.2.2 Insert action after social settings form
 */
do_action( 'dokan_payment_settings_after_form', $current_user, $profile_info ); ?>