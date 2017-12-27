<?php

class MM_WPFS_Members
{
    public static $instance;

    const VERSION = '1.2.0';

    /** @var MM_WPFS_Members_Admin_Menu */
    private $admin_menu = null;
    /** @var MM_WPFS_Members_Database */
    private $db = null;
    /** @var MM_WPFS_Members_Admin */
    private $admin = null;
    /** @var MM_WPFS_Members_Front */
    private $front = null;
    private $role_plans = array();
    private $role_ranks = array();

    /**
     * @var string
     */
    const ERR_INVALID_NUMBER_ERROR = 'invalid_number';
    /**
     * @var string
     */
    const ERR_INVALID_EXPIRY_MONTH_ERROR = 'invalid_expiry_month';
    /**
     * @var string
     */
    const ERR_INVALID_EXPIRY_YEAR_ERROR = 'invalid_expiry_year';
    /**
     * @var string
     */
    const ERR_INVALID_CVC_ERROR = 'invalid_cvc';
    /**
     * @var string
     */
    const ERR_INCORRECT_NUMBER_ERROR = 'incorrect_number';
    /**
     * @var string
     */
    const ERR_EXPIRED_CARD_ERROR = 'expired_card';
    /**
     * @var string
     */
    const ERR_INCORRECT_CVC_ERROR = 'incorrect_cvc';
    /**
     * @var string
     */
    const ERR_INCORRECT_ZIP_ERROR = 'incorrect_zip';
    /**
     * @var string
     */
    const ERR_CARD_DECLINED_ERROR = 'card_declined';
    /**
     * @var string
     */
    const ERR_MISSING_ERROR = 'missing';
    /**
     * @var string
     */
    const ERR_PROCESSING_ERROR = 'processing_error';


    /**
     * @var string
     */
    const STATUS_ACTIVE = 'active';
    /**
     * @var string
     */
    const STATUS_UNPAID = 'unpaid';
    /**
     * @var string
     */
    const STATUS_CANCELING = 'canceling';
    /**
     * @var string
     */
    const STATUS_CANCELLED = 'cancelled';
    /**
     * @var string
     */
    const STATUS_PAST_DUE = 'past_due';
    /**
     * @var string
     */
    const STATUS_TRIALING = 'trialing';


    /**
     * @var string
     */
    const ROLE_NO_ACCESS = 'wpfs_no_access';
    /**
     * @var string
     */
    const ROLE_BASIC = 'wpfs_basic';
    /**
     * @var string
     */
    const ROLE_BRONZE = 'wpfs_bronze';
    /**
     * @var string
     */
    const ROLE_SILVER = 'wpfs_silver';
    /**
     * @var string
     */
    const ROLE_GOLD = 'wpfs_gold';
    /**
     * @var string
     */
    const ROLE_ALL_ACCESS = 'wpfs_all_access';



    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new MM_WPFS_Members();
        return self::$instance;
    }

    public function __construct()
    {
        $this->includes();
        $this->hooks();
        $this->setup();
    }

    private function includes() {
        include_once 'wpfs-members-database.php';
        include_once 'wpfs-members-admin-menu.php';
        include_once 'wpfs-members-admin.php';
        include_once 'wpfs-members-front.php';
        if ( ! class_exists( 'MM_WPFS_Stripe' ) ) {
            include_once trailingslashit( WP_PLUGIN_DIR ) . 'wp-full-stripe/include/wp-full-stripe-payments.php';
        }
    }

    private function hooks()
    {
        add_action('wp_ajax_wpfs_members_set_role_plans', array($this, 'set_role_plans'));
        add_action('wp_ajax_wpfs_members_update_settings', array($this, 'update_settings'));
        add_shortcode('wpfs_members_account', array($this, 'members_account'));
        add_action( 'check_member_status', array($this, 'check_member_status') );
        add_filter('auth_cookie_expiration', array($this, 'auth_cookie_expiration') ,10,3);
    }

    private function setup()
    {
        $this->role_plans = array(
            'wpfs_basic' => null,
            'wpfs_bronze' => null,
            'wpfs_silver' => null,
            'wpfs_gold' => null,
            'wpfs_all_access' => null
        );

        $this->role_ranks = array(
            'wpfs_no_access' => 0,
            'wpfs_basic' => 1,
            'wpfs_bronze' => 2,
            'wpfs_silver' => 3,
            'wpfs_gold' => 4,
            'wpfs_all_access' => 999999
        );

        //set option defaults
        $options = get_option('fullstripe_options');
        if (!array_key_exists('wpfs_members_version', $options) || $options['wpfs_members_version'] != self::VERSION)
        {
            $this->set_option_defaults($options);
        }

        // create classes
        $this->db = new MM_WPFS_Members_Database();
        $this->admin_menu = new MM_WPFS_Members_Admin_Menu();
        $this->admin = new MM_WPFS_Members_Admin();
        $this->front = new MM_WPFS_Members_Front();

        // schedule event to regularly check members status
        if ( ! wp_next_scheduled( 'check_member_status' ) ) {
            wp_schedule_event( time(), 'daily', 'check_member_status');
        }
    }

    private function set_option_defaults($options)
    {
        //first time installing wpfs_members
        if (!array_key_exists('wpfs_members_version', $options))
        {
            $options['wpfs_members_version'] = self::VERSION;
            $options['wpfs_members_role_plans'] = $this->role_plans;
            $options['wpfs_members_update_db'] = false;
            $options['wpfs_members_create_test_members'] = 0;
            $options['wpfs_members_default_password'] = 0;
            $options['wpfs_members_block_past_due'] = 1;
            $options['wpfs_members_allow_change_level'] = 1;
            $options['wpfs_members_allow_cancel_membership'] = 1;
            $options['wpfs_members_cookie_expiration'] = 172800; // 2 days
            $options['wpfs_members_member_status_cron'] = 1;
        }
        else //updating version
        {
            $options['wpfs_members_version'] = self::VERSION;
            if (!array_key_exists('wpfs_members_role_plans', $options)) $options['wpfs_members_role_plans'] = $this->role_plans;
            if (!array_key_exists('wpfs_members_create_test_members', $options)) $options['wpfs_members_create_test_members'] = 0;
            if (!array_key_exists('wpfs_members_default_password', $options)) $options['wpfs_members_default_password'] = 0;
            if (!array_key_exists('wpfs_members_block_past_due', $options)) $options['wpfs_members_block_past_due'] = 1;
            if (!array_key_exists('wpfs_members_allow_change_level', $options)) $options['wpfs_members_allow_change_level'] = 1;
            if (!array_key_exists('wpfs_members_allow_cancel_membership', $options)) $options['wpfs_members_allow_cancel_membership'] = 1;
            if (!array_key_exists('wpfs_members_cookie_expiration', $options)) $options['wpfs_members_cookie_expiration'] = 172800; //2 days
            if (!array_key_exists('wpfs_members_member_status_cron', $options)) $options['wpfs_members_member_status_cron'] = 1;

            // might also need db update
            MM_WPFS_Members_Database::setup_db();
        }

        update_option('fullstripe_options', $options);
    }

    public static function setup_db()
    {
        include_once 'wpfs-members-database.php';
        MM_WPFS_Members_Database::setup_db();

        // Setup our default roles.  In later versions we'll allow users to create more
        add_role('wpfs_no_access', 'No Access', array('read' => true)); // The no_access role is used to block user from any protected pages (usually on subscription expiry)
        add_role('wpfs_basic', 'Basic', array('read' => true));
        add_role('wpfs_bronze', 'Bronze', array('read' => true));
        add_role('wpfs_silver', 'Silver', array('read' => true));
        add_role('wpfs_gold', 'Gold', array('read' => true));
        add_role('wpfs_all_access', 'All Access', array('read' => true));
    }

    public static function uninstall()
    {
        remove_role('wpfs_no_access');
        remove_role('wpfs_basic');
        remove_role('wpfs_bronze');
        remove_role('wpfs_silver');
        remove_role('wpfs_gold');
        remove_role('wpfs_all_access');

        wp_clear_scheduled_hook( 'check_member_status' );
    }

    public function update_settings()
    {
        if (defined('WPFS_MEMBERS_DEMO')) return;

        $options = get_option('fullstripe_options');
        $options['wpfs_members_create_test_members'] = $_POST['wpfs_members_create_test_members'];
        $options['wpfs_members_default_password'] =  $_POST['wpfs_members_default_password'];
        $options['wpfs_members_block_past_due'] =  $_POST['wpfs_members_block_past_due'];
        $options['wpfs_members_allow_change_level'] =  $_POST['wpfs_members_allow_change_level'];
        $options['wpfs_members_allow_cancel_membership'] =  $_POST['wpfs_members_allow_cancel_membership'];
        $options['wpfs_members_cookie_expiration'] =  $_POST['wpfs_members_cookie_expiration'];
        $options['wpfs_members_member_status_cron'] =  $_POST['wpfs_members_member_status_cron'];
        update_option('fullstripe_options', $options);
    }

    public function members_account()
    {
        //load scripts
        $options = get_option('fullstripe_options');
        wp_enqueue_script( 'stripe-js', 'https://js.stripe.com/v2/', array( 'jquery' ) );
        wp_enqueue_script( 'sprintf-js', plugins_url( 'js/sprintf.min.js', dirname( __FILE__ ) ), null, MM_WPFS_Members::VERSION );
        wp_enqueue_script( 'wpfs-members-public-js', plugins_url( 'js/public.js', dirname( __FILE__ ) ), array(
            'sprintf-js',
            'stripe-js'
        ), MM_WPFS_Members::VERSION );
        if ($options['apiMode'] === 'test')
        {
            wp_localize_script('wpfs-members-public-js', 'stripekey', $options['publishKey_test']);
        }
        else
        {
            wp_localize_script('wpfs-members-public-js', 'stripekey', $options['publishKey_live']);
        }

        wp_localize_script('wpfs-members-public-js', 'ajaxurl', admin_url('admin-ajax.php'));

        $stripe = new MM_WPFS_Stripe();
        wp_localize_script( 'wpfs-members-public-js', 'wpfsm_L10n', array(
            'changeLevelSuccessMessage'                => __( 'Membership updated successfully.', 'wp-full-stripe-members' ),
            'cancelMembershipSuccessMessage'           => __( 'Membership canceled successfully.', 'wp-full-stripe-members' ),
            'updateCardSuccessMessage'                 => __( 'Credit card updated successfully.', 'wp-full-stripe-members' ),
            'plan_details_with_singular_interval'      =>
            /* translators: 1: currency symbol/code, 2: amount, 3: interval in singular */
                __( 'Price is %1$s%2$.2f per %3$s', 'wp-full-stripe-members' ),
            'plan_details_with_plural_interval'        =>
            /* translators: 1: currency symbol/code, 2: amount, 3: interval count > 1, 4: interval in plural */
                __( 'Price is %1$s%2$.2f per %3$d %4$s', 'wp-full-stripe-members' ),
            self::ERR_INVALID_NUMBER_ERROR       => self::resolve_error_message_by_code( self::ERR_INVALID_NUMBER_ERROR ),
            self::ERR_INVALID_EXPIRY_MONTH_ERROR => self::resolve_error_message_by_code( self::ERR_INVALID_EXPIRY_MONTH_ERROR ),
            self::ERR_INVALID_EXPIRY_YEAR_ERROR  => self::resolve_error_message_by_code( self::ERR_INVALID_EXPIRY_YEAR_ERROR ),
            self::ERR_INVALID_CVC_ERROR          => self::resolve_error_message_by_code( self::ERR_INVALID_CVC_ERROR ),
            self::ERR_INCORRECT_NUMBER_ERROR     => self::resolve_error_message_by_code( self::ERR_INCORRECT_NUMBER_ERROR ),
            self::ERR_EXPIRED_CARD_ERROR         => self::resolve_error_message_by_code( self::ERR_EXPIRED_CARD_ERROR ),
            self::ERR_INCORRECT_CVC_ERROR        => self::resolve_error_message_by_code( self::ERR_INCORRECT_CVC_ERROR ),
            self::ERR_INCORRECT_ZIP_ERROR        => self::resolve_error_message_by_code( self::ERR_INCORRECT_ZIP_ERROR ),
            self::ERR_CARD_DECLINED_ERROR        => self::resolve_error_message_by_code( self::ERR_CARD_DECLINED_ERROR ),
            self::ERR_MISSING_ERROR              => self::resolve_error_message_by_code( self::ERR_MISSING_ERROR ),
            self::ERR_PROCESSING_ERROR           => self::resolve_error_message_by_code( self::ERR_PROCESSING_ERROR )
        ) );

        wp_enqueue_style('wpfs-members-bootstrap-css', plugins_url('/css/newstyle.css', dirname(__FILE__)));

        // Get membership details for page
        if ( is_user_logged_in() )
        {
            $current_user = wp_get_current_user();
            $member = $this->db->get_member_by_wpid($current_user->ID);

            if ($member)
            {
                try
                {
                    $subscription = MM_WPFS::getInstance()->get_subscription($member->stripeCustomerID, $member->stripeSubscriptionID);
                }
                catch (Exception $e)
                {
                    //TODO: Send admin email with exact Stripe error
                    //...
                    return "<p>There was an error retrieving your account details. Please try again later.</p>";
                }

                ob_start();
                include  WPFS_MEMBERS_DIR . '/views/members_account.php';
                $content = ob_get_clean();
                return apply_filters('wpfs_members_account_page_html', $content);
            }
        }

        // Not logged in or a member
        ob_start();
        include  WPFS_MEMBERS_DIR . '/views/non_member_account.php';
        $content = ob_get_clean();
        return apply_filters('wpfs_members_account_page_html', $content);
    }

    public function check_member_status()
    {
        if (defined('WPFS_MEMBERS_DEMO')) return;

        $options = get_option('fullstripe_options');
        if ($options['wpfs_members_member_status_cron'] == 1)
        {
            $members = $this->db->get_members();
            //NOTE:  This could take a while for sites with lots of members
            foreach ($members as $m)
            {
                $this->admin->check_member_status($m);
            }
        }
    }

    function auth_cookie_expiration($expiry, $user_id, $remember)
    {
        $options = get_option('fullstripe_options');
        return $options['wpfs_members_cookie_expiration'];
    }

    public function get_wp_roles()
    {
        $wpRoles = array();
        $wpRoles['wpfs_no_access'] = get_role('wpfs_no_access');
        $wpRoles['wpfs_basic'] = get_role('wpfs_basic');
        $wpRoles['wpfs_bronze'] = get_role('wpfs_bronze');
        $wpRoles['wpfs_silver'] = get_role('wpfs_silver');
        $wpRoles['wpfs_gold'] = get_role('wpfs_gold');
        $wpRoles['wpfs_all_access'] = get_role('wpfs_all_access');
        return $wpRoles;
    }

    // get a list of values, containing pairs of: $role_name => $display_name
    public function get_wp_role_names()
    {
        global $wp_roles;
        return $wp_roles->get_names();
    }

    public function get_role_plans()
    {
        $options = get_option('fullstripe_options');
        return $options['wpfs_members_role_plans'];
    }

    public function set_role_plans()
    {
        if (defined('WPFS_MEMBERS_DEMO')) return;

        $rolePlans = $this->get_role_plans();
        $newPlans = array();
        foreach ($rolePlans as $role => $plan)
        {
            // $_POST[$role] contains value of <select name=role> i.e. the plan ID
            if (isset($_POST[$role]))
            {
                if ($_POST[$role] != 'none')
                    $newPlans[$role] = $_POST[$role];
                else
                    $newPlans[$role] = null;
            }
        }

        $options = get_option('fullstripe_options');
        $options['wpfs_members_role_plans'] = $newPlans;
        update_option('fullstripe_options', $options);

        header("Content-Type: application/json");
        echo json_encode(array('success' => true));
        exit;
    }

    public function get_role_for_plan($planID)
    {
        $options = get_option('fullstripe_options');
        foreach ($options['wpfs_members_role_plans'] as $role => $plan)
        {
            if ($plan == $planID)
            {
                return $role;
            }
        }
        return null;
    }

    // Get all Stripe::Plans for roles that have set plans
    public function get_stripe_plans_for_active_roles()
    {
        $rolePlans = $this->get_role_plans();

        $stripePlans = array();
        foreach ($rolePlans as $role => $plan)
        {
            if ($plan)
            {
                $sp = Stripe_Plan::retrieve($plan); // This exists and API key setup because of WPFS being installed
                $stripePlans[$role] = $sp;
            }
        }

        return $stripePlans;
    }

    public function get_role_ranks()
    {
        return $this->role_ranks;
    }

    public function get_member($memberID)
    {
        return $this->db->get_member($memberID);
    }

    public function get_currency_symbol()
    {
        $options = get_option('fullstripe_options');
        $currencySymbol = '$';
        if ( $options['currency'] === 'eur' )
        {
            $currencySymbol = '€';
        }
        elseif ( $options['currency'] === 'gbp' )
        {
            $currencySymbol = '£';
        }
        elseif ( $options['currency'] === 'cad' )
        {
            $currencySymbol = '$';
        }
        return $currencySymbol;
    }

    public static function echo_translated_label( $label ) {
        echo self::translate_label( $label );
    }

    public static function translate_label( $label ) {
        if ( empty( $label ) ) {
            return '';
        }

        return __( sanitize_text_field( $label ), 'wp-full-stripe-members' );
    }

    public static function get_translated_interval_label( $interval, $count ) {
        $label = null;
        if ( $interval == 'week' ) {
            $label = _n( 'week', 'weeks', $count, 'wp-full-stripe-members' );
        } elseif ( $interval == 'month' ) {
            $label = _n( 'month', 'months', $count, 'wp-full-stripe-members' );
        } elseif ( $interval == 'year' ) {
            $label = _n( 'year', 'years', $count, 'wp-full-stripe-members' );
        } else {
            $label = $interval;
        }
        return $label;
    }

    
    public static function resolve_role_by_code ( $role ) {
        if ( $role === self::ROLE_NO_ACCESS) {
            $resolved_role =  /* translators: Membership role 'No Access' */
                __('No Access', 'wp-full-stripe-members');
        } elseif ( $role === self::ROLE_BASIC) {
            $resolved_role =  /* translators: Membership role 'Basic' */
                __( 'Basic', 'wp-full-stripe-members' );
        } elseif ( $role === self::ROLE_BRONZE) {
            $resolved_role =  /* translators: Membership role 'Bronze' */
                __( 'Bronze', 'wp-full-stripe-members' );
        } elseif ( $role === self::ROLE_SILVER) {
            $resolved_role =  /* translators: Membership role 'Silver' */
                __( 'Silver', 'wp-full-stripe-members' );
        } elseif ( $role === self::ROLE_GOLD) {
            $resolved_role =  /* translators: Membership role 'Gold' */
                __( 'Gold', 'wp-full-stripe-members' );
        } elseif ( $role === self::ROLE_ALL_ACCESS) {
            $resolved_role =  /* translators: Membership role 'All Access' */
                __( 'All Access', 'wp-full-stripe-members' );
        } else {
            $roleNames = MM_WPFS_Members::getInstance()->get_wp_role_names();
            $resolved_role = MM_WPFS_Members::translate_label( $roleNames[ $role ] );
        }

        return $resolved_role;
    }


    public static function resolve_status_by_code ( $status ) {
        if ( $status === self::STATUS_ACTIVE) {
            $resolved_status =  /* translators: Stripe subscription status code 'Active' */
                __( 'Active', 'wp-full-stripe-members' );
        } elseif ( $status === self::STATUS_CANCELLED ) {
            $resolved_status = /* translators: Stripe subscription status code 'Cancelled' */
                __('Cancelled', 'wp-full-stripe-members');
        } elseif ( $status === self::STATUS_CANCELING ) {
            $resolved_status = /* translators: Stripe subscription status code 'Cancelled' */
                __('Canceling', 'wp-full-stripe-members');
        } elseif ( $status === self::STATUS_PAST_DUE ) {
            $resolved_status = /* translators: Stripe subscription status code 'Past due' */
                __('Past due', 'wp-full-stripe-members');
        } elseif ( $status === self::STATUS_UNPAID ) {
            $resolved_status = /* translators: Stripe subscription status code 'Unpaid' */
                __('Unpaid', 'wp-full-stripe-members');
        } elseif ( $status === self::STATUS_TRIALING ) {
            $resolved_status = /* translators: Stripe subscription status code 'Trialing' */
                __('Trialing', 'wp-full-stripe-members');
        } else {
            $resolved_status = MM_WPFS_Members::translate_label( $status );
        }

        return $resolved_status;
    }


    private static function resolve_error_message_by_code( $code ) {
        if ( $code === self::ERR_INVALID_NUMBER_ERROR ) {
            $resolved_message =  /* translators: message for Stripe error code 'invalid_number' */
                __( 'The card number is not a valid credit card number.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INVALID_EXPIRY_MONTH_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'invalid_expiry_month' */
                __( 'The card\'s expiration month is invalid.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INVALID_EXPIRY_YEAR_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'invalid_expiry_year' */
                __( 'The card\'s expiration year is invalid.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INVALID_CVC_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'invalid_cvc' */
                __( 'The card\'s security code is invalid.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INCORRECT_NUMBER_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'incorrect_number' */
                __( 'The card number is incorrect.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_EXPIRED_CARD_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'expired_card' */
                __( 'The card has expired.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INCORRECT_CVC_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'incorrect_cvc' */
                __( 'The card\'s security code is incorrect.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_INCORRECT_ZIP_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'incorrect_zip' */
                __( 'The card\'s zip code failed validation.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_CARD_DECLINED_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'card_declined' */
                __( 'The card was declined.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_MISSING_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'missing' */
                __( 'There is no card on a customer that is being charged.', 'wp-full-stripe-members' );
        } elseif ( $code === self::ERR_PROCESSING_ERROR ) {
            $resolved_message = /* translators: message for Stripe error code 'processing_error' */
                __( 'An error occurred while processing the card.', 'wp-full-stripe-members' );
        } else {
            $resolved_message = null;
        }
        return $resolved_message;
    }
}

MM_WPFS_Members::getInstance();