
<?php 

/*
Template Name: Change Membership Level
*/

?>
<?php get_header();
?>
<?php 
$plan_id = $_POST['plan'];
global $wpdb;
$wpUserID = $_SESSION['user_id'];


    //var_dump($redarr);
$sql = "select * from wp_fullstripe_members where wpUserID='".$wpUserID."'";
$result = $wpdb->get_results($sql);
foreach ($result as $results) {
  $stripeCustomerID = $results->stripeCustomerID;
  $_SESSION['customer_id'] = $results->stripeCustomerID;
  $stripeSubscriptionID = $results->stripeSubscriptionID;
}
global $wpdb;

$amount = $_POST['ammount'];
$plan_id = $_POST['plan'];

$customer_id     = $stripeCustomerID;
$row1 = "UPDATE wp_fullstripe_members SET 
plan = '".$plan_id."' WHERE stripeCustomerID = '".$customer_id."'";

$row2 = "UPDATE wp_fullstripe_subscribers SET 
planID = '".$plan_id."' WHERE stripeCustomerID = '".$customer_id."'";

$row3 = "UPDATE wp_user_account SET 
user_plan = '".$plan_id."' WHERE user_id = '".$wpUserID."'";

$row4 = "DELETE FROM wp_coupon_create
WHERE cuppon_subscriber_id='".$wpUserID."' AND time_stamp != 
    (SELECT latest FROM
        (SELECT MAX(time_stamp) AS latest FROM wp_coupon_create WHERE cuppon_subscriber_id='".$wpUserID."') AS temp
    )";

$results1 = $wpdb->query($row1);
$results2 = $wpdb->query($row2);
$results3 = $wpdb->query($row3);
$results4 = $wpdb->get_results($row4);
if($plan_id==1){
if ( $results1 && $results2 && $results3 && $results4 ) {
	echo "success";
}
}
else{

	if ($results1 && $results2 && $results3 ) {
	echo "success";
}

}


Stripe::setApiKey("sk_live_3Emb6wzItnTSdpRLNk5cfOwy");
if( $customer_id ) {


	


$proration_date = time();
$invoice = Stripe_Invoice::upcoming(array(
  'customer' => $customer_id,
  'subscription' => $stripeSubscriptionID,
  'subscription_plan' => $plan_id, 
  'subscription_proration_date' => $proration_date

));
$cost = 0;
$current_prorations = array();
foreach ($invoice->lines->data as $line) {
  if ($line->period->start == $proration_date) {
    array_push($current_prorations, $line);
    $cost += $line->amount;
  }
}


/*$charge = Stripe_Charge::create(array(
			'amount' => $cost, // amount in cents
			'currency' => 'usd',
			'customer' => $customer_id
		)
	);*/


		// retrieve our customer from Stripe
		$cu = Stripe_Customer::retrieve( $customer_id );
 
		// update the customer's card info (in case it has changed )
		$cu->card = $token;
 
		// update a customer's subscription
		$cu->updateSubscription(array(
				'plan' => $plan_id,
				'proration_date' => $proration_date
			)
		);
 
		// save everything
		$cu->save();
		

		
}

echo $data = "Your card details have been updated!";
    wp_redirect("http://account.couponbutter.com/billing/");
 
?>



<?php get_footer();?>
