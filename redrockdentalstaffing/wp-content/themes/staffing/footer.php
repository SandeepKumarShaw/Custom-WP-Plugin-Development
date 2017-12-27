<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<footer>
    <div class="row">
      <div class="small-6 large-4 columns">
	    <ul class="menu vertical">
              <?php
              /********get  current user role*********/
              $current_user   = wp_get_current_user();
              $role_name      = $current_user->roles[0];
              ?>
		  <li>
			<?php if(!is_user_logged_in()){ 
			?>
			      <a href="<?php echo get_permalink(get_page_by_path('register')); ?>">Register</a>
			<?php
			}
			else{		      
				
			      if( $role_name == 'job_seeker' ) { ?>
				    <a href="<?php echo get_permalink(get_page_by_path('job-listing')); ?>">Candidate Dashboard</a>
			      <?php } ?>
			      <?php if( $role_name == 'job_provider' ) { ?>
				    <a href="<?php echo get_permalink(get_page_by_path('user-lists')); ?>">Employer Dashboard</a>
			      <?php } ?>
			<?php } ?>
			
		  </li>
		  <li>
			<?php if(!is_user_logged_in())
			{
			?>
			      <a href="<?php echo get_permalink(get_page_by_path('user-lists')); ?>">Login</a>
			      <?php
			}
			else
			{ ?>
			      <a href="<?php echo wp_logout_url(); ?>">Logout</a>
			<?php }?>
		  </li>
		  <li><a href="https://redrockdentalstaffing.com/services/">How It Works</a></li>
                  <?php if( $role_name == 'job_provider' ) { ?>
		  <li><a href="https://redrockdentalstaffing.com/user-lists/">Find A Pro</a></li>
                  <?php } ?>
                  
                  <?php if( $role_name == 'job_seeker' ) { ?>
		  <li><a href="https://redrockdentalstaffing.com/job-listing/">Find A Job</a></li>
                  <?php } ?>
		  <?php if( is_user_logged_in() ) : ?>
		  <li><a href="<?php echo site_url().get_option('view_profile_url_after_login');?>" title="View My Profile">View my Profile</a></li>
		  <li><a href="<?php echo site_url().get_option('edit_profile_url_after_login');?>" title="Edit My Profile">Edit My Profile</a></li>
		  <?php endif; ?>
		  <?php /* 
		  echo '<li>';
			$args = array( 'menu' => 'Custom Menu', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '', 'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'item_spacing' => 'preserve',
 'depth' => 0, 'walker' => '', 'theme_location' => '' );
			wp_nav_menu( $args );
		  echo '</li>';
		  */ ?>
	    </ul>
      </div>
      <div class="small-6 large-4 columns text-center">
            <?php if(is_active_sidebar('footer_logo')) { dynamic_sidebar('footer_logo'); } ?>
      </div>
      <div class="small-6 large-4 columns text-center socialMedia">
            <?php if(is_active_sidebar('footer_contact_social')) { dynamic_sidebar('footer_contact_social'); } ?>
      </div>
    </div>
    <div class="row column">
            <?php if(is_active_sidebar('footer_copy')) { dynamic_sidebar('footer_copy'); } ?>
    </div>
  </footer>
    <script>
      jQuery(document).foundation();
    </script>
    <?php wp_footer(); ?>
  </body>
</html>