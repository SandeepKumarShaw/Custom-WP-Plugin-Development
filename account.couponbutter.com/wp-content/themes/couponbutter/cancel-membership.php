<?php 

/*
Template Name: Cancel Membership
*/

?>
<?php get_header();
?>
<?php 
global $wpdb;
$wpUserID = $_SESSION['user_id'];
$sql = "select * from wp_fullstripe_members where wpUserID='".$wpUserID."'";
$result = $wpdb->get_results($sql);
foreach ($result as $results) {
  $stripeCustomerID = $results->stripeCustomerID;
  $stripeSubscriptionID = $results->stripeSubscriptionID;
}


?>
<?php    

$customer_id     = $stripeCustomerID;
Stripe::setApiKey("sk_live_3Emb6wzItnTSdpRLNk5cfOwy");
if( $customer_id ) {
 
		// retrieve our customer from Stripe
		$cu = Stripe_Customer::retrieve( $customer_id );
 
		// update the customer's card info (in case it has changed )
		
 $cu->subscriptions->retrieve($stripeSubscriptionID)->cancel(
     array("at_period_end" => true ));
		// save everything
		$results = $cu->save();
		
}

echo $data = "Your card details have been updated!";
    wp_redirect("http://account.couponbutter.com/billing/");
 
?>



<?php get_footer();?>
