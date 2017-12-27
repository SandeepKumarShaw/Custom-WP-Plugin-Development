<?php
$options    = get_option( 'fullstripe_options' );
$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'stripe';
?>
<div class="wrap">
	<h2><?php _e( 'Full Stripe Settings', 'wp-full-stripe' ); ?></h2>

	<div id="updateDiv"><p><strong id="updateMessage"></strong></p></div>
	<h2 class="nav-tab-wrapper">
		<a href="?page=fullstripe-settings&tab=stripe" class="nav-tab <?php echo $active_tab == 'stripe' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Stripe', 'wp-full-stripe' ); ?></a>
		<a href="?page=fullstripe-settings&tab=appearance" class="nav-tab <?php echo $active_tab == 'appearance' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Appearance', 'wp-full-stripe' ); ?></a>
		<a href="?page=fullstripe-settings&tab=email-receipts" class="nav-tab <?php echo $active_tab == 'email-receipts' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Email receipts', 'wp-full-stripe' ); ?></a>
		<a href="?page=fullstripe-settings&tab=users" class="nav-tab <?php echo $active_tab == 'users' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Users', 'wp-full-stripe' ); ?></a>
	</h2>
	<div class="tab-content">
		<?php if ( $active_tab == 'stripe' ): ?>
			<div id="stripe-tab">
				<p class="alert alert-info"><?php _e( 'The Stripe API keys are required for payments to work. You can find your keys on your <a href="https://manage.stripe.com">Stripe Dashboard</a> -> Account Settings -> API Keys tab', 'wp-full-stripe' ); ?></p>

				<form class="form-horizontal" action="#" method="post" id="settings-stripe-form">
					<p class="tips"></p>
					<input type="hidden" name="action" value="wp_full_stripe_update_settings"/>
					<input type="hidden" name="tab" value="stripe">
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label class="control-label"><?php _e( "API mode: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<label class="radio">
									<input type="radio" name="apiMode" id="modeTest" value="test" <?php echo ( $options['apiMode'] == 'test' ) ? 'checked' : '' ?> >
									Test
								</label> <label class="radio">
									<input type="radio" name="apiMode" id="modeLive" value="live" <?php echo ( $options['apiMode'] == 'live' ) ? 'checked' : '' ?>>
									Live
								</label>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="currency"><?php _e( "Payment Currency: ", 'wp-full-stripe' ); ?></label>
							</th>
							<td>
								<div class="ui-widget">
									<select id="currency" name="currency">
										<option value=""><?php esc_attr_e( 'Select from the list or start typing', 'wp-full-stripe' ); ?></option>
										<?php
										foreach ( MM_WPFS::get_available_currencies() as $currency_key => $currency_obj ) {
											$option = '<option value="' . $currency_key . '"';
											if ( $options['currency'] === $currency_key ) {
												$option .= 'selected="selected"';
											}
											$option .= '>';
											$option .= $currency_obj['name'] . ' (' . $currency_obj['code'] . ')';
											$option .= '</option>';
											echo $option;
										}
										?>
									</select>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="secretKey_test"><?php _e( "Stripe Test Secret Key: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<input type="text" name="secretKey_test" id="secretKey_test" value="<?php echo $options['secretKey_test']; ?>" class="regular-text code">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="publishKey_test"><?php _e( "Stripe Test Publishable Key: ", 'wp-full-stripe' ); ?></label>
							</th>
							<td>
								<input type="text" id="publishKey_test" name="publishKey_test" value="<?php echo $options['publishKey_test']; ?>" class="regular-text code">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="secretKey_live"><?php _e( "Stripe Live Secret Key: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<input type="text" name="secretKey_live" id="secretKey_live" value="<?php echo $options['secretKey_live']; ?>" class="regular-text code">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="publishKey_live"><?php _e( "Stripe Live Publishable Key: ", 'wp-full-stripe' ); ?></label>
							</th>
							<td>
								<input type="text" id="publishKey_live" name="publishKey_live" value="<?php echo $options['publishKey_live']; ?>" class="regular-text code">
							</td>
						</tr>
					</table>
					<hr>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label class="control-label"><?php _e( 'Stripe Webhook URL: ', 'wp-full-stripe'); ?></label>
							</th>
							<td>
								<input id="stripe-webhook-url" class="large-text" type="text" value="<?php echo esc_attr( add_query_arg( array( 'action' => 'handle_wpfs_event', 'auth_token' => MM_WPFS_Admin::get_webhook_token() ), admin_url( 'admin-post.php' ) ) ); ?>" readonly>
								<p class="description"><?php printf( __( 'This URL must be set in Stripe as a webhook endpoint. See the <a target="_blank" href="%s">"Setup" chapter</a> of the "Help" page for more information.', 'wp-full-stripe' ), admin_url( "admin.php?page=fullstripe-help#" ) ); ?>
								</p>
							</td>
						</tr>
					</table>
					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes' ) ?></button>
					</p>
				</form>
			</div>
		<?php elseif ( $active_tab == 'appearance' ): ?>
			<div id="appearance-tab">
				<form class="form-horizontal" action="#" method="post" id="settings-appearance-form">
					<p class="tips"></p>
					<input type="hidden" name="action" value="wp_full_stripe_update_settings"/>
					<input type="hidden" name="tab" value="appearance">
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label class="control-label" for="form_css"><?php _e( "Custom Form CSS: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<textarea name="form_css" id="form_css" class="large-text code" rows="10" cols="50"><?php echo $options['form_css']; ?></textarea>

								<p class="description"><?php _e( 'Add extra styling to the form. NOTE: if you don\'t know what this is do not change it.', 'wp-full-stripe' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label class="control-label"><?php _e( "Include Default Styles: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<label class="radio">
									<input type="radio" name="includeStyles" id="includeStylesY" value="1" <?php echo ( $options['includeStyles'] == '1' ) ? 'checked' : '' ?> >
									<?php _e( 'Include', 'wp-full-stripe' ); ?>
								</label> <label class="radio">
									<input type="radio" name="includeStyles" id="includeStylesN" value="0" <?php echo ( $options['includeStyles'] == '0' ) ? 'checked' : '' ?>>
									<?php _e( 'Exclude', 'wp-full-stripe' ); ?>
								</label>

								<p class="description"><?php _e( 'Exclude styles if the payment forms do not appear properly. This can indicate a conflict with your theme.', 'wp-full-stripe' ); ?></p>
							</td>
						</tr>
					</table>
					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes' ) ?></button>
					</p>
				</form>
			</div>
		<?php elseif ( $active_tab == 'email-receipts' ): ?>
			<div id="email-receipts-tab">
				<form class="form-horizontal" action="#" method="post" id="settings-email-receipts-form">
					<p class="tips"></p>
					<input type="hidden" name="action" value="wp_full_stripe_update_settings"/>
					<input type="hidden" name="tab" value="email-receipts">
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label class="control-label"><?php _e( "Receipt Email Type: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<label class="radio">
									<input type="radio" name="receiptEmailType" id="receiptEmailTypePlugin" value="plugin" <?php echo ( $options['receiptEmailType'] == 'plugin' ) ? 'checked' : '' ?> >
									<?php _e( 'Plugin', 'wp-full-stripe' ); ?>
								</label> <label class="radio">
									<input type="radio" name="receiptEmailType" id="receiptEmailTypeStripe" value="stripe" <?php echo ( $options['receiptEmailType'] == 'stripe' ) ? 'checked' : '' ?>>
									<?php _e( 'Stripe', 'wp-full-stripe' ); ?>
								</label>

								<p class="description"><?php _e( 'Choose the type of payment receipt emails. Plugin emails are defined below and Stripe emails can be setup in your Stripe Dashboard.', 'wp-full-stripe' ); ?></p>
							</td>
						</tr>
						<tr id="email_receipt_row" valign="top" <?php echo ( $options['receiptEmailType'] == 'stripe' ) ? 'style="display: none;"' : '' ?>>
							<th scope="row">
								<label class="control-label"><?php _e( "Email Templates: ", 'wp-full-stripe' ); ?></label>
							</th>
							<td>
								<input id="email_receipts" name="email_receipts" type="hidden">
								<table id="email_receipt_templates">
									<tr>
										<td>
											<select id="email_receipt_template" size="20" class="regular-text">
												<option value="paymentMade"><?php esc_html_e( 'Payment receipt', 'wp-full-stripe' ); ?></option>
												<option value="subscriptionStarted"><?php esc_html_e( 'Subscription receipt', 'wp-full-stripe' ); ?></option>
												<option value="subscriptionFinished"><?php esc_html_e( 'Subscription ended', 'wp-full-stripe' ); ?></option>
											</select>
										</td>
										<td>
											<label><?php _e( 'E-mail Subject', 'wp-full-stripe' ); ?></label><br>
											<input id="email_receipt_subject" type="text" class="large-text code"><br>
											<label><?php _e('E-mail body (HTML)', 'wp-full-stripe'); ?></label><br>
											<textarea id="email_receipt_html" class="large-text code" rows="13"></textarea>
											<p class="description"><?php _e( '%CUSTOMERNAME% and %AMOUNT% are replaced with the name of the customer and payment amount, respectively.', 'wp-full-stripe' ); ?>
												<?php printf( __( 'See the <a target="_blank" href="%s">Help page</a> for more options.', 'wp-full-stripe' ), admin_url( "admin.php?page=fullstripe-help#receipt-tokens" ) ); ?></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="email_receipt_sender_address_row" valign="top" <?php echo ( $options['receiptEmailType'] == 'stripe' ) ? 'style="display: none;"' : '' ?>>
							<th scope="row">
								<label class="control-label" for="email_receipt_sender_address"><?php _e( 'Email Receipt Sender Address', 'wp-full-stripe' ); ?></label>
							</th>
							<td>
								<input id="email_receipt_sender_address" name="email_receipt_sender_address" type="text" class="regular-text" value="<?php echo esc_attr( $options['email_receipt_sender_address'] ); ?>">

								<p class="description"><?php _e( 'The sender address of email receipts. If you leave it empty then the email address of the blog admin will be used.', 'wp-full-stripe' ); ?></p>
							</td>
						</tr>
						<tr id="admin_payment_receipt_row" valign="top" <?php echo ( $options['receiptEmailType'] == 'stripe' ) ? 'style="display: none;"' : '' ?>>
							<th scope="row">
								<label class="control-label"><?php _e( "Send Copy of Email Receipt?: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<label class="radio">
									<input type="radio" name="admin_payment_receipt" id="admin_payment_receipt_no" value="no" <?php echo ( $options['admin_payment_receipt'] == 'no' ) ? 'checked' : '' ?>>
									<?php _e( 'No', 'wp-full-stripe' ); ?>
								</label>
								<label class="radio">
									<input type="radio" name="admin_payment_receipt" id="admin_payment_receipt_website_admin" value="website_admin" <?php echo ( $options['admin_payment_receipt'] == 'website_admin' ) ? 'checked' : '' ?> >
									<?php _e( 'Yes, to the Website Admin', 'wp-full-stripe' ); ?>
								</label>
								<label class="radio">
									<input type="radio" name="admin_payment_receipt" id="admin_payment_receipt_sender_address" value="sender_address" <?php echo ( $options['admin_payment_receipt'] == 'sender_address' ) ? 'checked' : '' ?>>
									<?php _e( 'Yes, to the Email Receipt Sender Address', 'wp-full-stripe' ); ?>
								</label>
								<p class="description"><?php _e( 'Send copies of payment/subscription receipts to the website admin as well?', 'wp-full-stripe' ); ?></p>
							</td>
						</tr>
					</table>
					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes' ) ?></button>
					</p>
				</form>
			</div>
		<?php elseif ( $active_tab == 'users' ): ?>
			<div id="users-tab">
				<form class="form-horizontal" action="#" method="post" id="settings-email-receipts-form">
					<p class="tips"></p>
					<input type="hidden" name="action" value="wp_full_stripe_update_settings"/>
					<input type="hidden" name="tab" value="users">
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label class="control-label"><?php _e( "Lock e-mail address field for logged in users?: ", 'wp-full-stripe' ); ?> </label>
							</th>
							<td>
								<label class="radio">
									<input type="radio" name="lock_email_field_for_logged_in_users" id="lock_email_field_for_logged_in_users_no" value="0" <?php echo ( $options['lock_email_field_for_logged_in_users'] == '0' ) ? 'checked' : '' ?>>
									<?php _e( 'No', 'wp-full-stripe' ); ?>
								</label>
								<label class="radio">
									<input type="radio" name="lock_email_field_for_logged_in_users" id="lock_email_field_for_logged_in_users_yes" value="1" <?php echo ( $options['lock_email_field_for_logged_in_users'] == '1' ) ? 'checked' : '' ?> >
									<?php _e( 'Yes', 'wp-full-stripe' ); ?>
								</label>
							</td>
						</tr>
					</table>
					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Save Changes' ) ?></button>
					</p>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>
