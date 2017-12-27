<?php



// used for tracking error messages
function job_log_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function job_post_error_messages() {
	if($codes = job_log_errors()->get_error_codes()) {
		echo '<div class="job_log_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = job_log_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}




/****** Job Post Form Start******/

//Frontend Job Manager Page
include( plugin_dir_path( __FILE__ ) . 'job-post-form.php');


add_shortcode('job_post_form', 'custom_job_post_form');
function custom_job_post_form(){
    $post_id = '';
    /*********logs a member in after submitting a form start***********/
    if(isset($_POST['submit_job_post']) && wp_verify_nonce($_POST['custom_job_post_nonce'], 'custom_job_post_nonce')) {
                        
        //////////////ERROR CHECKING START////////////////
        
        if(!isset($_POST['custom_job_post_title']) || $_POST['custom_job_post_title'] == '') {
            // if no job title was entered
	    job_log_errors()->add('empty_post_title', __('Please enter a Job Title'));
        }
        
        if(!isset($_POST['custom_job_post_descrip']) || $_POST['custom_job_post_descrip'] == '') {
            // if no job description was entered
	    job_log_errors()->add('empty_post_descrip', __('Please enter a Job Description'));
        }
        
        if(!isset($_POST['custom_job_start_date']) || $_POST['custom_job_start_date'] == '') {
            // if no job start date was entered
	    job_log_errors()->add('empty_post_start_date', __('Please enter a Job Start Date'));
        }
        /*
        if(!isset($_POST['custom_job_end_date']) || $_POST['custom_job_end_date'] == '') {
            // if no job end date was entered
	    job_log_errors()->add('empty_post_end_date', __('Please enter a Job End Date'));
        }
        */
        
        if(!isset($_POST['custom_job_post_loc']) || $_POST['custom_job_post_loc'] == '') {
            // if no job location was entered
	    job_log_errors()->add('empty_post_location', __('Please enter a Job Location'));
        }
        
	if(isset($_POST["custom_job_post_salary"]) ){

	    $salary = $_POST["custom_job_post_salary"];
	    if (!empty($salary)){
          if(!is_numeric ($salary)){
            job_log_errors()->add('salary_negative', __('Please enter a Numeric Salary'));
          }elseif($salary < 0){
                job_log_errors()->add('salary_negative', __('Please enter a Valid Salary'));
            }
        }

	}
	
        //if(!isset($_POST['custom_job_Year_expr']) || $_POST['custom_job_Year_expr'] == '') {
	if(!isset($_POST['custom_reg_log_user_exp_years']) || !isset($_POST['custom_reg_log_user_exp_months'])) {
            // if no job location was entered
	    job_log_errors()->add('empty_year_exp', __('Please enter Year Of Experience'));
        }

        //////////////ERROR CHECKING End////////////////
        
         $errors = job_log_errors()->get_error_message();
	 
	 if(empty($errors)) {
		    if(isset($_POST["custom_job_post_title"]) ){
			$job_post_title = $_POST["custom_job_post_title"]; // Job Title		
		    }
		    
		    if(isset($_POST["custom_job_post_descrip"]) ){
			$job_post_descrip = $_POST["custom_job_post_descrip"]; // Job Description		
		    }
		    
		    if(isset($_POST["custom_job_post_require"]) ){
			$job_post_require = $_POST["custom_job_post_require"]; // Job Requirements		
		    }
		    /*
		    if(isset($_POST["custom_job_post_comp_name"]) ){
			$job_post_comp_name = $_POST["custom_job_post_comp_name"]; // Job Company Name		
		    }
		    */
		    if(isset($_POST["custom_job_post_contact"]) ){
			$job_post_contact = $_POST["custom_job_post_contact"]; // Job Post Contact
		    }
		    
		    if(isset($_POST["custom_job_start_date"]) ){
			/*   $timestamp = strtotime($_POST["custom_job_start_date"]);
			$timestamp_date = date('Y-m-d', $timestamp);
			$job_start_date = $timestamp_date; // Job Start Date
			*/   
			
			
			
			$getstart_date = explode('-', $_POST["custom_job_start_date"]);
			$getstart_date_d = $getstart_date['1'];
			$getstart_date_m = $getstart_date['0'];
			$getstart_date_y = $getstart_date['2'];
			$job_start_date = $getstart_date_y.'-'.$getstart_date_m.'-'.$getstart_date_d;// Job Start Date
			
		    
		    
		    }
		    if(isset($_POST["custom_job_end_date"]) ){
			/*   $timestamp_end = strtotime($_POST["custom_job_end_date"]);
			$timestamp_date_end = date('Y-m-d', $timestamp_end);
			$job_end_date = $timestamp_date_end; // Job End Date
			*/  
			
			$getend_date = explode('-', $_POST["custom_job_end_date"]);
			$getend_date_d = $getend_date['1'];
			$getend_date_m = $getend_date['0'];
			$getend_date_y = $getend_date['2'];
			$job_end_date = $getend_date_y.'-'.$getend_date_m.'-'.$getend_date_d;
		    
		    }
		    
		    if(isset($_POST["custom_job_category"]) ){
			$job_category = $_POST["custom_job_category"]; // Job Category(Fulltime/Halftime)		
		    }
		    
		    
		    if(isset($_POST["custom_job_type"]) ){
			$job_type = $_POST["custom_job_type"]; // Job Category(Fulltime/Halftime)		
		    }
		    
		    
		    /*if(isset($_POST["custom_job_post_designatn"]) ){
			$job_post_designatn = $_POST["custom_job_post_designatn"]; // Job Post Designation		
		    }
		    */
		    
		    if(isset($_POST["custom_job_post_salary"]) ){
			$job_post_salary = $_POST["custom_job_post_salary"]; // Job Post Salary		
		    }
		    
		    /*
		    if(isset($_POST["custom_job_post_department"]) ){
			$job_post_department = $_POST["custom_job_post_department"]; // Job Post Department		
		    }
		    */
		    if(isset($_POST["custom_job_post_loc"]) ){
			$job_post_loc = $_POST["custom_job_post_loc"]; // Job Post Location		
		    }
		    /*
		    if(isset($_POST["custom_job_Year_expr"]) ){
			$job_Year_expr = $_POST["custom_job_Year_expr"]; // Job Post Required Experience		
		    }*/
		    
		    
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
			$job_Year_expr = $user_exp_in_month;
		}else{
			$job_Year_expr = $user_experience_months;
		}
		
		
		
		    
		    /*if(isset($_POST["custom_job_vacancy"]) ){
			$job_vacancy = $_POST["custom_job_vacancy"]; // Job Post vacancy		
		    } 
		    */
		    
		    /******************Insert job as a Post Named 'cptjobsmanager' start******************/
		    //print_r($_REQUEST);
		    $user_id = get_current_user_id();
		    $new_job_entry = array();
		    $new_job_entry['ID'] = $_REQUEST['post_id'];
		   
		  
		    $new_job_entry['post_title'] = $job_post_title;
		    $new_job_entry['post_content'] = $job_post_descrip;
		    $new_job_entry['post_status'] = 'draft';
		    $new_job_entry['post_type'] = 'cptjobsmanager';
		    $new_job_entry['post_author'] = $user_id;
		    $new__job_post = wp_update_post($new_job_entry);
		    if($new__job_post){
		    
			///Insert Other records as Post Meta Start////////                    
			//update_post_meta($new__job_post, "jobs_manager_company_name", $job_post_comp_name);                    
			update_post_meta($new__job_post, "jobs_manager_contact", $job_post_contact);                    
			update_post_meta($new__job_post, "jobs_manager_startdate", $job_start_date);
			update_post_meta($new__job_post, "jobs_manager_enddate", $job_end_date);
			update_post_meta($new__job_post, "jobs_manager_jobtype", $job_type);
			
			
			///// Job Category Start///////
			$terms =array();
			foreach($job_category as $single_cat){
			    $terms_details = get_term_by('slug', $single_cat, 'cptjobsmanager_category');
			    $terms[] =  $terms_details->term_id;
			}                    
			wp_set_post_terms( $new__job_post, $terms, 'cptjobsmanager_category');
			///// Job Category End///////
			
			//update_post_meta($new__job_post, "jobs_manager_designation", $job_post_designatn);
			update_post_meta($new__job_post, "jobs_manager_requirements", $job_post_require);
			update_post_meta($new__job_post, "jobs_manager_salary", $job_post_salary);
			update_post_meta($new__job_post, "jobs_manager_location", $job_post_loc); 
			update_post_meta($new__job_post, "jobs_manager_experience", $job_Year_expr);                    
			//update_post_meta($new__job_post, "jobs_manager_vacancy", $job_vacancy);                  
			
			
			///Insert Other records as Post Meta End////////
		    }
		    
		    /******************Insert job as a Post Named 'cptjobsmanager' End******************/  
	   // echo $new__job_post;
	   
	    
	    if($new__job_post){
		$post_id = $new__job_post;
	    }
	    else{
		$post_id = '';
	    }
	    //echo $post_id;
	    //die("HI");
	}

	
    
 
    }
    /*********logs a member in after submitting a form end***********/

    if(!is_user_logged_in())
    {
        echo "<div class='job-listing-hld'>Please login first to post a job.</div>";
		echo '<div class="login_page"><div class="user-login-frm staff-user-list">'.do_shortcode('[login_form]').'</div></div>';
        
    }
    else
    { 
        global $current_user;
        $user_role = $current_user->roles[0];
        if($user_role == 'job_provider' || $user_role == 'administrator'){
            $output_job = custom_job_post_form_field($post_id);
        }
        else{
             echo "<div class='job-listing-hld'>You are not authorized to see the form</div>";
        }
        
        return $output_job;
    }
}
/****** Job Post Form End******/





/**************************Add Shortcode Start To display Job ( Job Listing )***********************/

//[cpt_jobsmanager perpage="10" title="" terms=""]
function custom_post_jobsmanager_shortcode($atts) {
    global $current_user;
    $user_type = $current_user->roles[0];
    if($user_type == 'job_provider'){
        $author_type = $current_user->ID;
    }
    else{        
        $author_type = '';
    }
  ob_start();

  if (!function_exists("pagination")) {
    include_once( plugin_dir_path( __FILE__ ) . 'numeric-pagination.php' );
  }

  $atts = shortcode_atts( array( 'perpage' => '10', 'title' => '', 'terms' => '' ), $atts );
  //echo 'output: ' . $atts['perpage'] . ' ' . $atts['title'] . ' ' . $atts['terms'];
  ?>
  <section class="item-lists">
    <?php if( !empty($atts['title']) ) { ?>
    <h2 class="sec-title"><?php echo $atts['title']; ?></h2>
    <?php } ?>
    <div class="container">
	
      <?php
      global $wpdb;
	if(isset($_POST['seeker_search_btn']) && !empty($_POST['seeker_search_btn'])) {
	    //print_r($_REQUEST);
	    /***********For Job Title Search START*********/
	    $seeker_job_title_search_field = $_REQUEST['seeker_search_job_title']?$_REQUEST['seeker_search_job_title']:'';
	    /***********For Job Title Search END*********/
	    
	    
	    
	    /***********For Job Salery wise Search START*********/
	    if($_REQUEST['seeker_search_salary']){
		    $seeker_job_salary_search_field[] = array(
				    'key' => 'jobs_manager_salary',
				    'value' => $_REQUEST['seeker_search_salary'],
				    'type' => 'numeric',
				    'compare' => '>='
			    );
	    }
	    else{
		    $seeker_job_salary_search_field = array();
	    }
	    /***********For Job Salery wise Search End*********/
	    
	    
	    
	    /***********For Job Category wise Search START*********/
	    if($_REQUEST['custom_job_category']){
		    $seeker_job_cat_search_field = $_REQUEST['custom_job_category'];
	    }    
	    /***********For Job Category wise Search End*********/
	    
	    
	    
	    /***********For Job Category wise Search START*********/
	    /*
	    if($_REQUEST['custom_job_type']){
		    $seeker_job_type_search_field = $_REQUEST['custom_job_type'];
	    }
	    */
	    /***********For Job Category wise Search End*********/
	    
	    
				
	}
      
      
       $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	  
        if( $atts['terms'] ) {
              $tax_query = array(
		    'taxonomy'  => 'cptjobsmanager_category',
		    'field'     => 'slug',
		    'terms'     => array( $atts['terms']?$atts['terms']: '' ),
              );
        }
	if($seeker_job_cat_search_field){
	    $tax_query = array(
		'taxonomy'  => 'cptjobsmanager_category',
		'field'     => 'slug',
		'terms'     => $seeker_job_cat_search_field,
            );      
	}
	
	
	
        $args = array(
	    'post_type' => 'cptjobsmanager',
	    's' => esc_attr( $seeker_job_title_search_field ),
	    'author'        =>  $author_type,
	    'posts_per_page' => $atts['perpage'],
	    'paged' => $paged,
	    
	    'tax_query' => array($tax_query?$tax_query:''),
				
					
	    'meta_query' => array(
		$seeker_job_salary_search_field,
		$seeker_job_loc_search_field
		
	    )
		
        );

      $jobsmanager = new WP_Query( $args );
	
	//echo $wpdb->last_query;
	$get_permission = get_user_meta($current_user->ID, 'users_permission');
	//print_r($get_permission);
    //print_r($jobsmanager);
    if ( is_user_logged_in() && ($get_permission[0] == 'Enable') ) 
    {
        ?>
	
	
	<?php if($user_type == 'job_seeker'){ ?>
	<!--====================SEEKER APPLICATION UPLOAD SECTION START================-->
	    <div class="application_upload">
		<?php
		$user_signapp = get_the_author_meta( '_user_signapp', $current_user->ID );
		if(!$user_signapp){
		    echo "<span class='red_cross'>Before you can apply for a job, you must have a signed Candidate Agreement on file. <a href='".get_permalink(365)."'>Click here</a></span>";
		    
		}else{
		    echo "<span class='green_check'>Signed Candidate Agreement on file</span>";
		} 
		?>
	    </div>
	<!--====================SEEKER APPLICATION UPLOAD SECTION END================-->
	<?php } ?>
	
	<?php /*if($user_type == 'job_provider'){ ?>
	<!--====================PROVIDER APPLICATION UPLOAD SECTION START================-->
	    <div class="application_upload">
		<?php
		$user_signapp = get_the_author_meta( '_user_signapp', $current_user->ID );
		if(!$user_signapp){
		    echo "<span class='red_cross'>Before you can apply for a job, you must have a signed Candidate Agreement on file. <a href='".get_permalink(365)."'>Click here</a></span>";
		    
		}else{
		    echo "<span class='green_check'>Signed Candidate Agreement on file</span>";
		} 
		?>
	    </div>
	<!--====================PROVIDER APPLICATION UPLOAD SECTION END================-->
	<?php } */?>
	
	
	
	
	
	
	
	
	<div class="formwrapper">
                <!-- ==================JOB SEARCH FORM START=============  -->
            <form name="seeker-list-form" id="seeker-list-form" method="post" action="">
                <div class="search-sec">
                    <div class="text_box_search <?php if($user_type == 'job_provider') { echo 'text_box_search-1'?><?php } ?>">
                        <input type="text" name="seeker_search_job_title" id="seeker_search_job_title" value="<?php echo $_REQUEST['seeker_search_job_title']?$_REQUEST['seeker_search_job_title']:'';?>" placeholder="Type job title here">		
			
			
                    <?php if($user_type == 'job_seeker'){ ?>    
                        <input type="number" name="seeker_search_salary" id="seeker_search_salary" value="<?php echo $_REQUEST['seeker_search_salary']?$_REQUEST['seeker_search_salary']:'';?>" placeholder="Min salary requirement">
                    </div>
                    
                    <div class="custom_check">
                            <label for="job_cat"><?php _e('Category'); ?></label>
                            
                            <?php $terms_list = get_terms( array(
                                    'taxonomy' => 'cptjobsmanager_category',
                                    'hide_empty' => false,
                                ) );
                            $selected_cat = $_POST["custom_job_category"];
                            //$selected_cat = wp_get_post_terms($p_id, 'cptjobsmanager_category', array("fields" => "slugs"));
                                    
                            
                            if($terms_list){
                            ?>
                            <div class="checkbox-wrap custom_radio">
                                    <?php
                                    foreach($terms_list as $single_term ){
                                            //print_r($single_term);
                                            if (in_array($single_term->slug, $selected_cat)) {						
                                                $selected_item = ' checked="checked"';
                                            } else {
                                                $selected_item = ' ';
                                            }
                                    ?>
                                            <span><input name="custom_job_category[]" type="checkbox" value="<?php echo $single_term->slug ;?>" <?php echo $selected_item; ?> /><?php echo $single_term->name ;?></span>
                                    <?php } ?>
                                    
                            </div>
                            <?php
                            }
                            ?>
                    </div>	
                    <?php } //Checking of if 'job-seeker' ?>
		    <div class="cbthldr">
                    <input type="submit" name="seeker_search_btn" class="custom-btton" id="seeker_search_btn" value="Filter">
		    </div>
                </div>
            </form>
		<!-- ==================JOB SEARCH FORM END=============  -->
        </div>
		
        <div class="test">
        <input type="hidden" id="ajax_url" name="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>" readonly="readonly">
        </div>
        <?php if( $jobsmanager->have_posts() ) { ?>
			<!-- =========Accordian HTML Start========= -->
			<div id="accordion" class="apply_to_job">
				<?php
				while( $jobsmanager->have_posts() ) {
				$jobsmanager->the_post();
				$job_post_form_ink = get_field("job_post_form_link","options");
				?>
				<div class="separt_section">
				    <h3><?php echo get_the_title(); ?></h3>
				    <div>
					    <div class="item-dtls seekers_details">
						    <ul>
							    <?php /*<li><?php echo get_the_post_thumbnail(get_the_ID(), array(96, 96) ); ?></li>*/ ?>
							    <li><span>Job Description:</span><span><?php echo get_the_content() ?></span></li>
							    <li><span>Job Requirements:</span><span> <?php if(get_post_meta( get_the_ID(), 'jobs_manager_requirements',true)){echo get_post_meta( get_the_ID(), 'jobs_manager_requirements',true);} else{echo 'N/A'; } ?></span></li>
							    <?php /*?>
							    <li><span>Company Name: </span><span><?php if(get_post_meta( get_the_ID(), 'jobs_manager_company_name',true)){echo get_post_meta( get_the_ID(), 'jobs_manager_company_name',true);} else{echo 'N/A'; } ?></span></li>
							    <li><span>Contact: </span><span> <?php if(get_post_meta( get_the_ID(), 'jobs_manager_contact',true )){echo get_post_meta( get_the_ID(), 'jobs_manager_contact',true ); } else{ echo 'N/A'; } ?></span></li>
							    <?php */ ?>
					    <?php
					    $job_enddate = date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_enddate', true ) ));
					    
				    $match_status = 'matched';
				    $match_content = '';
				    if(strcmp($job_enddate,"January 1, 1970") != 0){
					$match_status = 'not_matched';
					$match_content = " to ".date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_enddate', true ) ));
					}	
					    //print_r($match_content);
					    ?>
							    <?php /*?><li><span>Job Post Duration: </span><span> <?php echo date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_startdate', true ) )) .' to '.date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_enddate', true ) )); ?></span></li>
								   <?php */?>
								   
								   <li><span>Job Post Duration: </span><span> From <?php echo date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_startdate', true ) )) .$match_content; ?></span></li>
								   
								   
							    <li><span>Category: </span>
								    <?php $terms = get_the_terms( get_the_ID() , 'cptjobsmanager_category' );
								    if($terms){
									    $termsnm = array();
									    foreach ( $terms as $key => $term ) {
										    //echo $key . '=====' . $term->name.', ';
										    $termsnm[] = '<span class="showcats">'.$term->name.'</span>';
									    }
									    //echo $entry_terms = rtrim( $entry_terms, ', ' );
									    echo implode(', ', $termsnm);
								    }
								    else{
									    echo '<span>'. 'N/A' . '</span>';
								    }
								    ?>
							    </li>							
							    <li><span>Job Salary:</span><?php if(get_post_meta( get_the_ID(), 'jobs_manager_salary',true )){$salary_number= get_post_meta( get_the_ID(), 'jobs_manager_salary',true );echo '<span>'. '$'. number_format($salary_number, 2, '.', ','). '</span>';}else{echo '<span>'. 'N/A' . '</span>';} ?></li>
							    
							    <li><span>Job Location: </span><?php if(get_post_meta( get_the_ID(), 'jobs_manager_location',true )){echo '<span>'.get_post_meta( get_the_ID(), 'jobs_manager_location',true ).'</span>' ;}else{echo '<span>'.'N/A' .'</span>';} ?></li>
							    <?php
							    $user_experience = get_post_meta( get_the_ID(), 'jobs_manager_experience',true );
							    
							    if($user_experience){
								if($user_experience/12 >0){
								    $user_experience_years = (int)($user_experience / 12);
								    $user_experience_month = $user_experience % 12;
								    $current_exp = $user_experience_years.' years '.$user_experience_month.' months';
								}
								else{
								    $current_exp = $user_experience;
								}
							    }				
							    
							    
							    ?>
							    <li><span>Years Of Experience Desired: </span><?php if($current_exp){echo '<span>'. $current_exp. '</span>';}else{echo '<span>'. 'N/A' . '</span>'; } ?></li>							
						    </ul>
					    </div>
					    
					    <div class="aply_edit edlbtn" style="margin-bottom: 0px;">
						    <?php if($user_type == 'job_seeker'){ ?><a href="javascript:void(0)" class="job_apply custom-btton" id="<?php echo get_the_ID(); ?>">Apply Now</a> <span class="click_butn aply_<?php echo get_the_ID(); ?>"> </span><?php } ?>
						    <?php if($user_type == 'job_provider' || $user_type == 'administrator'){ ?>
							    <a class="custom-btton" href="<?php echo $job_post_form_ink;?>?id=<?php echo get_the_ID(); ?>" class="providers_action" id="<?php echo get_the_ID(); ?>">Edit</a>
							    <a class="custom-btton delete_job" href="javascript:void(0)" class="providers_action delete_job" id="<?php echo get_the_ID(); ?>">Delete</a>
						    <?php } ?>
					    </div>
				    </div>
				</div>
				<?php } ?>
			</div>
			<script>
				jQuery( "#accordion" ).accordion();
			</script>		
			<!-- =========Accordian HTML End========= -->
			<?php
			if (function_exists("pagination")) { echo pagination($jobsmanager->max_num_pages); }
			echo '<div class="teamList"></div>';
		}
		else {
			if(isset($_POST['seeker_search_btn']) && !empty($_POST['seeker_search_btn'])) {
				echo '<div class="job-listing-hld">'.'No jobs found.' . '</div>';
			} else {
				echo '<div class="job-listing-hld">'.'There are no jobs.' . '</div>';
			}
		}
    }
    else
    {
	// If Not Logged In User
	//echo "<div class='job-listing-hld'>";
	if ( is_user_logged_in() ) {
	    //echo "You are not authorized user.<br/>";



	    if($_REQUEST['msg'])
	    {
		$regis_status = '<span class="success_msg">Thank you. Your registration process successfully completed.</span>';
	    }
	    else
	    {
		$regis_status = '';
	    }
	    
	    $c_user   = wp_get_current_user();
	    $r_name      = $c_user->roles[0];
	    
	    
	    if($r_name == 'job_seeker')
	    {
		echo '<p class="success">'.$regis_status.'<div class="job-listing-hld">Please wait for authorization to view job list.</div></p>';	
	    }
	    if($r_name == 'job_provider'){
		    echo '<p class="success">'.$regis_status.'<div class="job-listing-hld">Please wait for authorization to view candidate list.</div></p>';	
	    }









	}
	if ( !is_user_logged_in() ) {
	echo "<div class='job-listing-hld'>";
	echo "Please <a href='".site_url()."/login-now'>Login</a> or <a href='".site_url()."/register'>Register</a> to see the details"; 
	echo "</div>";
	}
	//echo "</div>";
    }
      
      ?>                
    </div>
  </section>
  <?php
  return ob_get_clean();
}
add_shortcode( 'cpt_jobsmanager', 'custom_post_jobsmanager_shortcode' );
//[cpt_jobsmanager perpage="10" title="" terms=""]

/**************************Add Shortcode End ***********************/



/*=========Start to send a mail after "apply job" button click=========*/
function send_a_mail_to_admin($user_id, $job_id) {
	//Get user details by user id
	$user_info = get_userdata( $user_id );
	$username = $user_info->user_login;
	$first_name = $user_info->first_name;
	$last_name = $user_info->last_name;
	$user_email = $user_info->user_email;
	
	//Get post details by post id
	$post = get_post( $job_id );
	$post_title = $post->post_title;
	$post_content =  apply_filters( 'the_content', $post->post_content );
	
	//Get the admin email
	$admin_email = get_option( 'admin_email' );
	
	
	//To send a html email to admin as apply to job notification
	$to = $admin_email;
	$subject = 'A candidate interested to a job ('.$post_title.')';
	$from = $user_email;
	 
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	 
	// Compose a simple HTML email message
	$message = '<html><body>';
	$message .= '<h1 style="color:#f40;">Hi Administrator,</h1>';
	$message .= '<p style="color:#080;font-size:18px;">I, '.$first_name.' '.$last_name.' interested on this job ('.$post_title.'). Please inform me to continue the process. </p>';
	$message .= '</body></html>';
	 
	// Sending email
	if(mail($to, $subject, $message, $headers)){
		//echo 'Your mail has been sent successfully.';
	} else{
		//echo 'Unable to send email. Please try again.';
	}

}
/*=========Start to send a mail after "apply job" button click=========*/



/*********************Applied For A Job Start************/
function apply_job(){
   // echo $_POST['job_id'];
    global $current_user;
    get_currentuserinfo();
    $user_id = $current_user->ID;
    $job_id = $_POST['job_id'];
    $job_id_array = array();
    $post_id = $job_id;
    $post_id_array =array();
    
    if(get_user_meta( $user_id, 'users_applied_job', true )){
	//echo "In if";
        $user_list_string = get_user_meta( $user_id, 'users_applied_job', true );
        $job_id_array = explode(",",$user_list_string);
        if (!in_array($job_id, $job_id_array))
        {
            //echo "Hello";
            array_push($job_id_array,$job_id);        
            $job_id_string = implode(",",$job_id_array);
            update_user_meta( $user_id, 'users_applied_job', $job_id_string );
	    
		
		    $job_user_list = get_post_meta( $job_id, 'job_seekers_list', true);
		    //print_r($job_user_list);
		    if($job_user_list){
			//echo "In IF IF";
			add_post_meta( $job_id, 'job_seekers_list', $user_id);
		    }else{
			//echo "In IF Else";
			add_post_meta( $job_id, 'job_seekers_list', $user_id);
		    }
		    /*
			//update jobs to a user
			array_push($post_id_array,$user_id);
			$post_id_string = implode(",", $post_id_array);
			//print_r($post_id_string);
			add_post_meta( $job_id, 'job_seekers_list', $user_id );
		
			send_a_mail_to_admin($user_id, $job_id);
			*/
		
            echo 1;
        }
        else{
            //echo "hi";
            echo 2;
        }
        
    }
    else{
	//echo "In else";
        $job_id_array[] = $job_id;
        $job_id_string = implode(",",$job_id_array);
        add_user_meta( $user_id, 'users_applied_job', $job_id_string );
	
		//add jobs to a user
		$post_id_array[] = $user_id;
		$post_id_string = implode(",", $post_id_array);
		add_post_meta( $job_id, 'job_seekers_list', $user_id );
		
		send_a_mail_to_admin($user_id, $job_id);
		
        echo 1;
    }   
    
    /*
   // if(get_user_meta( $user_id, 'users_applied_job', true )){
    if(get_post_meta($job_id, 'job_seekers_list', true )){
        $user_list_string = get_user_meta( $user_id, 'users_applied_job', true );
        $job_id_array = explode(",",$user_list_string);
	
	
	//////////////////////
	$job_user_list = get_post_meta($job_id, 'job_seekers_list', true )
	$job_user_list_array = explode(",",$job_user_list);
	/////////////////////
	
	
	
        if (!in_array($job_id, $job_id_array))
        {
            //echo "Hello";
            array_push($job_id_array,$job_id);        
            $job_id_string = implode(",",$job_id_array);
            update_user_meta( $user_id, 'users_applied_job', $job_id_string );
	    
			//update jobs to a user
			array_push($post_id_array,$user_id);
			$post_id_string = implode(",", $post_id_array);
			//print_r($post_id_string);
			update_post_meta( $job_id, 'job_seekers_list', $user_id );
		
			send_a_mail_to_admin($user_id, $job_id);
		
            echo 1;
        }
        else{
            //echo "hi";
            echo 2;
        }
        
    }
    else{
        $job_id_array[] = $job_id;
        $job_id_string = implode(",",$job_id_array);
        add_user_meta( $user_id, 'users_applied_job', $job_id_string );
	
		//add jobs to a user
		$post_id_array[] = $user_id;
		$post_id_string = implode(",", $post_id_array);
		add_post_meta( $job_id, 'job_seekers_list', $user_id );
		
		send_a_mail_to_admin($user_id, $job_id);
		
        echo 1;
    }
    */
    
    //wp_die();
    exit;
}
add_action( 'wp_ajax_apply_jobs_ajax', 'apply_job' );
add_action( 'wp_ajax_nopriv_apply_jobs_ajax', 'apply_job' );
/*********************Applied For A Job End************/




/*********************DELETE JOB FROM JOB LIST START*************/
function delete_job(){

    global $wpdb;
    global $current_user;
    get_currentuserinfo();
    $user_id = $current_user->ID;
    //echo $_POST['id'];

    $table = 'sa_posts';
    $wpdb->delete( $table, array( 'ID' => $_POST['id'] ) );

    echo 1;
    wp_die();
    exit;


}

add_action( 'wp_ajax_delete_job_ajax', 'delete_job' );
add_action( 'wp_ajax_nopriv_delete_job_ajax', 'delete_job' );
/*********************DELETE JOB FROM JOB LIST END*************/




/*********************DELETE USER FROM ASSIGN-TO START*************/
function delete_assgn_user(){

    global $wpdb;

    $curnt_post_id = $_POST['curnt_post_id'];
    
    $cancel_usr_id = $_POST['cancel_usr_id'];
    
    $job_asigned_list = get_post_meta($curnt_post_id,'job_asigned_list', true);
    //print_r($job_asigned_list);
    
    $job_asigned_list_array = explode(",",$job_asigned_list);
    
    if (($key = array_search($cancel_usr_id, $job_asigned_list_array)) !== false) {
	unset($job_asigned_list_array[$key]);
	$job_asigned_list_array = array_values($job_asigned_list_array);
    }
    //print_r($job_asigned_list_array);
    $job_asigned_list_string = implode(",",$job_asigned_list_array);
    //print_r($job_asigned_list_string);
    if($job_asigned_list_string == ''){
	delete_post_meta($curnt_post_id,'job_asigned_list');
    }else{
	update_post_meta($curnt_post_id,'job_asigned_list', $job_asigned_list_string);
    }
    
    delete_user_meta( $cancel_usr_id, 'asgnd_to_job' );
    
    delete_post_meta($curnt_post_id, "jobs_assign_to_dates");
     echo 1;
/*
    $table = 'sa_posts';
    $wpdb->delete( $table, array( 'ID' => $_POST['id'] ) );

    echo 1;
    wp_die();
    */
    exit;


}

add_action( 'wp_ajax_delete_asgn_to_ajax', 'delete_assgn_user' );
add_action( 'wp_ajax_nopriv_delete_asgn_to_ajax', 'delete_assgn_user' );
/****************DELETE USER FROM ASSIGN-TO END*************/

?>