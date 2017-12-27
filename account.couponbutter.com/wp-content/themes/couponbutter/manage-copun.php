<?php 

/*
Template Name: Manage Coupon
*/

?>
<?php get_header(); ?>
<body>
<?php  
//echo $_SESSION['user_id'];

if(!isset($_SESSION['user_id'])){
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect("http://account.couponbutter.com/");
     exit();
}    
else{?>
<?php 

//if(isset($_SESSION['image'])) :
//echo $_SESSION['image'];
//endif;
//$table_name=$wpdb->prefix ."coupon_create";
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
                  <p>Manage Coupons</p>
             </div>
             </div>

     <?php include( get_template_directory() . '/menu_header.php'); ?>
        
        <div class="back_color">
        <div class="container ">



<?php
$count=0;
$nan="SELECT * FROM wp_coupon_create where cuppon_subscriber_id ='".$_SESSION['user_id']."' ORDER BY time_stamp DESC;  ";

  $no = $wpdb->get_results($nan);
  foreach ($no as $none) {
    

    $yes=$wpdb->get_results("SELECT wp_customer_details.customer_reedem
FROM wp_customer_details
LEFT JOIN wp_coupon_create ON wp_customer_details.customer_getcoupon_id = wp_coupon_create.coupon_id
WHERE wp_coupon_create.coupon_id=$none->coupon_id");
//echo $yes;
foreach ($yes as $yap) {
 
if($yap->customer_reedem==1)
{

  $count++;
  //echo $count;
  $wpdb->query("UPDATE wp_coupon_create SET coupon_reedem='".$count."' WHERE coupon_id='".$none->coupon_id."'");
}
}
  }


?>


        <?php if($_GET['c'])
        {

          echo"updated successfully";
        }?>
        <div class="company_name_bx center_top">
        <table class="table table-bordered">
    <thead>
      <tr>
        <th>Coupon Name </th>
        <th>status</th>
        <th>coupon redeemed</th>
        <th>Delete coupon</th>
        
        <th>Edit Coupon</th>
        <th>View Coupon</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $i=0;
     
if(isset($_SESSION['user_id']))


{
//echo $_SESSION['user_id'];
  $sql="SELECT * FROM wp_coupon_create where cuppon_subscriber_id ='".$_SESSION['user_id']."' ORDER BY time_stamp DESC;  ";

  $row = $wpdb->get_results($sql);
   $date1 = date('m/d/Y');

foreach ($row as $rows){ $i++;

 $_SESSION['coupon_id']=$rows->coupon_id;
 $tempArr=explode('/', $rows->coupon_end_date);
$date2 = date($rows->coupon_end_date, mktime(0, 0, 0, $tempArr[1], $tempArr[0], $tempArr[2]));
        ?>
   
      <tr id="<?php echo $rows->coupon_id; ?>">
       

       <?php if(strtotime($date1) > strtotime($date2)) { ?>
<td> <?php echo $rows->coupon_name; ?> </td>   
<td><?php echo "Expired"; ?>  </td>

      <?php  } else {?>
        <td><a href="http://account.couponbutter.com/coupon/?coupon_id=<?php echo $rows->coupon_id; ?>"><?php echo $rows->coupon_name; ?> </a></td>
       <td><?php echo "Active" ?>  </td>
        <?php  } ?>

         <td><?php echo $rows->coupon_reedem; ?> </td>

         <td><div id="Managedel"><a href="javascript:void(0);" class="Manacid" id="Manacid" rel="<?php echo $rows->coupon_id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i>          
        </a></div></td>
 
        
        <td><div id="Manageupd"><a href="http://account.couponbutter.com/update-coupon/?coupon_id=<?php echo $rows->coupon_id; ?>" class="" id="" rel="<?php echo $rows->coupon_id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>       
        </a></div></td>
        <td><div id="Manageview"><a href="http://account.couponbutter.com/view-coupon/?coupon_id=<?php echo $rows->coupon_id; ?>"><i class="fa fa-eye" aria-hidden="true"></i>          
        </a></div></td> 
      </tr>
      <?php }
      }
      ?>
    </tbody>
  </table>
        
       </div>
       
       <div class="add_new_cupon">
        <a href="http://account.couponbutter.com/coupon/"><button type="button" class="btn btn-danger copun_btn2">ADD NEW COUPON</button></a>

       

  <!-- Modal -->
  
       
       </div>
       
       </div>
        
        
        </div>
        
   
</section>
<?php } ?>
<?php get_footer();?>
