<?php 

/*
Template Name: Delete Manage Coupon
*/

?>
<?php get_header(); ?>

<?php   

global $wpdb;

$sql = "Delete FROM wp_coupon_create where coupon_id='".$_POST['mc_id']."'";
$result = $wpdb->get_results($sql);
if($result):
  echo "yes";
else:
  echo "No";

endif;

?>
<?php get_footer();?>