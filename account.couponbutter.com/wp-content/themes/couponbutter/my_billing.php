<?php 

/*
Template Name: My Billing
*/

?>
<?php get_header();?>
<body>
<?php  
if(!isset($_SESSION['user_id'])){
   //header("Location: http://localhost/account.couponbutter.com/");
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
        </section>
        <section>
        
        <div class="my_acc">
         <div class="container">
       <div class="row act_act">
       
        <div class="col-md-12 act1">
        <div class="active_copn">
        <p><a href="http://account.couponbutter.com/active-coupon/ ">Active Coupons</a></p>
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
        <div class="col-md-9">
          <div class="billings">
       <div class="active_setting_bx" id="active2">
        <p>Your Current Membership Status</p>
        </div>
        

<div class="biiling-page-bx">

<div class="ful_bxc" id="two22">
<div class="ful-bx-in">
<div class="row">
<div class="col-md-12">
<?php 
global $wpdb;
//$wpUserID = $_SESSION['user_id'];
$sql = "select * from wp_fullstripe_members where wpUserID='".$_SESSION['user_id']."'";
$result = $wpdb->get_results($sql);
foreach ($result as $results) {
  $stripeCustomerID = $results->stripeCustomerID;
   $stripeSubscriptionID = $results->stripeSubscriptionID;
}

 //print_r($stripeCustomerID);

?>
<?php 
 
 Stripe::setApiKey("sk_live_3Emb6wzItnTSdpRLNk5cfOwy");
  //Create Customer
  try {
        
$customer_info = Stripe_Customer::retrieve($stripeCustomerID);
$sub_id = $customer_info->subscriptions->data[0]->plan; 
$sub_id2 = $customer_info->subscriptions->data[0]->current_period_end;
$sub_id3 = $customer_info->subscriptions->data[0]->status; 
$plan              = $sub_id->name;
$Amount            = $sub_id->amount;
$amount            = $Amount/100.0; 
$interval          = $sub_id->interval;
$interval_count    = $sub_id->interval_count;       
$next_payment_date = date('m/d/Y',$sub_id2);
       
       //print_r($customer_info);

        
  }
  catch (Exception $e) {
    $error = $e->getMessage();

  }

?>
<div class="row">
  <div class="col-md-7">
    <div class="pricr-tx">
      <p>Membership Level </p>
    </div>
  </div>
  <div class="col-md-5">
    <div class="my-current-acct">
      <p><?php echo $plan; ?></p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="pricr-tx">
      <p>Membership Price </p>
    </div>
  </div>
  <div class="col-md-5">
    <div class="my-current-acct">
      <p>$<?php echo $amount; ?> per <?php echo $interval_count .' '. $interval; ?></p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="pricr-tx">
      <p>Next Billing Date </p>
    </div>
  </div>
  <div class="col-md-5">
    <div class="my-current-acct">
      <p><?php echo $next_payment_date; ?></p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="pricr-tx">
      <p>Membership Status </p>
    </div>
  </div>
  <div class="col-md-5">
    <div class="my-current-acct">
      <p><?php echo $sub_id3; ?></p>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>


<div class="active_setting_bx" id="active3">
        <p>Upgrade/Downgrade Subscription</p>
        </div>
<div class="ful_bxc">
<div class="ful-bx-in">
<div class="row">
<div class="col-md-12">

<div class="row">
<div class="col-md-12" id="change">

</div>
<div class="col-md-7 div7">
<div class="form-group">
 <label class="control-label col-sm-4 new-lev" for="pwd">Select New Membership:</label>
  <div class="col-sm-6">
  <?php 
 
  global $wpdb;
$row = "select * from wp_fullstripe_members where wpUserID='".$_SESSION['user_id']."'";
$result = $wpdb->get_results($row);
foreach ($result as $results) {
  $abc = $results->plan;
  //print_r($abc);
}




  ?>
  <select class="form-control fullstripe_plan" id="sel1" name="fullstripe_plan" data-plan="<?php echo $abc?>">
    
         <!--  <?php //foreach ( $plans as $plan ): ?>
            <option value="<?php ?>"
                    data-value="<?php  ?>"
                    data-amount=""
                    data-interval=""
                    data-interval-count=""
                    data-currency="">
              <?php //echo "hi"; ?>
            </option>
          <?php //endforeach; ?> -->
          <?php 
 
  global $wpdb;
$row = "select * from wp_fullstripe_members where memberID='".$_SESSION['user_id']."'";
$result = $wpdb->get_results($row);
foreach ($result as $results) {
  $abc = $results->plan;
  print_r($abc);
}
?>
           <option value="<?php echo "CBInd"; ?>" id="<?php echo $abc?>" class="<?php echo "499"; ?>">Coupon Butter Individual</option>
          <option value="<?php echo "CBDev"; ?>" id="<?php echo $abc?>" class="<?php echo "2999"; ?>">Coupon Butter Developer</option>
        </select>
    
  
</div>

</div>

<div class="pricr-tx">
<p class="ind">price is $4.99 per months </p>
<p class="dev">price is $29.99 per months </p>
</div>
</div>

<div class="col-md-5">

<div class="pricrde-btn">
<button type="button" class="btn btn-danger pricrss-bnts" 
id="Change-membership">Change Membership</button>
</div>

<div class="change-member-tx-tx">

</div>
</div>
</div>
</div>
</div>
</div>
</div>



<div class="active_setting_bx" id="active4">
        <p>Update Card Details </p>
        </div>
<div class="ful_bxc" id="two21">
<div class="ful-bx-in">
<div class="row">
<div class="col-md-12">

<div class="row">
<div class="col-md-7">

<div class="pricr-tx">
<p>You can update your card details here </p>
</div>

</div>

<div class="col-md-5">
<div class="pricrde-btn update-dharam-class">
<form action="http://account.couponbutter.com/update-billing/" method="POST">
  <script
  src="https://checkout.stripe.com/checkout.js" class="stripe-button pricrss-bnts"
  data-key="pk_live_ClLRZli36EeVil1djjaLC05a"
  data-image="<?php get_template_directory(); ?>/wp-content/themes/couponbutter/images/coupon-butter-logo.png"
  data-name="CouponButter"
  data-panel-label="Update Credit Card"
  data-label="Update Your Card"
  data-allow-remember-me=false
  data-locale="auto">
  </script>
</form>
<!-- <button type="button" class="btn btn-danger pricrss-bnts">Update Credit Card</button> -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php 
/*$plan_id = 1;
$customer_id = 'cus_9RG323LaBxgIfE';
$row1 = "UPDATE wp_fullstripe_members SET 
plan = '".$plan_id."' WHERE stripeCustomerID = '".$customer_id."'";

$row2 = "UPDATE wp_fullstripe_subscribers SET 
planID = '".$plan_id."' WHERE stripeCustomerID = '".$customer_id."'";

echo $row1;
echo '<br/>';
echo $row2;
*/
?>
<div class="active_setting_bx" id="active6">
        <p>Cancel Membership</p>
        </div>
<div class="ful_bxc" id="th3">

<div class="ful-bx-in">

<div class="row">
<div class="col-md-12">

<div class="row">
<div class="col-md-12" id="cancel">
<div id="message"></div>
</div>
<div class="col-md-7">
<div class="pricr-tx" id="three3">
<p>You can cancel your membership anytime by clicking cancel membership button </p>
</div>

</div>

<div class="col-md-5">
<div class="pricrde-btn">
<button type="button" class="btn btn-danger pricrss-bnts" id="cancel-membership">Cancel Membership</button>

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>




        <div class="register_form">
        <div class="row">
<?php 
 
/* Stripe::setApiKey("sk_test_zzHb4IbXw2av5dgQWu3LnfO5");
  //Create Customer
  try {
        $customer_id="cus_9RG323LaBxgIfE";
        $plan_id=1;
        $customer_info = Stripe_Customer::retrieve($customer_id);
        $card_id      = $customer_info->default_source;
        print_r($customer_info);

        
  }
  catch (Exception $e) {
    $error = $e->getMessage();

  }*/

?>
<div class="col-md-12">
<div class="cancel">

</div>

        


        </div>
        
        </div>
        
        
        </div>
        </div>
        </div>
       
        </div>
        </div>
        
   </div>

</section>
<?php } ?>
<?php get_footer();?>