<?php 

/*
Template Name: Email List Insert
*/

?>
<?php get_header(); ?>

<?php 

//echo $data = "<h4>".$_POST['cou_id']."</h4><br><h4>".$_POST['cus_id']."</h4><br><h4>".$_POST['cou_name']."</h4>";
//exit;

// global $wpdb;
// $_SESSION['cou_id']=$_POST['cou_id'];
// $_SESSION['cus_id']=$_POST['cus_id'];
// $values = array();
// $sql="SELECT * FROM `wp_coupon_create` WHERE coupon_id='$_POST[cou_id]'";
// $query=$wpdb->results($sql);
// foreach ($query as $key) {
  
//  $_SESSION['cou_name']=$key->coupon_name;
// }



// $sql1="SELECT * FROM `wp_customer_details` WHERE parent_id='$_POST[cus_id]'";
// $query1=$wpdb->results($sql1);
// foreach ($query1 as $key1) {
  
//  $_SESSION['cus_name']=$key1->customer_name;
//  //$_SESSION['cus_email']=$key1->customer_email;
//  $sql3="INSERT INTO wp_my_email_list SET  my_coupon_name='".$_SESSION['cou_name']."', my_customer_name='".$_SESSION['cus_name']."', my_customer_parent_id='".$_POST['cus_id']."'";
//    $rez = $wpdb->query($sql3);

// }
  
    
   
   

// }

?>
<?php



global $wpdb;
$_POST['cou_id'];
$_POST['cus_id'];

$_POST['cou_name'];
$sql4=" SELECT customer_cuppon_id FROM wp_customer_details WHERE customer_id = '".$_POST['cus_id']."'";
$result=$wpdb->get_results($sql4);
foreach ($result as $results ) {
  if($results->customer_cuppon_id==0)
  {
$sql3="UPDATE wp_customer_details SET  customer_cuppon_id = '".$_POST['cou_id']."' WHERE customer_id = '".$_POST['cus_id']."'";
$wpdb->query($sql3);

  }else
  {

    echo"not";
  }
}
$narray=array();
$darray=array();

$_POST['couponid'];
$_POST['customerid'];
  $sql1="SELECT customer_email,customer_name
 FROM wp_customer_details
 WHERE parent_id = '$_POST[customerid]' AND customer_email NOT 
 IN (

 SELECT my_customer_email
 FROM wp_my_email_list
 WHERE my_customer_parent_id = '$_POST[customerid]')";
    $result=$wpdb->get_results($sql1);
//   // print_r($query);
//  //  return $query;
//  // //echo $data. = "<h4>".$query."</h4>";
   foreach ($result as $key1) {

  $cus_mail=$key1->customer_email;
   $narray[]=$cus_mail;
  $darray[]=$key1->customer_name;

   }

 if($cus_mail)
 {
  
  foreach ($narray as $resultmail) {
  foreach ($darray as $resultd) {

// // $sql="SELECT my_customer_email FROM wp_my_email_list WHERE my_coupon_id='".$_POST['cou_id'];."'";
// // $rslt=$wpdb->get_results($sql1);
// // foreach ($rslt as $rsltmail) {
// //   $mymail=$rsltmail->my_customer_email;
// // if($mymail===$resultmail)
// // {
  
// // }else{

    
 $res="INSERT INTO wp_my_email_list SET  my_coupon_id='".$_POST['couponid']."',my_coupon_name='".$resultd."', my_customer_email='".$resultmail."',my_customer_parent_id='".$_POST['customerid']."'";
 $rez = $wpdb->query($res);
// // }
// // }
}
 }
 }
?>





<?php get_footer();?>