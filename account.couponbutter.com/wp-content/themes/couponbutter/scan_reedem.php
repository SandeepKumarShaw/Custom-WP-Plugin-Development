<?php 

/*
Template Name: scan reedem
*/

?>
<?php get_header();
?>

<?php
global $wpdb;
 $scan_coupon_id = $_GET['scpnid'];
 $scan_qrcode_id = $_GET['scqrc'];





    $sql="SELECT customer_reedem FROM wp_customer_details WHERE customer_getcoupon_id='".$scan_coupon_id."' AND customer_qr_code='".$scan_qrcode_id."'";
    //echo $sql;
    $res=$wpdb->get_results($sql);
    foreach ($res as $result) {
        
        $status=$result->customer_reedem;
    }
    //echo $status;
 if($status==0)
     {

//$sql1="UPDATE wp_customer_details SET customer_reedem=1 WHERE customer_getcoupon_id='".$scan_coupon_id."' AND customer_qr_code='".$scan_qrcode_id."'";
// //echo $sql1;
//$wpdb->query($sql1);
 wp_redirect('http://account.couponbutter.com/green/?scpnid="'.$scan_coupon_id.'"&scqrc="'.$scan_qrcode_id.'"');
      }elseif ($status==1) {
         wp_redirect('http://account.couponbutter.com/red/');
     }

?>