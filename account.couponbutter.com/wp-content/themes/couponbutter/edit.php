<?php 

/*
Template Name: edit
*/

?>
<?php get_header();
?>

<?php  
if(!isset($_SESSION['user_id'])){
   //header("Location: http://localhost/coupon.demostage.net/");
        //exit();
  wp_redirect("http://account.couponbutter.com/");
     exit();
}    
else{
	$table_name = $wpdb->prefix . "user_account";
$sql="UPDATE $table_name SET business_name='".$_POST['bname']."',business_address='".$_POST['baddress']."',business_website='".$_POST['bsite']."' where id='".$_SESSION['account_id']."'";


$rez = $wpdb->query($sql);
//print_r($rez);
if ($rez>0){
	 echo '<script type="text/javascript">';        
     echo 'window.location= "http://account.couponbutter.com/accountedit/"';
     echo '</script>'; 
		  
		  
		}
        else{
		  //echo "not";

        	wp_redirect("http://account.couponbutter.com/accountedit/");
            exit();
				
        }



}






	?>


<?php get_footer();
?>