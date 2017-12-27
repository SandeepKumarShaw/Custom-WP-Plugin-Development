<?php 

/*
Template Name: update Address
*/

?>
<?php get_header();
?>

<?php 
global $wpdb;

$_SESSION['account_id']=$_POST['text12'];

$sql="UPDATE wp_user_account SET business_address='".$_POST['val2']."' WHERE id='".$_SESSION['account_id']."'";

$result = $wpdb->get_results($sql);

if($result){
   echo "YES";
} else {
   echo "NO";
}
?>


<?php get_footer();?>
