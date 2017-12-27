<?php
/*
Plugin Name: WS Jobs Manager
Plugin URI: http://wpteam.com/
Description: This is a jobs management plugin.
Author: WP Team
Version: 1.0
Author URI: http://wpteam.com/author/wpteam
*/

/*
if ( function_exists( 'add_image_size' ) ) { 
  add_theme_support( 'ourjobsthumb' ); // post-thumbnails
  add_image_size( 'ourjobsthumb',96, 96, true ); //(cropped)
  //set_post_thumbnail_size( 420, 110 ); // default Post Thumbnail dimensions   
}

// Remove these using WordPress action intermediate_image_sizes_advanced then unset the thumbnail, medium and large sizes, it means there only left full image size.
function remove_thumbnail_medium_large_img_for_ourjobsthumb( $sizes) {
  if( isset($_REQUEST['post_id']) && 'cptjobsmanager' === get_post_type( $_REQUEST['post_id'] ) ) {
    unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    unset( $sizes['large']);
  }
  return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_thumbnail_medium_large_img_for_ourtestimonials');
*/

//################ include for datepicker ################//
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_script( 'jobs-multi-date', plugin_dir_url(__FILE__) . '/js/jquery-ui.multidatespicker.js', array('jquery'), '1.0',  false );
wp_enqueue_script( 'table-download', plugin_dir_url(__FILE__) . '/js/table2download.js', array('jquery'), '1.0',  false );
wp_enqueue_script( 'jobs-manager', plugin_dir_url(__FILE__) . '/js/jobs-manager.js', array('jquery'), '1.0',  false );



wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
wp_enqueue_style('jobs-multi-date-css', plugin_dir_url(__FILE__) . '/css/jquery-ui.multidatespicker.css', array(), '0.1.0', 'all');
wp_enqueue_style('jobs-custom-css', plugin_dir_url(__FILE__) . '/css/job-custom.css', array(), '0.1.0', 'all');


//========= Start to create a custom post type post =========//
function custom_post_for_jobs_manager_fun() {
  $labels = array(
    'name'               => _x( 'Jobs Manager', 'post type general name' ),
    'singular_name'      => _x( 'Job Manager', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'job' ),
    'add_new_item'       => __( 'Add New Job' ),
    'edit_item'          => __( 'Edit Job' ),
    'new_item'           => __( 'New Job' ),
    'all_items'          => __( 'All Jobs' ),
    'view_item'          => __( 'View Jobs' ),
    'search_items'       => __( 'Search Jobs' ),
    'not_found'          => __( 'No Item(s) Found' ),
    'not_found_in_trash' => __( 'No Item(s) found in Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Jobs Manager'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our jobs and it&#39;s specific data',
    'public'        => true,
    'menu_position' => 66,
    'menu_icon'     => 'dashicons-forms',
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'cptjobsmanager', $args ); 
}
add_action( 'init', 'custom_post_for_jobs_manager_fun' );
//========= End to create a custom post type post =========//


function taxonomies_for_jobs_manager_fun() {
  $labels = array(
    'name'              => _x( 'Job Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Job Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Job Categories' ),
    'all_items'         => __( 'All Job Categories' ),
    'parent_item'       => __( 'Parent Job Category' ),
    'parent_item_colon' => __( 'Parent Job Category:' ),
    'edit_item'         => __( 'Edit Job Category' ), 
    'update_item'       => __( 'Update Job Category' ),
    'add_new_item'      => __( 'Add New Job Category' ),
    'new_item_name'     => __( 'New Job Category' ),
    'menu_name'         => __( 'Job Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'cptjobsmanager_category', array( 'cptjobsmanager' ), $args );
}
add_action( 'init', 'taxonomies_for_jobs_manager_fun', 0 );



//###########################################################################//



/*
// Adding custom columns
The first step in creating custom columns, is to make these columns available on the edit posts page. WordPress has a variable filter hook for this called manage_edit-{$post_type}_columns for all post types. Since the name of our post type is movie, the name of the hook you’d use is manage_edit-{$post_type}_columns.
*/

function custom_columns_for_cptjobsmanager_list( $columns ) {
    $columns = array(
        'cb'               => '<input type="checkbox" />',
        'featured_image'   => 'Image',
        'title'            => 'Title',
        //'comments'       => '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
        //'testimonial_authornm' => 'Name',
        //'testimonial_authordg' => 'Designation',
        'salary'           => 'Salary',
        'jobauthor'        => 'Author',
       // 'applied_user'     => 'Applied User',
        'assigned_to'     => 'Assigned To',
        'total_user'       => 'Total User',
        'location'         => 'Location',
        'startdate'        => 'Start Date',
        'enddate'          => 'End Date'
     );
    return $columns;
}
add_filter('manage_edit-cptjobsmanager_columns' , 'custom_columns_for_cptjobsmanager_list');

/*
// Adding content to custom columns
Now that you’ve created some custom columns, you have to actually put some content in them. We’re only worried about the duration and genre columns because they’re the only custom columns. WordPress knows how to handle the other columns by default.
The action hook in this case is manage_{$post_type}_posts_custom_column. Remember, the name of the post type is movie, so this hook becomes manage_movie_posts_custom_column.
*/

function custom_columns_data_for_cptjobsmanager( $column, $post_id ) {
    switch ( $column ) {
      case 'featured_image':
        if ( has_post_thumbnail() ) {
          echo the_post_thumbnail( array(48,48) );  //echo the_post_thumbnail( 'thumbnail' );
        } else {
          echo '<img src="'.esc_url( plugins_url( 'images/no-image-48x48.png', __FILE__ ) ).'" />';
        }
        break;
      
      case 'salary':
        echo get_post_meta( $post_id, 'jobs_manager_salary', true );       
        break;
            
      case 'jobauthor':
        $author = get_the_author();
        echo $author;        
        break;
    /*  
      case 'applied_user':
        //echo $post_id;
        $applied_user_id = get_post_meta( $post_id, 'job_seekers_list', false );
        //print_r ($applied_user_id);
        if( !empty($applied_user_id) ) {
          $username = array();
          foreach($applied_user_id as $userid) {          
            $user_info = get_userdata($userid);            
            $username[] = '<a href="users.php?s='.$userid.'" title="">'.$user_info->user_login.'</a>';
          }
          echo $data = implode(", ",$username);
        }        
      break;
  */
      case 'assigned_to':
        //echo $post_id;
        $assigned_user_id = get_post_meta( $post_id, 'job_asigned_list', false );
        if($assigned_user_id){
          $assigned_user_id_array = explode(",",$assigned_user_id[0]);
        }
        else{
          $assigned_user_id_array = '';
        }
        foreach($assigned_user_id_array as $single_assigned_user_id){
          $asgn_user_info = get_userdata($single_assigned_user_id);
        ?>        
        
          <a href="users.php?s=<?php echo $single_assigned_user_id; ?>"><?php echo $asgn_user_info->user_login; ?></a>
       
        <?php
        }
        break;      
      
      case 'total_user':
      $user_id_count = get_post_meta( $post_id, 'job_seekers_list', false );
      echo  $count = count($user_id_count);
      break;
    
      case 'location':
        echo get_post_meta( get_the_ID(), 'jobs_manager_location', true );
        break;
      case 'startdate':
        //echo get_post_meta( get_the_ID(), 'jobs_manager_startdate', true ); echo '<br/>';
        echo date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_startdate', true ) ));
        break;
      case 'enddate':
        //echo get_post_meta( get_the_ID(), 'jobs_manager_enddate', true ); echo '<br/>';
        echo date('F j, Y', strtotime( get_post_meta( get_the_ID(), 'jobs_manager_enddate', true ) ));
        break;
    }
}
add_action( 'manage_cptjobsmanager_posts_custom_column' , 'custom_columns_data_for_cptjobsmanager', 10, 2 ); 


/* ============ Start To Making Our Custom Columns Sortable ============ */
// Register the custom column as sortable
function cptjobsmanager_column_register_sortable( $columns ) {
  //$columns['jobauthor'] = 'jobauthor';
  $columns['location'] = 'location';
  $columns['startdate'] = 'startdate';
  $columns['enddate'] = 'enddate';
  return $columns;
}
add_filter( 'manage_edit-cptjobsmanager_sortable_columns', 'cptjobsmanager_column_register_sortable' );


//Sorting Metadata
function manage_wp_posts_be_qe_pre_get_posts( $query ) {
  if ( ! is_admin() ) return;
  
  if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
    switch( $orderby ) {
      // If we're ordering by 'location'
      case 'location':
          // set our query's meta_key, which is used for custom fields
          $query->set( 'meta_key', 'jobs_manager_location' );
          // If your meta value are numbers, change 'meta_value' to 'meta_value_num'.
          $query->set( 'orderby', 'meta_value' );
          break;
      // If we're ordering by 'startdate'
      case 'startdate':
          // set our query's meta_key, which is used for custom fields
          $query->set( 'meta_key', 'jobs_manager_startdate' );
          // If your meta value are numbers, change 'meta_value' to 'meta_value_num'.
          $query->set( 'orderby', 'meta_value' );
          break;
      // If we're ordering by 'enddate'
      case 'enddate':
          // set our query's meta_key, which is used for custom fields
          $query->set( 'meta_key', 'jobs_manager_enddate' );
          // If your meta value are numbers, change 'meta_value' to 'meta_value_num'.
          $query->set( 'orderby', 'meta_value' );
          break;
    }
  }
}
add_action( 'pre_get_posts', 'manage_wp_posts_be_qe_pre_get_posts', 1 );
/* ============ End To Making Our Custom Columns Sortable ============ */



//add custom metaboxes for jobs requirement
function add_custom_meta_box_for_job_require() {
  //add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null );
  add_meta_box("jobs_manager_extra_fields_requirement", "Job Requirements", "jobs_manager_extra_fields_req_fun", "cptjobsmanager", "normal", "default", null);
}
add_action("add_meta_boxes", "add_custom_meta_box_for_job_require");

//only show Jos Requirement below the content
function jobs_manager_extra_fields_req_fun($object){
  wp_nonce_field(basename(__FILE__), "meta-box-nonce");
  ?>
  <div>
      <label for="meta-box-text">Job Requirements: </label>
      <input name="jobs_manager_requirements" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_requirements", true); ?>" style="width: 100%;">
      <br>
  </div>
  <?php  
}

//add custom metaboxes for jobs
function add_custom_meta_box_for_jobs() {
  //add_meta_box( string $id, string $title, callable $callback, string|array|WP_Screen $screen = null, string $context = 'advanced', string $priority = 'default', array $callback_args = null );
  add_meta_box("jobs_manager_extra_fields", "Additional Job Information", "jobs_manager_extra_fields_fun", "cptjobsmanager", "side", "default", null);
  
  add_meta_box("jobs_manager_assigned_to", "Assign To:", "jobs_manager_assigned_to_finctn", "cptjobsmanager", "side", "default", null);//Job Assign To
}
add_action("add_meta_boxes", "add_custom_meta_box_for_jobs");

//To show input field of form
function jobs_manager_extra_fields_fun($object) {
  wp_nonce_field(basename(__FILE__), "meta-box-nonce");
  ?>
  <div>
  
      <label for="meta-box-text">Location: </label>
      <input name="jobs_manager_location" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_location", true); ?>">
      <br>
      <label for="meta-box-text">Start Date: </label>
      <input name="jobs_manager_startdate" type="text" value="<?php echo date("m-d-Y", strtotime(get_post_meta($object->ID, "jobs_manager_startdate", true))); ?>" class="startdate date_picker" placeholder="mm/dd/yyyy">
      <br>
      <label for="meta-box-text">End Date: </label>
      <input name="jobs_manager_enddate" type="text" value="<?php echo date("m-d-Y", strtotime(get_post_meta($object->ID, "jobs_manager_enddate", true))); ?>" class="enddate date_picker" placeholder="mm/dd/yyyy">
     
      <?php /* ?>
      <label for="meta-box-text">Company Name: </label>
      <input name="jobs_manager_company_name" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_company_name", true); ?>">
      <?php */?>
      <label for="meta-box-text">Contact No: </label>
      <input name="jobs_manager_contact" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_contact", true); ?>">
      <br>
      <!--<label for="meta-box-text">Job Requirements: </label>
      <input name="jobs_manager_requirements" type="text" value="<?php //echo get_post_meta($object->ID, "jobs_manager_requirements", true); ?>">
      <br>
      <label for="meta-box-text">Designation: </label>
      <input name="jobs_manager_designation" type="text" value="<?php //echo get_post_meta($object->ID, "jobs_manager_designation", true); ?>">
      <br>-->
      <label for="meta-box-text">Salary($): </label>
      <input name="jobs_manager_salary" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_salary", true); ?>">
      <br/>
      <!--
      <label for="meta-box-text">Department: </label>
      <input name="jobs_manager_department" type="text" value="<?php //echo get_post_meta($object->ID, "jobs_manager_department", true); ?>">
      <br>
        -->
        
        <!--
      <label for="meta-box-text">Experience: </label>
      <input name="jobs_manager_experience" type="text" value="<?php //echo get_post_meta($object->ID, "jobs_manager_experience", true); ?>">
      -->
     
     
    <?php
    $years_of_experience_required = get_field('years_of_experience_required','options');
    $user_experience = get_post_meta($object->ID, "jobs_manager_experience", true);
    
    if($user_experience){
        if($user_experience/12 >0){
          $user_experience_years = (int)($user_experience / 12);
          $user_experience_month = $user_experience % 12;
        }
    }
    ?>
    <label for="meta-box-text">Experience: </label>
      <div class="exp_wrap">
          <select name="custom_reg_log_user_exp_years">
               <option value="">Select Years</option>
               <?php for($i=0; $i<=$years_of_experience_required; $i++){?>
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
      
      
      
      
      
      
      
      
      
      
      
      
      <!--<br>
      <label for="meta-box-text">Vacancy No: </label>
      <input name="jobs_manager_vacancy" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_vacancy", true); ?>">
      -->
      <br>
      <label for="meta-box-text">Job Type: </label>
      <input name="jobs_manager_jobtype" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_jobtype", true)[0]; ?>" disabled>
  </div>
  <?php  
}




/**************JOB ASSIGN TO START***********/
function jobs_manager_assigned_to_finctn($object) {
  wp_nonce_field(basename(__FILE__), "meta-box-nonce");
  global $wpdb;
  ?>
  <div>
    <input type="hidden" name="ajax_asign_to" class="ajax_asign_to" value="<?php echo admin_url('admin-ajax.php'); ?>">
    <input type="hidden" name="curnt_post_id" class="curnt_post_id" value="<?php echo $object->ID; ?>">
  
      <label for="meta-box-text">Assign To: </label>
      <!--<input name="jobs_manager_location" type="text" value="<?php echo get_post_meta($object->ID, "jobs_manager_location", true); ?>">-->  
  
  <?php
  
  $args = array(
	'role'         => 'job_seeker',
        
	//'meta_query'   => array(),
        'meta_query' => array(
			array(
				'key'     => 'users_permission',
				'value'   => 'Enable',
	 			'compare' => '='
			),
			array(
				'key'     => 'asgnd_to_job',
				'compare' => 'NOT EXISTS',
			)
	),
        
        
	'order'        => 'ASC',
 );
  
  
  
  
  
  //global $wpdb;
  //echo $wpdb->last_query;
  //echo "<br /><br />";
 $users_list = get_users( $args ); 
//print_r($users_list);
  
  $applied_user_id = get_post_meta( $object->ID, 'job_seekers_list', false );
  //print_r($applied_user_id);
  $assigned_user_id = get_post_meta( $object->ID, 'job_asigned_list', false );
//print_r($assigned_user_id);
//die("hi");
  if($assigned_user_id){
    $user_info_check = get_userdata($assigned_user_id[0]);
    if($user_info_check){
      $assigned_user_id_array = explode(",",$assigned_user_id[0]);
    }
    else{
      //echo $assigned_user_id[0];
      delete_post_meta( $object->ID, 'job_asigned_list', $assigned_user_id[0] );
      //delete_user_meta( $assigned_user_id[0], 'asgnd_to_job');
      $wpdb->delete( 'sa_usermeta', array( 'user_id' => $assigned_user_id[0] ) );
    }
    
  }
  else{
    $assigned_user_id_array = '';
  }
  //print_r($assigned_user_id_array);         
  //if($users_list){
  ?>  
    <select name='job_assignd_to' id='job_assignd_to' class='job_assignd_to' <?php if($assigned_user_id_array != ''){echo "disabled='true'";} ?>>
            <option value="">Select assign to:</option>
            <?php if($users_list){
               foreach($users_list as $single_user) { 
                      $user_info = get_userdata($single_user->ID);
                      if($user_info){
                        if (in_array($single_user->ID, $applied_user_id)){
                          $counter = 'green';
                        }
                        else{
                          $counter = 'none';
                        }  
                      ?>            
                          <option class="<?php echo $counter; ?>" value="<?php echo $single_user->ID; ?>"><?php echo $user_info->user_login; ?></option>
                      
                      <?php
                      }
               } 
            } ?>
    </select>  
  <?php  
  //}
  ?>
  <input type="hidden" name="asgn_to_hidn" class="asgn_to_hidn" value="<?php if($assigned_user_id_array[0]){echo $assigned_user_id_array[0];}?>">
  <div class="asign_to_wrap">
    <?php if($assigned_user_id_array){ ?>
      <?php foreach($assigned_user_id_array as $single_assigned_user_id){
         $asgn_user_info = get_userdata($single_assigned_user_id);
         if($asgn_user_info){ 
        ?>
        
        <span class="asgn_div">
          <a href="javascript:void(0)" class="cancel_asign" id="cancel_<?php echo $single_assigned_user_id; ?>"> x</a>
          <a href="users.php?s=<?php echo $single_assigned_user_id; ?>" class="asgn_usr_name"><?php echo $asgn_user_info->user_login; ?></a>
        </span>
      <?php }
      }
    }?>
  </div>
  
  
  
  
  
  
  
  
  <?php
  
    /*
          
    //echo $post_id;
        $applied_user_id = get_post_meta( $object->ID, 'job_seekers_list', false );
        $assigned_user_id = get_post_meta( $object->ID, 'job_asigned_list', false );
        //print_r($applied_user_id);
        //print_r($assigned_user_id);
        if($assigned_user_id){
          $assigned_user_id_array = explode(",",$assigned_user_id[0]);
        }
        else{
          $assigned_user_id_array = '';
        }
        
        ?>
      <?php if( !empty($applied_user_id) ) {
          $username = array();?>
          <select name='job_assignd_to' id='job_assignd_to' class='job_assignd_to'>
            <option value="">Select assign to:</option>
            <?php foreach($applied_user_id as $userid) {
                  if (!in_array($userid, $assigned_user_id_array)){
                      $user_info = get_userdata($userid);
                      if($user_info){
                      ?>            
                          <option value="<?php echo $userid ?>"><?php echo $user_info->user_login; ?></option>
                      
                      <?php
                      }
                  }
            } ?>
          </select>
      <?php } ?>
      <input type="hidden" name="asgn_to_hidn" class="asgn_to_hidn" value="">
      <div class="asign_to_wrap">
        <?php foreach($assigned_user_id_array as $single_assigned_user_id){
           $asgn_user_info = get_userdata($single_assigned_user_id);
          ?>
          
          <span class="asgn_div">
            <a href="javascript:void(0)" class="cancel_asign" id="cancel_<?php echo $single_assigned_user_id; ?>"> close</a>
            <a href="users.php?s=<?php echo $single_assigned_user_id; ?>"><?php echo $asgn_user_info->user_login; ?></a>
          </span>
        <?php }?>
      </div>
      
      
      <?php */?>
      
      <?php //print_r($asgn_user_info);    ?>
      <?php $terms = wp_get_post_terms( $object->ID, 'cptjobsmanager_category');
      //if($terms[0]->slug == 'part-time')
      //{
        ?>
        
        <div class="mdp-demo" <?php if($terms[0]->slug == 'part-time'){ ?>style="display: block;"<?php }else{?>style="display: none;"<?php } ?>></div> 
        <?php /*?><input name="date_list" type="text" value="12-12-2017,12-22-2017" class="date_list"><?php */?>
        <input name="date_list" type="hidden" value="<?php echo get_post_meta($object->ID, "jobs_assign_to_dates", true);?>" class="date_list">
      <?php //} ?>
      
      <!--<input name="jobs_manager_enddate" type="text" value="" class="mdp-demo" placeholder="">-->
  </div>     
        
 <?php
}
 /**************JOB ASSIGN TO END***********/
 
 

//To save custom meta box
function save_custom_meta_box_for_jobs($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "cptjobsmanager";
    if($slug != $post->post_type)
        return $post_id;

    $jobs_manager_location    = "";
    $jobs_manager_startdate   = "";
    $jobs_manager_enddate     = "";
    $jobs_manager_company     = "";
    $jobs_manager_contact     = "";
    $jobs_manager_requirements = "";
    $jobs_manager_designation =  "";
    $jobs_manager_salary      = "";
    $jobs_manager_department  = "";
    $jobs_manager_experience  = "";
    $jobs_manager_vacancy     = "";
    
    if(isset($_POST["jobs_manager_location"])) {
        $jobs_manager_location = $_POST["jobs_manager_location"];
    }   
    update_post_meta($post_id, "jobs_manager_location", $jobs_manager_location);

    if(isset($_POST["jobs_manager_startdate"])) {
        //$jobs_manager_startdate = $_POST["jobs_manager_startdate"];
        $getstart_date = explode('-', $_POST["jobs_manager_startdate"]);
        $getstart_date_d = $getstart_date['1'];
        $getstart_date_m = $getstart_date['0'];
        $getstart_date_y = $getstart_date['2'];
        $jobs_manager_startdate = $getstart_date_y.'-'.$getstart_date_m.'-'.$getstart_date_d;
    }   
    update_post_meta($post_id, "jobs_manager_startdate", $jobs_manager_startdate);

    if(isset($_POST["jobs_manager_enddate"])) {
        //$jobs_manager_enddate = $_POST["jobs_manager_enddate"];
        $getend_date = explode('-', $_POST["jobs_manager_enddate"]);
        $getend_date_d = $getend_date['1'];
        $getend_date_m = $getend_date['0'];
        $getend_date_y = $getend_date['2'];
        $jobs_manager_enddate = $getend_date_y.'-'.$getend_date_m.'-'.$getend_date_d;
    }   
    update_post_meta($post_id, "jobs_manager_enddate", $jobs_manager_enddate);

    if(isset($_POST["jobs_manager_company_name"])) {
        $jobs_manager_company = $_POST["jobs_manager_company_name"];
    }   
    update_post_meta($post_id, "jobs_manager_company_name", $jobs_manager_company);

    
    if(isset($_POST["jobs_manager_contact"])) {
        $jobs_manager_contact = $_POST["jobs_manager_contact"];
    }   
    update_post_meta($post_id, "jobs_manager_contact", $jobs_manager_contact);
    

    if(isset($_POST["jobs_manager_requirements"])) {
        $jobs_manager_requirements = $_POST["jobs_manager_requirements"];
    }   
    update_post_meta($post_id, "jobs_manager_requirements", $jobs_manager_requirements); 
    
    if(isset($_POST["jobs_manager_designation"])) {
        $jobs_manager_designation = $_POST["jobs_manager_designation"];
    }   
    update_post_meta($post_id, "jobs_manager_designation", $jobs_manager_designation);
    
     if(isset($_POST["jobs_manager_salary"])) {
        $jobs_manager_salary = $_POST["jobs_manager_salary"];
    }   
    update_post_meta($post_id, "jobs_manager_salary", $jobs_manager_salary);
    
    if(isset($_POST["jobs_manager_department"])) {
        $jobs_manager_department = $_POST["jobs_manager_department"];
    }   
    update_post_meta($post_id, "jobs_manager_department", $jobs_manager_department);
/*
    if(isset($_POST["jobs_manager_experience"])) {
        $jobs_manager_experience = $_POST["jobs_manager_experience"];
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
            $jobs_manager_experience = $user_exp_in_month;
    }else{
            $jobs_manager_experience = $user_experience_months;
    }
    
    
    update_post_meta($post_id, "jobs_manager_experience", $jobs_manager_experience);

    
    
    
    
    
    
    
    
    
    if(isset($_POST["jobs_manager_vacancy"])) {
        $jobs_manager_vacancy = $_POST["jobs_manager_vacancy"];
    }   
    update_post_meta($post_id, "jobs_manager_vacancy", $jobs_manager_vacancy);
    
    
    
    /****save job assign to start****/
    if(isset($_POST["asgn_to_hidn"])) {
        $asgn_to_hidn = $_POST["asgn_to_hidn"];
    }
    //print_r($asgn_to_hidn);
    
    
    /*****Save user id in UserMeta table start*****/
    $asgn_to_hidn_array = $asgn_to_hidn;
    //print_r($asgn_to_hidn_array);
    //die("Hi");
    if($asgn_to_hidn_array){
      //foreach($asgn_to_hidn_array as $user_job_meta){
      $user_job_meta = $asgn_to_hidn_array;
        $asgnd_to_job = get_user_meta($user_job_meta,'asgnd_to_job','false');
        if($asgnd_to_job){
          //$asgnd_to_job = $asgnd_to_job.','.$post_id;
        }
        else{
          
          $asgnd_to_job = $post_id;
          add_user_meta($user_job_meta,'asgnd_to_job',$asgnd_to_job);
        }
        //print_r($asgnd_to_job);
      
      //}
     // add_user_meta($user_job_meta,'asgnd_to_job',$asgnd_to_job);
    }
    
    
    /*****Save user id in jobMeta table end*****/   
    
    
    /*$job_asigned_list = get_post_meta($post_id, "job_asigned_list", 'false');
    if($job_asigned_list){
      //$asgn_to_hidn = $job_asigned_list.','.$asgn_to_hidn;
      $asgn_to_hidn = $asgn_to_hidn;
      
      //update_post_meta($post_id, "job_asigned_list", $asgn_to_hidn);
    }
    if($asgn_to_hidn){
      update_post_meta($post_id, "job_asigned_list", $asgn_to_hidn);
    }else{
      update_post_meta($post_id, "job_asigned_list", $asgn_to_hidn);
    }
    */

    $job_asigned_list = get_post_meta($post_id, "job_asigned_list", 'false');
    if($job_asigned_list){
      update_post_meta($post_id, "job_asigned_list", $asgn_to_hidn);
    }else{
      add_post_meta($post_id, "job_asigned_list", $asgn_to_hidn);
    }
    
    /****save job assign to end****/
    
    
    
    
    /********Assign Jobs To Dates Start*******/
    
    if(isset($_POST["date_list"])) {
        $date_list = $_POST["date_list"];
    }
    //print_r($date_list);
    //die("HI");
    update_post_meta($post_id, "jobs_assign_to_dates", $date_list);
    
    
    /********Assign Jobs To Dates End*******/
    
}
add_action("save_post", "save_custom_meta_box_for_jobs", 10, 3);


function mdy_to_ymd($change_date){
    $newdate_array = explode("-",$change_date);
    //print_r($billing_startdate_array);
    $newdate_month = $newdate_array[0];
    $newdate_day = $newdate_array[1];
    $newdate_year = $newdate_array[2];
    
    $date_new = $newdate_year."-".$newdate_month."-".$newdate_day;
    return $date_new;
}


/**********************7-12-2017 START************************/

///////////////////////////////////=====================///////////////////////////////////////
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class CustomUser_List_Table extends WP_List_Table
{
  function prepare_items() {
    //$this->process_bulk_action(); // Delete the data by bulk or single
    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    //$sortable = $this->get_sortable_columns();

    //$this->_column_headers = array($columns, $hidden, $sortable);
    $this->_column_headers = array($columns, $hidden);
    $this->items = $this->table_data();
  }
	
  function get_columns(){
    $columns = array(
    //'cb'               => '<input type="checkbox" />',
    'dentaloffice' => 'Dental Office',
    'jobname'    => 'Job Name',
    'jobtype'    => 'Job Type',
    'matchmade'  => 'Match Made',
    'perdayamount'=> 'Per Day Amount',
    'workdays'   => '# of Workdays',
    'amountdue'  => 'Amount Due' 
    );
    return $columns;
  }
  
  
  public function get_hidden_columns()
    {
        return array();
    }
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
      $sort_column = 	array(
          'dentaloffice' => array('dentaloffice', false),
          'jobname' => array('jobname', false)
      );
      return $sort_column;
    }
    
    
    
    
    
    
    
    
    











  function table_data(){
    //print_r($_REQUEST);
   
    if($_REQUEST['billing_startdate']){
      $billing_startdate = $_REQUEST['billing_startdate'];
      
      $billing_startdate_new = mdy_to_ymd($billing_startdate);

    }
    
    if($_REQUEST['billing_enddate']){
      $billing_enddate = $_REQUEST['billing_enddate'];
      
      $billing_enddate_new = mdy_to_ymd($billing_enddate);
    }



$step = '+1 day';
$output_format = 'Y-m-d';


//$first = '2017-12-01';
//$last = '2017-12-05';

$first = $billing_startdate_new;
$last = $billing_enddate_new;


$dates_range = array();
    $current = strtotime($first);
    $last = strtotime($last);
    if($current && $last){
      while( $current <= $last ) {
  
          $dates_range[] = date($output_format, $current);
          $current = strtotime($step, $current);
      }
    }
    else{
      $dates_range = '';
    }  

//print_r($dates_range);
    
    $args = array(
            'post_type' => 'cptjobsmanager',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'meta_query' => array(
		array(
			'key'     => 'job_asigned_list',
			'compare' => 'EXISTS',
		),
                array(
			'key'     => 'jobs_manager_jobtype',
			'compare' => 'EXISTS',
		)
            ),
            );
    $loop = new WP_Query($args);
    while($loop->have_posts()){
        $loop->the_post();
        $job_id = get_the_ID();
        $jobs_assign_to_dates_array = '';
        $job_cat = wp_get_post_terms($job_id, 'cptjobsmanager_category');
        if($job_cat[0]->slug=='full-time'){
          $jobs_manager_startdate = get_post_meta($job_id,'jobs_manager_startdate',true);
          
          //echo "@@@@@@@@@@@@@@";
          //print_r($jobs_manager_startdate);
          //echo "%%%%%%%%%%%%%%%%%%%%%";
        }
        if($job_cat[0]->slug=='part-time'){
              $jobs_assign_to_dates = get_post_meta($job_id, "jobs_assign_to_dates", true);             
              
              $jobs_assign_to_dates_array = explode(",",$jobs_assign_to_dates);
             
             // print_r($jobs_assign_to_dates_array);
        
        }
        
       
        
        
       
        if($dates_range){
          if($jobs_assign_to_dates_array){
                  foreach($jobs_assign_to_dates_array as $single_asgn_dates){ //echo $single_asgn_dates;
                    $single_asgn_dates_new = mdy_to_ymd($single_asgn_dates);
                      if (in_array($single_asgn_dates_new, $dates_range)){                
                            $job_list[] = get_the_ID();                 
                      }
                    
                  }
          }
          else{            
                if (in_array($jobs_manager_startdate, $dates_range)){
                      $job_list[] = get_the_ID();                 
                }
            
          }  
          
          
        }
        else{
             // $job_cat = wp_get_post_terms($job_id, 'cptjobsmanager_category');
              //print_r($job_cat[0]->slug);
              
              
              
          
          
                $job_asigned_to_candi = get_post_meta($job_id,'job_asigned_list',true);
                //print_r($job_asigned_to_candi);
                //echo "Hello";
                $jobs_assign_to_dates = get_post_meta($job_id,'jobs_assign_to_dates',true);
                $jobs_assign_to_dates_array = explode(",",$jobs_assign_to_dates);
                //print_r($jobs_assign_to_dates_array);
                
                
              if($job_cat[0]->slug=='full-time'){
                $workdays = '';
              }
              if($job_cat[0]->slug=='part-time'){
                $workdays = count($jobs_assign_to_dates_array);
              }
                
                
                $user_info = get_userdata($job_asigned_to_candi);
                //print_r($user_info);
                $job_name = '<a href="post.php?post='.get_the_ID().'&action=edit">'. get_the_title().'</a>';
                
                $matchmade = '<a href="users.php?s='.$user_info->ID.'">'.$user_info->user_login.'</a>';
                
                $data[] =  array(
                  'id'          => get_the_ID(),
                  'dentaloffice'=> get_the_author(),
                  'jobname'     => $job_name,                   
                  'matchmade'   => $matchmade,
                  'workdays'    => $workdays
                );    
          
        }       
      
    }

    //$job_list_unique = array_unique($job_list);
    
    $job_list_unique = $job_list;
    
    $vals_new_job_id = array_count_values($job_list_unique);
  
  /*
    if($job_list_unique){
      foreach($job_list_unique as $jid_unique){
        $job_id = $jid_unique;
        $job_asigned_to_candi = get_post_meta($job_id,'job_asigned_list',true);
        $jobs_assign_to_dates = get_post_meta($job_id,'jobs_assign_to_dates',true);
        $jobs_assign_to_dates_array = explode(",",$jobs_assign_to_dates);
        //print_r($jobs_assign_to_dates_array);
        
        $user_info = get_userdata($job_asigned_to_candi);
        //print_r($user_info);
        $job_name = '<a href="post.php?post='.$jid_unique.'&action=edit">'. get_the_title($jid_unique).'</a>';
        $matchmade = '<a href="users.php?s='.$user_info->ID.'">'.$user_info->user_login.'</a>';
        
        
        
        
            $data[] =  array(
              'id'          => $jid_unique,
              'dentaloffice'=> get_the_author($jid_unique),
              //'jobname'     => get_the_title($jid_unique),
              'jobname'     => $job_name,
              'matchmade'   => $matchmade,
              'workdays'    => count($jobs_assign_to_dates_array)
            ); 
      }
    }
    */
  
  
  if($vals_new_job_id){
      foreach($vals_new_job_id as $jid_unique => $number_of_occurance){
         $job_id = $jid_unique;
        
        $job_asigned_to_candi = get_post_meta($job_id,'job_asigned_list',true);
        $jobs_assign_to_dates = get_post_meta($job_id,'jobs_assign_to_dates',true);
        $jobs_assign_to_dates_array = explode(",",$jobs_assign_to_dates);
        //print_r($jobs_assign_to_dates_array);
        
        $job_cat = wp_get_post_terms($job_id, 'cptjobsmanager_category');
         if($job_cat[0]->slug=='full-time'){
            $workdays = '';
          }
          if($job_cat[0]->slug=='part-time'){
            $workdays = $number_of_occurance;
          }
              
              
        
        $user_info = get_userdata($job_asigned_to_candi);
        //print_r($user_info);
        $job_name = '<a href="post.php?post='.$jid_unique.'&action=edit">'. get_the_title($jid_unique).'</a>';
        $matchmade = '<a href="users.php?s='.$user_info->ID.'">'.$user_info->user_login.'</a>';
        
        
        
        $auth = get_post($jid_unique); // gets author from post
        //print_r($auth);
        $authid = $auth->post_author; // gets author id for the post
        $user_firstname = get_the_author_meta('user_firstname',$authid); // retrieve firstname
        get_the_author_meta('display_name', $authid);

        
        
            $data[] =  array(
              'id'          => $jid_unique,
              'dentaloffice'=> get_the_author_meta('display_name', $authid),
              //'jobname'     => get_the_title($jid_unique),
              'jobname'     => $job_name,
              'matchmade'   => $matchmade,
              //'workdays'    => $number_of_occurance
              'workdays'    => $workdays
            ); 
      }
    }
  return $data;  
  }
  

  
  function column_default( $item, $column_name ) {
    switch( $column_name ) { 
      case 'dentaloffice':
      case 'jobname':
      case 'jobtype':
      case 'matchmade':
      case 'perdayamount':
      case 'workdays':
      return $item[ $column_name ];
      //case 'isbn':
      //return $item[ $column_name ];
      default:
      return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
    }
  }
  
  function column_cb($item) {
    return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
    );
  }
  

  
  function column_jobtype($item){
    //print_r($item);
    $selected_jobtype = get_post_meta($item['id'],'jobs_manager_jobtype',true);
    //print_r($selected_jobtype);
    return $selected_jobtype[0];
  }
  
  function column_perdayamount($item){
    $job_cat = wp_get_post_terms( $item['id'], 'cptjobsmanager_category');
    //print_r($job_cat[0]->slug);
    
    
    if($job_cat[0]->slug=='full-time'){
        echo "Permanent";
    }
    else{
          $selectedjobtype = get_post_meta($item['id'],'jobs_manager_jobtype',true);  
          $pricingpage = get_page_by_path('pricing');
          $pricingpage_ID =  $pricingpage->ID;
          
          
          if( have_rows('business_matches_positions',$pricingpage_ID) ){ 
              // $count=1;
                while ( have_rows('business_matches_positions',$pricingpage_ID) ) {
                        the_row();
                        $position_field_name = get_sub_field('dental_position_field_name');
                        
                        if (in_array($position_field_name, $selectedjobtype)) {                
                            echo $selected_item_rate = get_sub_field('dental_position_field_rate_per_day');
                        } else {
                            $selected_item_rate = ' ';
                        }              
                }    
          }
    }
    
  }
  
  
  function column_amountdue($item){
    
    /*
    $jobs_assign_to_dates = get_post_meta($item['id'],'jobs_assign_to_dates',true);
    $jobs_assign_to_dates_array = explode(",",$jobs_assign_to_dates);
    $jobs_assign_to_dates_count = count($jobs_assign_to_dates_array);
    */
    $jobs_assign_to_dates_count = $item['workdays'];
    //echo "HI";
    $selected_jb_type = get_post_meta($item['id'],'jobs_manager_jobtype',true);
    
    $pricingpage = get_page_by_path('pricing');
      $pricingpage_ID =  $pricingpage->ID;
      
    
    if( have_rows('business_matches_positions',$pricingpage_ID) ){ 
    // $count=1;
        while ( have_rows('business_matches_positions',$pricingpage_ID) ) {
                the_row();
                $position_field_name = get_sub_field('dental_position_field_name');
                
                if (in_array($position_field_name, $selected_jb_type)) {
                    if($jobs_assign_to_dates_count == ''){
                      
                      $selected_item_rate_month_basis = get_sub_field('dental_position_field_rate_per_month');
                      $total_amount = $selected_item_rate_month_basis;
                      echo $total_amount;
                      
                    }else{
                            $selected_item_rate = get_sub_field('dental_position_field_rate_per_day');
                            $selected_item_rate_w_o = str_replace("$","",$selected_item_rate);
                            $total_amount = $jobs_assign_to_dates_count*$selected_item_rate_w_o;
                            echo '$'.$total_amount;
                    }
                    
                    
                } else {
                    $selected_item_rate = ' ';
                }
                
        }    
    }
  }
  
}

//Add sub menu page to the Jobs Manager.
add_action('admin_menu', 'custom_submenu_under_jobs_menu');

function custom_submenu_under_jobs_menu() {
	if ( current_user_can( 'manage_options' ) )  {
		//add_users_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		add_submenu_page('edit.php?post_type=cptjobsmanager','Jobs Billing Report', 'Jobs Billing', 'read', 'jobs-billing-report', 'jobs_billing_report_function');
	      
	}
}

function jobs_billing_report_function(){
  $myListTable = new CustomUser_List_Table();
  
  //$userListTable->prepare_items();
  echo '<div class="wrap"><h2>My Billing List Table</h2>';
  
  $myListTable->prepare_items();
  ?>
  <div class="date_from_to_wrap">
    <?php
    if($_REQUEST['billing_startdate']){
      $billing_startdate = $_REQUEST['billing_startdate'];
    }
    if($_REQUEST['billing_enddate']){
      $billing_enddate = $_REQUEST['billing_enddate'];
    }
    
    ?>
    <form action="javascript:void(0);" method="get" name="search_by_start_end_date">
      <input name="jobs_billing_startdate" value="<?php echo $billing_startdate; ?>" class="startdate date_picker" placeholder="From(mm-dd-yyyy):" id="jobs_billing_startdate" type="text" required>
      <input name="jobs_billing_enddate" value="<?php echo $billing_enddate; ?>" class="enddate date_picker" placeholder="To(mm-dd-yyyy):" id="jobs_billing_enddate" type="text" required>
      <input id="search_start_end_button" class="button" type="button" name="" value="FILTER" />
    </form>
  </div>
  <?php
  $myListTable->display();
  
  echo '</div>'; 
}

/***********************7-12-2017 END***************/

      
    
//Startr for column with
function my_column_width() {
    echo '<style type="text/css">';
    echo '.column-featured_image { width:8%; }';
    echo '.column-title { width:20%; }';
    echo '.column-salary { width:15%; }';
    echo '.column-jobauthor { width:15%; }';
    //echo '.column-applied_user { width:15%; }';
    echo '.column-assigned_to { width:15%; }';
    echo '.column-total_user { width:15%; }';
    echo '.column-location { width:14%; }';
    echo '.column-startdate { width:15%; }';
    echo '.column-enddate { width:15%; }';
    echo '.asgn_div {display: inline-block;padding: 4px 15px;border: 1px solid #c5c5c5; position: relative;margin:6px 0;}';
    echo '.cancel_asign { position: absolute; right: 4px; top: -3px; text-decoration: none; color: red;}';
    echo '.asgn_div a.asgn_usr_name { color: #444; text-decoration: none;}';
    echo '</style>';
}
add_action('admin_head', 'my_column_width');
//End for column with


// to include files
include( plugin_dir_path( __FILE__ ) . 'frontend-job-manager.php');
?>