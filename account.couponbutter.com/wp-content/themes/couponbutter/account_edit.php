<?php 

/*
Template Name: account edit
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
//         <?php 
//         $q = "select * FROM wp_customer_details where parent_id=0 LIMIT 1";
//         $query=$wpdb->get_results($q);
// //print_r($query);
// foreach ($query as $value) {
//   $customer_id=$value->customer_id;
//   //print_r($customer_id);

//    }
//         ?>
       
        <li><a href="http://account.couponbutter.com/accountedit/"><span><i class="fa fa-user sz" aria-hidden="true"></i></span>My Account Edit </a></li>
       
<li class="my_list" id="my_list"><a href="http://account.couponbutter.com/changepassword/"><span><i class="fa fa-lock" aria-hidden="true"></i></span>Change Password</a>
</li>
       <li class="bill"><a href="http://account.couponbutter.com/billing/"><span><i class="fa fa-calculator" aria-hidden="true"></i></span>Billing</a></li>
        
        </ul>
        </div>
        </div><!---MAIN--COL-MD- 4-END---->
        <div class="col-md-9"><!---MAIN--COL-MD-START---->
        <div class="list_heading">Edit Account</div>
        <div class="mylist_table">
        <div class="all_form padding-left0">
       
         <?php
 if ( isset( $_SESSION['user_id'])){ 
  
  global $wpdb;

$table_name = $wpdb->prefix . "user_account";
$sql1="select * from $table_name where user_id= $_SESSION[user_id]";
//echo $sql1;
$row = $wpdb->get_results($sql1);
foreach($row as $rows)
{
 $_SESSION['account_id']=$rows->id;
 $_SESSION['bname']=$rows->business_name;
 $_SESSION['baddress']=$rows->business_address;
 $_SESSION['bsite']=$rows->business_website;

  }  
 }
}
?>
        
     
        <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="http://account.couponbutter.com/edit/">
    
    <div class="form-group niche">
   <div class="col-md-3">
   <p>Business Name </p>
   </div>
      <div class="col-md-8 padding-left0" id="mytarget">
        <input type="text" name="bname" class="form-control" id="bname" value="<?php echo $rows->business_name; ?>" readonly="readonly">
      </div>
      <div class="col-md-1 padding-left0" id="mytarget1">
      <a href="javascript:void(0);" class="btn btn-info makeEditable" id="makeEditable1">
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
      </div>
       <div class="col-md-1 padding-left0" id="mytarget2">
      <a href="javascript:void(0);" class="btn btn-info">
          <span id="update-account" data-uid="<?php echo $_SESSION['account_id'];  ?>" class="glyphicon glyphicon-ok-sign"></span>
        </a>
        </div>
      <div id="alert"></div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
   <p>Business Address</p>
   </div>
      <div class="col-md-8 padding-left0">
        <input type="text" name="baddress" class="form-control" id="address" value="<?php echo $rows->business_address; ?>" readonly="readonly">
      </div>      
      <div class="col-md-1 padding-left0" id="mytarget3">
      <a href="javascript:void(0);" class="btn btn-info makeEditable2" id="makeEditable2">
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
      </div>
      <div class="col-md-1 padding-left0" id="mytarget4">
      <a href="javascript:void(0);" class="btn btn-info">
          <span id="update-account-address" data-uid="<?php echo $_SESSION['account_id'];  ?>" class="glyphicon glyphicon-ok-sign"></span>
        </a>
      </div>
      <div id="alert1"></div>
    </div>
    <div class="form-group">
       <div class="col-md-3">
   <p>Business Website</p>
   </div>
      <div class="col-md-8 padding-left0">
        <input type="text" name="bsite" class="form-control" id="Business-Website" value="<?php echo $rows->business_website; ?>" readonly="readonly">
      </div>
      <div class="col-md-1 padding-left0" id="mytarget5">
      <a href="javascript:void(0);" class="btn btn-info" id="makeEditable3">
          <span class="glyphicon glyphicon-pencil"></span>
        </a>
      </div>
       <div class="col-md-1 padding-left0" id="mytarget6">
      <a href="javascript:void(0);" class="btn btn-info">
          <span id="update-account-website" data-uid="<?php echo $_SESSION['account_id'];  ?>" class="glyphicon glyphicon-ok-sign"></span>
        </a>
        </div>
      <div id="alert2"></div>
    </div>
     
    
    <!-- <div class="form-group">
       <div class="col-md-2">
   </div>
      <div class="col-md-10">
         <button type="submit" name="sub" class="btn btn-default submitss2">SUBMIT </button>
      </div>
    </div> -->
   

  </form>
   
  
        </div>
         
        </div><!---MAIN--COL-MD-8-END---->
        
        
        </div>
        </div><!---RIGHT MENU_SECTION_END---->
       
        </div>
        </div>
        
   </div>
   </div>

</section>




<?php get_footer();?>
