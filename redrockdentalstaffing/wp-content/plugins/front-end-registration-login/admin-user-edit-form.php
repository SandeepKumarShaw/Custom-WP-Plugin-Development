<?php
//Job Providers Form
//Admin Form For User Profile Edit

//add columns to User panel list page
function add_user_columns($column) {
    $column['assigned_to'] = 'Assigned To';
    $column['zip_code'] = 'Zip Code';    
    return $column;
}
add_filter( 'manage_users_columns', 'add_user_columns' );

//add the data to columns at User panel list page
function add_user_column_data( $val, $column_name, $user_id ) {
    $user = get_userdata($user_id);    
    $u_role = $user->roles[0];

    switch ($column_name) {
	
	case 'assigned_to':
	    if($u_role=='job_seeker'){
		 //echo $post_id;
		$assigned_user_id = get_user_meta( $user_id, 'asgnd_to_job', false );
		//print_r($assigned_user_id);
		
		if($assigned_user_id){
		  $assigned_user_id_array = explode(",",$assigned_user_id[0]);
		}
		else{
		  $assigned_user_id_array = '';
		}
		if($assigned_user_id_array){	    
		    foreach($assigned_user_id_array as $single_assigned_user_id){
		      $j_title = get_the_title($single_assigned_user_id);
		      return $j_title;
		    }
		}   
	    }
        
        break;        
	
        case 'zip_code' :
            return $user->zip_code;
            break;
        default:
    }
    return;
}
add_filter( 'manage_users_custom_column', 'add_user_column_data', 10, 3 );




//add/edit/view additional fields at user profile page
add_action( 'show_user_profile', 'additional_user_profile_fields' );
add_action( 'edit_user_profile', 'additional_user_profile_fields' );

function additional_user_profile_fields( $user ) { ?>
<h3><?php _e("Additional profile information", ""); ?></h3>

<table class="form-table">
	<?php
		$user_role =  $user->roles[0];
		if($user_role == 'job_provider'){
	?>
	<tr>
		<th><label for="company"><?php _e("Company"); ?></label></th>	
		<td>
			<input type="text" name="company" id="company" value="<?php echo esc_attr( get_the_author_meta( 'company_name', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter your company."); ?></span>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<th><label for="address"><?php _e("Address"); ?></label></th>
		<td>
			<input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'user_addr', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter address."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="city"><?php _e("City"); ?></label></th>
		<td>
			<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'user_city', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter city."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="state"><?php _e("State"); ?></label></th>
		<td>
			<input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'user_state', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter state."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="zip"><?php _e("Zip Code"); ?></label></th>
		<td>
			<input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip_code', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter zip code."); ?></span>
		</td>
	</tr>
	<?php /*
	<tr>
		<th><label for="country"><?php _e("Country"); ?></label></th>
		<td>
			<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'user_country', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter country."); ?></span>
		</td>
	</tr>
	*/ ?>
	<?php
		$user_role =  $user->roles[0];
		if($user_role == 'job_seeker'){
	?>
	
	<?php
	$job_candidate_years_within = get_field('job_candidate_years_within','options');
	$user_experience = esc_attr( get_the_author_meta( 'user_experience', $user->ID ) );
	if($user_experience){
	    if($user_experience/12 >0){
		$user_experience_years = (int)($user_experience / 12);
		$user_experience_month = $user_experience % 12;
	    }
	}	    
	
	?>
	<tr>
		<th><label for="working_experience"><?php _e("Experience"); ?></label></th>
		<td>
			<!--<input type="text" name="working_experience" id="working_experience" value="<?php //echo esc_attr( get_the_author_meta( 'user_experience', $user->ID ) ); ?>" class="regular-text" /><br />
			-->
			
			
			
			<select name="custom_reg_log_user_exp_years">
				<option value="">Select Years</option>
				<?php for($i=0; $i<=$job_candidate_years_within; $i++){?>
					<option value="<?php echo $i; ?>" <?php if($user_experience_years == $i){echo 'selected';} ?>><?php echo $i; ?></option>
				
				
				<?php }?>
			</select>
			<span>years</span>
			<select name="custom_reg_log_user_exp_months">
				<option value="">Select Months</option>
				<?php for($j=0; $j<=11; $j++){?>
					<option value="<?php echo $j; ?>" <?php if($user_experience_month == $j){echo 'selected';} ?>><?php echo $j; ?></option>					
                                <?php }?>
			</select>
			<span>months</span><br />		
			<span class="description"><?php _e("Define working experience."); ?></span>
		</td>
	</tr>
	
	
	
	<tr>
		<th><label for="working_distance"><?php _e("Max working distance"); ?></label></th>
		<td>
			<input type="text" name="working_distance" id="working_distance" value="<?php echo esc_attr( get_the_author_meta( 'max_working_distance', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Define working distance."); ?></span>
		</td>
	</tr>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<tr>
	    <th><label for="available"><?php _e("Position Requested"); ?></label></th>
	    <td>
		    <?php
		    $position_requested = get_user_meta($user->ID, 'position_requested');
		    //print_r($position_requested);
		    
		    ?>
		   <input type="text" name="position_requested" id="position_requested" value="<?php echo $position_requested[0]; ?>" class="regular-text" disabled /><br />		    		   
	    </td>
	</tr>
		
		
		
		
		
		
		
		
		
		
	
	<?php } ?>
	<tr>
		<th><label for="industry"><?php _e("Industry"); ?></label></th>
		
		<?php
			//echo '<pre>'; print_r($user); echo '</pre>';			
			//echo $user->roles[0];
			$user_role =  $user->roles[0];
			if($user_role == 'job_seeker'){
		?>
		
		<td>
			<input name="industry" type="radio" value="Any Kind" <?php if( get_the_author_meta( 'industry', $user->ID )=='Any Kind' ) echo ' checked'; ?> class="regular-text" />Any Kind &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Temporary" <?php if( get_the_author_meta( 'industry', $user->ID )=='Temporary' ) echo ' checked'; ?> class="regular-text" />Temporary &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Permanent" <?php if( get_the_author_meta( 'industry', $user->ID )=='Permanent' ) echo ' checked'; ?> class="regular-text" />Permanent &nbsp;&nbsp;&nbsp;	
			
			<br />
			<span class="description"><?php _e("What kind of work are you looking for."); ?></span>
		</td>
		<?php } elseif($user_role == 'job_provider'){?>
		<td>
			<input name="industry" type="radio" value="General" <?php if( get_the_author_meta( 'industry', $user->ID )=='General' ) echo ' checked'; ?> class="regular-text" />General &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Periodontal" <?php if( get_the_author_meta( 'industry', $user->ID )=='Periodontal' ) echo ' checked'; ?> class="regular-text" />Periodontal &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Pediatric" <?php if( get_the_author_meta( 'industry', $user->ID )=='Pediatric' ) echo ' checked'; ?> class="regular-text" />Pediatric &nbsp;&nbsp;&nbsp;						
			<input name="industry" type="radio" value="Orthodontic" <?php if( get_the_author_meta( 'industry', $user->ID )=='Orthodontic' ) echo ' checked'; ?> class="regular-text" />Orthodontic &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Endodontic" <?php if( get_the_author_meta( 'industry', $user->ID )=='Endodontic' ) echo ' checked'; ?> class="regular-text" />Endodontic &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Dental Lab" <?php if( get_the_author_meta( 'industry', $user->ID )=='Dental Lab' ) echo ' checked'; ?> class="regular-text" />Dental Lab &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Government" <?php if( get_the_author_meta( 'industry', $user->ID )=='Government' ) echo ' checked'; ?> class="regular-text" />Government &nbsp;&nbsp;&nbsp;
			<input name="industry" type="radio" value="Other" <?php if( get_the_author_meta( 'industry', $user->ID )=='Other' ) echo ' checked'; ?> class="regular-text" />Other
					
			<br />
			<span class="description"><?php _e("What kind of work are you looking for."); ?></span>
		</td>
		<?php } ?>
	</tr>	
	<?php
		$user_role =  $user->roles[0];
		if($user_role == 'job_seeker'){
	?>
	<tr>
		<th><label for="available"><?php _e("Available on"); ?></label></th>
		<td>
			<?php
			$available=get_user_meta($user->ID, 'available_days');
			if($available){	
			$available_on=unserialize($available[0]);
			}
			?>
			<input name="available[]" type="checkbox" value="Monday" <?php if($available_on){ echo (in_array('Monday', $available_on)) ? ' checked="checked"' : '';} ?> class="regular-text" />Monday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Tuesday" <?php if($available_on){ echo (in_array('Tuesday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Tuesday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Wednesday" <?php if($available_on){ echo (in_array('Wednesday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Wednesday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Thursday" <?php if($available_on){ echo (in_array('Thursday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Thursday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Friday" <?php if($available_on){ echo (in_array('Friday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Friday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Saturday" <?php if($available_on){ echo (in_array('Saturday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Saturday &nbsp;&nbsp;&nbsp;
			<input name="available[]" type="checkbox" value="Sunday" <?php if($available_on){ echo (in_array('Sunday', $available_on)) ? ' checked="checked"' : ''; } ?> class="regular-text" />Sunday &nbsp;&nbsp;&nbsp;
			<br />
			<span class="description"><?php _e("What days are you available?"); ?></span>		   
		</td>
	</tr>	
	<tr>
		<th><label for="licenses"><?php _e("Upload Licenses and Certifications"); ?></label></th>
		<td>
		    
		    <?php	
			// Check file extension  
			$file_paths = explode("/", get_the_author_meta( '_user_licenses', $user->ID ));
			$filename = $file_paths[1];
			$extension = pathinfo($filename);  
			$extension = $extension[extension];
			$uploads = wp_upload_dir();
			$upload_path = $uploads['baseurl'].'/users_doc/';
			
			if ( in_array($extension, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
				?><img src="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $user->ID ); ?>" style="width:150px;"><br /><?php
			} elseif(in_array($extension, array( 'PDF', 'pdf'))) {
				?><a href="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}else{
			       echo "NA";
			}
		    ?>
		    
		    
		</td>
	</tr>	
	<tr>
		<th><label for="resume"><?php _e("Upload Resume"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths2 = explode("/", get_the_author_meta( '_user_resume', $user->ID ));
			$filename2 = $file_paths2[1];
			$extension2 = pathinfo($filename2);  
			$extension2 = $extension2[extension];
			$uploads2 = wp_upload_dir();
			$upload_path2 = $uploads2['baseurl'].'/users_doc/';
			
			if(in_array($extension2, array( 'PDF', 'pdf', 'DOC', 'doc', 'DOCX', 'docx', 'TXT', 'txt'))) {
				?><a href="<?php echo $upload_path2.get_the_author_meta( '_user_resume', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}else{
				echo 'NA';
			}
			?>			
		</td>
	</tr>
	<tr>
		<th><label for="signapp"><?php _e("Signed Application"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths4 = explode("/", get_the_author_meta( '_user_signapp', $user->ID ));
			$filename4 = $file_paths4[1];
			$extension4 = pathinfo($filename4);  
			$extension4 = $extension4[extension];
			$uploads4 = wp_upload_dir();
			$upload_path4 = $uploads4['baseurl'].'/users_doc/';
			
			if( in_array($extension4, array('PDF', 'pdf'))) {
				?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $user->ID ); ?>" target="_blank" title="">Yes</a><br /><?php
			}else{
			    echo "No";
			}
			?>			
		</td>
	</tr>
	
	
	<tr>
	    <?php $candi_star_rating = esc_attr( get_the_author_meta( 'candi_star_rating', $user->ID ) ); ?>
		<th><label for="signapp"><?php _e("Rating"); ?></label></th>
		<td>
		    <select class="candi_star" name="candi_star">
			<option value="1" <?php if($candi_star_rating == 1){ echo "selected"; } ?>>1 Star</option>
			<option value="2" <?php if($candi_star_rating == 2){ echo "selected"; } ?>>2 Star</option>
			<option value="3" <?php if($candi_star_rating == 3){ echo "selected"; } ?>>3 Star</option>
			<option value="4" <?php if($candi_star_rating == 4){ echo "selected"; } ?>>4 Star</option>
			<option value="4" <?php if($candi_star_rating == 5){ echo "selected"; } ?>>5 Star</option>
		    </select>			
		</td>
	</tr>
	
	
	<tr>
		<th><label for="signapp"><?php _e("Assigned To"); ?></label></th>
		<td>
			<?php	
			$asgnd_to_job = get_user_meta($user->ID,'asgnd_to_job',true);
			//print_r($asgnd_to_job);
			$asgnd_to_job_array = explode(',',$asgnd_to_job);
			//print_r($asgnd_to_job_array);
			if($asgnd_to_job_array[0]){
			?>
			<ul class="back_asgn_to">
			<?php
			foreach($asgnd_to_job_array as $single_asgnd){
			    $asgnd_post = get_post($single_asgnd);
			    $asgnd_post_title = $asgnd_post->post_title;
			    $assgnd_end_date =  date('F j, Y', strtotime( get_post_meta($asgnd_post->ID, "jobs_manager_enddate", true) ));
			?>
			    <li><span class="a_post_title"><?php echo $asgnd_post_title; ?></span> Ending on: <?php echo $assgnd_end_date; ?></li>
			<?php
			}
			?>
			</ul>
			<?php
			}
			else{
			    echo "No";
			}
			
			?>			
		</td>
	</tr>
	<?php } elseif($user_role == 'job_provider') {?>
	
	<!--==============Start for job providers=================-->
	<tr>
		<th><label for="authorized_contact"><?php _e("Authorized Contact Person"); ?></label></th>
		<td>
			<input type="text" name="authorized_contact" id="authorized_contact" value="<?php echo esc_attr( get_the_author_meta( 'authorized_contact', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter contact number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="office_phone"><?php _e("Office Phone"); ?></label></th>
		<td>
			<input type="text" name="office_phone" id="office_phone" value="<?php echo esc_attr( get_the_author_meta( 'office_phone', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter phone number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="fax"><?php _e("Fax"); ?></label></th>
		<td>
			<input type="text" name="fax" id="fax" value="<?php echo esc_attr( get_the_author_meta( 'user_fax', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter fax."); ?></span>
		</td>
	</tr>
	<tr>
		<th colspan=2><h3 class="crnt_staf"><?php _e("Number of Current Staff", ""); ?></h3></th>
	</tr>
	<tr>
		<th><label for="dentists"><?php _e("Dentists"); ?></label></th>
		<td>
			<input type="text" name="dentists" id="dentists" value="<?php echo esc_attr( get_the_author_meta( 'emp_dentists', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter dentists number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="hygienists"><?php _e("Hygienists"); ?></label></th>
		<td>
			<input type="text" name="hygienists" id="hygienists" value="<?php echo esc_attr( get_the_author_meta( 'emp_hygienists', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter hygienists number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="assistants"><?php _e("Assistants"); ?></label></th>
		<td>
			<input type="text" name="assistants" id="assistants" value="<?php echo esc_attr( get_the_author_meta( 'emp_assistants', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter assistants number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="front_office"><?php _e("Front Office"); ?></label></th>
		<td>
			<input type="text" name="front_office" id="front_office" value="<?php echo esc_attr( get_the_author_meta( 'emp_front_office', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter front officer number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="other_stuff"><?php _e("Other"); ?></label></th>
		<td>
			<input type="text" name="other_stuff" id="other_stuff" value="<?php echo esc_attr( get_the_author_meta( 'other_stuff', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter other stuff number."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="computer_sw"><?php _e("Computer Software used"); ?></label></th>
		<td>
			<input type="text" name="computer_sw" id="computer_sw" value="<?php echo esc_attr( get_the_author_meta( 'computer_sw', $user->ID ) ); ?>" class="regular-text" /><br />
			<span class="description"><?php _e("Please enter computer software."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="exp_with_sw"><?php _e("Will you accept a candidate who does not know your software?"); ?></label></th>
		<td>
			<input type="radio" name="exp_with_sw" value="yes" <?php if( get_the_author_meta( 'exp_with_sw', $user->ID ) == 'yes' ) echo ' checked'; ?> class="regular-text" />Yes &nbsp;&nbsp;&nbsp;
			<input type="radio" name="exp_with_sw" value="no" <?php if( get_the_author_meta( 'exp_with_sw', $user->ID ) == 'no' ) echo ' checked'; ?>  class="regular-text" />No<br/>
			<span class="description"><?php _e("Please select yes or no."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="x_ray_used"><?php _e("What type of X-ray system is used ?"); ?></label></th>
		<td class="xray_used_type">
		    <?php /*?>
			<div class="xray_used">
			    <input type="radio" name="x_ray_used" value="yes" <?php if( get_the_author_meta( 'x_ray_used', $user->ID ) == 'yes' ) echo ' checked'; ?> class="regular-text" />Yes &nbsp;&nbsp;&nbsp;
			    <input type="radio" name="x_ray_used" value="no" <?php if( get_the_author_meta( 'x_ray_used', $user->ID ) == 'no' ) echo ' checked'; ?>  class="regular-text" />No<br/>
			    <span class="description"><?php _e("Please select yes or no."); ?></span>
			</div>	    	
			
			<div class="xray_type">
			    <input type="text" name="x_ray_type" id="x_ray_type" value="<?php echo esc_attr( get_the_author_meta( 'x_ray_type', $user->ID ) ); ?>" class="regular-text" placeholder="What type of X-ray system is used?" <?php if(get_the_author_meta( 'x_ray_used', $user->ID ) == 'yes'){ ?>style="display: block;"<?php }else{ ?> style="display: none;"<?php }?>/>
			</div>
		    <?php */ ?>
			
			
		    <div class="xray_type">
			<input type="text" name="x_ray_type" id="x_ray_type" value="<?php echo esc_attr( get_the_author_meta( 'x_ray_type', $user->ID ) ); ?>" class="regular-text" placeholder="What type of X-ray system is used?" />
		    </div>
		</td>
		
		<td class="">
		    <?php //echo get_the_author_meta( 'x_ray_used', $user->ID ); ?>
		    <br />
		</td>
		
	</tr>	
	
	<tr>
		<th><label for="creditapp"><?php _e("Credit Application"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths4 = explode("/", get_the_author_meta( '_user_creditapp', $user->ID ));
			//print_r($file_paths4);
			$filename4 = $file_paths4[1];
			$extension4 = pathinfo($filename4);  
			$extension4 = $extension4[extension];
			$uploads4 = wp_upload_dir();
			$upload_path4 = $uploads4['baseurl'].'/users_doc/';
			
			if( in_array($extension4, array('PDF', 'pdf'))) {
				?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_creditapp', $user->ID ); ?>" target="_blank" title="">Yes</a><br /><?php
			}else{
			    echo "No";
			}
			?>			
		</td>
	</tr>
	
	<tr>
		<th><label for="offcaggr"><?php _e("Office Agreement"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths4 = explode("/", get_the_author_meta( '_user_offcaggr', $user->ID ));
			$filename4 = $file_paths4[1];
			$extension4 = pathinfo($filename4);  
			$extension4 = $extension4[extension];
			$uploads4 = wp_upload_dir();
			$upload_path4 = $uploads4['baseurl'].'/users_doc/';
			
			if( in_array($extension4, array('PDF', 'pdf'))) {
				?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_offcaggr', $user->ID ); ?>" target="_blank" title="">Yes</a><br /><?php
			}else{
			    echo "No";
			}
			?>			
		</td>
	</tr>
	<?php } ?>
	<!--==============Start for job providers=================-->
    
	
	<?php /*
	<tr>
		<th><label for="licenses"><?php _e("Upload Licenses and Certifications"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths = explode("/", get_the_author_meta( '_user_licenses', $user->ID ));
			$filename = $file_paths[1];
			$extension = pathinfo($filename);  
			$extension = $extension[extension];
			$uploads = wp_upload_dir();
			$upload_path = $uploads['baseurl'].'/users_doc/';
			
			if ( in_array($extension, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
				?><img src="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $user->ID ); ?>" style="width:150px;"><br /><?php
			} else {
				?><a href="<?php echo $upload_path.get_the_author_meta( '_user_licenses', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}
			?>
			<input name="licenses" id="licenses" type="file"><br />
			<span class="description"><?php _e("Upload your Licenses and Certifications here (JPG, PNG or PDF, at least 900px across)."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="resume"><?php _e("Upload Resume"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths2 = explode("/", get_the_author_meta( '_user_resume', $user->ID ));
			$filename2 = $file_paths2[1];
			$extension2 = pathinfo($filename2);  
			$extension2 = $extension2[extension];
			$uploads2 = wp_upload_dir();
			$upload_path2 = $uploads2['baseurl'].'/users_doc/';
			
			if ( in_array($extension2, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
				?><img src="<?php echo $upload_path2.get_the_author_meta( '_user_resume', $user->ID ); ?>" style="width:150px;"><br /><?php
			} else {
				?><a href="<?php echo $upload_path2.get_the_author_meta( '_user_resume', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}
			?>
			<input name="resume" id="resume" type="file"><br />
			<span class="description"><?php _e("Upload your Resume (TXT, DOC, DOCX or PDF)."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="uavatar"><?php _e("User Photo"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths3 = explode("/", get_the_author_meta( '_user_avatar', $user->ID ));
			$filename3 = $file_paths3[1];
			$extension3 = pathinfo($filename3);  
			$extension3 = $extension3[extension];
			$uploads3 = wp_upload_dir();
			$upload_path3 = $uploads3['baseurl'].'/users_doc/';
			
			if ( in_array($extension3, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
				?><img src="<?php echo $upload_path3.get_the_author_meta( '_user_avatar', $user->ID ); ?>" style="width:150px;"><br /><?php
			} else {
				?><a href="<?php echo $upload_path3.get_the_author_meta( '_user_avatar', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}
			?>
			<input name="uavatar" id="uavatar" type="file"><br />
			<span class="description"><?php _e("Upload a picture of yourself that we can use on the website (JPG, PNG or PDF)."); ?></span>
		</td>
	</tr>
	<tr>
		<th><label for="signapp"><?php _e("Signed Application"); ?></label></th>
		<td>
			<?php	
			// Check file extension  
			$file_paths4 = explode("/", get_the_author_meta( '_user_signapp', $user->ID ));
			$filename4 = $file_paths4[1];
			$extension4 = pathinfo($filename4);  
			$extension4 = $extension4[extension];
			$uploads4 = wp_upload_dir();
			$upload_path4 = $uploads4['baseurl'].'/users_doc/';
			
			if ( in_array($extension4, array( 'JPG', 'jpg', 'JPEG', 'jpeg', 'PNG', 'png', 'GIF', 'gif' ) ) ) {
				?><img src="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $user->ID ); ?>" style="width:150px;"><br /><?php
			} else {
				?><a href="<?php echo $upload_path4.get_the_author_meta( '_user_signapp', $user->ID ); ?>" target="_blank" title="">View</a><br /><?php
			}
			?>
			<input name="signapp" id="signapp" type="file"><br />
			<span class="description"><?php _e("Upload the signed application (JPG, PNG or PDF)."); ?></span>
		</td>
	</tr>
	*/ ?>
</table>
<?php
}

//add/edit/view additional fields value in DB of user profile page
add_action( 'personal_options_update', 'save_additional_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_additional_user_profile_fields' );

function save_additional_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	//print_r($_POST); die("HI");
	
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
	
	update_user_meta( $user_id, 'company_name', 		$_POST['company'] );
	update_user_meta( $user_id, 'zip_code', 			$_POST['zip'] );
	update_user_meta( $user_id, 'industry', 			$_POST['industry'] );
	update_user_meta( $user_id, 'user_addr', 			$_POST['address'] );
	update_user_meta( $user_id, 'user_city', 			$_POST['city'] );
	update_user_meta( $user_id, 'user_state', 			$_POST['state'] );
	update_user_meta( $user_id, 'user_country', 		$_POST['country'] );	
	update_user_meta( $user_id, 'user_experience', $user_experience );	
	update_user_meta( $user_id, 'max_working_distance', $_POST['working_distance'] );
	
	update_user_meta( $user_id, 'position_requested', $_POST['position_requested'] );
	update_user_meta( $user_id, 'available_days', 		serialize( $_POST['available'] ) );
	update_user_meta( $user_id, 'candi_star_rating', $_POST['candi_star'] );	
	

	// used for job providers
	update_user_meta( $user_id, 'authorized_contact', 	$_POST['authorized_contact'] );
	update_user_meta( $user_id, 'office_phone', 		$_POST['office_phone'] );
	update_user_meta( $user_id, 'user_fax', 			$_POST['fax'] );
	update_user_meta( $user_id, 'emp_dentists', 		$_POST['dentists'] );
	update_user_meta( $user_id, 'emp_hygienists', 		$_POST['hygienists'] );
	update_user_meta( $user_id, 'emp_assistants', 		$_POST['assistants'] );
	update_user_meta( $user_id, 'emp_front_office', 	$_POST['front_office'] );
	update_user_meta( $user_id, 'other_stuff', 			$_POST['other_stuff'] );
	update_user_meta( $user_id, 'computer_sw', 			$_POST['computer_sw'] );
	update_user_meta( $user_id, 'exp_with_sw', 			$_POST['exp_with_sw'] );
	update_user_meta( $user_id, 'x_ray_used', 			$_POST['x_ray_used'] );	
	update_user_meta( $user_id, 'x_ray_type', 			$_POST['x_ray_type'] );

	

	/*
	//start for avatar/user profile image
	if( $_FILES['uavatar']['name'] != '' ) {
		// Allowed mimes    
		$allowed_ext = "JPG, jpg, JPEG, jpeg, GIF, gif, PNG, png";  
		// Default is 50kb 
		$max_size = (50*1024);  
		// height in pixels, default is 175px 
		$max_height = 320;  
		// width in pixels, default is 450px 
		$max_width = 384;
		
		// Check mime types are allowed  
		$extension = pathinfo($_FILES['uavatar']['name']);  
		$extension = $extension[extension];  
		$allowed_paths = explode(", ", $allowed_ext);
		if ( !in_array($extension, $allowed_paths) ) {
			$avatar_upload_extn == 1;
		}

		// Check File Size  
		if($_FILES['uavatar']['size'] > $max_size) {  
			$avatar_upload_size == 1;
		}  
		
		// Check Height & Width  
		if ($max_width && $max_height) {  
			list($width, $height, $type, $w) = getimagesize($_FILES['uavatar']['tmp_name']);  
			if($width > $max_width || $height > $max_height) {  
				$avatar_upload_wxh == 1;
			}  
		}
		
		if( $avatar_upload_extn == 1 && $avatar_upload_size == 1 && $avatar_upload_wxh == 1 ) {
			// Directory for uploaded images
			$uploaddir = ABSPATH . 'wp-content/uploads/users_doc/avatars';  
			if (!file_exists($uploaddir)) {
				mkdir($uploaddir, 0777, true);
			}
			$image_name=$new_user_id.'.'.$extension;
			// Rename file and move to folder
			$newname = $uploaddir."/user_avatar_".$image_name;  
			$files = $_FILES['uavatar'];
			if( move_uploaded_file($files['tmp_name'], $newname) ) {
				//update_usermeta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
				update_usermeta($new_user_id,'_user_avatar','avatars/user_avatar_'.$image_name);
			}
		}
	}
	//end for avatar/user profile image
	
	
	//start for licenses/certifications image
	if( $_FILES['licenses']['name'] != '' ) {
		// Allowed mimes    
		$allowed_ext2 = "JPG, jpg, JPEG, jpeg, GIF, gif, PNG, png, PDF, pdf";  
		// Default is 50kb 
		$max_size2 = (5000*1024);  
		
		// Check mime types are allowed  
		$extension2 = pathinfo($_FILES['licenses']['name']);  
		$extension2 = $extension2[extension];  
		$allowed_paths2 = explode(", ", $allowed_ext2);
		if ( !in_array($extension2, $allowed_paths2) ) {
			$licenses_upload_extn == 1;
		}

		// Check File Size  
		if($_FILES['licenses']['size'] > $max_size2) {  
			$licenses_upload_size == 1;
		}
		
		if( $licenses_upload_extn == 1 && $licenses_upload_size == 1 ) {
			// Directory for licenses images 
			$uploaddir2 = ABSPATH . 'wp-content/uploads/users_doc/licenses';  
			if (!file_exists($uploaddir2)) {
				mkdir($uploaddir2, 0777, true);
			}
			$image_name2=$new_user_id.'.'.$extension2;
			// Rename file and move to folder
			$newname2 = $uploaddir2."/user_licenses_".$image_name2;  
			$files2 = $_FILES['licenses'];
			if( move_uploaded_file($files2['tmp_name'], $newname2) ) {
				update_usermeta($new_user_id,'_user_licenses','licenses/user_licenses_'.$image_name2);
			}
		}
	}
	//end for licenses/certifications image
	
	
	//start for resume upload
	if( $_FILES['resume']['name'] != '' ) {
		// Allowed mimes    
		$allowed_ext3 = "TXT, txt, DOC, doc, DOCX, docx, PDF, pdf";  
		// Default is 50kb 
		$max_size3 = (5000*1024);  

		// Check mime types are allowed  
		$extension3 = pathinfo($_FILES['resume']['name']);  
		$extension3 = $extension3[extension];  
		$allowed_paths3 = explode(", ", $allowed_ext3);
		if ( !in_array($extension3, $allowed_paths3) ) {
			$resume_upload_extn == 1;
		}

		// Check File Size  
		if($_FILES['resume']['size'] > $max_size3) {  
			$resume_upload_size == 1;
		}
		
		if( $resume_upload_extn == 1 && $resume_upload_size == 1 ) {
			// Directory for resume doc 
			$uploaddir3 = ABSPATH . 'wp-content/uploads/users_doc/resume';  
			if (!file_exists($uploaddir3)) {
				mkdir($uploaddir3, 0777, true);
			}
			$image_name3=$new_user_id.'.'.$extension3;
			// Rename file and move to folder
			$newname3 = $uploaddir3."/user_resume_".$image_name3;  
			$files3 = $_FILES['resume'];
			if( move_uploaded_file($files3['tmp_name'], $newname3) ) {
				update_usermeta($new_user_id,'_user_resume','resume/user_resume_'.$image_name3);
			}
		}
	}
	//end for resume upload
	
	
	//start for for signed application
	if( $_FILES['signapp']['name'] != '' ) {
		// Allowed mimes    
		$allowed_ext4 = "JPG, jpg, JPEG, jpeg, GIF, gif, PNG, png, PDF, pdf";  
		// Default is 50kb 
		$max_size4 = (5000*1024);  
		// height in pixels, default is 175px 
		$max_height4 = 2480;  
		// width in pixels, default is 450px 
		$max_width4 = 3508;
		
		// Check mime types are allowed  
		$extension4 = pathinfo($_FILES['signapp']['name']);  
		$extension4 = $extension4[extension];  
		$allowed_paths4 = explode(", ", $allowed_ext4);
		if ( !in_array($extension4, $allowed_paths4) ) {
			$signapp_upload_extn == 1;
		}

		// Check File Size  
		if($_FILES['signapp']['size'] > $max_size4) {  
			$signapp_upload_size == 1;
		}  
		
		// Check Height & Width  
		if ($max_width4 && $max_height4) {  
			list($width4, $height4, $type4, $w4) = getimagesize($_FILES['signapp']['tmp_name']);  
			if($width4 > $max_width4 || $height4 > $max_height4) {  
				$signapp_upload_wxh == 1;
			}  
		}
		
		if( $signapp_upload_extn == 1 && $signapp_upload_size == 1 && $signapp_upload_wxh == 1 ) {
			// Directory for signed application images/doc
			$uploaddir4 = ABSPATH . 'wp-content/uploads/users_doc/signapp';  
			if (!file_exists($uploaddir4)) {
				mkdir($uploaddir4, 0777, true);
			}
			$image_name4=$new_user_id.'.'.$extension4;
			// Rename file and move to folder
			$newname4 = $uploaddir4."/user_signapp_".$image_name4;  
			$files4 = $_FILES['signapp'];
			if( move_uploaded_file($files4['tmp_name'], $newname4) ) {
				update_usermeta($new_user_id,'_user_signapp','signapp/user_signapp_'.$image_name4);
			}
		}
	}
	//end for signed application
	*/
	
	
	// Start for job providers
	wp_update_user( array( 'ID' => $user_id, 'user_url' => $_POST['url'] ) );
	
	update_user_meta( $user_id, 'description', $_POST['description'] );
	
}


// to include file for user access control page
include( plugin_dir_path( __FILE__ ) . 'user-access.php');
?>