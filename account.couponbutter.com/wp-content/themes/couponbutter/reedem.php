<?php 

/*
Template Name: reedem
*/

?>
<?php get_header();
?>


<section class="manage_cupon">
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
                  <p>Redeem</p>
             </div>
             </div>
             </div>
             </div>
             </div>


<div class="container">
<div class="redem-table">
<form method="post" action="">
<div  class="form-group">
<div class="col-sm-5"><label for="CouponName" class="col-sm-4 control-label">coupon no:</label>
<input type="text" class="col-sm-8" name="scan_cpn_name"></input></div></div>
<div  class="form-group">
<div class="col-sm-5"><label for="CouponName" class="col-sm-4 control-label">qr no:</label>
<input type="text" class="col-sm-8" name="scan_qr_code"></input></div></div>
<div  class="form-group">
<button type="submit" name="sub" value="enter"> check </button>
</div>
</form>
</div>
</div>
</section>
<style>
.msg {
    max-width: 300px;
    margin: 0 auto;
}
    
</style>


<?php
//$err = '';
if($_POST['sub'])
{
global $wpdb;
$scan_cpn_name=$_POST['scan_cpn_name'];
$scan_qr_code=$_POST['scan_qr_code'];
if( $scan_cpn_name == "" || $scan_cpn_name == "") {
        echo"<div class='msg'>Please don't leave the required field.</div>";
        } else{

    $sql="SELECT customer_reedem FROM wp_customer_details WHERE customer_getcoupon_id='".$scan_cpn_name."' AND customer_qr_code='".$scan_qr_code."'";
    $res=$wpdb->get_results($sql);
    foreach ($res as $result) {
        
        $status=$result->customer_reedem;
    }

    if($status==0)
    {

//$sql1="UPDATE wp_customer_details SET customer_reedem=1 WHERE customer_getcoupon_id='".$scan_cpn_name."' AND customer_qr_code='".$scan_qr_code."'";
//echo $sql1;
//$wpdb->query($sql1);
wp_redirect('http://account.couponbutter.com/green/?scpnid="'.$scan_cpn_name.'"&scqrc="'.$scan_qr_code.'"');
    }elseif ($status==1) {
        wp_redirect('http://account.couponbutter.com/red/');
    }
}
}

?>
<?php get_footer();?>
