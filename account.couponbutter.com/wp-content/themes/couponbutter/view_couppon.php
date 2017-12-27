<?php 

/*
Template Name: View Coupon
*/

?>
<?php get_header();
?>
<?php
        //if ( isset( $_SESSION['user_id'])){ 

if(!isset($_SESSION['user_id'])):
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect('http://account.couponbutter.com/');
     exit();
endif;   
?>
<body>
<div class="menu_header">
        <div class="container">
          <div class="coupon_viewhead">
           <a href="http://account.couponbutter.com/manage-coupon/">BACK TO MANAGE COUPON</a>
          </div>
        </div>
        </div>
<h2 style="text-align:center;font-weight: bold;color: #696565;">Your Buttery Coupon has Arrived<br><span style="font-size:14px;">THIS COUPON ENTITLES YOU TO</span>
</h2>
<?php  
//echo $_GET['coupon_id'];
//echo $_SESSION['coupon_id'];
         global $wpdb;
         $table_name = $wpdb->prefix . "coupon_create";
         $sql="SELECT * FROM $table_name where coupon_id ='".$_GET['coupon_id']."'";

         $row = $wpdb->get_results($sql);
  
         foreach ($row as $rows){
         $file = $rows->coupon_pdf_path;
         //echo $file;



        ?>
<div style="width:625px; height:auto; background:url(<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-edited.png) no-repeat; background-size: 100% 100%; margin:0 auto 25px;">
<div style="display: inline-block;padding: 0 35px 30px 85px;width: 625px;text-align: center;">
<div style=" width:100%; margin:0 auto 15px;">
<h1 style=" font-size: 42px;padding: 56px 15px 0; text-align:center; margin:18px 0; font-family:
'SinkinSans-600SemiBold';"><?php echo $rows->coupon_discount; ?></h1>
<!--<h1 style="text-align:center; font-size:18px; font-weight:bold; margin:0;">Your Purchase of $30 or More.</h1>-->
<p style="text-align:center; font-size:14px; font-weight:bold;">EXPIRES <?php echo $rows->coupon_end_date; ?></p>
</div>

<div style="margin: 0 auto;text-align: center;"><img src="<?php echo $rows->coupon_logo; ?>" style="width:110px;"/></div>

<div style=" width:100%; margin:auto; text-align:center;"><h2 style=" font-size:24px;margin-top: 15px;text-transform: capitalize;font-weight: bold;"><?php echo $rows->resturant_name; ?><br><span style=" font-size:17px;font-weight: normal;"><?php echo $rows->resturant_address; ?> </span><br><span style=" font-size:20px;font-weight: normal;"><?php echo $rows->coupon_phone;?></span><br><span style=" font-size:16px;text-transform: initial;font-weight: normal;"><?php echo $rows->resturant_website; ?></span></h2>
</div>

<div style="width:100%;"><p style=" font-size:12px;text-align: center;margin-bottom: 15px;padding: 0 15px;"><?php echo $rows->coupon_disclaimer; ?></p></div>

<div style=" margin:0 auto;display: inline-block;"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/mark.jpg" style="width:110px;"/></div>

<div style=" width:100%; margin:auto; text-align:center;"><h2 style=" font-size:14px; font-weight:bold;margin: 9px 0;"><span style=" font-size:10px;margin-bottom: 3px;display: inline-block;">RESTAURANT OWNERS SCAN HERE TO REDEEM</span><br>COUPON No.: <?php echo $_GET['coupon_id']; ?></h2>
</div>
 <div style=' width:100%;float:left;text-align:center;font-size: 11px;font-weight: bold;margin-bottom: 30px;'> OR ENTER COUPON NO AT :<a href="http://account.couponbutter.com/redeem/">http://account.couponbutter.com/redeem/</a></div>
</div>
</div>
<?php }?>
<div style="width:625px;margin: auto;text-align: center;padding-left: 31px;padding-bottom: 15px;">
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/coupon-butter-logo.png"/>
</div>
<div style="width:783px; margin-left:112px; margin:auto; margin-bottom:40px;"><p style=" font-size:12px;">
<h3 style="text-align:center; padding:0;margin: 0 0 15px;">www.couponbutter.com</h3>

<p style="text-align:center;font-size: 13px;font-weight: bold;color: #696565;">Coupons may be used only once and may not be duplicated or photocopied.Further, in the event that coupons are electronically distributed,Coupons may be printed or scanned only once. Coupons are strictly prohibited from being posted electronically. No cash value, credit or change eill be given.The coupon holder is responsible for any applicable sales tax. Coupons nay not be combined with any other coupon or employee discount. Coupons not redeemed by any expiration date hereon. Failure to use a coupon by any expiration date hereon shall result in the forfeiture of such coupon. Proprietor may refuse coupon for any reason.</p></div>
</body>
</html>
<?php get_footer();?>
