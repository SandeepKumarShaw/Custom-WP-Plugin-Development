<?php
//============ Start for edit profile at frontend ============//
function edit_my_profile_at_frontend($atts) {
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
	
		<?php
		if (isset($_POST['custom_reg_log_register_update_nonce']) && wp_verify_nonce($_POST['custom_reg_log_register_update_nonce'], 'custom_reg_log-register-update-nonce')) {
			if(isset($_POST["custom_reg_log_user_first"]) ){
			$user_first = $_POST["custom_reg_log_user_first"];
			}
			if(isset($_POST["custom_reg_log_user_last"]) ){
			$user_last = $_POST["custom_reg_log_user_last"];
			}
			if(isset($_POST["custom_reg_log_user_pass"]) ){
				$user_pass = $_POST["custom_reg_log_user_pass"];
			}
			if(isset($_POST["custom_reg_log_user_pass_confirm"]) ){
				$pass_confirm = $_POST["custom_reg_log_user_pass_confirm"];
			}
			if(isset($_POST["custom_reg_log_user_comp_name"]) ){
				$user_comp_name = $_POST["custom_reg_log_user_comp_name"];
			}
			if(isset($_POST["custom_reg_log_user_zip_code"]) ){
				$user_zip_code = $_POST["custom_reg_log_user_zip_code"];
			}
			//print_r($_POST["custom_reg_log_user_industry"]);die("HI");
			if(isset($_POST["custom_reg_log_user_industry"]) ){
				$user_industry = $_POST["custom_reg_log_user_industry"];
			}
			if(isset($_POST["custom_reg_log_user_city"]) ){
				$user_city = $_POST["custom_reg_log_user_city"];
			}
			if(isset($_POST["custom_reg_log_user_state"]) ){
				$user_state = $_POST["custom_reg_log_user_state"];
			}
			if(isset($_POST["custom_reg_log_user_country"]) ){
				$user_country = $_POST["custom_reg_log_user_country"];
			}
			if(isset($_POST["custom_reg_log_user_max_working_distance"]) ){
				$user_max_working_distance = $_POST["custom_reg_log_user_max_working_distance"];
			}
			
			
			
			if(isset($_POST["custom_reg_log_user_pos_requestd"]) ){
				$user_pos_requestd = $_POST["custom_reg_log_user_pos_requestd"];
			}
			
			
			//print_r($_POST["custom_reg_log_user_available_days"]);die("HI");
			if(isset($_POST["custom_reg_log_user_available_days"]) ){
				$user_available_days = serialize($_POST["custom_reg_log_user_available_days"]);
			}
	  
					
					
			 if(isset($_POST["custom_reg_log_user_exp_years"]) ){
			      $user_experience_years = $_POST["custom_reg_log_user_exp_years"];
			 }
			 if(isset($_POST["custom_reg_log_user_exp_months"]) ){
			      $user_experience_months = $_POST["custom_reg_log_user_exp_months"];
			 }
			 if($user_experience_years){
			      $user_exp_in_month = $user_experience_years*12;
			 if($user_experience_months){
			      $user_exp_in_month = $user_exp_in_month+$user_experience_months;
			 }
			      $user_experience = $user_exp_in_month;
			 }else{
			      $user_experience = $user_experience_months;
			 }
		
		
			/********For Provider Form Start*******/
			if(isset($_POST["custom_reg_log_user_auth_per"]) ){
				$user_authorised_person = $_POST["custom_reg_log_user_auth_per"];
			}
			
			if(isset($_POST["custom_reg_log_user_adrs"]) ){
				$user_address = $_POST["custom_reg_log_user_adrs"];
			}
			
			if(isset($_POST["custom_reg_log_user_off_phone"]) ){
				$user_offc_phn = $_POST["custom_reg_log_user_off_phone"];
			}
			
			if(isset($_POST["custom_reg_log_user_fax"]) ){
				$user_fax = $_POST["custom_reg_log_user_fax"];
			}
			
			if(isset($_POST["custom_reg_log_user_website"]) ){
				$user_website = $_POST["custom_reg_log_user_website"];
			}
			if(isset($_POST["custom_reg_log_practice_type"]) ){
				//$user_practice_type = $_POST["custom_reg_log_practice_type"];
				$user_industry = $_POST["custom_reg_log_practice_type"];
			}
			if(isset($_POST["custom_reg_log_dentists"]) ){
				$user_dentist = $_POST["custom_reg_log_dentists"];
			}
			if(isset($_POST["custom_reg_log_hygienists"]) ){
				$user_hygienist = $_POST["custom_reg_log_hygienists"];
			}
			if(isset($_POST["custom_reg_log_assistants"]) ){
				$user_assistant = $_POST["custom_reg_log_assistants"];
			}
			if(isset($_POST["custom_reg_log_front_office"]) ){
				$user_front_offc = $_POST["custom_reg_log_front_office"];
			}
			if(isset($_POST["custom_reg_log_other"]) ){
				$user_log_other = $_POST["custom_reg_log_other"];
			}
			if(isset($_POST["custom_reg_log_comp_soft_used"]) ){
				$user_comp_used = $_POST["custom_reg_log_comp_soft_used"];
			}
			if(isset($_POST["custom_reg_log_accept_candidate"]) ){
				$user_accpt_candidate = $_POST["custom_reg_log_accept_candidate"];
			}
			/*if(isset($_POST["custom_reg_log_xray_used"]) ){
			$user_xray_used = $_POST["custom_reg_log_xray_used"];
			 }
			 */
		if(isset($_POST["custom_reg_log_xray_type"]) ){
			$user_xray_type = $_POST["custom_reg_log_xray_type"];
		}
			if(isset($_POST["custom_reg_log_add_info"]) ){
				$user_add_info = $_POST["custom_reg_log_add_info"];
			}
			/********For Provider Form End*******/
			
			
			// this is required for username checks
			require_once(ABSPATH . WPINC . '/registration.php');
			
			 if($user_pass != '') {
			       if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $user_pass) === 0) {
				    // Password must be strong
				    custom_reg_log_errors()->add('password_empty', __('Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit'));
			       }
			 
			       if($user_pass != $pass_confirm) {
				    // passwords do not match
				    custom_reg_log_errors()->add('password_mismatch', __('Passwords do not match'));
			       }
			  }
		
			//start for licenses/certifications image
			if(isset( $_FILES['custom_reg_log_user_licenses']) && $_FILES['custom_reg_log_user_licenses']['name'] != ''){
				// Allowed mimes    
				$allowed_ext2 = "JPG, jpg, JPEG, jpeg, GIF, gif, PNG, png, PDF, pdf";  
				// Default is 50kb 
				$max_size2 = (1000*1024);  
				
				// Check mime types are allowed  
				$extension2 = pathinfo($_FILES['custom_reg_log_user_licenses']['name']);  
				$extension2 = $extension2[extension];  
				$allowed_paths2 = explode(", ", $allowed_ext2);
				if ( !in_array($extension2, $allowed_paths2) ) {
					custom_reg_log_errors()->add('file_extension2', __('File type for licenses/certifications does not support!'));
				}
		
				// Check File Size  
				if($_FILES['custom_reg_log_user_licenses']['size'] > $max_size2) {  
					custom_reg_log_errors()->add('file_size2', __('Licenses/Certifications file size is too big!'));
				}  
			}
			//end for licenses/certifications image
			
			
			//start for resume upload
			if(isset( $_FILES['custom_reg_log_user_resume']) && $_FILES['custom_reg_log_user_resume']['name'] != ''){
				// Allowed mimes    
				$allowed_ext3 = "TXT, txt, DOC, doc, DOCX, docx, PDF, pdf";  
				// Default is 50kb 
				$max_size3 = (1000*1024);  
	
				// Check mime types are allowed  
				$extension3 = pathinfo($_FILES['custom_reg_log_user_resume']['name']);  
				$extension3 = $extension3[extension];  
				$allowed_paths3 = explode(", ", $allowed_ext3);
				if ( !in_array($extension3, $allowed_paths3) ) {
					custom_reg_log_errors()->add('file_extension3', __('File type for resume does not support!'));
				}
		
				// Check File Size  
				if($_FILES['custom_reg_log_user_resume']['size'] > $max_size3) {  
					custom_reg_log_errors()->add('file_size3', __('Resume file size is too big!'));
				}  
			}
			//end for resume upload
			
			
			//start for avatar/user profile image
			if(isset( $_FILES['custom_reg_log_user_profile_picture']) && $_FILES['custom_reg_log_user_profile_picture']['name'] != ''){
				// Allowed mimes    
				$allowed_ext = "JPG, jpg, JPEG, jpeg, GIF, gif, PNG, png";  
				// Default is 50kb 
				$max_size = (1000*1024);  
				// height in pixels, default is 320px 
				$max_height = 320;  
				// width in pixels, default is 384px 
				$max_width = 384;
				
				// Check mime types are allowed  
				$extension = pathinfo($_FILES['custom_reg_log_user_profile_picture']['name']);  
				$extension = $extension[extension];  
				$allowed_paths = explode(", ", $allowed_ext);
				if ( !in_array($extension, $allowed_paths) ) {
					custom_reg_log_errors()->add('file_extension', __('Profile picture file type does not support!'));
				}
		
				// Check File Size  
				elseif($_FILES['custom_reg_log_user_profile_picture']['size'] > $max_size) {  
					custom_reg_log_errors()->add('file_size', __('Profile picture file size is too big!'));
				}  
				
				// Check Height & Width  
				/*if ($max_width && $max_height) {  
					list($width, $height, $type, $w) = getimagesize($_FILES['custom_reg_log_user_profile_picture']['tmp_name']);  
					if($width > $max_width || $height > $max_height) {  
						custom_reg_log_errors()->add('file_height_width', __('Profile picture file size is too big! file size should be with in (W x H = 320 x 384)px.'));
					}  
				}
				*/
	       }
			//end for avatar/user profile image
			
			
			//start for for signed application
			if(isset( $_FILES['custom_reg_log_user_signed_app']) && $_FILES['custom_reg_log_user_signed_app']['name'] != ''){
				// Allowed mimes    
				$allowed_ext4 = "PDF, pdf";  
				// Default is 50kb 
				$max_size4 = (1000*1024);  
				// height in pixels, default is 175px 
				$max_height4 = 2480;  
				// width in pixels, default is 450px 
				$max_width4 = 3508;
				
				// Check mime types are allowed  
				$extension4 = pathinfo($_FILES['custom_reg_log_user_signed_app']['name']);  
				$extension4 = $extension4[extension];  
				$allowed_paths4 = explode(", ", $allowed_ext4);
				if ( !in_array($extension4, $allowed_paths4) ) {
					custom_reg_log_errors()->add('file_extension4', __('Signed application file type supports PDF only!'));
                   // file type supports PDF only!
				}
		
				// Check File Size  
				if($_FILES['custom_reg_log_user_signed_app']['size'] > $max_size4) {  
					custom_reg_log_errors()->add('file_size4', __('Signed application file size is too big!'));
				}  
				
				// Check Height & Width  
				if ($max_width4 && $max_height4) {  
					list($width4, $height4, $type4, $w4) = getimagesize($_FILES['custom_reg_log_user_signed_app']['tmp_name']);  
					if($width4 > $max_width4 || $height4 > $max_height4) {  
						custom_reg_log_errors()->add('file_height_width4', __('Signed application file size is too big! file size should be with in (W x H = 2480 x 3508)px.'));
					}  
				}  
			}
			//end for signed application
			
			
	
			/************For Job Providers File Upload Section start********/
			//start for Credit Application
			if(isset( $_FILES['custom_reg_log_user_credt_aplict']) && $_FILES['custom_reg_log_user_credt_aplict']['name'] != ''){
				// Allowed mimes    
				$allowed_ext5 = "PDF, pdf";  
				// Default is 50kb 
				$max_size5 = (1000*1024);  
				
				// Check mime types are allowed  
				$extension5 = pathinfo($_FILES['custom_reg_log_user_credt_aplict']['name']);
				
				$extension5 = $extension5[extension];  
				$allowed_paths5 = explode(", ", $allowed_ext5);
				if ( !in_array($extension5, $allowed_paths5) ) {
					custom_reg_log_errors()->add('file_extension5', __('Credit Application file type supports PDF only!'));
				}
		
				// Check File Size  
				if($_FILES['custom_reg_log_user_credt_aplict']['size'] > $max_size5) {  
					custom_reg_log_errors()->add('file_size5', __('Credit Application file size is too big!'));
				}  
			}
			//end for Credit Application
			
			//start for Office Agreement
			if(isset( $_FILES['custom_reg_log_user_offc_aggrmnt']) && $_FILES['custom_reg_log_user_offc_aggrmnt']['name'] != ''){
				// Allowed mimes    
				$allowed_ext6 = "PDF, pdf";  
				// Default is 50kb 
				$max_size6 = (1000*1024);  
				
				// Check mime types are allowed  
				$extension6 = pathinfo($_FILES['custom_reg_log_user_offc_aggrmnt']['name']);
				
				$extension6 = $extension6[extension];  
				$allowed_paths6 = explode(", ", $allowed_ext6);
				if ( !in_array($extension6, $allowed_paths6) ) {
					custom_reg_log_errors()->add('file_extension6', __('Office Agreement file type supports PDF only!'));
				}
		
				// Check File Size  
				if($_FILES['custom_reg_log_user_offc_aggrmnt']['size'] > $max_size6) {  
					custom_reg_log_errors()->add('file_size6', __('Office Agreement file size is too big!'));
				}  
			}
			//end for Office Agreement
			
			/************For Job Providers File Upload Section End********/
						
			$errors = custom_reg_log_errors()->get_error_messages();
			
			 // only create the user in if there are no errors
			 if(empty($errors)) {
			      if($current_user->ID) {
				   //wp_update_user( array ('ID' => $current_user->ID, 'role' => 'editor') ) ;
				   
				   update_user_meta( $current_user->ID, 'company_name', $user_comp_name );
				   update_user_meta( $current_user->ID, 'zip_code', $user_zip_code );
				   update_user_meta( $current_user->ID, 'industry', $user_industry );
				   update_user_meta( $current_user->ID, 'user_city', $user_city );
				   update_user_meta( $current_user->ID, 'user_state', $user_state );
				   update_user_meta( $current_user->ID, 'user_country', $user_country );
				   update_user_meta( $current_user->ID, 'max_working_distance', $user_max_working_distance );
				   
				   update_user_meta( $current_user->ID, 'position_requested', $user_pos_requestd );
				   
				   
				   update_user_meta( $current_user->ID, 'available_days', $user_available_days );
				   update_user_meta( $current_user->ID, 'user_experience', $user_experience );
				   
				   /****** For Providers Section Start*****/
				   update_user_meta( $current_user->ID, 'authorized_contact', $user_authorised_person );			
				   update_user_meta( $current_user->ID, 'user_addr', $user_address );				
				   update_user_meta( $current_user->ID, 'office_phone', $user_offc_phn );
				   update_user_meta( $current_user->ID, 'user_fax', $user_fax );
				   wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => $user_website ) ); // For Website
				   //update_user_meta( $current_user->ID, 'practice_type',	$user_practice_type );//Type Of Practice/Company
				   
				   update_user_meta( $current_user->ID, 'emp_dentists', $user_dentist );
				   update_user_meta( $current_user->ID, 'emp_hygienists', $user_hygienist );				
				   update_user_meta( $current_user->ID, 'emp_assistants', $user_assistant );
				   update_user_meta( $current_user->ID, 'emp_front_office', $user_front_offc );
				   update_user_meta( $current_user->ID, 'other_stuff', $user_log_other );				
				   update_user_meta( $current_user->ID, 'computer_sw', $user_comp_used );
				   update_user_meta( $current_user->ID, 'exp_with_sw', $user_accpt_candidate );
				  /*update_user_meta( $new_user_id, 'x_ray_used', $user_xray_used );*/
				update_user_meta( $current_user->ID, 'x_ray_type', $user_xray_type );
				   update_user_meta( $current_user->ID, 'description', $user_add_info );//For Additional Comments:
				   
				   /****** For Providers Section End*****/
				   
				   if(isset($_FILES['custom_reg_log_user_licenses']) && $_FILES['custom_reg_log_user_licenses']['name'] != '') {
					   
					   $delete_uploaded_img2 = get_user_option( '_user_licenses', $current_user->ID );
					   if(!empty($delete_uploaded_img2)) {
						   wp_delete_file( ABSPATH . 'wp-content/uploads/users_doc/'.$delete_uploaded_img2 );
					   }
					   
					   // Directory for licenses images 
					   $uploaddir2 = ABSPATH . 'wp-content/uploads/users_doc/licenses';  
					   if (!file_exists($uploaddir2)) {
						   mkdir($uploaddir2, 0777, true);
					   }
					   $image_name2=$current_user->ID.'.'.$extension2;
					   // Rename file and move to folder
					   $newname2 = $uploaddir2."/user_licenses_".$image_name2;  
					   $files2 = $_FILES['custom_reg_log_user_licenses'];
					   if( move_uploaded_file($files2['tmp_name'], $newname2) ) {
						   update_usermeta($current_user->ID,'_user_licenses','licenses/user_licenses_'.$image_name2);
					   }
				   }
				   //echo '<br><br>';
				   
				   if(isset($_FILES['custom_reg_log_user_resume']) && $_FILES['custom_reg_log_user_resume']['name'] != '') {
					   
					   $delete_uploaded_img3 = get_user_option( '_user_resume', $current_user->ID );
					   if(!empty($delete_uploaded_img3)) {
						   wp_delete_file( ABSPATH . 'wp-content/uploads/users_doc/'.$delete_uploaded_img3 );
					   }
					   
					   // Directory for resume doc 
					   $uploaddir3 = ABSPATH . 'wp-content/uploads/users_doc/resume';  
					   if (!file_exists($uploaddir3)) {
						   mkdir($uploaddir3, 0777, true);
					   }
					   $image_name3=$current_user->ID.'.'.$extension3;
					   // Rename file and move to folder
					   $newname3 = $uploaddir3."/user_resume_".$image_name3;  
					   $files3 = $_FILES['custom_reg_log_user_resume'];
					   if( move_uploaded_file($files3['tmp_name'], $newname3) ) {
						   update_usermeta($current_user->ID,'_user_resume','resume/user_resume_'.$image_name3);
					   }
				   }
				   //echo '<br><br>';
				   
				   if(isset($_FILES['custom_reg_log_user_signed_app']) && $_FILES['custom_reg_log_user_signed_app']['name'] != '') {
					   
					   $delete_uploaded_img4 = get_user_option( '_user_signapp', $current_user->ID );
					   if(!empty($delete_uploaded_img4)) {
						   wp_delete_file( ABSPATH . 'wp-content/uploads/users_doc/'.$delete_uploaded_img4 );
					   }
					   
					   // Directory for signed application images/doc
					   $uploaddir4 = ABSPATH . 'wp-content/uploads/users_doc/signapp';  
					   if (!file_exists($uploaddir4)) {
						   mkdir($uploaddir4, 0777, true);
					   }
					   $image_name4=$current_user->ID.'.'.$extension4;
					   // Rename file and move to folder
					   $newname4 = $uploaddir4."/user_signapp_".$image_name4;  
					   $files4 = $_FILES['custom_reg_log_user_signed_app'];
					   if( move_uploaded_file($files4['tmp_name'], $newname4) ) {
						  update_usermeta($current_user->ID,'_user_signapp','signapp/user_signapp_'.$image_name4);//HELLOOO
					   }
				   }	
				   //echo '<br><br>';
				   
				   if(isset($_FILES['custom_reg_log_user_credt_aplict']) && $_FILES['custom_reg_log_user_credt_aplict']['name'] != '') {
					   
					   $delete_uploaded_img5 = get_user_option( '_user_creditapp', $current_user->ID );
					   if(!empty($delete_uploaded_img5)) {
						   wp_delete_file( ABSPATH . 'wp-content/uploads/users_doc/'.$delete_uploaded_img5 );
					   }
					   
					   // Directory for Credit Application
					   $uploaddir5 = ABSPATH . 'wp-content/uploads/users_doc/creditapp';  
					   if (!file_exists($uploaddir5)) {
						   mkdir($uploaddir5, 0777, true);
					   }
					   $image_name5=$current_user->ID.'.'.$extension5;
					   // Rename file and move to folder
					   $newname5 = $uploaddir5."/user_creditapp_".$image_name5;
					   $files5 = $_FILES['custom_reg_log_user_credt_aplict'];
					   
					   if( move_uploaded_file($files5['tmp_name'], $newname5) ) {
						   update_usermeta($current_user->ID,'_user_creditapp','creditapp/user_creditapp_'.$image_name5);
					   }
				   }
				   //echo '<br><br>';
				   
				   if(isset($_FILES['custom_reg_log_user_offc_aggrmnt']) && $_FILES['custom_reg_log_user_offc_aggrmnt']['name'] != '') {
					   
					   $delete_uploaded_img6 = get_user_option( '_user_offcaggr', $current_user->ID );
					   if(!empty($delete_uploaded_img6)) {
						   wp_delete_file( ABSPATH . 'wp-content/uploads/users_doc/'.$delete_uploaded_img6 );
					   }
					   
					   // Directory for Office Agreement
					   $uploaddir6 = ABSPATH . 'wp-content/uploads/users_doc/officeaggr';  
					   if (!file_exists($uploaddir6)) {
						   mkdir($uploaddir6, 0777, true);
					   }
					   
					   $image_name6=$current_user->ID.'.'.$extension6;
					   // Rename file and move to folder
					   $newname6 = $uploaddir6."/user_offcaggr_".$image_name6;
					   $files6 = $_FILES['custom_reg_log_user_offc_aggrmnt'];
					   
					   if( move_uploaded_file($files6['tmp_name'], $newname6) ) {
						   update_usermeta($current_user->ID,'_user_offcaggr','officeaggr/user_offcaggr_'.$image_name6);
					   }
				   }
				   //echo '<br><br>';
   
				   /***************Start Profile picture upload*************/
				   if(isset($_FILES['custom_reg_log_user_profile_picture']) && $_FILES['custom_reg_log_user_profile_picture']['name'] != '') {
					
					$post_id = get_user_option( 'metronet_post_id', $current_user->ID );
					$avatar_attachment_id = get_user_option( 'metronet_image_id', $current_user->ID );
					if(!empty($avatar_attachment_id)) {
						wp_delete_attachment( $avatar_attachment_id );
					}

					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					require_once(ABSPATH . "wp-admin" . '/includes/file.php');
					require_once(ABSPATH . "wp-admin" . '/includes/media.php');
					
					//var_dump($_POST); exit;
					$file = $_FILES['custom_reg_log_user_profile_picture'];
					$uploads = wp_upload_dir();//var_dump($uploads); exit;
					
		
					if(!$post_id) {
						$args = array(
							'post_status' => 'publish',
							'post_author' => $current_user->ID,
							'post_title' => $current_user->ID,
							'post_content' => '',
							'post_type' => 'mt_pp'
						);
						$post_id = wp_insert_post( $args );
					}
					
					if($post_id) {
						$upload_overrides = array( 'test_form' => FALSE );
		
						$uploaded_file = wp_handle_upload( $file, $upload_overrides );
						$attachment = array(
							   'post_mime_type' => $uploaded_file['type'],
							   'post_title' => preg_replace('/\.[^.]+$/', '', basename( $uploaded_file['file'] ) ),
							   'post_content' => '',
							   'post_author' => '',
							   'post_status' => 'inherit',
							   'post_type' => 'attachment',
							   'post_parent' => $post_id,
							   'guid' => $uploaded_file['file']
						   );
						$attachment_id = wp_insert_attachment( $attachment, $uploaded_file['file'] );
						$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
					   
						// update the attachment metadata
						wp_update_attachment_metadata( $attachment_id,  $attach_data );
						//Set as thumbnail
						set_post_thumbnail ($post_id, $attachment_id );
						
						update_user_option( $current_user->ID, 'metronet_post_id', $post_id );
						update_user_option( $current_user->ID, 'metronet_image_id', $attachment_id );
						update_user_option( $current_user->ID, 'metronet_avatar_override', 'on' );
					}
				   }
				   /***************End Profile picture upload*************/		
				   
				   // send an email to the admin alerting them of the registration
				   //wp_new_user_notification($current_user->ID);
				   
				   if( $user_pass != '' ) {
					$update_pass = wp_update_user( array(
									'ID' => $current_user->ID,
									'user_pass'=>$user_pass
								) );  // correct email address
					
					if( $update_pass ) {
					  echo '<script>window.location = "'.site_url().get_option( 'user_login_url').'?updusr='.md5('passrestsuc').'";</script>';
					}
				   }
				  echo '<script>window.location = "'.site_url().get_option( 'view_profile_url_after_login').'?updusr='.md5('usrprflupdsuc').'";</script>';
			      }
			}
		}		
		?>
     
		<?php /*<h2 class="custom_reg_log_header"><?php _e('Edit My Profile'); ?></h2>*/ ?>
		
		<?php 
		// show any error messages after form submission
		custom_reg_log_show_error_messages();
		?>
		<?php if( $profile_status != '' ) { echo '<div class="job-listing-hld">'.$profile_status.'</div>'; } ?>
		<form name="custom_reg_log_registration_form" id="custom_reg_log_registration_form" class="custom_reg_log_form edit" action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="user_type" value="<?php echo $user_roles;?>" readonly="readonly">
			<fieldset>
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 <!--===========Seeker Candidate Agreement Start=========-->
			 <?php if( $user_roles == 'job_seeker' ){ ?>
			      <?php
			      $user_signapp = get_the_author_meta( '_user_signapp', $current_user->ID );
			      //print_r($user_signapp);
			      if($user_signapp){
				   echo "<span class='green_check'>Signed Candidate Agreement on file</span>";
				   
			      }
			      else{
				   echo "<div class='d_wrap'>";
				   echo "<div class='dwnld_wrap'>";
				   echo '<span class="not_updated"><a href="https://redrockdentalstaffing.com/wp-content/uploads/2017/12/candidate.pdf" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Download</a> the candidate agreement, review and sign it, and upload it back to us</span>';
				
				?>
				   <p>
				      <input name="custom_reg_log_user_signed_app" id="custom_reg_log_user_signed_app" type="file">
				      <?php
				   
				   
					   // Check file extension  
					   $file_paths4 = explode("/", get_the_author_meta( '_user_signapp', $current_user->ID ));
					   $filename4 = $file_paths4[1];
					   $extension4 = pathinfo($filename4);  
					   $extension4 = $extension4[extension];
					   $uploads4 = wp_upload_dir();
					   $upload_path4 = $uploads4['baseurl'].'/users_doc/';
					   /*
					   if( in_array($extension4, array('PDF', 'pdf'))) {
						?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
					   }else{
						echo "N/A";
					   }
					*/
					
				   
				      ?>
				   </p>
				   
				<?php
				   echo "</div>";
				   echo "</div>";
			      }
			      ?>
			      
			 <?php } ?>
			  <!--===========Seeker Candidate Agreement End=========-->
			 
			 
			 
			 
			 
			 <!--============== Provider Credit Application AND Office Agreement START==================-->
			 <?php if( $user_roles == 'job_provider' ){ ?>
			      <?php
			      $user_creditapp = get_the_author_meta( '_user_creditapp', $current_user->ID );
			      //print_r($user_signapp);
			      if($user_creditapp){
				   echo "<span class='green_check'>Credit application On file</span>";
				   
			      }
			      else{
				   echo "<div class='d_wrap'>";
				   echo "<div class='dwnld_wrap'>";
				  echo '<span class="not_updated"><a href="'.get_field("download_credit_application","options").'" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Download</a> the Credit Application, review and sign it, then Upload it here</span>';
				  ?>
				  <p>
				   
					<input name="custom_reg_log_user_credt_aplict" id="custom_reg_log_user_credt_aplict" type="file">
                         <?php	
                         // Check file extension  
                         $file_paths4 = explode("/", get_the_author_meta( '_user_creditapp', $current_user->ID ));
                         $filename4 = $file_paths4[1];
                         $extension4 = pathinfo($filename4);  
                         $extension4 = $extension4[extension];
                         $uploads4 = wp_upload_dir();
                         $upload_path4 = $uploads4['baseurl'].'/users_doc/';
                         /*
                         if( in_array($extension4, array('PDF', 'pdf'))) {
                              ?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_creditapp', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                         }else{
                             echo "N/A";
                         }
			 */
                         ?>			
                         
				</p>
			 <?php
				   echo "</div>";
				   echo "</div>";
			      }
			      
			      
			      
			      
			      
			      $user_offcaggr = get_the_author_meta( '_user_offcaggr', $current_user->ID );
			      //print_r($user_signapp);
			      if($user_offcaggr){
				   echo "<span class='green_check'>Your Employer Application is on file</span>";
				   
			      }
			      else{
				   echo "<div class='d_wrap'>";
				   echo "<div class='dwnld_wrap'>";
				  echo '<span class="not_updated"><a href="'.get_field('download_office_agreement','options').'" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Download</a> the Employer Application, review and sign it, then Upload it here.</span>';
				  ?>
				  <p>				   
					<input name="custom_reg_log_user_offc_aggrmnt" id="custom_reg_log_user_offc_aggrmnt" type="file">
                         <?php	
                         // Check file extension  
                         $file_paths4 = explode("/", get_the_author_meta( '_user_offcaggr', $current_user->ID ));
                         $filename4 = $file_paths4[1];
                         $extension4 = pathinfo($filename4);  
                         $extension4 = $extension4[extension];
                         $uploads4 = wp_upload_dir();
                         $upload_path4 = $uploads4['baseurl'].'/users_doc/';
                         /*
                         if( in_array($extension4, array('PDF', 'pdf'))) {
                              ?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_offcaggr', $current_user->ID ); ?>" target="_blank" title="">View</a><br /><?php
                         }else{
                             echo "N/A";
                         }
			 */
                         ?>			
          	
				</p>
			 <?php
			      echo "</div>";
			      echo "</div>";
			      
			      }
			      
			      
			      
			      
			      
			 }
			 ?>
			 
								
				
				
				
			      <!--============= Provider Credit Application AND Office Agreement END=================-->
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
				<p>
					<label for="custom_reg_log_user_first"><?php _e('First Name <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_first" id="custom_reg_log_user_first" type="text" value="<?php echo esc_attr( $current_user->user_firstname ); ?>" placeholder="First Name" required/>
				</p>
				<p>
					<label for="custom_reg_log_user_last"><?php _e('Last Name <span class="required">*</span>'); ?></label>
					<input name="custom_reg_log_user_last" id="custom_reg_log_user_last" type="text" value="<?php echo esc_attr( $current_user->user_lastname ); ?>" placeholder="Last Name" required/>
				</p>
				<p>
					<label for="custom_reg_log_user_Login"><?php _e('Username <span class="required">*</span>'); ?></label>
					<span class="mar-btm"><?php echo esc_attr( $current_user->user_login ); ?></span>
				</p>
				<p>
					<label for="custom_reg_log_user_email"><?php _e('Email <span class="required">*</span>'); ?></label>
					<span class="mar-btm"><?php echo esc_attr( $current_user->user_email ); ?></span>
				</p>
				<p>
					<label for="password"><?php _e('Password'); ?></label>
					<input name="custom_reg_log_user_pass" id="password" class="required" type="password" value="<?php echo ( isset( $_POST["custom_reg_log_user_pass"] ) ? esc_attr( $_POST["custom_reg_log_user_pass"] ) : '' )?>" placeholder="Password" />
				</p>
				<p>
					<label for="password_again"><?php _e('Confirm Password'); ?></label>
					<input name="custom_reg_log_user_pass_confirm" id="password_again" class="required" type="password" value="<?php echo ( isset( $_POST["custom_reg_log_user_pass_confirm"] ) ? esc_attr( $_POST["custom_reg_log_user_pass_confirm"] ) : '' )?>" placeholder="Confirm Password" />
				</p>
				
				
				
			      <?php
			      $job_candidate_years_within = get_field('job_candidate_years_within','options');
			      $user_experience = esc_attr( get_the_author_meta( 'user_experience', $current_user->ID ) );
			      if($user_experience){
				  if($user_experience/12 >0){
				    $user_experience_years = (int)($user_experience / 12);
				    $user_experience_month = $user_experience % 12;
				  }
			      }
			      ?>
			      <div class="exp_label">
				   <label for="custom_reg_log_user_experience"><?php _e('Experience'); ?></label>
			      </div>
			      <div class="exp_wrap">
				   <select name="custom_reg_log_user_exp_years">
					<option value="">Select Years</option>
					<?php for($i=0; $i<=$job_candidate_years_within; $i++){?>
						<option value="<?php echo $i; ?>" <?php if($user_experience_years == $i){echo 'selected';} ?>><?php echo $i; ?></option>
					
					
					<?php }?>
				   </select>
				   <span class="exp_type">years</span>
				   <select name="custom_reg_log_user_exp_months">
					<option value="">Select Months</option>
					<?php for($j=0; $j<=11; $j++){?>
						   <option value="<?php echo $j; ?>" <?php if($user_experience_month == $j){echo 'selected';} ?>><?php echo $j; ?></option>					
					   <?php }?>
				   </select>
				   <span class="exp_type">months</span>
			      </div>
			
				
				
				
				
				<p>
					<label for="adrs"><?php _e('Address'); ?></label>
					<input name="custom_reg_log_user_adrs" id="adrs" type="text" value="<?php echo esc_attr( get_the_author_meta( 'user_addr', $current_user->ID ) ); ?>" placeholder="Address"/>
				</p>
				<p>
					<label for="city"><?php _e('City'); ?></label>
					<input name="custom_reg_log_user_city" id="city" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'user_city', $current_user->ID ) ); ?>" placeholder="City"/>
				</p>
				<p>
					<label for="state"><?php _e('State'); ?></label>
					<input name="custom_reg_log_user_state" id="state" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'user_state', $current_user->ID ) ); ?>" placeholder="State"/>
				</p>
				<p>
					<label for="zip_code"><?php _e('Zip Code'); ?></label>
					<input name="custom_reg_log_user_zip_code" id="zip_code" class="required" type="text" value="<?php echo esc_attr( get_the_author_meta( 'zip_code', $current_user->ID ) ); ?>" placeholder="Zip Code" />
				</p>	       
	       
	       
	       
	       
	       
	            
	       
	       <?php /***********************FOR SEEKER START*****************/?>
	           
               <?php if( $user_roles == 'job_seeker' ) : ?>
				<p>
					<label for="max_working_distance"><?php _e('Max working distance'); ?></label>
					<input name="custom_reg_log_user_max_working_distance" id="max_working_distance" type="text" value="<?php echo esc_attr( get_the_author_meta( 'max_working_distance', $current_user->ID ) ); ?>" placeholder="Max working distance(Miles)"/>
				</p>
				
				
			      <div class="gap">
				   <label for="job_position"><?php _e('Position Requested'); ?></label>					<div class="radio-wrap">
					<?php					
					//$selected_position = $_POST["custom_reg_log_user_pos_requestd"];
					
					$selected_position = esc_attr( get_the_author_meta( 'position_requested', $current_user->ID ) );
					//print_r($selected_position);
					?>					
					<?php
					$page = get_page_by_path('pricing');
					$pricing_page_id = $page->ID;
					
					if( have_rows('business_matches_positions',$pricing_page_id) ){ 
					// $count=1;
						while ( have_rows('business_matches_positions',$pricing_page_id) ) {
							the_row();
							$position_field_name = get_sub_field('dental_position_field_name');
							
							//if (in_array($position_field_name, $selected_position)) {
							
							if(strcmp($position_field_name,$selected_position) == 0){
							    $selected_pos = ' checked="checked"';
							} else {
							    $selected_pos = ' ';
							}				
							?>
							<span><input name="custom_reg_log_user_pos_requestd" type="radio" value="<?php echo $position_field_name ;?>" <?php echo $selected_pos; ?> /><?php echo $position_field_name ;?></span>
						
					<?php 	}
					
					}?>
				   </div>
			      </div>
				
				
				
				<div class="gap">
					<label for="industry_name"><?php _e('What kind of work are you looking for'); ?></label>
					<div class=radio-wrap>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Any Kind" <?php if( get_the_author_meta( 'industry', $current_user->ID )=='Any Kind' ) echo ' checked'; ?> <?php if(get_the_author_meta( 'industry', $current_user->ID )) echo ' checked="checked"'; ?> />Any Kind</span>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Temporary" <?php if( get_the_author_meta( 'industry', $current_user->ID )=='Temporary' ) echo ' checked'; ?> />Temporary</span>
						<span><input name="custom_reg_log_user_industry" type="radio" value="Permanent" <?php if( get_the_author_meta( 'industry', $current_user->ID )=='Permanent' ) echo ' checked'; ?> />Permanent</span>
					</div>
				</div>
				<div class="gap">
					<label for="available_days"><?php _e('What days are you available?'); ?></label>
					<div class=checkbox-wrap>
                              <?php
                              $available=get_user_meta($current_user->ID, 'available_days');
                              if($available){ $available_on=unserialize($available[0]); }
                              ?>
                              
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Monday" <?php if($available_on){ echo (in_array('Monday', $available_on)) ? ' checked="checked"' : '';} ?> />Monday</span>
                              <span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Tuesday" <?php if($available_on){ echo (in_array('Tuesday', $available_on)) ? ' checked="checked"' : ''; } ?> />Tuesday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Wednesday" <?php if($available_on){ echo (in_array('Wednesday', $available_on)) ? ' checked="checked"' : ''; } ?> />Wednesday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Thursday" <?php if($available_on){ echo (in_array('Thursday', $available_on)) ? ' checked="checked"' : ''; } ?> />Thursday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Friday" <?php if($available_on){ echo (in_array('Friday', $available_on)) ? ' checked="checked"' : ''; } ?> />Friday </span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Saturday" <?php if($available_on){ echo (in_array('Saturday', $available_on)) ? ' checked="checked"' : ''; } ?> />Saturday</span>
						<span><input name="custom_reg_log_user_available_days[]" type="checkbox" value="Sunday" <?php if($available_on){ echo (in_array('Sunday', $available_on)) ? ' checked="checked"' : ''; } ?> />Sunday</span>
					</div>
				</div>
				
				<p>
					<label for="custom_reg_log_user_licenses"><?php _e('Upload your Licenses and Certifications here'); ?></label>
					<input name="custom_reg_log_user_licenses" id="custom_reg_log_user_licenses" type="file">
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
                                 echo "N/A";
                          }
                         ?>
					<br /><small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png, .pdf<br />File size should be less than 1MB </small>
				</p>
				
				<p>
					<label for="custom_reg_log_user_resume"><?php _e('Upload your Resume'); ?></label>
					<input name="custom_reg_log_user_resume" id="custom_reg_log_user_resume" type="file">
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
                              echo 'N/A';
                         }
                         ?>			
					<br /><small style="color:#666666; font-size:0.7em;">Allowed file types are .pdf, .doc, .docx, .txt<br />File size should be less than 1MB </small>
				</p>
			
			 
               <?php endif; ?>
               <?php /***********************FOR SEEKER END*****************/?>
	       
	       

	       
	       
	       
	       <?php /***********************FOR PROVIDER START*****************/?>
               <?php if( $user_roles == 'job_provider' ) : ?>
				<p>
					<label for="company_name"><?php _e('Name Of Company/Dental Practice'); ?></label>
					<input name="custom_reg_log_user_comp_name" id="company_name" type="text" value="<?php echo esc_attr( get_the_author_meta( 'company_name', $current_user->ID ) ); ?>" placeholder="Name Of Company/Dental Practice"/>
				</p>				
				<p>
					<label for="authorized_person"><?php _e('Authorized Contact Person(s)'); ?></label>
					<input name="custom_reg_log_user_auth_per" id="authorized_person" type="text" value="<?php echo esc_attr( get_the_author_meta( 'authorized_contact', $current_user->ID ) ); ?>" placeholder="Authorized Contact Person(s)"/>
				</p>

				<p>
					<label for="off_phone"><?php _e('Office Phone'); ?></label>
					<input name="custom_reg_log_user_off_phone" id="off_phone" class="wpcf7-tel" type="text" value="<?php echo esc_attr( get_the_author_meta( 'office_phone', $current_user->ID ) ); ?>" placeholder="Office Phone" />
				</p>
				<p>
					<label for="fax_num"><?php _e('#Fax'); ?></label>
					<input name="custom_reg_log_user_fax" id="fax_num" class="required" type="text" value="<?php echo esc_attr( get_the_author_meta( 'user_fax', $current_user->ID ) ); ?>" placeholder="#Fax" />
				</p>	
				<p>
					<label for="user_website"><?php _e('Website'); ?></label>
					<input name="custom_reg_log_user_website" id="user_website" class="" type="text" value="<?php echo esc_attr( $current_user->user_url ); ?>" placeholder="Website"/>
				</p>			
				<div class="gap">
					<label for="practice_type"><?php _e('Type Of Practice/Company'); ?></label>
					<div class=radio-wrap>
						<span><input name="custom_reg_log_practice_type" type="radio" value="General" <?php if( get_user_meta($current_user->ID,'industry',true) =='General' ) echo ' checked'; ?> <?php if(empty(get_user_meta($current_user->ID,'industry',true))) echo ' checked="checked"'; ?> />General
						</span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Periodontal" <?php if( get_user_meta($current_user->ID,'industry',true) =='Periodontal' ) echo ' checked'; ?> />Periodontal</span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Pediatric" <?php if( get_user_meta($current_user->ID,'industry',true) =='Pediatric' ) echo ' checked'; ?> />Pediatric </span>					
						<span><input name="custom_reg_log_practice_type" type="radio" value="Orthodontic" <?php if( get_user_meta($current_user->ID,'industry',true) =='Orthodontic' ) echo ' checked'; ?> />Orthodontic </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Endodontic" <?php if( get_user_meta($current_user->ID,'industry',true) =='Endodontic' ) echo ' checked'; ?> />Endodontic </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Dental Lab" <?php if( get_user_meta($current_user->ID,'industry',true) =='Dental Lab' ) echo ' checked'; ?> />Dental Lab </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Government" <?php if( get_user_meta($current_user->ID,'industry',true) =='Government' ) echo ' checked'; ?> />Government </span>
						<span><input name="custom_reg_log_practice_type" type="radio" value="Other" <?php if( get_user_meta($current_user->ID,'industry',true) =='Other' ) echo ' checked'; ?> />Other </span>
					</div>
				</div>	
				<p>Number of Current Staff:</p>			
				<p>
					<label for="dentist"><?php _e('Dentists'); ?></label>
					<input name="custom_reg_log_dentists" id="dentist" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'emp_dentists', $current_user->ID ) ); ?>" placeholder="Dentists"/>
				</p>
				<p>
					<label for="hygienists"><?php _e('Hygienists'); ?></label>
					<input name="custom_reg_log_hygienists" id="hygienists" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'emp_hygienists', $current_user->ID ) ); ?>" placeholder="Hygienists"/>
				</p>
				<p>
					<label for="assistants"><?php _e('Assistants'); ?></label>
					<input name="custom_reg_log_assistants" id="assistants" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'emp_assistants', $current_user->ID ) ); ?>" placeholder="Assistants"/>
				</p>
				<p>
					<label for="front_office"><?php _e('Front Office'); ?></label>
					<input name="custom_reg_log_front_office" id="front_office" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'emp_front_office', $current_user->ID ) ); ?>" placeholder="Front Office"/>
				</p>
				<p>
					<label for="other"><?php _e('Other'); ?></label>
					<input name="custom_reg_log_other" id="other" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'other_stuff', $current_user->ID ) ); ?>" placeholder="Other"/>
				</p>
				<p>
					<label for="comp_soft_used"><?php _e('Computer Software used'); ?></label>
					<input name="custom_reg_log_comp_soft_used" id="comp_soft_used" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'computer_sw', $current_user->ID ) ); ?>" placeholder="Computer Software used"/>
				</p>
				<div class="gap">
					<label for="practice_type"><?php _e('Will you accept a candidate who does not know your software?'); ?></label>
					<div class=radio-wrap>
					     <span><input name="custom_reg_log_accept_candidate" type="radio" value="yes" <?php if( get_the_author_meta( 'exp_with_sw', $current_user->ID ) == 'yes' ) echo ' checked'; ?> />Yes </span>
					     <span><input name="custom_reg_log_accept_candidate" type="radio" value="no" <?php if( get_the_author_meta( 'exp_with_sw', $current_user->ID ) == 'no' ) echo ' checked'; ?> />No </span>
				
					</div>
				</div>
				<p>
					<label class="xray_used" for="xray_used"><?php _e('What type of X-ray system is used?'); ?></label>
					<?php /*?>
					<input name="custom_reg_log_xray_used" type="radio" value="yes" <?php if( isset($_POST["custom_reg_log_xray_used"]) && $_POST["custom_reg_log_xray_used"]=='yes' ) echo ' checked'; ?> />Yes &nbsp;&nbsp;&nbsp;
					<input name="custom_reg_log_xray_used" type="radio" value="no" <?php if( isset($_POST["custom_reg_log_xray_used"]) && $_POST["custom_reg_log_xray_used"]=='no' ) echo ' checked'; ?> />No &nbsp;&nbsp;&nbsp;
					<?php */?>
				<input name="custom_reg_log_xray_type" id="custom_reg_log_xray_type" class="" type="text" value="<?php echo esc_attr( get_the_author_meta( 'x_ray_type', $current_user->ID ) ); ?>" placeholder="What type of X-ray system is used?"/>
				</p>
				<p>
					<label for="add_info"><?php _e('Additional Comments/Information'); ?></label>
					<textarea name="custom_reg_log_add_info" id="custom_reg_log_add_info" class=""><?php echo get_user_meta($current_user->ID,'description',true); ?></textarea>
				</p>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				

               <?php endif; ?>
	       <?php /***********************FOR PROVIDER END*****************/?>
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
               <div class="upload">
				<p>
					<label for="custom_reg_log_user_profile_picture"><?php _e('Upload profile picture here'); ?></label>
					<input name="custom_reg_log_user_profile_picture" id="custom_reg_log_user_profile_picture" type="file">
					<?php //echo get_avatar( $id_or_email, $size, $default, $alt, $args ); ?> 
					<?php echo get_avatar( $current_user->ID, 92 ); ?> 
                         <br/>
					<small style="color:#666666; font-size:0.7em;">Allowed image types are .jpg, .gif, .png.<br />File size should be less than 1MB </small>
				</p>
                    </div>
				<p>
					<input type="hidden" name="custom_reg_log_register_update_nonce" value="<?php echo wp_create_nonce('custom_reg_log-register-update-nonce'); ?>"/>
					<input type="submit" value="<?php _e('Update Now'); ?>"/>
				</p>
                    
			</fieldset>
		</form>
     <?php
     return ob_get_clean();
}
add_shortcode('edit_my_profile', 'edit_my_profile_at_frontend');
//============ End for edit profile at frontend ============//
?>