<?php 

/*
Template Name: Delete Coupon
*/

?>
<?php get_header();?>

<?php  

global $wpdb;



if(isset($_POST['id'])){
	foreach ($_POST['id'] as $id) {		
// $qry = "DELETE my_coupon_id FROM wp_my_email_list WHERE my_email_id ='".$id."'";
$qry="DELETE FROM wp_customer_details WHERE customer_id = '".$id."'";

$result = $wpdb->get_results($qry);

if($result){
   echo "YES";
} else {
   echo "NO";
}
}
}



?>

<?php get_footer();?>
