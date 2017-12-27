<?php

$options        = get_option( 'fullstripe_options' );
$currencySymbol = MM_WPFS::get_currency_symbol_for( $options['currency'] );
$lockEmail      = $options['lock_email_field_for_logged_in_users'];

$emailAddress   = "";
$isUserLoggedIn = is_user_logged_in();
if ( $lockEmail == '1' && $isUserLoggedIn ) {
	$current_user = wp_get_current_user();
	$emailAddress = $current_user->user_email;
}

/** @var stdClass $formData */

?>
<form class="form-horizontal" action="" method="POST" id="payment-form">
	<fieldset>
		<div id="legend">
            <span class="fullstripe-form-title">
                <?php MM_WPFS::echo_translated_label( $formData->formTitle ); ?>
            </span>
		</div>
		<input type="hidden" name="action" value="wp_full_stripe_subscription_charge"/>
		<input type="hidden" name="formId" value="<?php echo $formData->subscriptionFormID; ?>"/>
		<input type="hidden" name="formName" value="<?php echo $formData->name; ?>"/>
		<input type="hidden" name="formDoRedirect" value="<?php echo $formData->redirectOnSuccess; ?>"/>
		<input type="hidden" name="formRedirectPostID" value="<?php echo $formData->redirectPostID; ?>"/>
		<input type="hidden" name="formRedirectUrl" value="<?php echo $formData->redirectUrl; ?>"/>
		<input type="hidden" name="formRedirectToPageOrPost" value="<?php echo $formData->redirectToPageOrPost; ?>"/>
		<input type="hidden" name="sendEmailReceipt" value="<?php echo $formData->sendEmailReceipt; ?>"/>
		<input type="hidden" name="showAddress" value="<?php echo $formData->showAddress; ?>"/>
		<input type="hidden" name="fullstripe_setupFee" id="fullstripe_setupFee" value="<?php echo $formData->setupFee; ?>"/>
		<?php if ( $formData->showCustomInput == 1 && $formData->customInputs ): ?>
			<input type="hidden" name="customInputs" value="<?php echo $formData->customInputs; ?>"/>
		<?php endif; ?>
		<p class="payment-errors"></p>
		<!-- Name -->
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Card Holder\'s Name', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<input type="text" autocomplete="off" placeholder="Name" class="input-xlarge fullstripe-form-input" name="fullstripe_name" id="fullstripe_name" data-stripe="name">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Email Address', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<?php if ( $lockEmail == '1' && $isUserLoggedIn ): ?>
					<label class="fullstripe-data-label"><?php echo $emailAddress; ?></label>
					<input type="hidden" value="<?php echo $emailAddress; ?>" name="fullstripe_email" id="fullstripe_email">
				<?php else: ?>
					<input type="text" class="input-xlarge fullstripe-form-input" name="fullstripe_email" id="fullstripe_email">
				<?php endif; ?>
			</div>
		</div>
		<?php if ( $formData->showCustomInput == 1 ): ?>
			<?php
			$customInputs = array();
			if ( $formData->customInputs != null ) {
				$customInputs = explode( '{{', $formData->customInputs );
			}
			?>
			<?php if ( $formData->customInputs == null ): ?>
				<div class="control-group">
					<label class="control-label fullstripe-form-label"><?php MM_WPFS::echo_translated_label( $formData->customInputTitle ); ?></label>

					<div class="controls">
						<input type="text" class="input-xlarge fullstripe-form-input" name="fullstripe_custom_input" id="fullstripe_custom_input">
					</div>
				</div>
			<?php endif; ?>
			<?php foreach ( $customInputs as $i => $label ): ?>
				<div class="control-group">
					<label class="control-label fullstripe-form-label"><?php MM_WPFS::echo_translated_label( $label ); ?></label>

					<div class="controls">
						<input type="text" class="input-xlarge fullstripe-form-input" name="fullstripe_custom_input[]" id="fullstripe_custom_input_<?php echo $i + 1; ?>">
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Subscription Plan', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<select id="fullstripe_plan" name="fullstripe_plan">
					<?php foreach ( $plans as $plan ): ?>
						<option value="<?php echo esc_attr( stripslashes( $plan->id ) ); ?>"
						        data-value="<?php echo esc_attr( $plan->id ); ?>"
						        data-amount="<?php echo esc_attr( $plan->amount ); ?>"
						        data-interval="<?php echo esc_attr( MM_WPFS::get_translated_interval_label( $plan->interval, $plan->interval_count ) ); ?>"
						        data-interval-count="<?php echo esc_attr( $plan->interval_count ); ?>"
						        data-currency="<?php echo esc_attr( $currencySymbol ); ?>">
							<?php echo esc_html( MM_WPFS::translate_label( $plan->name ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<?php if ( $formData->showAddress == 1 ): ?>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'Billing Address Street', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" name="fullstripe_address_line1" id="fullstripe_address_line1" class="fullstripe-form-input"><br/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'Billing Address Line 2', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" name="fullstripe_address_line2" id="fullstripe_address_line2" class="fullstripe-form-input"><br/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'City', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" name="fullstripe_address_city" id="fullstripe_address_city" class="fullstripe-form-input"><br/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'State', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" style="width: 60px;" name="fullstripe_address_state" id="fullstripe_address_state" class="fullstripe-form-input"><br/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'Zip', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" style="width: 60px;" name="fullstripe_address_zip" id="fullstripe_address_zip" class="fullstripe-form-input"><br/>
				</div>
			</div>
		<?php endif; ?>
		<!-- Card Number -->
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Card Number', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<input type="text" autocomplete="off" placeholder="4242424242424242" class="input-xlarge fullstripe-form-input" size="20" data-stripe="number">
			</div>
		</div>
		<!-- Expiry-->
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Card Expiry Date', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<input type="text" style="width: 60px;" size="2" placeholder="10" data-stripe="exp-month" class="fullstripe-form-input"/>
				<span> / </span>
				<input type="text" style="width: 60px;" size="4" placeholder="2016" data-stripe="exp-year" class="fullstripe-form-input"/>
			</div>
		</div>
		<!-- CVV -->
		<div class="control-group">
			<label class="control-label fullstripe-form-label"><?php _e( 'Card CVV', 'wp-full-stripe' ); ?></label>

			<div class="controls">
				<input type="password" autocomplete="off" placeholder="123" class="input-mini fullstripe-form-input" size="4" data-stripe="cvc"/>
			</div>
		</div>
		<?php if ( $formData->showCouponInput == 1 ): ?>
			<div class="control-group">
				<label class="control-label fullstripe-form-label"><?php _e( 'Coupon Code', 'wp-full-stripe' ); ?></label>

				<div class="controls">
					<input type="text" class="input-mini fullstripe-form-input" name="fullstripe_coupon_input" id="fullstripe_coupon_input">
					<button id="fullstripe_check_coupon_code"><?php _e( 'Apply', 'wp-full-stripe' ); ?></button>
					<img src="<?php echo plugins_url( '/img/loader.gif', dirname( __FILE__ ) ); ?>" alt="<?php _e( 'Loading...', 'wp-full-stripe' ); ?>" id="showLoadingC"/>
				</div>
			</div>
		<?php endif; ?>
		<!-- Submit -->
		<div class="control-group">
			<div class="controls">
				<button type="submit"><?php MM_WPFS::echo_translated_label( $formData->buttonTitle ); ?></button>
				<img src="<?php echo plugins_url( '/img/loader.gif', dirname( __FILE__ ) ); ?>" alt="<?php _e( 'Loading...', 'wp-full-stripe' ); ?>" id="showLoading"/>
				<p class="fullstripe_plan_details"></p>
			</div>
		</div>
	</fieldset>
	
</form>

<div class="div10"><a href="http://account.couponbutter.com/login/"> go to login page</a> </div>

