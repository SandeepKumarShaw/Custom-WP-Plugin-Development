<?php 

/*
Template Name: Update Billing
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
}


?>
<?php
Stripe::setApiKey("sk_live_3Emb6wzItnTSdpRLNk5cfOwy");

if (isset($_POST['stripeToken'])){
  try {
    $customer_id=$stripeCustomerID;
    $cu = Stripe_Customer::retrieve($customer_id); // stored in your application
    $cu->source = $_POST['stripeToken']; // obtained with Checkout
    $cu->save();

    $success = "Your card details have been updated!";
    wp_redirect("http://account.couponbutter.com/billing/");
  }
  catch(\Stripe\Error\Card $e) {

    // Use the variable $error to save any errors
    // To be displayed to the customer later in the page
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $error = $err['message'];
  }
  // Add additional error handling here as needed
}
?>
<?php get_footer();?>
