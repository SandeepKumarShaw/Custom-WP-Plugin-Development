<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url');  ?>/img/favicon.ico">
<link rel="profile" href="//gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<header class="header">
  <div class="top-bar">
    <div class="row">
      <div class="top-bar-left medium-2"><a href="<?php echo get_site_url(); ?>" class="logo"><img src="<?php bloginfo('template_url');  ?>/img/logo.png" alt="no-logo"></a></div>
      <div class="top-bar-right medium-10">
      <div class="column">  
			<?php //if(is_active_sidebar('header_signin')) { dynamic_sidebar('header_signin'); } ?>
			<?php
				/********get  current user role*********/
				$current_user   = wp_get_current_user();
				$role_name      = $current_user->roles[0];
				//echo $role_name;
			?>
			<ul class="menu text-right topMenu">
			    <li><?php if(!is_user_logged_in()){ ?>
					<a href="<?php echo get_permalink(get_page_by_path('user-lists')); ?>">Login</a>
					<?php }				
					elseif($role_name == 'job_seeker' || $role_name == 'job_provider') { ?>
					<a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
					<?php } else{?>
					<a href="<?php echo wp_logout_url(); ?>">Logout</a>
					<?php } ?>
			    </li>
			    <li><?php if(!is_user_logged_in()){ ?>
						<a href="<?php echo get_permalink(get_page_by_path('register')); ?>">Register</a>
						<?php	} else{ ?>						
						  <?php if( $role_name == 'job_seeker' ) { ?>
						    <a href="<?php echo get_permalink(get_page_by_path('job-listing')); ?>">Dashboard</a>
						  <?php } ?>
						  <?php if( $role_name == 'job_provider' ) { ?>
						    <a href="<?php echo get_permalink(get_page_by_path('user-lists')); ?>">Dashboard</a>
						  <?php } ?>
						<?php } ?>
			    </li>
					<li>
					<?php if( $role_name == 'job_seeker' ) { ?>
						<a href="<?php echo get_permalink(get_page_by_path('job-listing')); ?>">View Jobs</a>
					<?php } ?>
					<?php if( $role_name == 'job_provider' ) { ?>
						<a href="<?php echo get_permalink(get_page_by_path('job-listing')); ?>">Manage Jobs</a>
					<?php } ?>
					</li>

				<?php if(is_user_logged_in()){ ?>	
			    <li class="signinuser_credential">
						<div class="signin_details">
							<?php
								$current_user = wp_get_current_user();
                $current_user_role = $current_user->roles[0];
								//echo 'Username: ' . $current_user->user_login . '<br />';
								//echo 'User email: ' . $current_user->user_email . '<br />';
								//echo 'User first name: ' . $current_user->user_firstname . '<br />';
								//echo 'User last name: ' . $current_user->user_lastname . '<br />';
								//echo 'User display name: ' . $current_user->display_name . '<br />';
								//echo 'User ID: ' . $current_user->ID . '<br />';
								//echo $current_user->user_firstname.' '.$current_user->user_lastname.'('.$current_user->user_login.')';
								//echo '<a href="'.wp_lostpassword_url( get_permalink() ).'" title="Lost Password">Lost Password</a>';
							?>
                                                        
							<div class="useravatar">
								<a href="<?php echo site_url().get_option('view_profile_url_after_login');?>" title="View my Profile">
								<?php //echo get_avatar( $current_user->ID, 32, $default, $alt, $args ); ?>
								<?php echo get_avatar( $current_user->ID, 32 ); ?>
								</a>
							</div>
							<div class="user_other_infos" style="display: none;">
								<p class="username"><?php echo $current_user->user_firstname.' '.$current_user->user_lastname.'('.$current_user->user_login.')'; ?></p>
								<p class="useremail"><?php echo $current_user->user_email; ?></p>
								<p class="editprofile"><a href="<?php echo site_url().get_option('edit_profile_url_after_login');?>">Edit My Profile</a></p>
							</div>
						</div>
					</li>
				<?php } ?>	
					
			</ul>
      </div>
        <div class="column">
	<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium" data-responsivetoggle="1g2ylu-responsivetoggle">
	  <button class="menu-icon" type="button" data-toggle=""></button>
	  <div class="title-bar-title">Menu</div>
	</div>
	 <div id="main-menu" class="top-bar">
		 <?php
		// Main Menu 
	    wp_nav_menu( array(
						   'container' => '',
						   'theme_location' => 'primary',
						   'items_wrap' => '<ul id="%1$s" class="menu dropdown mainMenu" data-responsive-menu="drilldown medium-dropdown" data-accordionmenu="i6f55a-accordionmenu" data-responsivemenu="4m3axf-responsivemenu">%3$s</ul>'
						   ));
	    ?>
	  </div> 
        </div>
      </div>
    </div>
  </div>
  </header>
<?php if( is_page( array( 'user-lists', 'user-details', 'job-providers', 'job-seekers', 'job-listing', 'job-post-form', 'login-now', 'sign-up-for-dental-offices', 'sign-up-for-candidates', 'edit-my-profile', 'view-my-profile', 'forgot-password','reset-password') ) ) { ?>
<div class="bannerSecNull"></div>
<?php } else { ?>
<div class="orbit bannerSec">
    <div class="bannerCont">
	<?php if( is_front_page() ){ ?>
	  <div class="homeTitle">
	  <?php echo get_field('page_title'); ?>
	  </div>
	<?php }elseif(is_404()){ ?>
	 <div class="homeTitle">
	  <h1>Oops! That page can’t be found.</h1>
	 </div>
	<?php }else{ ?>
	  <div class="innerTitle">
	  <h2><?php if(get_field('page_title')){ echo get_field('page_title'); }else{ the_title(); } ?></h2>
	  </div>
	<?php	} ?>
    </div>
  </div>
<?php	} ?>
