<?php
/*
Template Name: Forgot Password 
*/
?>
<?php get_header();?>

<body>
<section class="login_pages">
                   <div class="login_bx">
                          <div class="row first_row">
          <div class="col-md-12 logo_img">
              <div class="fist_login">
                          <img src="<?php bloginfo('template_directory'); ?>/images/coupon-butter-logo.png" class="img-responsive center-block"/>
            </div>
       </div>


               <div class="col-md-12 line_bx">
                        <div class="line_cl"></div>
                 </div>


<?php 
global $wpdb;
$success_message = ''; 
$error_message = '';  

	if(isset($_POST['forgot-password']))
	{
	//We shall SQL escape all inputs to avoid sql injection.
	$useremail = $wpdb->escape($_POST['email']);


		if( $useremail == "") {
		$error_message = 'Please don\'t leave the required field.';
		} 
		else { 

		$table_name = $wpdb->prefix . "users"; 
		$sql = "SELECT * FROM $table_name WHERE user_email='".$_POST['email']."'";   
		//$wpdb->get_results($sql);
		$result = $wpdb->get_results($sql); 
        foreach ($result as $results){  
        $user_id    = $results->ID;
        $email      = $results->user_email;
        $current_user = wp_set_current_user( $results->ID, $username );  
        $from = "coupons@couponbutter.com";
        $headers = "From: " . strip_tags($from) . "\r\n";
  		$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
  		$headers .= "CC: coupons@couponbutter.com\r\n";   
        $role_name  = $current_user->roles[0];
        if( 'subscriber' === $role_name ) {
        $_SESSION['user_id']  = $user_id;
        $_SESSION['user_email']  = $email;
        
        $code=rand(100,999);	
        $message    ="You activation link is: http://account.couponbutter.com/password-reset/?email=$email&code=$code";
		mail($email, "Password Reset", $message,$headers);
		$success_message = "Please check your Email ";
	    }
        else{
			$error_message = 'No user exist with this email id';

		}


        }
		/*$count= $wpdb->num_rows;
			if($count==1){
			$email=$_POST['email'];
			$code=rand(100,999);
			$message="You activation link is: http://account.couponbutter.com/password-reset/?email=$useremail&code=$code";
			mail($email, "Subject Goes Here", $message);
			$success_message = "Please check your Email ";
			}*/
			


		}
	}

?>
<div class="col-md-12 form_cl">
  <div class="form_login">
  
                  
<form role="form" action="" method="post">
<h2>Forgot Password?</h2>
	<?php if(!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if(!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>
    <div class="form-group mgtp">
      <div class="input_filds">
        <i class="fa fa-user usersa" aria-hidden="true"></i>
        <input type="email" name="email" class="form-control form_hover" id="email" placeholder="abc@couponbutter.com">
      </div>
    </div>
    
   
    <input type="submit" name="forgot-password" value="Forgot Password" class="btn btn-danger btn_red" />
   <!-- <a href="#"><button type="button" class="btn btn-danger btn_red">LOGIN</button></a> -->
</form>
</div>
</div>

           
</div>
</div>
</section>

<?php get_footer(); ?> 
