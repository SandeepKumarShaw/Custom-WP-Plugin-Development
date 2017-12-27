<?php
/*
 *Plugin Name: Our Cron Jobs
 *Description: This cron jobs will help us to delete posts automatically with a scheduling time repetedly.
*/

register_activation_hook(__FILE__, 'my_activation');

function my_activation() {
    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'myprefix_cron_hook' ) ) {
	wp_schedule_event( time(), 'every_six_hours', 'myprefix_cron_hook' );
    }
}

function myprefix_custom_cron_schedule( $schedules ) {
    $schedules['every_six_hours'] = array(
        'interval' => 21600, // Every 6hours
        'display'  => __( 'Every 6 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

///Hook into that action that'll fire every six hours
 add_action( 'myprefix_cron_hook', 'myprefix_cron_function' );

//create your function, that runs on cron
function myprefix_cron_function() {    
     $to = 'dev@ironspringsdesign.com';
    $subject = 'Test my 3-minute cron job';
    $message = 'If you received this message, it means that your 3-minute cron job has worked! <img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/2.3/svg/1f642.svg"> ';
 
    wp_mail( $to, $subject, $message );
    
    $current_date =  date("Y-m-d");
    
    
     $seeker_end_date_search_field[] = array(
	'key' => 'jobs_manager_enddate', 
	'value' => $current_date,
	'compare' => '<'
       // 'type' => 'DATE'
    );
     
     global $wpdb, $post;
	$args = array(
		'post_type' => 'cptjobsmanager',
		'posts_per_page' => -1,
		'meta_query' => array(
		    $seeker_end_date_search_field
		)
	);
    $posts_arrays = get_posts( $args );

	// Cycle through each Post ID
	
	foreach ($posts_arrays as $posts_array) {
	    
	    $args = array (
		'role'       => 'job_seeker',		
		'meta_query' => array(
		    'relation' => 'OR',
		    array(
			'key'     => 'asgnd_to_job',
			'value'   => $posts_array->ID,
			'compare' => 'LIKE'
		    ),
		    array(
			'key'     => 'users_applied_job',
			'value'   => $posts_array->ID,
			'compare' => 'LIKE'
		    )
		)
		
	    );
	    // Create the WP_User_Query object
	    $wp_user_query = new WP_User_Query( $args );
	    
	    // Get the results
	    $u_list = $wp_user_query->get_results();
	    foreach ( $u_list as $single_u_list ) {	
		
		if(get_user_meta($single_u_list->ID, 'users_applied_job',true)){
		    $users_applied_job = get_user_meta($single_u_list->ID, 'users_applied_job',true);
		    $users_applied_job_array = explode(",",$users_applied_job);
		    
		    $key = array_search($posts_array->ID, $users_applied_job_array);
		   
		    unset($users_applied_job_array[$key]); // remove item at index 0
		    $users_applied_job_array_new = array_values($users_applied_job_array); // 'reindex' array
		    if($users_applied_job_array_new){
			 $users_applied_job_array_new = implode(",",$users_applied_job_array_new);
			update_user_meta($single_u_list->ID, 'users_applied_job',$users_applied_job_array_new);
		    }
		    else{
			delete_user_meta($single_u_list->ID, 'users_applied_job');
		    }
		   
		}
		
		if(get_user_meta($single_u_list->ID, 'asgnd_to_job',true)){
		    
		    delete_user_meta($single_u_list->ID, 'asgnd_to_job');
		}
	    } 
	    
	    // Update post 37
	      $my_post = array(
		  'ID'          => $posts_array->ID,
		  'post_type'   => 'cptjobsmanager',
		  'post_status' => array('draft')
	      );
	    
	    // Update the post into the database
	     // wp_update_post( $my_post );
	      //wp_trash_post($posts_array->ID);
	      wp_delete_post($posts_array->ID);
	}
}


register_deactivation_hook(__FILE__, 'my_deactivation');

function my_deactivation() {
	wp_clear_scheduled_hook('myprefix_cron_hook');
}
?>