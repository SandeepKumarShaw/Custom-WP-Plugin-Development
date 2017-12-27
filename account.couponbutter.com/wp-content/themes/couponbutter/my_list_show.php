<?php 

/*
Template Name: My List Show
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
                  <p>My List</p>
             </div>
             </div>
           <?php include( get_template_directory() . '/menu_header.php'); ?>
        <div class="back_color">
        <div class="container">
        <p class="breadcrumb"><a href="http://account.couponbutter.com/my-list/"> BACK TO MY LIST </a></p>

        <div class="company_name_bx center_top" id="employee_table">
        <div id="list-head">
        <?php 
        global $wpdb;
        $mainlist=$wpdb->get_results("SELECT customer_name FROM `wp_customer_details` WHERE customer_id='$_GET[customer_id]'");
        foreach ($mainlist as $main) {
          echo $main->customer_name;

        }
  ?>
  </div>
          <table class="table table-bordered" id="table1">
    <thead>
      <tr>
        <th>Customer Name</th>
         <th>Email Id</th>
        
      </tr>
    </thead>
    <tbody>
    <?php
    if($_GET['customer_id'])
    {
    $_SESSION['customer_id']=$_GET['customer_id'];
global $wpdb;
$new_list=$wpdb->get_results("SELECT * FROM `wp_customer_details` WHERE parent_id='$_GET[customer_id]'");
//print_r($new_list);
foreach ($new_list as $variable) {
  ?>

    <tr>
    <td><?php echo $variable->customer_name; ?></td>
    <td><?php echo $variable->customer_email; ?></td>


    </tr>
    <?php

    }
}
}
    ?> 
    
    </tbody>
    </table>
    </div>
    <div class="col-md-10">
        <!--  <a href="#"><button type="submit" name="submit" class="btn btn-default submitss2">ADD NEW CUSTOMER</button></a> -->

         <button type="button" class="btn btn-default submitss2" data-toggle="modal" data-target="#myModal11">ADD NEW CUSTOMER</button>

         
         </div>
        </div>
  </div>
  



         <div class="modal fade" id="myModal11" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ADD NEW CUSTOMER</h4>
        </div>
        <div class="modal-body">

        

          <form class="form-horizontal" method="post" action="http://account.couponbutter.com/customer/?>">
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Customer Name</label>
    <div class="col-sm-10">
      <input type="name" name="customer_name" id="customer" class="form-control" id="inputEmail3" placeholder="Enter Customer Name" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3"  class="col-sm-2 control-label">Customer Email</label>
    <div class="col-sm-10">
      <input type="email" name="customer_email"  id="customer" class="form-control" id="inputEmail3" placeholder="Enter Customer Email" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" id="signin" class="btn btn-default">Add</button>
    </div>
  </div>
</form>


        </div>
       
      </div>
      
    </div>
  </div>
  </section>
  <?php get_footer();?>