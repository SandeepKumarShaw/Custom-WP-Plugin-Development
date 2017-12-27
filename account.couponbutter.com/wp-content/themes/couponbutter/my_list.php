<?php 

/*
Template Name: My List
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
        </section>
        <section>
        
        <div class="my_acc">
         <div class="container">
       <div class="row act_act">
       
        <div class="col-md-12 act1">
        <div class="active_copn">
        <p><a href="http://account.couponbutter.com/active-coupon/ ">Active Coupons</a></p>
        </div>
        <div class="col-md-12 pd">
        <div class="active_setting_bx_01_11_16">
        <p></p>
        </div>
        </div>
        </div>
        </div>
        
        
        <div class="stc_brd_01_11_16">
        <div class="right_menu_section">
        <div class="row">
        <!-- <div class="col-md-3"> --><!---MAIN--COL-MD4-START---->
        <!-- <div class="right_menu_list">
        <ul>
       
        <li><a href="http://account.couponbutter.com/accountedit/"><span><i class="fa fa-user sz" aria-hidden="true"></i></span>My Account Edit</a></li>
       <li class="my_list" id="my_list"><a href="http://account.couponbutter.com/my-list/"><span><i class="fa fa-list sz" aria-hidden="true"></i></span>My Lists</a>

          </li>

       <li class="bill"><a href="http://account.couponbutter.com/billing/"><span><i class="fa fa-list-ul sz" aria-hidden="true"></i></span>Billing</a></li>
        
        </ul>
        </div> -->

       <!--  </div> --><!---MAIN--COL-MD- 4-END---->
        <div class="col-md-12">
             <div class="list_heading">My list</div> 
       
      <div class="mylist_table">
        

<ul  class="addlist_page">

<?php 


global $wpdb;
$list="SELECT * FROM `wp_customer_details` WHERE parent_id=0 AND subscriber_id='".$_SESSION['user_id']."'";

$query=$wpdb->get_results($list);
//print_r($query);
foreach ($query as $value) {
   
?>
<li>
<a href=" http://account.couponbutter.com/my-list-show/?customer_id=<?php echo $value->customer_id;?>" id="<?php echo $value->customer_id;?>"><?php echo $value->customer_name; ?> </a><div class="listdel" id="listdel" data-cusid="<?php echo $value->customer_id;  ?>"><a href="http://account.couponbutter.com/my-list-delete/?del_id=<?php echo $value->customer_id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div></li>
<?php
}

  ?>
   </ul>
   </div>
      
<?php } ?>
  <div class="col-md-10">
        <!--  <a href="#"><button type="submit" name="submit" class="btn btn-default submitss2">ADD NEW CUSTOMER</button></a> -->

         
         <button type="button" class="btn btn-default submitss2" data-toggle="modal" data-target="#myModal1">CREATE NEW LIST</button>
  </div>
   
  <!-- Modal -->

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">CREATE NEW LIST</h4>
        </div>
        <div class="modal-body">

        

          <form class="form-horizontal" method="post" action="">
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">List Name</label>
    <div class="col-sm-10">
      <input type="name" name="list_name" id="customer" class="form-control" id="inputEmail3" placeholder="Enter New List" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" id="signin" class="btn btn-default">Add</button>
    </div>
  </div>
</form>
<?php 

if($_POST['list_name'])
{

$sql2="INSERT INTO wp_customer_details SET customer_name='".$_POST['list_name']."', parent_id = 0,subscriber_id='".$_SESSION['user_id']."'";
//echo $sql2;
$row2=$wpdb->query($sql2);
wp_redirect("http://account.couponbutter.com/my-list/");
}


?>


        </div>
       
      </div>
      
    </div>
  </div>
        

       
       <!-- <div class="add_new_cupon">
        <a href="#"><button type="button" class="btn btn-danger copun_btn2">ADD NEW COUPON</button></a>
       
       </div> -->
       
       
       
       
        
        
        
        </div>
       
        </div>
        </div>
        
   </div>

</section>

<?php get_footer();?>

