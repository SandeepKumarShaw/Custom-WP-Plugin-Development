<?php
//Job Providers Form
// registration form fields
function custom_reg_log_registration_job_provider_form_fields() {
	
	ob_start(); ?>	
		<h2 class="custom_reg_log_header"><?php _e('Register New Account'); ?></h2>
		
		<?php 
		// show any error messages after form submission
		custom_reg_log_show_error_messages(); ?>
		
		<form name="custom_reg_log_registration_form" id="custom_reg_log_registration_form" class="custom_reg_log_form" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="user_type" value="job_provider" readonly="readonly">
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
				<p>
					<label for="company_name"><?php _e('Name Of Company/Dental Practice'); ?></label>
					<input name="custom_reg_log_user_comp_name" id="company_name" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_comp_name"] ) ? esc_attr( $_POST["custom_reg_log_user_comp_name"] ) : '' )?>" placeholder="Name Of Company/Dental Practice"/>
				</p>				
				<p>
					<label for="authorized_person"><?php _e('Authorized Contact Person(s)'); ?></label>
					<input name="custom_reg_log_user_auth_per" id="authorized_person" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_auth_per"] ) ? esc_attr( $_POST["custom_reg_log_user_auth_per"] ) : '' )?>" placeholder="Authorized Contact Person(s)"/>
				</p>
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
				<p>
					<label for="off_phone"><?php _e('Office Phone'); ?></label>
					<input name="custom_reg_log_user_off_phone" class="wpcf7-tel" id="off_phone" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_off_phone"] ) ? esc_attr( $_POST["custom_reg_log_user_off_phone"] ) : '' )?>" placeholder="Office Phone" />
				</p>
				<p>
					<label for="fax_num"><?php _e('#Fax'); ?></label>
					<input name="custom_reg_log_user_fax" id="fax_num" class="required" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_fax"] ) ? esc_attr( $_POST["custom_reg_log_user_fax"] ) : '' )?>" placeholder="#Fax" />
				</p>	
				<p>
					<label for="user_website"><?php _e('Website'); ?></label>
					<input name="custom_reg_log_user_website" id="user_website" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_user_website"] ) ? esc_attr( $_POST["custom_reg_log_user_website"] ) : '' )?>" placeholder="Website"/>
				</p>			
				<div class="gap">
					<label for="practice_type"><?php _e('Type Of Practice/Company'); ?></label>
					<div class=radio-wrap>
						<span><input name="custom_reg_log_practice_type" type="radio" value="General" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='General' ) echo ' checked'; ?> <?php if(empty($_POST["custom_reg_log_practice_type"])) echo ' checked="checked"'; ?> />General
						</span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Periodontal" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Periodontal' ) echo ' checked'; ?> />Periodontal</span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Pediatric" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Pediatric' ) echo ' checked'; ?> />Pediatric </span>					
						<span><input name="custom_reg_log_practice_type" type="radio" value="Orthodontic" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Orthodontic' ) echo ' checked'; ?> />Orthodontic </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Endodontic" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Endodontic' ) echo ' checked'; ?> />Endodontic </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Dental Lab" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Dental Lab' ) echo ' checked'; ?> />Dental Lab </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Government" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Government' ) echo ' checked'; ?> />Government </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Other" <?php if( isset($_POST["custom_reg_log_practice_type"]) && $_POST["custom_reg_log_practice_type"]=='Other' ) echo ' checked'; ?> />Other </span>
					</div>
				</div>	
				<p>Number of Current Staff:</p>			
				<p>
					<label for="dentist"><?php _e('Dentists'); ?></label>
					<input name="custom_reg_log_dentists" id="dentist" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_dentists"] ) ? esc_attr( $_POST["custom_reg_log_dentists"] ) : '' )?>" placeholder="Dentists"/>
				</p>
				<p>
					<label for="hygienists"><?php _e('Hygienists'); ?></label>
					<input name="custom_reg_log_hygienists" id="hygienists" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_hygienists"] ) ? esc_attr( $_POST["custom_reg_log_hygienists"] ) : '' )?>" placeholder="Hygienists"/>
				</p>
				<p>
					<label for="assistants"><?php _e('Assistants'); ?></label>
					<input name="custom_reg_log_assistants" id="assistants" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_assistants"] ) ? esc_attr( $_POST["custom_reg_log_assistants"] ) : '' )?>" placeholder="Assistants"/>
				</p>
				<p>
					<label for="front_office"><?php _e('Front Office'); ?></label>
					<input name="custom_reg_log_front_office" id="front_office" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_front_office"] ) ? esc_attr( $_POST["custom_reg_log_front_office"] ) : '' )?>" placeholder="Front Office"/>
				</p>
				<p>
					<label for="other"><?php _e('Other'); ?></label>
					<input name="custom_reg_log_other" id="other" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_other"] ) ? esc_attr( $_POST["custom_reg_log_other"] ) : '' )?>" placeholder="Other"/>
				</p>
				<p>
					<label for="comp_soft_used"><?php _e('Computer Software used'); ?></label>
					<input name="custom_reg_log_comp_soft_used" id="comp_soft_used" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_comp_soft_used"] ) ? esc_attr( $_POST["custom_reg_log_comp_soft_used"] ) : '' )?>" placeholder="Computer Software used"/>
				</p>
				<div class="gap">
					<label for="practice_type"><?php _e('Will you accept a candidate who does not know your software?'); ?></label>
					<div class="radio-wrap">
						<span><input name="custom_reg_log_accept_candidate" type="radio" value="yes" <?php if( isset($_POST["custom_reg_log_accept_candidate"]) && $_POST["custom_reg_log_accept_candidate"]=='yes' ) echo ' checked'; ?> <?php if(empty($_POST["custom_reg_log_accept_candidate"])) echo ' checked="checked"'; ?> />Yes </span>
						<span><input name="custom_reg_log_accept_candidate" type="radio" value="no" <?php if( isset($_POST["custom_reg_log_accept_candidate"]) && $_POST["custom_reg_log_accept_candidate"]=='no' ) echo ' checked'; ?> />No </span>
				
					</div>	
				</div>
				<p>
					<label class="xray_used" for="xray_used"><?php _e('What type of X-ray system is used?'); ?></label>
					<?php /*?>
					<input name="custom_reg_log_xray_used" type="radio" value="yes" <?php if( isset($_POST["custom_reg_log_xray_used"]) && $_POST["custom_reg_log_xray_used"]=='yes' ) echo ' checked'; ?> />Yes &nbsp;&nbsp;&nbsp;
					<input name="custom_reg_log_xray_used" type="radio" value="no" <?php if( isset($_POST["custom_reg_log_xray_used"]) && $_POST["custom_reg_log_xray_used"]=='no' ) echo ' checked'; ?> />No &nbsp;&nbsp;&nbsp;
					<?php */?>
				<input name="custom_reg_log_xray_type" id="custom_reg_log_xray_type" class="" type="text" value="<?php echo ( isset( $_POST["custom_reg_log_xray_type"] ) ? esc_attr( $_POST["custom_reg_log_xray_type"] ) : '' )?>" placeholder="What type of X-ray system is used?"/>
				</p>
				
				<p>
					<label for="add_info"><?php _e('Additional Comments/Information'); ?></label>
					<textarea name="custom_reg_log_add_info" id="custom_reg_log_add_info" class=""><?php echo ( isset( $_POST["custom_reg_log_add_info"] ) ? esc_attr( $_POST["custom_reg_log_add_info"] ) : '' )?></textarea>
				</p>			
				
				<!--
				<p>
					<label><?php //_e('Upload the Credit Application here'); ?></label>
					<input name="custom_reg_log_user_credt_aplict" id="custom_reg_log_user_credt_aplict" type="file"><br/>
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png, .pdf<br />Max image width = 175px, Max image height = 450px and file size 1 MB </small>
				</p>				
				<p>
					<label><?php //_e('Upload the Office Agreement here'); ?></label>
					<input name="custom_reg_log_user_offc_aggrmnt" id="custom_reg_log_user_offc_aggrmnt" type="file"><br/>
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png, .pdf<br />Max image width = 175px, Max image height = 450px and file size 1 MB </small>	
				</p>
				-->
				
				<p>
					<label><?php _e('Upload profile picture here'); ?></label>
					<input name="custom_reg_log_user_profile_picture" id="custom_reg_log_user_profile_picture" type="file"><br/>
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png.<br />File size should be less than 1MB </small>
				</p>
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