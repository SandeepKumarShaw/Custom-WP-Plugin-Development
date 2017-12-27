<?php
//============ Start for view profile at frontend ============//
function view_my_profile_at_frontend($atts) {
    ob_start();
    
    //Start check user is login or not
    if(!is_user_logged_in()) return false;
    //End check user is login or not
    
    //Start to get information of current login user details
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles[0];
    //echo 'User ID: ' . $current_user->ID . '<br />';
    //echo 'Username: ' . $current_user->user_login . '<br />';
    //echo 'User email: ' . $current_user->user_email . '<br />';
    //echo 'User first name: ' . $current_user->user_firstname . '<br />';
    //echo 'User last name: ' . $current_user->user_lastname . '<br />';
    //echo 'User display name: ' . $current_user->display_name . '<br />';
    //End to get information of current login user details
    ?>
		<?php /*<h2 class="custom_reg_log_header"><?php _e('View My Profile'); ?></h2>*/ ?>
		
		<?php if( isset($_REQUEST['updusr']) && $_REQUEST['updusr']==md5('usrprflupdsuc') ) : ?>
			<span class='success_msg'>Your Profile Successfully Updated.</span>
		<?php endif; ?>
		
			<div class="edit-my-profile">
				<p ><?php echo get_avatar( $current_user->ID, 92 ); ?></p>
               <p ><a href="<?php echo site_url().get_option( 'edit_profile_url_after_login'); ?>" title="Edit My Profile" class=" custom-btton">Edit My Profile</a></p>
          </div>
			<div class="clear"></div>
        <fieldset>
			
			<div class="seekers_details">
				<ul>
            <li>
                <span><label for="custom_reg_log_user_first"><?php _e('First Name '); ?></label></span>
                  <span><?php echo $current_user->user_firstname?$current_user->user_firstname:'N/A'; ?></span>
            </li>
			<li>
                 <span><label for="custom_reg_log_user_last"><?php _e('Last Name '); ?></label></span>
                 <span><?php echo $current_user->user_lastname?$current_user->user_lastname:'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="custom_reg_log_user_Login"><?php _e('Username '); ?></label></span>
                <span><?php echo $current_user->user_login; ?></span>
            </li>
            <li>
                 <span><label for="custom_reg_log_user_email"><?php _e('Email '); ?></label></span>
                <span><?php echo $current_user->user_email; ?></span>
            </li>
            <li>
                 <span><label for="adrs"><?php _e('Address '); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'user_addr',true)?get_user_meta($current_user->ID,'user_addr',true):'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="city"><?php _e('City '); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'user_city',true)?get_user_meta($current_user->ID,'user_city',true):'N/A'; ?></span>
            </li>
           <li>
                 <span><label for="state"><?php _e('State '); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'user_state',true)?get_user_meta($current_user->ID,'user_state',true):'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="zip_code"><?php _e('Zip Code '); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'zip_code',true)?get_user_meta($current_user->ID,'zip_code',true):'N/A'; ?></span>
            </li>
            
        <?php if( $user_roles == 'job_seeker' ) : ?>
            <li>
                 <span><label for="max_working_distance"><?php _e('Max working distance(Miles) '); ?></label></span>
                 <span> <?php echo get_user_meta($current_user->ID,'max_working_distance',true)?get_user_meta($current_user->ID,'max_working_distance',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="industry_name"><?php _e('Work type '); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'industry',true)?get_user_meta($current_user->ID,'industry',true):'N/A'; ?></span>
            </li>
            <li>
               <span> <label for="available_days"><?php _e('Available days '); ?></label></span>
				<?php
				$available=get_user_meta($current_user->ID, 'available_days');
				if(!empty($available)){
					$available_on=unserialize($available[0]);
					echo '<span>'.implode(', ', $available_on).'</span>';
				} else { echo "<span>N/A</span>"; }
				?>
			</li>
            
            <li>
                <span><label for="custom_reg_log_user_licenses"><?php _e('Licenses and Certifications '); ?></label></span>
                <?php	
                // Check file extension  
                $file_paths = explode("/", get_the_author_meta( '_user_licenses', $current_user->ID ));
                $filename = $file_paths[1];
                $extension = pathinfo($filename);  
                $extension = $extension[extension];
                $uploads = wp_upload_dir();
                $upload_path = $uploads['baseurl'].'/users_doc/';
                
                if ( in_array($extension, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
                    ?><img src="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $current_user->ID ); ?>" style="width:150px;"><br /><?php
                } elseif(in_array($extension, array( 'PDF', 'pdf'))) {
                    ?><a href="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                }else{
                       echo "<span>N/A</span>";
                }
                ?>
            </li>
            
            <li>
                <span><label for="custom_reg_log_user_resume"><?php _e('Resume'); ?></label></span>
                <?php	
                // Check file extension  
                $file_paths2 = explode("/", get_the_author_meta( '_user_resume', $current_user->ID ));
                $filename2 = $file_paths2[1];
                $extension2 = pathinfo($filename2);  
                $extension2 = $extension2[extension];
                $uploads2 = wp_upload_dir();
                $upload_path2 = $uploads2['baseurl'].'/users_doc/';
                
                if(in_array($extension2, array( 'PDF', 'pdf', 'DOC', 'doc', 'DOCX', 'docx', 'TXT', 'txt'))) {
                    ?><a href="<?php echo $upload_path2.get_the_author_meta( '_user_resume', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                }else{
                    echo "<span>N/A</span>";
                }
                ?>			
            </li>
	    <?php /* ?>
            <li>
               <span> <label for="custom_reg_log_user_signed_app"><?php _e('Signed application'); ?></label></span>
                <?php	
                // Check file extension  
                $file_paths4 = explode("/", get_the_author_meta( '_user_signapp', $current_user->ID ));
                $filename4 = $file_paths4[1];
                $extension4 = pathinfo($filename4);  
                $extension4 = $extension4[extension];
                $uploads4 = wp_upload_dir();
                $upload_path4 = $uploads4['baseurl'].'/users_doc/';
                
                if ( in_array($extension4, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
                    ?><img src="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $current_user->ID ); ?>" style="width:150px;"><br /><?php
                } elseif( in_array($extension4, array('PDF', 'pdf'))) {
                    ?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                }else{
                    echo "<span>N/A</span>";
                }
                ?>			
            </li>
	    <?php */ ?>
        <?php endif; ?>
        
        <?php if( $user_roles == 'job_provider' ) : ?>
            <li>
                 <span> <label for="authorized_person"><?php _e('Authorized Contact Person(s)'); ?></label></span>
                 <span> <?php echo get_user_meta($current_user->ID,'authorized_contact',true)?get_user_meta($current_user->ID,'authorized_contact',true):'N/A'; ?></span>
            </li>
            <li>
                 <span> <label for="off_phone"><?php _e('Office Phone'); ?></label></span>
                 <span> <?php echo get_user_meta($current_user->ID,'office_phone',true)?get_user_meta($current_user->ID,'office_phone',true):'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="fax_num"><?php _e('#Fax'); ?></label></span>
                 <span><?php echo get_user_meta($current_user->ID,'user_fax',true)?get_user_meta($current_user->ID,'user_fax',true):'N/A'; ?></span>
            </li>	
            <li>
                 <span><label for="user_website"><?php _e('Website'); ?></label></span>
                 <span><?php echo $current_user->user_url?$current_user->user_url:'N/A'; ?></span>
            </li>			
            <li>
                <span><label for="practice_type"><?php _e('Type Of Practice/Company'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'industry',true)?get_user_meta($current_user->ID,'industry',true):'N/A'; ?></span>
            </li>	
            <p class="frm-head">Number of Current Staff:</p>			
            <li>
                <span><label for="dentist"><?php _e('Dentists'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'emp_dentists',true)?get_user_meta($current_user->ID,'emp_dentists',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="hygienists"><?php _e('Hygienists'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'emp_hygienists',true)?get_user_meta($current_user->ID,'emp_hygienists',true):'N/A'; ?></span></span>
            </li>
            <li>
                <span><label for="assistants"><?php _e('Assistants'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'emp_assistants',true)?get_user_meta($current_user->ID,'emp_assistants',true):'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="front_office"><?php _e('Front Office'); ?></label></span>
                 <span><?php echo get_user_meta($current_user->ID,'emp_front_office',true)?get_user_meta($current_user->ID,'emp_front_office',true):'N/A'; ?></span>
            </li>
            <li>
                 <span><label for="other"><?php _e('Other'); ?></label></span>
                 <span><?php echo get_user_meta($current_user->ID,'other_stuff',true)?get_user_meta($current_user->ID,'other_stuff',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="comp_soft_used"><?php _e('Computer Software used'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'computer_sw',true)?get_user_meta($current_user->ID,'computer_sw',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="practice_type"><?php _e('Will I accept a candidate who does not know your software?')?_e('Will I accept a candidate who does not know your software?'):'N/A'; ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'exp_with_sw',true)?get_user_meta($current_user->ID,'exp_with_sw',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="xray_used"><?php _e('What type of X-ray system is used?'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'x_ray_type',true)?get_user_meta($current_user->ID,'x_ray_type',true):'N/A'; ?></span>
            </li>
            <li>
                <span><label for="add_info"><?php _e('Additional Comments/Information'); ?></label></span>
                <span><?php echo get_user_meta($current_user->ID,'description',true)?get_user_meta($current_user->ID,'description',true):'N/A'; ?></span>
            </li>			
            <?php /*?>
            <li>
               <span> <label for="custom_reg_log_user_credt_aplict"><?php _e('Credit Application'); ?></label></span>
                <?php	
                // Check file extension  
                $file_paths4 = explode("/", get_the_author_meta( '_user_creditapp', $current_user->ID ));
                $filename4 = $file_paths4[1];
                $extension4 = pathinfo($filename4);  
                $extension4 = $extension4[extension];
                $uploads4 = wp_upload_dir();
                $upload_path4 = $uploads4['baseurl'].'/users_doc/';
                
                if ( in_array($extension4, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
                    ?><img src="<?php echo $upload_path4.get_the_author_meta( '_user_creditapp', $current_user->ID ); ?>" style="width:150px;"><br /><?php
                } elseif( in_array($extension4, array('PDF', 'pdf'))) {
                    ?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_creditapp', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                }else{
                    echo "<span>N/A</span>";
                }
                ?>			
            </li>				
            <li>
                <span><label for="custom_reg_log_user_offc_aggrmnt"><?php _e('Office Agreement'); ?></label></span>
                <?php	
                // Check file extension  
                $file_paths4 = explode("/", get_the_author_meta( '_user_offcaggr', $current_user->ID ));
                $filename4 = $file_paths4[1];
                $extension4 = pathinfo($filename4);  
                $extension4 = $extension4[extension];
                $uploads4 = wp_upload_dir();
                $upload_path4 = $uploads4['baseurl'].'/users_doc/';
                
                if ( in_array($extension4, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
                    ?><img src="<?php echo $upload_path4.get_the_author_meta( '_user_offcaggr', $current_user->ID ); ?>" style="width:150px;"><br /><?php
                } elseif( in_array($extension4, array('PDF', 'pdf'))) {
                    ?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_offcaggr', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                }else{
                    echo "<span>N/A</span>";
                }
                ?>			
            </li>
	    <?php */ ?>
        <?php endif; ?>
		</ul>
		</div>
			
        </fieldset>
    <?php
    return ob_get_clean();
}
add_shortcode('view_my_profile', 'view_my_profile_at_frontend');
//============ End for view profile at frontend ============//
?>