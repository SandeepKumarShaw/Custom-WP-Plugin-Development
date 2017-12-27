0<?php 

/*
Template Name: Reedem Update Page
*/

?>
<?php get_header();
?>
<?php
$usdate = new datetime($usdate);
$usdate = date_format($usdate,"m/d/Y");
global $wpdb;
$sql1="UPDATE wp_customer_details SET customer_reedem=1, reedem_date='".$usdate."' WHERE customer_getcoupon_id='".$_POST['scpnid']."' AND customer_qr_code='".$_POST['scqrc']."'";
$wpdb->query($sql1);

// $sql2=$wpdb->get_results("SELECT customer_email FROM wp_customer_details WHERE customer_getcoupon_id='".$_POST['scpnid']."' AND customer_qr_code='".$_POST['scqrc']."'");
// foreach ($sql2 as $row2 ) {
// 	$eid=$row2->customer_email;
// }

// $sql3="UPDATE wp_my_email_list SET my_email_reedemed_status=1, my_email_reedemed_date='".$usdate."' WHERE my_coupon_id='".$_POST['scpnid']."' AND my_customer_email='".$eid."'";
// $wpdb->query($sql3);

?>
<?php get_footer();?>
