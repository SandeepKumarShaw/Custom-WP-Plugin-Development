<?php 

/*
Template Name: Home
*/
the_post();

?>

<?php get_header();
?>
<body class="main-indexs">
<section class="login_pages">
                   <div class="login_bx">
                          <div class="row first_row">
          <div class="col-md-12 logo_img">
              <div class="fist_login">
                          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-butter-logo.png" class="img-responsive center-block"/>
            </div>
       </div>


               <div class="col-md-12 line_bx">
                        <div class="line_cl"></div>
                 </div>



<div class="col-md-12 form_cl">
  <div class="form_login">
<?php 
global $wpdb;
$err = '';  
if(isset($_POST['Login']))
{
	$username = $wpdb->escape($_POST['log']);
	$password = $wpdb->escape(($_POST['pwd']));      

	if( $username == "" || $password == "" ) {
	    $err = 'Please don\'t leave the required field.';
	} 
	else {        
		$user = get_user_by( 'login', $username );		

		if( $user && wp_check_password( $password, $user->data->user_pass, $user->ID) ){
			
		$current_user = wp_set_current_user( $user->ID, $username );
		
		$role_name      = $current_user->roles[0];
		

			if ( 'subscriber' === $role_name ) {

				wp_redirect('http://account.couponbutter.com/account/');
				$_SESSION['user_id'] = $user->ID;
                                $_SESSION['username'] = $user->user_email;
				exit;

			}
			else{
				$err = 'Username or password wrong.';
				
			}


		
		}
		else{
		 $err = 'Wrong username/Password.';
		}
	}
}

?>

<form role="form" action="" method="post">
<p>
      <?php 
      if( !empty($err) )
        echo $err;        
      
      ?>
    </p>
    <div class="form-group mgtp">
      <div class="input_filds">
        <i class="fa fa-user usersa" aria-hidden="true"></i>
        <input type="text" name="log" class="form-control form_hover" id="email" placeholder="username">
      </div>
    </div>
    
    <div class="form-group mgtp">
      <div class="input_filds">
          <i class="fa fa-lock usersa" aria-hidden="true"></i>
          <input type="password" name="pwd" class="form-control form_hover" id="pwd" placeholder="password">
      </div>
    </div>
    <input type="submit" name="Login" value="Login" class="btn btn-danger btn_red" />
   <!-- <a href="#"><button type="button" class="btn btn-danger btn_red">LOGIN</button></a> -->
</form>
</div>
</div>

            <div class="col-md-12 forget_psw">
            <?php
//$url="http://".$_SERVER['HTTP_HOST']."/forgot-password/";
//echo $url;
         $url= "http://account.couponbutter.com/forgot-password/";

   ?>
                     <p><a href="<?php echo $url;?>";>Forgot your password?</a></p>
            </div>
</div>
</div>
</section>
<?php get_footer(); ?> 
