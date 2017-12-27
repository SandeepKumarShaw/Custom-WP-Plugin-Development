<?php 

/*
Template Name: My List Delete
*/

?>
<?php get_header();?>
<?php  

if (isset($_GET['del_id'])) {
	# code...

$qry = "DELETE FROM wp_customer_details WHERE customer_id ='".$_GET['del_id']."' OR parent_id='".$_GET['del_id']."'";
//echo $qry;
//die;
$result = $wpdb->query($qry);
if ($result) {
	
	wp_redirect('http://account.couponbutter.com/my-list/');
}
}



?>
<?php get_footer();?>
