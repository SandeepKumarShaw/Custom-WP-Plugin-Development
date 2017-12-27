<?php 

/*
Template Name: Account
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

<?php 
  global $wpdb;

$uresult=$wpdb->get_results("SELECT user_email FROM wp_users WHERE ID='".$_SESSION['user_id']."'");
foreach ($uresult as $uresults) {
 $uemail=$uresults->user_email;
}

$rest=$wpdb->get_results("SELECT  wp_fullstripe_subscribers.planID
FROM  wp_fullstripe_subscribers
LEFT JOIN wp_users
ON wp_fullstripe_subscribers.email=wp_users.user_email WHERE wp_users.user_email='".$uemail."'");
foreach ($rest as $rests) {
 $plan_id=$rests->planID;
 $_SESSION['plan_id']=$plan_id;

}
?>

  <?php
 
 if ( isset( $_POST['bname'])){ 
  $bname=trim($_POST['bname']);
//echo $bname;
 $baddress=$_POST['baddress'];
 $bsite=$_POST['bsite'];
  global $wpdb;

//die;
$table_name = $wpdb->prefix . "user_account";
//echo $table_name;
//die;
$sql1="select user_id from $table_name";
$row = $wpdb->get_results($sql1);
foreach($row as $row1)
  {
  $narray[]=$row1->user_id;

}
  
foreach ($narray as $account_id1) {

if($account_id1==$_SESSION['user_id'])
{
 $updid=$account_id1;

}elseif($_SESSION['user_id'])
{
 $insid=$_SESSION['user_id'];
}

}


if($updid)
{

 $sql="UPDATE $table_name SET business_name='".$bname."', business_address='".$baddress."',business_website='".$bsite."',user_plan='".$_SESSION['plan_id']."' WHERE user_id='".$updid."'";
 echo $sql;
 $query = $wpdb->query($sql);
  
}else if($insid)
{
 
  $sql5="INSERT INTO $table_name SET business_name='".$bname."', business_address='".$baddress."',business_website='".$bsite."',user_id='".$insid."',user_plan='".$_SESSION['plan_id']."'";
  echo $sql5;
       $res = $wpdb->query($sql5);

}
     //}
       } }

        ?> 
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
       
        <!-- <li><a href="http://account.couponbutter.com/accountedit/"><span><i class="fa fa-user sz" aria-hidden="true"></i></span>My Account Edit</a></li> -->
      <?php include( get_template_directory() . '/sublist.php'); ?>
       <li class="bill"><a href="http://account.couponbutter.com/billing/"><span><i class="fa fa-calculator" aria-hidden="true"></i></span>Billing</a></li>
        
        </ul>
        </div>
        </div><!---MAIN--COL-MD- 4-END---->
        <div class="col-md-9"><!---MAIN--COL-MD-START---->
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
 $rows->id;
 $rows->business_name;
 $rows->business_address;
 $rows->business_website;

  }  
 }

?>
     
       <!--  <form class="form-horizontal" id="AccountForm" enctype="multipart/form-data" role="form" method="POST" action="">
    
    <div class="form-group niche">
   <div class="col-md-3">
   <p>Business Name </p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="text" name="bname" class="form-control" id="businessname" value="<?php //echo  $rows->business_name; ?>"> 
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-3">
   <p>Business Address</p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="text" name="baddress" class="form-control" id="businessaddress" value="<?php //echo  $rows->business_address; ?>">
      </div>
    </div>
    <div class="form-group">
       <div class="col-md-3">
   <p>Business Website</p>
   </div>
      <div class="col-md-9 padding-left0">
        <input type="text" name="bsite" class="form-control" id="businesswebsite" value="<?php //echo  $rows->business_website; ?>"> 
      </div>
    </div>
    
    <div class="form-group">
       <div class="col-md-2">
   </div>
      <div class="col-md-10">
         <a href="#"><button type="submit" name="submit" class="btn btn-default myaccountsubmit submitss2">SUBMIT</button></a>
      </div>
    </div>
   

  </form> -->
   
  
        </div>
         
        </div><!---MAIN--COL-MD-8-END---->
        
        
        </div>
        </div><!---RIGHT MENU_SECTION_END---->
       
        </div>
        </div>
        
   </div>
   <?php
global $wpdb;
        //echo $id;


        $query="SELECT * FROM  wp_user_account LEFT JOIN wp_users
        ON wp_user_account.user_id=wp_users.ID WHERE user_id='".$_SESSION['user_id']."'";
        //echo $query;
        //die;
        $query1 = $wpdb->get_results($query);
        //print_r($row);

        foreach ($query1 as $querys){ 

          //var_dump( $querys);
        //$image=$rows->business_logo;
        //$sub_id=$rows->id;
        //$_SESSION['image']=$image;
        $_SESSION['user_email'] =$querys->user_email;
        $_SESSION['business_name']    =$querys->business_name;
        $_SESSION['business_website'] =$querys->business_website;
        $_SESSION['business_address'] =$querys->business_address;
        //$_SESSION['subcriber_id']     =$sub_id;
}
       // }
         ?>

</section>

      
     



<?php get_footer();?>
<?php

wp_redirect("http://account.couponbutter.com/manage-coupon/");
?>