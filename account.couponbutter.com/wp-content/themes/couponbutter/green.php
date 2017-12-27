<?php 

/*
Template Name: green
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
                  <p>Redeem Status</p>
             </div>
             </div>
             </div>
             </div>
             </div>
 <div class="container">
	 <div class="row">
<div class="nreedemed">
<div class="col-md-12 class10">
<div class="col-md-4 tickss">
<div class="right-sign">
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/check-mark.png" class="center-block"/>
</div>
</div>
<div class="col-md-6">
<?php 

$coupon_id = $_GET['scpnid'];
$qrcode_id = $_GET['scqrc'];

?>
<p>This Coupon Has Not Been Redeemed</p>
</div>
</div>
<div class="col-md-12 class10">
<div  class="form-group buttonsub">
<button type="submit" name="sub" class="sucreedeemed" data-rcid="<?php echo $coupon_id; ?>" data-rqid="<?php echo $qrcode_id; ?>" value="enter"> Redeem</button>
</div>
<div id="sucreedeemed"></div>
</div>
</div>
</div>
</div>

</section>
<style>
.nreedemed button {
background: #ef4923;
border-radius: 39px;
height: 40px;
border: none;
padding: 0 36px;
color: #fff;
outline: 0;
}
.nreedemed .buttonsub {
padding: 37px 6px 0px 225px;
}
	
    div#sucreedeemed {
    text-align: center;
}

</style>
<?php get_footer();?>
