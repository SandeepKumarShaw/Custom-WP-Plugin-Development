<?php 

/*
Template Name: support
*/

?>
<?php get_header();?>
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
                  <p>Support</p>

             </div>
             </div>

           <?php include( get_template_directory() . '/menu_header.php'); ?>
                   
</div> </div> </div>
<div class="container">
<div id="list-head">
					SUPPORT
                   </div>
                   <p class="sprt"> COMING SOON </p>
</div>
<?php }?>
</section>
           <?php get_footer();?>
