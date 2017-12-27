<?php
//Job Seekers Form
// registration form fields
function custom_reg_log_registration_job_seeker_form_fields() {
	
	ob_start(); ?>	
		<h2 class="custom_reg_log_header"><?php _e('Register New Account'); ?></h2>
		
		<?php 
		// show any error messages after form submission
		custom_reg_log_show_error_messages(); ?>
		
		<form name="custom_reg_log_registration_form" id="custom_reg_log_registration_form" class="custom_reg_log_form" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="user_type" value="job_seeker" readonly="readonly">
			<fieldset>
				<p>
					<label for="custom_reg_log_user_first"><?php _e('First Name <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_first" id="custom_reg_log_user_first" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_first"] ) ? esc_attr( $_POST["custom_reg_log_user_first"] ) : '' )?>" placeholder="First Name" required/>
				</p>
				<p>
					<label for="custom_reg_log_user_last"><?php _e('Last Name <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_last" id="custom_reg_log_user_last" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_last"] ) ? esc_attr( $_POST["custom_reg_log_user_last"] ) : '' )?>" placeholder="Last Name" required/>
				</p>
				<p>
					<label for="custom_reg_log_user_Login"><?php _e('Username <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_login" id="custom_reg_log_user_login" class="required" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_login"] ) ? esc_attr( $_POST["custom_reg_log_user_login"] ) : '' )?>" placeholder="Username" required/>
				</p>
				<p>
					<label for="custom_reg_log_user_email"><?php _e('Email <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_email" id="custom_reg_log_user_email" class="required" type="email" value="<?php echo ( isset( $_POST["custom_reg_log_user_email"] ) ? esc_attr( $_POST["custom_reg_log_user_email"] ) : '' )?>" placeholder="Email" required/>
				</p>
				<p>
					<label for="password"><?php _e('Password <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_pass" id="password" class="required" type="password" value="<?php echo ( isset( $_POST["custom_reg_log_user_pass"] ) ? esc_attr( $_POST["custom_reg_log_user_pass"] ) : '' )?>" placeholder="8 characters with must contain lower and upper case letter and one digit" required/>
				</p>
				<p>
					<label for="password_again"><?php _e('Confirm Password <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_pass_confirm" id="password_again" class="required" type="password" value="<?php echo ( isset( $_POST["custom_reg_log_user_pass_confirm"] ) ? esc_attr( $_POST["custom_reg_log_user_pass_confirm"] ) : '' )?>" placeholder="8 characters with must contain lower and upper case letter and one digit" required/>
				</p>				
				<div class="exp_label">
					<label for="custom_reg_log_user_experience"><?php _e('Experience'); ?></label>
				<!--<input name="custom_reg_log_user_experience" id="custom_reg_log_user_experience" type="text" value="<?php //echo ( isset( $_POST["custom_reg_log_user_experience"] ) ? esc_attr( $_POST["custom_reg_log_user_experience"] ) : '' )?>" placeholder="Experience" />-->
				</div>
				<div class="exp_wrap">
					<?php $job_candidate_years_within = get_field('job_candidate_years_within','options'); ?>
					<select name="custom_reg_log_user_exp_years">
						<option value="">Select Years</option>
						<?php for($i=0; $i<=$job_candidate_years_within; $i++){?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						
						
						<?php }?>
					</select>
					<span class="exp_type">years</span>
					<select name="custom_reg_log_user_exp_months">
						<option value="">Select Months</option>
						<?php for($j=0; $j<=11; $j++){?>
							<option value="<?php echo $j; ?>"><?php echo $j; ?></option>					
						
						<?php }?>
					</select>
					<span class="exp_type">months</span>
				</div>
				
				<!--<p>
					<label for="company_name"><//?php _e('Company'); ?></label>
					<input name="custom_reg_log_user_comp_name" id="company_name" type="text" value="<//?php echo ( isset( $_POST["custom_reg_log_user_comp_name"] ) ? esc_attr( $_POST["custom_reg_log_user_comp_name"] ) : '' )?>" placeholder="Company"/>
				</p>-->
				<p>
					<label for="adrs"><?php _e('Address'); ?></label>
					<input name="custom_reg_log_user_adrs" id="adrs" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_adrs"] ) ? esc_attr( $_POST["custom_reg_log_user_adrs"] ) : '' )?>" placeholder="Address"/>
				</p>
				<p>
					<label for="city"><?php _e('City'); ?></label>
					<input name="custom_reg_log_user_city" id="city" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_city"] ) ? esc_attr( $_POST["custom_reg_log_user_city"] ) : '' )?>" placeholder="City"/>
				</p>
				<p>
					<label for="state"><?php _e('State'); ?></label>
					<input name="custom_reg_log_user_state" id="state" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_state"] ) ? esc_attr( $_POST["custom_reg_log_user_state"] ) : '' )?>" placeholder="State"/>
				</p>
				<p>
					<label for="zip_code"><?php _e('Zip Code'); ?></label>
					<input name="custom_reg_log_user_zip_code" id="zip_code" class="required" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_zip_code"] ) ? esc_attr( $_POST["custom_reg_log_user_zip_code"] ) : '' )?>" placeholder="Zip Code" />
				</p>
				<?php /*
				<p>
					<label for="country"><?php _e('Country'); ?></label>
					<input name="custom_reg_log_user_country" id="country" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_country"] ) ? esc_attr( $_POST["custom_reg_log_user_country"] ) : '' )?>" placeholder="Country"/>
				</p>
				*/ ?>
				<p>
					<label for="max_working_distance"><?php _e('Max working distance'); ?></label>
					<input name="custom_reg_log_user_max_working_distance" id="max_working_distance" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_max_working_distance"] ) ? esc_attr( $_POST["custom_reg_log_user_max_working_distance"] ) : '' )?>" placeholder="Max working distance (Miles)"/>
				</p>
				
				
				<div class="gap">
					<label for="job_cat"><?php _e('Position Requested'); ?></label>
					<div class=radio-wrap>
						<?php
						
						$selected_position = $_POST["custom_reg_log_user_pos_requestd"];
						
						?>
						
						<?php
						$page = get_page_by_path('pricing');
						$pricing_page_id = $page->ID;
						
						if( have_rows('business_matches_positions',$pricing_page_id) ){ 
						// $count=1;
						$i=0;
							while ( have_rows('business_matches_positions',$pricing_page_id) ) {
								the_row();
								$position_field_name = get_sub_field('dental_position_field_name');
								
								if (in_array($position_field_name, $selected_position)) {						
								    $selected_pos = ' checked="checked"';
								} else {
								    $selected_pos = ' ';
								}
								
								?>
								<span><input name="custom_reg_log_user_pos_requestd" type="radio" value="<?php echo $position_field_name ;?>" <?php echo $selected_pos; ?> <?php if(empty($_POST["custom_reg_log_user_pos_requestd"]) &&$i==0) echo ' checked="checked"'; ?>/><?php echo $position_field_name ;?></span>
								<?php $i++; ?>
							
						<?php 	}
						
						}?>
					</div>
				</div>
				
				
				<div class="gap">
					<label for="industry_name"><?php _e('What kind of work are you looking for'); ?></label>
					<div class=radio-wrap>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Any Kind" <?php if( isset($_POST["custom_reg_log_user_industry"]) && $_POST["custom_reg_log_user_industry"]=='Any Kind' ) echo ' checked'; ?> <?php if(empty($_POST["custom_reg_log_user_industry"])) echo ' checked="checked"'; ?> />Any Kind</span>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Temporary" <?php if( isset($_POST["custom_reg_log_user_industry"]) && $_POST["custom_reg_log_user_industry"]=='Temporary' ) echo ' checked'; ?> />Temporary</span>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Permanent" <?php if( isset($_POST["custom_reg_log_user_industry"]) && $_POST["custom_reg_log_user_industry"]=='Permanent' ) echo ' checked'; ?> />Permanent</span>
					</div>
				</div>
				<div class="gap">
					<label for="available_days"><?php _e('What days are you available?'); ?></label>
					<div class=checkbox-wrap>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Monday" <?php if(isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Monday' ) echo ' checked'; ?> />Monday</span>			<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Tuesday" <?php if( isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Tuesday' ) echo ' checked'; ?> />Tuesday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Wednesday" <?php if(isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Wednesday' ) echo ' checked'; ?> />Wednesday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Thursday" <?php if( isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Thursday' ) echo ' checked'; ?> />Thursday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Friday" <?php if( isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Friday' ) echo ' checked'; ?> />Friday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Saturday" <?php if( isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Saturday' ) echo ' checked'; ?> />Saturday</span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Sunday" <?php if(isset($_POST["custom_reg_log_user_available_days"]) && $_POST["custom_reg_log_user_available_days"]=='Sunday' ) echo ' checked'; ?> />Sunday</span>
					</div>
				</div>
				
				<p>
					<label><?php _e('Upload your Licenses and Certifications here'); ?></label>
					<input name="custom_reg_log_user_licenses" id="custom_reg_log_user_licenses" type="file"><br />
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png, .pdf<br />File size should be less than 1MB </small>
				</p>
				
				<p>
					<label><?php _e('Upload your Resume'); ?></label>
					<input name="custom_reg_log_user_resume" id="custom_reg_log_user_resume" type="file"><br />
					<small style="color:#666666; font-size:0.7em;">Allowed file types are .pdf, .doc, .docx, .txt<br />File size should be less than 1MB </small>
				</p>
				
				<!--<p>
					<label for="custom_reg_log_user_avatar">Upload a picture of yourself that we can use on the website</label>
					<input type="file" name="custom_reg_log_user_avatar" id="custom_reg_log_user_avatar" /><br />
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png.<br />Max image width = 175px, Max image height = 450px and file size 1 MB </small>
				</p>-->
				<p>
					<label>Upload a picture of yourself that we can use on the website</label>
					<input type="file" name="custom_reg_log_user_profile_picture" id="custom_reg_log_user_profile_picture"/><br />
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png.<br /> File size should be less than 1MB </small>
				</p>
				<!--
				<p>
					<label><?php //_e('Upload the signed application'); ?></label>
					<input name="custom_reg_log_user_signed_app" id="custom_reg_log_user_signed_app" type="file"><br />
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png, .pdf<br />Max image width = 175px, Max image height = 450px and file size 1 MB </small>
				</p>
				-->
				<?php /*
				<p>
					<label for="verify"><?php _e('Verify'); ?></label>
					<!--<script src='https://www.google.com/recaptcha/api.js'></script>-->
					<div class="grecaptcha">
						<?php
						//========== Start for g-reCaptcha Version-2 ==========//
						// Register API keys at https://www.google.com/recaptcha/admin
						$siteKey = '6LeDBzQUAAAAAH7TD2yNLXp0w0CEyvo8ROBwbbCo';
						$secret = '6LeDBzQUAAAAAFxY5nHasQCQGUfV8QlL_KF4rTpE';
						
						// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
						$lang = 'en';						
						?>
						<div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
						<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang; ?>"></script>
						<?php
						//========== Start for g-reCaptcha Version-1 ==========//
						?>
					</div>
				</p>
				*/ ?>
				
				<p>
					<input type="hidden" name="custom_reg_log_register_nonce" value="<?php echo wp_create_nonce('custom_reg_log-register-nonce'); ?>"/>
					<input type="submit" value="<?php _e('Register Now'); ?>"/>
				</p>
			</fieldset>
		</form>
		
	
	<?php
	return ob_get_clean();
}
?>