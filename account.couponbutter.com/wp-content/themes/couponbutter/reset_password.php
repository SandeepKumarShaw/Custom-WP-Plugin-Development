<?php
/*
Template Name: Password Reset 
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



<div class="col-md-12 form_cl">
  <div class="form_login">
  <?php  
if(!isset($_SESSION['user_email'])):
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect('http://account.couponbutter.com/');
     exit();
endif; ?>
<?php 



if(isset($_GET['email'])&& isset($_POST['ResetPassword'])){
  $x=$_GET['email'];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  
  //$password = preg_replace("/[^a-zA-Z0-9]+/", "", $password);
  //$confirmpassword = preg_replace("/[^a-zA-Z0-9]+/", "", $confirmpassword);

    if ($password == $confirmpassword){
      global $wpdb;
      $hash = wp_hash_password( $password );
      $table_name = $wpdb->prefix . "users";
      $sql="UPDATE $table_name SET user_pass='".$hash."' where user_email='".$x."'";
      //echo $sql;
      //die;
      $result = $wpdb->query($sql);
      if ($result){
         

    $user = get_user_by( 'login', $x );    

    if( $user && wp_check_password( $password, $user->data->user_pass, $user->ID) ){
      
    $current_user = wp_set_current_user( $user->ID, $username );
    
    $role_name      = $current_user->roles[0];
    

      if ( 'subscriber' === $role_name ) {

        wp_redirect('http://account.couponbutter.com/account/');
        $_SESSION['user_id'] = $user->ID;
        $_SESSION['username'] = $user->user_email;
        exit;

      }




       //wp_redirect("http://account.couponbutter.com/log-out/");
      }
    }
    else{
      $error_message = 'Password and Confirm password Does not match!';
      }
    }
}
?>
                  
<form role="form" action="" method="post">
<h2>Reset Password?</h2>
  <?php if(!empty($success_message)) { ?>
  <div class="success_message">
  <?php echo $success_message; ?></div>
  <?php } ?>

  <div id="validation-message">
    <?php if(!empty($error_message)) { ?>
  <?php echo $error_message; ?>
  <?php } ?>
  </div>
    <div class="form-group mgtp">
      <div class="input_filds">
          <i class="fa fa-lock usersa" aria-hidden="true"></i>
          <input type="password" name="password" class="form-control form_hover" id="pwd" placeholder="New Password">
      </div>
    </div>
    <div class="form-group mgtp">
      <div class="input_filds">
          <i class="fa fa-lock usersa" aria-hidden="true"></i>
          <input type="password" name="confirmpassword" class="form-control form_hover" id="pwd" placeholder="Confirm Password">
      </div>
    </div>
    
   
    <input type="submit" name="ResetPassword" value="Reset Password" class="btn btn-danger btn_red" />
   <!-- <a href="#"><button type="button" class="btn btn-danger btn_red">LOGIN</button></a> -->
</form>
</div>
</div>

           
</div>
</div>
</section>

<?php get_footer(); ?> 
