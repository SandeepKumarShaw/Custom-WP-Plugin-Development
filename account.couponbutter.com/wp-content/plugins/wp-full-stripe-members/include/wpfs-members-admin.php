<?php

// Deal with all member admin like adding new members, checking subscriptions
// changing member status and so on.

class MM_WPFS_Members_Admin
{
    const SESSION_KEY_IMPORTED_SUBSCRIBERS = 'wpfsm_imported_subscribers';
    const IMPORT_STATUS_ABORT_DUE_TO_TEST_MODE = 'ABORT_DUE_TO_TEST_MODE';
    const IMPORT_STATUS_ABORT_DUE_TO_NO_SUBSCRIPTIONS = 'ABORT_DUE_TO_NO_SUBSCRIPTIONS';
    const IMPORT_STATUS_ABORT_DUE_TO_NO_PLANS_MATCHING_SUBSCRIPTIONS = 'ABORT_DUE_TO_NO_PLANS_MATCHING_SUBSCRIPTIONS';
    const IMPORT_STATUS_ABORT_DUE_TO_AMBIGUOUS_PLANS = 'ABORT_DUE_TO_AMBIGUOUS_PLANS';
    const IMPORT_STATUS_SUCCESSFULLY_CREATED = 'SUCCESSFULLY_CREATED';
    const IMPORT_STATUS_SUCCESSFULLY_UPDATED = 'SUCCESSFULLY_UPDATED';
    /** @var MM_WPFS_Members_Database|null */
    private $db = null;
    /** @var MM_WPFS_Stripe|null */
    private $stripe = null;
    private $default_password = 'NewMember123';

    public function __construct()
    {
        include_once 'wpfs-members-database.php';
        $this->db = new MM_WPFS_Members_Database();
        $this->stripe = new MM_WPFS_Stripe();
        
        // tnagy prepare session for use during import
        add_action('init', array($this, 'start_session'), 1);
        add_action('wp_logout', array($this, 'end_session'));
        add_action('wp_login', array($this, 'end_session'));

        //attach to the action after a successful subscription setup by wp full stripe
        add_action('fullstripe_after_subscription_charge', array($this, 'add_member'));
        //make sure we check when a user logs in that they are still subscribed, if not, change role
        add_action('wp_login', array($this, 'check_member_status_login'), 10, 2);
        // remove the default login authentication filter - we want to allow login by email
        remove_filter('authenticate', array($this, 'wp_authenticate_username_password'), 20, 3);
        add_filter('authenticate', array($this, 'authenticate_username_password'), 20, 3);
        // members or admin changing  membership plan & role
        add_action('wp_ajax_nopriv_wpfs_members_change_level', array($this, 'change_level'));
        add_action('wp_ajax_wpfs_members_change_level', array($this, 'change_level'));
        // members or admin cancelling membership
        add_action('wp_ajax_nopriv_wpfs_members_cancel', array($this, 'cancel_membership'));
        add_action('wp_ajax_wpfs_members_cancel', array($this, 'cancel_membership'));
         // members updating card
        add_action('wp_ajax_nopriv_wpfs_members_update_card', array($this, 'update_card'));
        add_action('wp_ajax_wpfs_members_update_card', array($this, 'update_card'));
        //admin changing just the role on edit member page
        add_action('wp_ajax_nopriv_wpfs_members_change_role', array($this, 'change_role'));
        add_action('wp_ajax_wpfs_members_change_role', array($this, 'change_role'));
        //admin manually creating a new member
        add_action('wp_ajax_wpfs_members_manual_create_member', array($this, 'manual_create_member'));

        // tnagy admin importing subscribers from stripe
        add_action('wp_ajax_wpfs_members_import_subscribers_from_stripe_step1', array($this, 'import_subscribers_from_stripe_step1'));
        add_action('wp_ajax_wpfs_members_import_subscribers_from_stripe_step3', array($this, 'import_subscribers_from_stripe_step3'));
        add_action('wp_ajax_wpfs_members_import_subscribers_from_stripe_step5', array($this, 'import_subscribers_from_stripe_step5'));
    }

    /**
     * Starts a session if not started already.
     *
     * @author tnagy
     */
    function start_session() {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Ends a previously started session.
     *
     * @author tnagy
     */
    function end_session() {
        session_destroy();
    }

    // Here we must add (or update) a wordpress user and assign them the role
    // associated with this subscription plan, if any.
    function add_member($stripeCustomer)
    {
        $options = get_option('fullstripe_options');
        // Only allow test mode member creation if setting is allowed
        if (!$stripeCustomer->livemode && $options['wpfs_members_create_test_members'] == 0) {
            return;
        }

        // Get stripe and role data
        $email = $stripeCustomer->email;
        $planID = $stripeCustomer->subscription->plan->id;
        // Get the role name for this plan, if any
        $planRole = MM_WPFS_Members::getInstance()->get_role_for_plan($planID);
        if (!$planRole)
            return; // No role assigned to this plan means it's not a membership subscription

        // First check if the user exists
        $wpUserID = username_exists($email);
        if (!$wpUserID)
        {
            // We also want to check that the email isn't already registered to another user
            $wpUserID = email_exists($email);
            if (!$wpUserID)
            {
                $this->create_new_user($stripeCustomer, $planRole);
            }
            else // add the role to this user
            {
                $this->update_existing_user($wpUserID,$stripeCustomer,$planRole);
            }
        }
        else // update the role of this user
        {
            $this->update_existing_user($wpUserID,$stripeCustomer,$planRole);
        }
    }

    function check_member_status_login($user_login, $user)
    {
        $member = $this->db->get_member_by_wpid($user->ID);
        if ($member)
        {
            $this->check_member_status($member);
        }
    }

    //TODO: We could also use webhooks instead of this login/cron approach
    function check_member_status($member)
    {
        // get the wpfs member from the WP_User $user, check Stripe for subscription
        // status and update role if not subscribed any more.

        $options = get_option('fullstripe_options');
        // Check subscription status. Note Stripe is loaded because WP Full Stripe.
        $stripeCustomer = Stripe_Customer::retrieve($member->stripeCustomerID);
        if (count($stripeCustomer->subscriptions->data) > 0)
        {
            $invalidStatuses = array('unpaid', 'canceled');
            if ($options['wpfs_members_block_past_due'] == 1)
                $invalidStatuses[] = 'past_due';

            // Find the subscription related to this membership signup.
            $found = false;
            foreach ($stripeCustomer->subscriptions->data as $sub)
            {
                if ($sub->id == $member->stripeSubscriptionID)
                {
                    if (in_array($sub->status, $invalidStatuses))
                    {
                        $this->remove_membership_role($member, $sub->status);
                    }
                    $found = true;
                    break;
                }
            }

            // The subscription this member signed up with is no longer on the Stripe
            // customer details, meaning it's been deleted/canceled.
            if (!$found)
            {
                $this->remove_membership_role($member, 'deleted');
            }
        }
        else
        {
            // not subscribed to anything...shouldn't happen.
            $this->remove_membership_role($member, 'unknown');
        }
    }

    function remove_membership_role($member, $newStatus)
    {
        // Remove the role and update the member record
        $user = get_user_by('id', $member->wpUserID);
        $user->remove_role($member->role);
        $user->add_role('wpfs_no_access');
        $this->db->update_member($member->memberID, array(
            'role' => 'wpfs_no_access',
            'stripeSubscriptionStatus' => $newStatus
        ));
    }

    // This allows users to put their email address in the username field on login.
    function authenticate_username_password($user, $username, $password)
    {
        if (!empty($username))
        {
            // We still try and login as usual so we don't break current users
            $user = get_user_by('login', $username);
            if (!$user)
            {
                // Now try email since we want to allow users to login via email
                // This is because we create the users via email after subscription as
                // we can always guarantee they'll have filled in an email address.
                $user = get_user_by('email', $username);
            }
        }

        if (isset($user->user_login, $user))
        {
            $username = $user->user_login;
        }

        // Now continue using the default WP authentication
        return wp_authenticate_username_password(NULL, $username, $password);
    }

	/**
	 * A member has selected a new subscription plan
	 */
	public function change_level() {
		$memberID = $_POST['memberID'];
		$newPlan  = $_POST['wpfs_members_level'];
		$newRole  = $_POST['role'];
		$return   = array( 'success' => true );

		$member = $this->db->get_member( $memberID );
		if ( $member ) {
			$subscriptionUpdated = false;
			try {
				$this->member_change_level( $member, $newPlan );
				$subscriptionUpdated = true;
			} catch ( Exception $e ) {
				$return = array(
					'success' => false,
					'msg'     => MM_WPFS_Members::translate_label( $e->getMessage() ),
					'ex_msg'  => $e->getMessage()
				);
			}

			// if Stripe was updated successfully, update our own records
			if ( $subscriptionUpdated ) {
				// change WP user role
				$user = get_user_by( 'id', $member->wpUserID );
				$user->remove_role( $member->role );
				$user->add_role( $newRole );

				// update DB
				$this->db->update_member( $memberID, array(
					'role' => $newRole,
					'plan' => $newPlan
				) );
			}
		} else {
			$return = array(
				'success' => false,
				'msg'     => __( 'No member found. Please re-log and try again.', 'wp-full-stripe-members' )
			);
		}

		header( "Content-Type: application/json" );
		echo json_encode( $return );
		exit;
	}

	/**
	 * A member chose to cancel their membership
	 */
	function cancel_membership() {
		$memberID = $_POST['memberID'];
		$return   = array( 'success' => true );

		$member = $this->db->get_member( $memberID );
		if ( $member ) {
			$subscriptionUpdated = false;
			try {
				$this->member_cancel_membership( $member );
				$subscriptionUpdated = true;
			} catch ( Exception $e ) {
				$return = array(
					'success' => false,
					'msg'     => MM_WPFS_Members::translate_label( $e->getMessage() ),
					'ex_msg'  => $e->getMessage()
				);
			}

			// if Stripe was updated successfully, update our own records
			if ( $subscriptionUpdated ) {
				// Might as well use our own check_status function that will update DB and WP Role as needed,
				// though it is slightly less efficient because it loops through all subscriptions...
				$this->check_member_status( $member );
			}
		} else {
			$return = array(
				'success' => false,
				'msg'     => __( 'No member found. Please re-log and try again.', 'wp-full-stripe-members' )
			);
		}

		header( "Content-Type: application/json" );
		echo json_encode( $return );
		exit;
	}

    function update_card() {
	    
	    error_log( 'CALLED' );
	    
        $memberID = $_POST['memberID'];
        $card     = $_POST['stripeToken'];
        $return   = array( 'success' => true );

        $member = $this->db->get_member( $memberID );
        if ( $member ) {
            try {
                $this->member_update_card( $member, $card );
            } catch ( \Stripe_CardError $e) {
                $message = $this->stripe->resolve_error_message_by_code( $e->getCode() );
	            error_log( 'resolved message=' . $message );
	            if ( is_null( $message ) ) {
		            $message = MM_WPFS_Members::translate_label( $e->getMessage() );
	            }
	            $return  = array(
		            'success' => false,
		            'msg'     => $message,
		            'ex_msg'  => $e->getMessage()
	            );
            } catch ( Exception $e ) {
	            error_log( 'exception class=' . get_class( $e ) );
                $message = $e->getMessage();
                $return  = array(
                    'success' => false,
                    'msg'     => MM_WPFS_Members::translate_label( $message ),
                    'ex_msg'  => $message
                );
            }
        } else {
            $return = array(
                'success' => false,
                'msg'     => __( 'No member found. Please re-log and try again.', 'wp-full-stripe-members' )
            );
        }

        header( "Content-Type: application/json" );
        echo json_encode( $return );
        exit;
    }

    // Here we just change the role with no regard to the associated subscription plan.
    // Should only be used with care - currently a button only for admins on edit member page.
    function change_role()
    {
        $memberID = $_POST['memberID'];
        $newRole = $_POST['wpfs_member_role'];
        $return = array('success' => true);

        $member = $this->db->get_member($memberID);
        if ($member)
        {
            $user = get_user_by('id', $member->wpUserID);
            $user->remove_role($member->role);
            $user->add_role($newRole);
            $this->db->update_member($member->memberID, array(
                'role' => $newRole
            ));
        }
        else
        {
            $return = array('success' => false, 'msg' => __('No member found. Please re-log and try again.', 'wp-full-stripe-members') );
        }

        header("Content-Type: application/json");
        echo json_encode($return);
        exit;
    }

    function manual_create_member()
    {
        $wpUserID = $_POST['wpfs_members_wp_user_id'];
        $email = $_POST['wpfs_members_email'];
        $plan = $_POST['wpfs_members_plan'];
        $role = $_POST['wpfs_members_role'];
        $stripeCustomerID = $_POST['wpfs_members_customer_id'];
        $stripeSubscriptionID = $_POST['wpfs_members_subscription_id'];
        $liveMode = $_POST['wpfs_members_live_mode'];
        $return = array('success' => true);

        // Add new role to the new users
        $user = get_user_by('id', $wpUserID );
        $user->add_role($role); //this updates the user metadata in wpdb

        // Save in the DB
        $this->db->insert_member(array(
            'role' => $role,
            'plan' => $plan,
            'email' => $email,
            'wpUserID' => $wpUserID,
            'stripeCustomerID' => $stripeCustomerID,
            'stripeSubscriptionID' => $stripeSubscriptionID,
            'stripeSubscriptionStatus' => 'active',
            'livemode' => $liveMode,
            'created' => date('Y-m-d H:i:s')
        ));

        header("Content-Type: application/json");
        echo json_encode($return);
        exit;
    }

    /**
     * This is the first step of the process to import Stripe customers as WPFS Members
     *
     * @author tnagy
     */
    function import_subscribers_from_stripe_step1()
    {

        $response = array();

        $this->reset_in_session();

        $total_count = -1;
        $total_count_with_subscriptions = 0;
        $last_customer = null;
        $has_more = FALSE;

        try {

            do {
                $params = array("limit" => 100, "include[]" => "total_count");
                if (!is_null($last_customer)) {
                    $params["starting_after"] = $last_customer;
                }

                $list_all_response = Stripe_Customer::all($params);
                $has_more = $list_all_response->has_more;

                if ($total_count == -1) {
                    $total_count = $list_all_response->total_count;
                }

                foreach ($list_all_response->data as $customer) {
                    if (isset($customer->subscriptions)) {
                        if (!empty($customer->subscriptions->data)) {
                            $total_count_with_subscriptions += 1;
                        }
                    }
                }

                if ($has_more) {
                    $last_customer = $list_all_response->data[count($list_all_response->data) - 1]["id"];
                }


            } while ($has_more);

            $response['status'] = 'OK';

        } catch (Exception $e) {
            error_log($e);
            $response['status'] = 'ERROR';
        }

        $response['total_count'] = $total_count;
        $response['total_count_with_subscriptions'] = $total_count_with_subscriptions;

        header( "Content-Type: application/json" );
        echo json_encode($response);
        exit;

    }

    /**
     * This is the third step of the process to import Stripe customers as WPFS Members
     *
     * @author tnagy
     */
    function import_subscribers_from_stripe_step3()
    {
        $response = $this->init_response();

        $this->reset_in_session();
        $from_session = null;

        $total_count = -1;
        $page = 0;
        $last_customer = null;
        $has_more = 0;

        try {

            // tnagy load customers
            do {

                $page += 1;
                $params = array("limit" => 100, "include[]" => "total_count");
                if (!is_null($last_customer)) {
                    $params["starting_after"] = $last_customer;
                }

                $list_all_response = Stripe_Customer::all($params);
                $has_more = $list_all_response->has_more;

                $from_session = $this->get_from_session();
                $from_session[$page] = $list_all_response;
                $this->store_to_session($from_session);

                if ($total_count == -1) {
                    $total_count = $list_all_response->total_count;
                }

                if ($has_more) {
                    $last_customer = $list_all_response->data[count($list_all_response->data) - 1]["id"];
                }

            } while ($has_more);

            if ($total_count != -1) {
                $response['total_count'] = $total_count;
            }

            // tnagy import customers
            $from_session = $this->get_from_session();

            if (isset($from_session) && is_array($from_session)) {

                foreach ($from_session as $page => $customer_list) {

                    foreach ($customer_list->data as $customer) {

                        $result = $this->import_member($customer);

                        $this->handle_result($result, $customer, $response);

                    }

                }
            }

            if ($total_count != -1) {
                $response['total_count_with_subscriptions'] = $total_count - $response['no_subscriptions'];
            }

            $response['status'] = 'OK';

        } catch (Exception $e) {
            error_log($e);
            $this->remove_from_session();
            $response = array(
                'status' => 'ERROR'
            );
        }

        header( "Content-Type: application/json" );
        echo json_encode($response);
        exit;

    }


    /**
     * This is the fifth step of the process to import Stripe customers as WPFS Members
     *
     * @author tnagy
     */
    function import_subscribers_from_stripe_step5()
    {

        $response = $this->init_response();

        try {

            $plans = $_POST['plans'];

            if (isset($plans) && is_array($plans)) {

                $from_session = $this->get_from_session();

                if (isset($from_session) && is_array($from_session)) {
                    foreach ($from_session as $page => $customer_list) {
                        foreach ($customer_list->data as $customer) {

                            $preferred_plan = $this->find_preferred_plan($customer->id, $plans);

                            if (!is_null($preferred_plan)) {
                                $result = $this->import_member($customer, $preferred_plan);

                                $this->handle_result($result, $customer, $response);

                            }
                        }
                    }
                }

            }

            $response['status'] = 'OK';

            $this->remove_from_session();

        } catch (Exception $e) {
            error_log($e);
            $response = array(
                'status' => 'ERROR'
            );
        }

        header( "Content-Type: application/json" );
        echo json_encode($response);
        exit;

    }

    /**
     * @param $stripe_customer
     * @param null $preferred_plan_id
     * @return array
     * @author tnagy
     */
    function import_member($stripe_customer, $preferred_plan_id = null)
    {

        $result = array();

        $result['live_mode'] = $stripe_customer->livemode;

        $options = get_option('fullstripe_options');

        // Only allow test mode member creation if setting is allowed
        if (!$stripe_customer->livemode && $options['wpfs_members_create_test_members'] == 0) {
            $result['status'] = self::IMPORT_STATUS_ABORT_DUE_TO_TEST_MODE;
            return $result;
        }

        // Get stripe and role data
        $email = $stripe_customer->email;

        $role_for_preferred_plan = null;
        if (isset($preferred_plan_id)) {
            $role_for_preferred_plan = MM_WPFS_Members::getInstance()->get_role_for_plan($preferred_plan_id);
        }

        $plans = array();
        if (isset($stripe_customer->subscriptions)) {
            if (!empty($stripe_customer->subscriptions->data)) {
                foreach($stripe_customer->subscriptions->data as $subscription) {
                    $role_for_plan = MM_WPFS_Members::getInstance()->get_role_for_plan($subscription->plan->id);
                    if (!is_null($role_for_plan)) {

                        $add_plan = true;
                        if (isset($role_for_preferred_plan)) {
                            if ($role_for_plan !== $role_for_preferred_plan) {
                                $add_plan = false;
                            }
                        }
                        if ($add_plan) {
                            $plans[] = array(
                                'id' => $subscription->plan->id,
                                'role' => $role_for_plan,
                                'subscription_id' => $subscription->id,
                                'subscription_status' => $subscription->status
                            );
                        }
                    }
                }
            } else {
                $result['status'] = self::IMPORT_STATUS_ABORT_DUE_TO_NO_SUBSCRIPTIONS;
                return $result;
            }
        }

        $result['plans'] = $plans;

        if (empty($plans)) {
            $result['status'] = self::IMPORT_STATUS_ABORT_DUE_TO_NO_PLANS_MATCHING_SUBSCRIPTIONS;
            return $result;
        }

        if (count($plans) > 1) {
            $result['status'] = self::IMPORT_STATUS_ABORT_DUE_TO_AMBIGUOUS_PLANS;
            return $result;
        }

        // First check if the user exists
        $wp_user_id = username_exists($email);
        if (!$wp_user_id) {
            // We also want to check that the email isn't already registered to another user
            $wp_user_id = email_exists($email);
            if (!$wp_user_id) {
                $this->import__create_new_user($stripe_customer, $plans[0], $preferred_plan_id);
                $wp_user_id = username_exists($email);
                $result['status'] = self::IMPORT_STATUS_SUCCESSFULLY_CREATED;
            } else {
                // add the role to this user
                $this->import__update_existing_user($wp_user_id, $stripe_customer, $plans[0]);
                $result['status'] = self::IMPORT_STATUS_SUCCESSFULLY_UPDATED;
            }
        } else {
            // update the role of this user
            $this->import__update_existing_user($wp_user_id, $stripe_customer, $plans[0]);
            $result['status'] = self::IMPORT_STATUS_SUCCESSFULLY_UPDATED;
        }

        $result['wp_user_id'] = $wp_user_id;

        return $result;
    }

    function member_change_level($member, $newPlan)
    {
        $cu = Stripe_Customer::retrieve($member->stripeCustomerID);
        $subscription = $cu->subscriptions->retrieve($member->stripeSubscriptionID);
        $subscription->plan = $newPlan;
        $subscription->save();
    }

    function member_cancel_membership($member)
    {
        $cu = Stripe_Customer::retrieve($member->stripeCustomerID);
        $subscription = $cu->subscriptions->retrieve($member->stripeSubscriptionID);
        $subscription->cancel(array('at_period_end' => true));
    }

    function member_update_card($member, $card)
    {
        $cu = Stripe_Customer::retrieve($member->stripeCustomerID);
        $cu->card = $card;
        $cu->save();
    }

    //////////////////////////
    ///  Private functions
    //////////////////////////

    private function create_new_user($stripeCustomer, $planRole)
    {
        $password = wp_generate_password( $length=12, $include_standard_special_chars=false );
        $options = get_option('fullstripe_options');
        if ($options['wpfs_members_default_password'] == 1)
            $password = $this->default_password;

        // Create a user with the email as username
        $user_id = wp_create_user( $stripeCustomer->email, $password, $stripeCustomer->email );
        // Add new role to the new users
        $user = get_user_by('id', $user_id );
        $user->add_role($planRole); //this updates the user metadata in wpdb
        // Save in the DB
        $this->db->insert_member(array(
            'role' => $planRole,
            'plan' => $stripeCustomer->subscription->plan->id,
            'email' => $stripeCustomer->email,
            'wpUserID' => $user_id,
            'stripeCustomerID' => $stripeCustomer->id,
            'stripeSubscriptionID' => $stripeCustomer->subscription->id,
            'stripeSubscriptionStatus' => $stripeCustomer->subscription->status,
            'livemode' => $stripeCustomer->livemode,
            'created' => date('Y-m-d H:i:s', $stripeCustomer->created)
        ));
        //Send registration email
        $this->email_new_user($stripeCustomer->email, $password);
    }

    private function update_existing_user($wpUserID, $stripeCustomer, $planRole)
    {
        $user = get_user_by('id', $wpUserID);
        $user->add_role($planRole);

        // Check if they have been a member before
        $member = $this->db->get_member_by_wpid($wpUserID);
        if ($member)
        {
            $this->db->update_member($member->memberID, array(
                'role' => $planRole,
                'plan' => $stripeCustomer->subscription->plan->id,
                'stripeSubscriptionID' => $stripeCustomer->subscription->id,
                'stripeSubscriptionStatus' => $stripeCustomer->subscription->status,
            ));
        }
        else
        {
            // Save in the DB
            $this->db->insert_member(array(
                'role' => $planRole,
                'plan' => $stripeCustomer->subscription->plan->id,
                'email' =>  $stripeCustomer->email,
                'wpUserID' => $wpUserID,
                'stripeCustomerID' => $stripeCustomer->id,
                'stripeSubscriptionID' => $stripeCustomer->subscription->id,
                'stripeSubscriptionStatus' => $stripeCustomer->subscription->status,
                'livemode' => $stripeCustomer->livemode,
                'created' => date('Y-m-d H:i:s', $stripeCustomer->created)
            ));
        }
    }

    /**
     * Create new user by Import process
     *
     * @param $stripe_customer
     * @param $plan
     */
    private function import__create_new_user($stripe_customer, $plan)
    {
        //$password = wp_generate_password($length = 20, $include_standard_special_chars = false);
         $password ='NewMember123';
        $options = get_option('fullstripe_options');
        if ($options['wpfs_members_default_password'] == 1) {
            //$password = $this->default_password;
            $password ='NewMember123';
        }

        // Create a user with the email as username
        $user_id = wp_create_user($stripe_customer->email, $password, $stripe_customer->email);
        // Add new role to the new users
        $user = get_user_by('id', $user_id);
        // tnagy remove existing roles
        foreach ($user->roles as $role) {
            $user->remove_role($role);
        }
        // tnagy add role by plan
        $user->add_role($plan['role']); //this updates the user metadata in wpdb

        // tnagy look for existing wpfs member by email
        $member = $this->db->get_member_by_email($stripe_customer->email);
        if ($member) {
            $this->db->update_member($member->memberID, array(
                'role' => $plan['role'],
                'plan' => $plan['id'],
                'wpUserID' => $user_id,
                'stripeCustomerID' => $stripe_customer->id,
                'stripeSubscriptionID' => $plan['subscription_id'],
                'stripeSubscriptionStatus' => $plan['subscription_status'],
                'livemode' => $stripe_customer->livemode,
                'created' => date('Y-m-d H:i:s', $stripe_customer->created)
            ));
        } else {
            // Save in the DB
            $this->db->insert_member(array(
                'role' => $plan['role'],
                'plan' => $plan['id'],
                'email' => $stripe_customer->email,
                'wpUserID' => $user_id,
                'stripeCustomerID' => $stripe_customer->id,
                'stripeSubscriptionID' => $plan['subscription_id'],
                'stripeSubscriptionStatus' => $plan['subscription_status'],
                'livemode' => $stripe_customer->livemode,
                'created' => date('Y-m-d H:i:s', $stripe_customer->created)
            ));
        }
    }

    /**
     * Update existing user by Import process
     *
     * @param $wp_user_id
     * @param $stripe_customer
     * @param $plan
     *
     * @author tnagy
     */
    private function import__update_existing_user($wp_user_id, $stripe_customer, $plan)
    {
        $user = get_user_by('id', $wp_user_id);
        $user->add_role($plan['role']);

        // Check if they have been a member before
        $member = $this->db->get_member_by_wpid($wp_user_id);
        if ($member)
        {
            $this->db->update_member($member->memberID, array(
                'role' => $plan['role'],
                'plan' => $plan['id'],
                'stripeSubscriptionID' => $plan['subscription_id'],
                'stripeSubscriptionStatus' => $plan['subscription_status'],
            ));
        }
        else
        {
            // Save in the DB
            $this->db->insert_member(array(
                'role' => $plan['role'],
                'plan' => $plan['id'],
                'email' =>  $stripe_customer->email,
                'wpUserID' => $wp_user_id,
                'stripeCustomerID' => $stripe_customer->id,
                'stripeSubscriptionID' => $plan['subscription_id'],
                'stripeSubscriptionStatus' => $plan['subscription_status'],
                'livemode' => $stripe_customer->livemode,
                'created' => date('Y-m-d H:i:s', $stripe_customer->created)
            ));
        }
    }

    private function email_new_user($email, $password)
    {
        //$name = get_bloginfo('name');
        //$admin_email = get_bloginfo('admin_email');

        $name = "couponbutter";
        $admin_email = "sandeep@simayaa.com";
        //$headers[] = "From: $name <$admin_email>";
        //$headers[] = "Content-type: text/html";


       
        $headers  = 'From: '.$name.'<'. strip_tags($admin_email) .'>' . "\r\n";
        $headers .= 'Reply-To: '.$name.'<'. strip_tags($admin_email) .'>' . "\r\n";

        //$headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";
        $headers .= "CC: coupons@couponbutter.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        


        $msg = "<html><body><h2>Registration Successful!</h2>";
        $msg .= "<p>Hi,</p><p>Thanks for registering at $name.  Your login details are below: </p><br/>";
        $msg .= "<p>Username: $email </p><br/>";
        $msg .= "<p>Password: $password </p><br/>";
        $msg .= "<p>Please make sure to update your password on first login.</p>";
        $msg .= "<p>Thanks!</p><p><a href='" . site_url() . "/login/'>" . site_url() . "/login/</a></p></body></html>";


        
            

        wp_mail($email,
            apply_filters('wpfs_members_signup_email_subject', 'Registration Successful'),
            apply_filters('wpfs_members_signup_email_message', $msg),
            apply_filters('wpfs_members_signup_email_headers', $headers));
    }

     /**
     * Removes Stripe customers from session
     *
     * @author tnagy
     */
    private function remove_from_session() {
        $session_key = self::SESSION_KEY_IMPORTED_SUBSCRIBERS;
        unset($_SESSION[$session_key]);
    }

    /**
     * Initialize an empty array in session for Stripe customers
     *
     * @author tnagy
     */
    private function reset_in_session() {
        $session_key = self::SESSION_KEY_IMPORTED_SUBSCRIBERS;
        $_SESSION[$session_key] = array();
    }

    /**
     * Gets the Stripe customers' array from session
     *
     * @return array
     *
     * @author tnagy
     */
    private function get_from_session() {
        $session_key = self::SESSION_KEY_IMPORTED_SUBSCRIBERS;
        if (isset($_SESSION[$session_key])) {
            return $_SESSION[$session_key];
        } else {
            return array();
        }
    }

    /**
     * Stores Stripe customers to session
     *
     * @param $value
     *
     * @author tnagy
     */
    private function store_to_session($value) {
        $session_key = self::SESSION_KEY_IMPORTED_SUBSCRIBERS;
        $_SESSION[$session_key] = $value;
    }

    /**
     * @param $result
     * @param $customer
     * @param $response
     */
    private function handle_result($result, $customer, &$response)
    {
        $response['live_mode'] = $result['live_mode'];
        switch ($result['status']) {
            case self::IMPORT_STATUS_ABORT_DUE_TO_TEST_MODE:
                $response['test_mode'][] = array(
                    'name' => $customer->metadata->customer_name,
                    'email' => $customer->email,
                    'customer_id' => $customer->id,
                    'reason' => $result['status']
                );
                break;
            case self::IMPORT_STATUS_ABORT_DUE_TO_NO_SUBSCRIPTIONS:
                $response['no_subscriptions'] += 1;
                break;
            case self::IMPORT_STATUS_ABORT_DUE_TO_NO_PLANS_MATCHING_SUBSCRIPTIONS:
                $response['cannot_import'][] = array(
                    'name' => $customer->metadata->customer_name,
                    'email' => $customer->email,
                    'customer_id' => $customer->id,
                    'reason' => $result['status']
                );
                break;
            case self::IMPORT_STATUS_ABORT_DUE_TO_AMBIGUOUS_PLANS:
                $available_plans_for_customer = array();
                $available_plans = $this->get_available_plans();
                foreach ($available_plans as $plan) {
                    foreach ($result['plans'] as $subscription_plan) {
                        if ($plan['plan'] === $subscription_plan['id']) {
                            $available_plans_for_customer[] = $plan;
                        }
                    }
                }
                $response['can_import_manually'][] = array(
                    'name' => $customer->metadata->customer_name,
                    'email' => $customer->email,
                    'customer_id' => $customer->id,
                    'reason' => $result['status'],
                    'available_plans' => $available_plans_for_customer
                );
                break;
            case self::IMPORT_STATUS_SUCCESSFULLY_CREATED:
            case self::IMPORT_STATUS_SUCCESSFULLY_UPDATED:
                $response['imported_successfully'] += 1;
                break;
        }
    }

    private function find_preferred_plan($customer_id, $plans) {
        foreach ($plans as $plan) {
            if ($plan['name'] === $customer_id) {
                return $plan['value'];
            }
        }
        return null;
    }

    /**
     * @return array
     */
    private function get_available_plans()
    {
        $available_plans = array();
        $role_plans = MM_WPFS_Members::getInstance()->get_role_plans();
        $role_names = MM_WPFS_Members::getInstance()->get_wp_role_names();
        foreach ($role_plans as $role => $plan) {
            $available_plans[] = array(
                'role' => $role,
                'plan' => $plan,
                'display_name' => $role_names[$role]
            );
        }
        return $available_plans;
    }

    /**
     * @return mixed
     */
    private function init_response()
    {
        $response = array();
        $response['imported_successfully'] = 0;
        $response['no_subscriptions'] = 0;
        $response['test_mode'] = array();
        $response['cannot_import'] = array();
        $response['can_import_manually'] = array();
        return $response;
    }

}