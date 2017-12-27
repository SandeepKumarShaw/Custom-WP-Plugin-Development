<?php 

/*
Template Name: Insert Customer
*/
 get_header();
?>

<?php 
//echo $_SESSION['customer_id'];

if(!empty($_POST['customer_name']))
{
  //echo"aaaaa";
 
	if( $_POST['customer_name'] == "" || $_POST['customer_email'] == "") {
        $err = 'Please don\'t leave the required field.';
        } else {
global $wpdb;
$sql1="INSERT INTO wp_customer_details 
SET customer_name='".$_POST['customer_name']."',customer_email='".$_POST['customer_email']."',subscriber_id='".$_SESSION['user_id']."',parent_id = '".$_SESSION['customer_id']."'";

//echo $sql1;
//die;
$row1=$wpdb->query($sql1);

wp_redirect("http://account.couponbutter.com/my-list-show/?customer_id='".$_SESSION['customer_id']."'");

}

}
?>






<?php get_footer();?>