<?php 

/*
Template Name: Change Password
*/

?>
<?php get_header();
?>


<body>
<?php  
if(!isset($_SESSION['user_id'])){
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect("http://account.couponbutter.com/");
     exit();
}    
else{?>
<section class="first_my_acont">


<div class="mainsheader">

        <div class="container">
                   <div class="row strt" id="frsts_sc">
           <div class="col-md-12 sc_logo">
             <div class="sc_logos_in">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-butter-logo.png" class="img-responsive"/>
        </div>
        </div>
        </div></div>
        </div>

<div class="menu_header">
             <div class="container">
             <div class="row strt">
             
             <div class="col-md-5">
             <div class="header_tx">
                  <p>My Account</p>
             </div>
             </div>
 
           <?php include( get_template_directory() . '/menu_header.php'); ?>
        
        <div class="my_acc">
         <div class="container">
        <div class="row act_act">
       
        <div class="col-md-12 act1">
        <div class="active_copn">
        <p><a href=" http://account.couponbutter.com/active-coupon/ ">Active Coupons</a></p>
        </div>
        <div class="col-md-12 pd">
        <div class="active_setting_bx">
        <p>Active setting box</p>
        </div>
        </div>
        </div>
        </div>
      
        



        <div class="stc_brd">
        <div class="right_menu_section">
        <div class="row">
        <div class="col-md-3"><!---MAIN--COL-MD4-START---->
        <div class="right_menu_list">
        <ul>
       
         <!-- <li><a href="http://account.couponbutter.com/accountedit/"><span><i class="fa fa-user sz" aria-hidden="true"></i></span>My Account Edit </a></li> -->
       
<li class="my_list" id="my_list"><a href="http://account.couponbutter.com/changepassword/"><span><i class="fa fa-lock" aria-hidden="true"></i></span>Change Password</a>
</li>
       <li class="bill"><a href="http://account.couponbutter.com/billing/"><span><i class="fa fa-calculator" aria-hidden="true"></i></span>Billing</a></li>
        
        </ul>
        </div>
        </div><!---MAIN--COL-MD- 4-END---->
        <div class="col-md-9"><!---MAIN--COL-MD-START---->
        <div class="all_form padding-left0">
      <p>
      <?php 
     
      if( !empty($err) ){
        echo $err;        
      }
      
      ?>
    </p>
   
<?php 

if(isset($_POST['cpass']))
{
    $err = ''; 
  $username = $_SESSION['username'];
  $oldpassword = $_POST["oldpassword"];
  $password = $_POST["newpassword"];
  $confirmpassword = $_POST["cnfpassword"];

  if( empty($oldpassword) && empty($password) && empty($confirmpassword) ) {
      echo $err = 'Please don\'t leave the required field.';
  } 
  else{
    $user = get_user_by( 'login', $username );    
    if( $user && wp_check_password( $oldpassword, $user->data->user_pass, $user->ID) ){

      if ($password == $confirmpassword) {

      global $wpdb;
      $hash = wp_hash_password( $password );
      $table_name = $wpdb->prefix . "users";
      $sql="UPDATE $table_name SET user_pass='".$hash."' where user_email='".$username."'";      
      $result = $wpdb->query($sql);
      if ($result){
        echo $err = 'Password Change successfully.';
      }
      }
      else{
        echo $err = 'New Password and Confirm password not matched.';
      }

    }
    else{
      echo $err = 'Please enter valid Old password.';
    }
  }
}
  ?>
   
  
        <form class="form-horizontal" id="changepassword" role="form" method="POST" action="">
    

    <div class="form-group niche">
   <div class="col-md-3">
   <p>Old Password </p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="password" name="oldpassword" class="form-control" id="oldpassword"> 
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
   <p>New Password</p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="password" name="newpassword" class="form-control" id="newpassword">
      </div>
    </div>
    <div class="form-group">
       <div class="col-md-3">
   <p>Confirm Password</p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="password" name="cnfpassword" class="form-control" id="cnfpassword"> 
      </div>
    </div>
    
    <div class="form-group">
       <div class="col-md-2">
   </div>
      <div class="col-md-10">
         <a><button type="submit" name="cpass" class="btn btn-default myaccountsubmit submitss2 change-password">Change Password</button></a>
      </div>
    </div>
   

  </form>
  
        </div>
         
        </div><!---MAIN--COL-MD-8-END---->
        
        
        </div>
        </div><!---RIGHT MENU_SECTION_END---->
       
        </div>
        </div>
        
   </div>
   
</section>

 <?php } ?>     
     



<?php get_footer();?>
