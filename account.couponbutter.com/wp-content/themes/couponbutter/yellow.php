<?php 

/*
Template Name: yellow
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
<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/cross.png" class="center-block"/>
</div>
</div>
<div class="col-md-7">
<p class="reedemed">This Coupon Has Already Been Redeemed</p>
</div>
</div>
</div>
</div>
</div>
</section>



<?php get_footer();?>
