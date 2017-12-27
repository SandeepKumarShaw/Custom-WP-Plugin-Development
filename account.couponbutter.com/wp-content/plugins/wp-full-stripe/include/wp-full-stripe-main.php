<?php
/*
WP Full Stripe
http://paymentsplugin.com
Complete Stripe payments integration for Wordpress
Mammothology
3.6.0
http://paymentsplugin.com
*/

require_once( 'wp-full-stripe-logger-configurator.php' );
require_once(ABSPATH .'wp-includes/pluggable.php');

class MM_WPFS {
	const VERSION = '3.6.0';
	public static $instance;
	/** @var MM_WPFS_Customer */
	private $customer = null;
	/** @var MM_WPFS_Admin */
	private $admin = null;
	/** @var MM_WPFS_Database */
	private $database = null;
	/** @var MM_WPFS_Stripe */
	private $stripe = null;
	/** @var MM_WPFS_Admin_Menu */
	private $adminMenu = null;
	private $log;

	public function __construct() {

		$this->includes();
		$this->setup();
		$this->hooks();

	}

	function includes() {

		include 'wp-full-stripe-database.php';
		include 'wp-full-stripe-mailer.php';
		include 'wp-full-stripe-customer.php';
		include 'wp-full-stripe-patcher.php';
		include 'wp-full-stripe-payments.php';
		include 'wp-full-stripe-admin.php';
		include 'wp-full-stripe-admin-menu.php';

		do_action( 'fullstripe_includes_action' );
	}

	function setup() {

		$this->log = Logger::getLogger( "WPFS" );

		//set option defaults
		$options = get_option( 'fullstripe_options' );
		if ( ! $options || $options['fullstripe_version'] != self::VERSION ) {
			$this->set_option_defaults( $options );
		}

		$this->update_option_defaults( get_option( 'fullstripe_options' ) );

		//set API key
		if ( $options['apiMode'] === 'test' ) {
			$this->fullstripe_set_api_key( $options['secretKey_test'] );
		} else {
			$this->fullstripe_set_api_key( $options['secretKey_live'] );
		}

		//setup subclasses to handle everything
		$this->database  = new MM_WPFS_Database();
		$this->customer  = new MM_WPFS_Customer();
		$this->admin     = new MM_WPFS_Admin();
		$this->stripe    = new MM_WPFS_Stripe();
		$this->adminMenu = new MM_WPFS_Admin_Menu();

		do_action( 'fullstripe_setup_action' );

	}

	function set_option_defaults( $options ) {
		if ( ! $options ) {

			$emailReceipts = $this->create_default_email_receipts();

			$arr = array(
				'secretKey_test'                       => 'YOUR_TEST_SECRET_KEY',
				'publishKey_test'                      => 'YOUR_TEST_PUBLISHABLE_KEY',
				'secretKey_live'                       => 'YOUR_LIVE_SECRET_KEY',
				'publishKey_live'                      => 'YOUR_LIVE_PUBLISHABLE_KEY',
				'apiMode'                              => 'test',
				'currency'                             => 'usd',
				'form_css'                             => ".fullstripe-form-title{ font-size: 120%;  color: #363636; font-weight: bold;}\n.fullstripe-form-input{}\n.fullstripe-form-label{font-weight: bold;}",
				'includeStyles'                        => '1',
				'receiptEmailType'                     => 'plugin',
				'email_receipts'                       => json_encode( $emailReceipts ),
				'email_receipt_sender_address'         => '',
				'admin_payment_receipt'                => '0',
				'lock_email_field_for_logged_in_users' => '1',
				'fullstripe_version'                   => self::VERSION,
				'webhook_token'                        => $this->create_webhook_token()
			);

			update_option( 'fullstripe_options', $arr );
		} else /* different version */ {
			$options['fullstripe_version'] = self::VERSION;
			if ( ! array_key_exists( 'secretKey_test', $options ) ) {
				$options['secretKey_test'] = 'YOUR_TEST_SECRET_KEY';
			}
			if ( ! array_key_exists( 'publishKey_test', $options ) ) {
				$options['publishKey_test'] = 'YOUR_TEST_PUBLISHABLE_KEY';
			}
			if ( ! array_key_exists( 'secretKey_live', $options ) ) {
				$options['secretKey_live'] = 'YOUR_LIVE_SECRET_KEY';
			}
			if ( ! array_key_exists( 'publishKey_live', $options ) ) {
				$options['publishKey_live'] = 'YOUR_LIVE_PUBLISHABLE_KEY';
			}
			if ( ! array_key_exists( 'apiMode', $options ) ) {
				$options['apiMode'] = 'test';
			}
			if ( ! array_key_exists( 'currency', $options ) ) {
				$options['currency'] = 'usd';
			}
			if ( ! array_key_exists( 'form_css', $options ) ) {
				$options['form_css'] = ".fullstripe-form-title{ font-size: 120%;  color: #363636; font-weight: bold;}\n.fullstripe-form-input{}\n.fullstripe-form-label{font-weight: bold;}";
			}
			if ( ! array_key_exists( 'includeStyles', $options ) ) {
				$options['includeStyles'] = '1';
			}
			if ( ! array_key_exists( 'receiptEmailType', $options ) ) {
				$options['receiptEmailType'] = 'plugin';
			}
			if ( ! array_key_exists( 'email_receipts', $options ) ) {
				$emailReceipts = $this->create_default_email_receipts();
				$options['email_receipts'] = json_encode( $emailReceipts );
			}
			if ( ! array_key_exists( 'email_receipt_sender_address', $options ) ) {
				$options['email_receipt_sender_address'] = '';
			}
			if ( ! array_key_exists( 'admin_payment_receipt', $options ) ) {
				$options['admin_payment_receipt'] = '0';
			}
			if ( ! array_key_exists( 'lock_email_field_for_logged_in_users', $options ) ) {
				$options['lock_email_field_for_logged_in_users'] = '1';
			}
			if ( ! array_key_exists( 'webhook_token', $options )) {
				$options['webhook_token'] = $this->create_webhook_token();
			}
			
			update_option( 'fullstripe_options', $options );
		}

		//also, if version changed then the DB might be out of date
		MM_WPFS_Database::fullstripe_setup_db();
	}

	function update_option_defaults( $options ) {
		if ( $options ) {
			if ( ! array_key_exists( 'secretKey_test', $options ) ) {
				$options['secretKey_test'] = 'YOUR_TEST_SECRET_KEY';
			}
			if ( ! array_key_exists( 'publishKey_test', $options ) ) {
				$options['publishKey_test'] = 'YOUR_TEST_PUBLISHABLE_KEY';
			}
			if ( ! array_key_exists( 'secretKey_live', $options ) ) {
				$options['secretKey_live'] = 'YOUR_LIVE_SECRET_KEY';
			}
			if ( ! array_key_exists( 'publishKey_live', $options ) ) {
				$options['publishKey_live'] = 'YOUR_LIVE_PUBLISHABLE_KEY';
			}
			if ( ! array_key_exists( 'apiMode', $options ) ) {
				$options['apiMode'] = 'test';
			}
			if ( ! array_key_exists( 'currency', $options ) ) {
				$options['currency'] = 'usd';
			}
			if ( ! array_key_exists( 'form_css', $options ) ) {
				$options['form_css'] = ".fullstripe-form-title{ font-size: 120%;  color: #363636; font-weight: bold;}\n.fullstripe-form-input{}\n.fullstripe-form-label{font-weight: bold;}";
			}
			if ( ! array_key_exists( 'includeStyles', $options ) ) {
				$options['includeStyles'] = '1';
			}
			if ( ! array_key_exists( 'receiptEmailType', $options ) ) {
				$options['receiptEmailType'] = 'plugin';
			}
			if ( ! array_key_exists( 'email_receipts', $options ) ) {
				$options['email_receipts'] = $this->create_default_email_receipts();
			}
			if ( ! array_key_exists( 'email_receipt_sender_address', $options ) ) {
				$options['email_receipt_sender_address'] = '';
			}
			if ( ! array_key_exists( 'admin_payment_receipt', $options ) ) {
				$options['admin_payment_receipt'] = 'no';
			} else {
				if ( $options['admin_payment_receipt'] == '0' ) {
					$options['admin_payment_receipt'] = 'no';
				}
				if ( $options['admin_payment_receipt'] == '1' ) {
					$options['admin_payment_receipt'] = 'website_admin';
				}
			}
			if ( ! array_key_exists( 'lock_email_field_for_logged_in_users', $options ) ) {
				$options['lock_email_field_for_logged_in_users'] = '1';
			}
			if ( ! array_key_exists( 'webhook_token', $options )) {
				$options['webhook_token'] = $this->create_webhook_token();
			}

			update_option( 'fullstripe_options', $options );

		}
	}

	function fullstripe_set_api_key( $key ) {
		if ( $key != '' && $key != 'YOUR_TEST_SECRET_KEY' && $key != 'YOUR_LIVE_SECRET_KEY' ) {
			try {
				Stripe::setApiKey( $key );
			} catch ( Exception $e ) {
				//invalid key was set, ignore it
			}
		}
	}

	function hooks() {

		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
		add_shortcode( 'fullstripe_payment', array( $this, 'fullstripe_payment_form' ) );
		add_shortcode( 'fullstripe_subscription', array( $this, 'fullstripe_subscription_form' ) );
		add_shortcode( 'fullstripe_checkout', array( $this, 'fullstripe_checkout_form' ) );
		add_action( 'wp_head', array( $this, 'fullstripe_wp_head' ) );

		do_action( 'fullstripe_main_hooks_action' );
	}

	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new MM_WPFS();
		}

		return self::$instance;
	}

	public static function setup_db() {
		MM_WPFS_Database::fullstripe_setup_db();
		MM_WPFS_Patcher::apply_patches();
	}

	public static function get_translated_interval_label( $interval, $count ) {
		$label = null;
		if ( $interval == 'week' ) {
			$label = _n( 'week', 'weeks', $count, 'wp-full-stripe' );
		} elseif ( $interval == 'month' ) {
			$label = _n( 'month', 'months', $count, 'wp-full-stripe' );
		} elseif ( $interval == 'year' ) {
			$label = _n( 'year', 'years', $count, 'wp-full-stripe' );
		} else {
			$label = $interval;
		}
		return $label;
	}

	public static function get_currency_symbol_for( $currency ) {
		if ( isset( $currency ) ) {

			$available_currencies = MM_WPFS::get_available_currencies();

			if ( isset( $available_currencies ) && array_key_exists( $currency, $available_currencies ) ) {
				$currency_symbol = $available_currencies[ $currency ]['symbol'];
			} else {
				$currency_symbol = strtoupper( $currency );
			}

			return $currency_symbol;
		}

		return null;
	}

	public static function get_available_currencies() {
		return array(
			'aed' => array(
				'code'   => 'AED',
				'name'   => 'United Arab Emirates Dirham',
				'symbol' => 'DH'
			),
			'afn' => array(
				'code'   => 'AFN',
				'name'   => 'Afghan Afghani',
				'symbol' => '؋'
			),
			'all' => array(
				'code'   => 'ALL',
				'name'   => 'Albanian Lek',
				'symbol' => 'L'
			),
			'amd' => array(
				'code'   => 'AMD',
				'name'   => 'Armenian Dram',
				'symbol' => '֏'
			),
			'ang' => array(
				'code'   => 'ANG',
				'name'   => 'Netherlands Antillean Gulden',
				'symbol' => 'ƒ'
			),
			'aoa' => array(
				'code'   => 'AOA',
				'name'   => 'Angolan Kwanza',
				'symbol' => 'Kz'
			),
			'ars' => array(
				'code'   => 'ARS',
				'name'   => 'Argentine Peso',
				'symbol' => '$'
			),
			'aud' => array(
				'code'   => 'AUD',
				'name'   => 'Australian Dollar',
				'symbol' => '$'
			),
			'awg' => array(
				'code'   => 'AWG',
				'name'   => 'Aruban Florin',
				'symbol' => 'ƒ'
			),
			'azn' => array(
				'code'   => 'AZN',
				'name'   => 'Azerbaijani Manat',
				'symbol' => 'm.'
			),
			'bam' => array(
				'code'   => 'BAM',
				'name'   => 'Bosnia & Herzegovina Convertible Mark',
				'symbol' => 'KM'
			),
			'bbd' => array(
				'code'   => 'BBD',
				'name'   => 'Barbadian Dollar',
				'symbol' => 'Bds$'
			),
			'bdt' => array(
				'code'   => 'BDT',
				'name'   => 'Bangladeshi Taka',
				'symbol' => '৳'
			),
			'bgn' => array(
				'code'   => 'BGN',
				'name'   => 'Bulgarian Lev',
				'symbol' => 'лв'
			),
			'bif' => array(
				'code'   => 'BIF',
				'name'   => 'Burundian Franc',
				'symbol' => 'FBu'
			),
			'bmd' => array(
				'code'   => 'BMD',
				'name'   => 'Bermudian Dollar',
				'symbol' => 'BD$'
			),
			'bnd' => array(
				'code'   => 'BND',
				'name'   => 'Brunei Dollar',
				'symbol' => 'B$'
			),
			'bob' => array(
				'code'   => 'BOB',
				'name'   => 'Bolivian Boliviano',
				'symbol' => 'Bs.'
			),
			'brl' => array(
				'code'   => 'BRL',
				'name'   => 'Brazilian Real',
				'symbol' => 'R$'
			),
			'bsd' => array(
				'code'   => 'BSD',
				'name'   => 'Bahamian Dollar',
				'symbol' => 'B$'
			),
			'bwp' => array(
				'code'   => 'BWP',
				'name'   => 'Botswana Pula',
				'symbol' => 'P'
			),
			'bzd' => array(
				'code'   => 'BZD',
				'name'   => 'Belize Dollar',
				'symbol' => 'BZ$'
			),
			'cad' => array(
				'code'   => 'CAD',
				'name'   => 'Canadian Dollar',
				'symbol' => '$'
			),
			'cdf' => array(
				'code'   => 'CDF',
				'name'   => 'Congolese Franc',
				'symbol' => 'CF'
			),
			'chf' => array(
				'code'   => 'CHF',
				'name'   => 'Swiss Franc',
				'symbol' => 'Fr'
			),
			'clp' => array(
				'code'   => 'CLP',
				'name'   => 'Chilean Peso',
				'symbol' => 'CLP$'
			),
			'cny' => array(
				'code'   => 'CNY',
				'name'   => 'Chinese Renminbi Yuan',
				'symbol' => '¥'
			),
			'cop' => array(
				'code'   => 'COP',
				'name'   => 'Colombian Peso',
				'symbol' => 'COL$'
			),
			'crc' => array(
				'code'   => 'CRC',
				'name'   => 'Costa Rican Colón',
				'symbol' => '₡'
			),
			'cve' => array(
				'code'   => 'CVE',
				'name'   => 'Cape Verdean Escudo',
				'symbol' => 'Esc'
			),
			'czk' => array(
				'code'   => 'CZK',
				'name'   => 'Czech Koruna',
				'symbol' => 'Kč'
			),
			'djf' => array(
				'code'   => 'DJF',
				'name'   => 'Djiboutian Franc',
				'symbol' => 'Fr'
			),
			'dkk' => array(
				'code'   => 'DKK',
				'name'   => 'Danish Krone',
				'symbol' => 'kr'
			),
			'dop' => array(
				'code'   => 'DOP',
				'name'   => 'Dominican Peso',
				'symbol' => 'RD$'
			),
			'dzd' => array(
				'code'   => 'DZD',
				'name'   => 'Algerian Dinar',
				'symbol' => 'DA'
			),
			'egp' => array(
				'code'   => 'EGP',
				'name'   => 'Egyptian Pound',
				'symbol' => 'L.E.'
			),
			'etb' => array(
				'code'   => 'ETB',
				'name'   => 'Ethiopian Birr',
				'symbol' => 'Br'
			),
			'eur' => array(
				'code'   => 'EUR',
				'name'   => 'Euro',
				'symbol' => '€'
			),
			'fjd' => array(
				'code'   => 'FJD',
				'name'   => 'Fijian Dollar',
				'symbol' => 'FJ$'
			),
			'fkp' => array(
				'code'   => 'FKP',
				'name'   => 'Falkland Islands Pound',
				'symbol' => 'FK£'
			),
			'gbp' => array(
				'code'   => 'GBP',
				'name'   => 'British Pound',
				'symbol' => '£'
			),
			'gel' => array(
				'code'   => 'GEL',
				'name'   => 'Georgian Lari',
				'symbol' => 'ლ'
			),
			'gip' => array(
				'code'   => 'GIP',
				'name'   => 'Gibraltar Pound',
				'symbol' => '£'
			),
			'gmd' => array(
				'code'   => 'GMD',
				'name'   => 'Gambian Dalasi',
				'symbol' => 'D'
			),
			'gnf' => array(
				'code'   => 'GNF',
				'name'   => 'Guinean Franc',
				'symbol' => 'FG'
			),
			'gtq' => array(
				'code'   => 'GTQ',
				'name'   => 'Guatemalan Quetzal',
				'symbol' => 'Q'
			),
			'gyd' => array(
				'code'   => 'GYD',
				'name'   => 'Guyanese Dollar',
				'symbol' => 'G$'
			),
			'hkd' => array(
				'code'   => 'HKD',
				'name'   => 'Hong Kong Dollar',
				'symbol' => 'HK$'
			),
			'hnl' => array(
				'code'   => 'HNL',
				'name'   => 'Honduran Lempira',
				'symbol' => 'L'
			),
			'hrk' => array(
				'code'   => 'HRK',
				'name'   => 'Croatian Kuna',
				'symbol' => 'kn'
			),
			'htg' => array(
				'code'   => 'HTG',
				'name'   => 'Haitian Gourde',
				'symbol' => 'G'
			),
			'huf' => array(
				'code'   => 'HUF',
				'name'   => 'Hungarian Forint',
				'symbol' => 'Ft'
			),
			'idr' => array(
				'code'   => 'IDR',
				'name'   => 'Indonesian Rupiah',
				'symbol' => 'Rp'
			),
			'ils' => array(
				'code'   => 'ILS',
				'name'   => 'Israeli New Sheqel',
				'symbol' => '₪'
			),
			'inr' => array(
				'code'   => 'INR',
				'name'   => 'Indian Rupee',
				'symbol' => '₹'
			),
			'isk' => array(
				'code'   => 'ISK',
				'name'   => 'Icelandic Króna',
				'symbol' => 'ikr'
			),
			'jmd' => array(
				'code'   => 'JMD',
				'name'   => 'Jamaican Dollar',
				'symbol' => 'J$'
			),
			'jpy' => array(
				'code'   => 'JPY',
				'name'   => 'Japanese Yen',
				'symbol' => '¥'
			),
			'kes' => array(
				'code'   => 'KES',
				'name'   => 'Kenyan Shilling',
				'symbol' => 'Ksh'
			),
			'kgs' => array(
				'code'   => 'KGS',
				'name'   => 'Kyrgyzstani Som',
				'symbol' => 'COM'
			),
			'khr' => array(
				'code'   => 'KHR',
				'name'   => 'Cambodian Riel',
				'symbol' => '៛'
			),
			'kmf' => array(
				'code'   => 'KMF',
				'name'   => 'Comorian Franc',
				'symbol' => 'CF'
			),
			'krw' => array(
				'code'   => 'KRW',
				'name'   => 'South Korean Won',
				'symbol' => '₩'
			),
			'kyd' => array(
				'code'   => 'KYD',
				'name'   => 'Cayman Islands Dollar',
				'symbol' => 'CI$'
			),
			'kzt' => array(
				'code'   => 'KZT',
				'name'   => 'Kazakhstani Tenge',
				'symbol' => '₸'
			),
			'lak' => array(
				'code'   => 'LAK',
				'name'   => 'Lao Kip',
				'symbol' => '₭'
			),
			'lbp' => array(
				'code'   => 'LBP',
				'name'   => 'Lebanese Pound',
				'symbol' => 'LL'
			),
			'lkr' => array(
				'code'   => 'LKR',
				'name'   => 'Sri Lankan Rupee',
				'symbol' => 'SLRs'
			),
			'lrd' => array(
				'code'   => 'LRD',
				'name'   => 'Liberian Dollar',
				'symbol' => 'L$'
			),
			'lsl' => array(
				'code'   => 'LSL',
				'name'   => 'Lesotho Loti',
				'symbol' => 'M'
			),
			'mad' => array(
				'code'   => 'MAD',
				'name'   => 'Moroccan Dirham',
				'symbol' => 'DH'
			),
			'mdl' => array(
				'code'   => 'MDL',
				'name'   => 'Moldovan Leu',
				'symbol' => 'MDL'
			),
			'mga' => array(
				'code'   => 'MGA',
				'name'   => 'Malagasy Ariary',
				'symbol' => 'Ar'
			),
			'mkd' => array(
				'code'   => 'MKD',
				'name'   => 'Macedonian Denar',
				'symbol' => 'ден'
			),
			'mnt' => array(
				'code'   => 'MNT',
				'name'   => 'Mongolian Tögrög',
				'symbol' => '₮'
			),
			'mop' => array(
				'code'   => 'MOP',
				'name'   => 'Macanese Pataca',
				'symbol' => 'MOP$'
			),
			'mro' => array(
				'code'   => 'MRO',
				'name'   => 'Mauritanian Ouguiya',
				'symbol' => 'UM'
			),
			'mur' => array(
				'code'   => 'MUR',
				'name'   => 'Mauritian Rupee',
				'symbol' => 'Rs'
			),
			'mvr' => array(
				'code'   => 'MVR',
				'name'   => 'Maldivian Rufiyaa',
				'symbol' => 'Rf.'
			),
			'mwk' => array(
				'code'   => 'MWK',
				'name'   => 'Malawian Kwacha',
				'symbol' => 'MK'
			),
			'mxn' => array(
				'code'   => 'MXN',
				'name'   => 'Mexican Peso',
				'symbol' => '$'
			),
			'myr' => array(
				'code'   => 'MYR',
				'name'   => 'Malaysian Ringgit',
				'symbol' => 'RM'
			),
			'mzn' => array(
				'code'   => 'MZN',
				'name'   => 'Mozambican Metical',
				'symbol' => 'MT'
			),
			'nad' => array(
				'code'   => 'NAD',
				'name'   => 'Namibian Dollar',
				'symbol' => 'N$'
			),
			'ngn' => array(
				'code'   => 'NGN',
				'name'   => 'Nigerian Naira',
				'symbol' => '₦'
			),
			'nio' => array(
				'code'   => 'NIO',
				'name'   => 'Nicaraguan Córdoba',
				'symbol' => 'C$'
			),
			'nok' => array(
				'code'   => 'NOK',
				'name'   => 'Norwegian Krone',
				'symbol' => 'kr'
			),
			'npr' => array(
				'code'   => 'NPR',
				'name'   => 'Nepalese Rupee',
				'symbol' => 'NRs'
			),
			'nzd' => array(
				'code'   => 'NZD',
				'name'   => 'New Zealand Dollar',
				'symbol' => 'NZ$'
			),
			'pab' => array(
				'code'   => 'PAB',
				'name'   => 'Panamanian Balboa',
				'symbol' => 'B/.'
			),
			'pen' => array(
				'code'   => 'PEN',
				'name'   => 'Peruvian Nuevo Sol',
				'symbol' => 'S/.'
			),
			'pgk' => array(
				'code'   => 'PGK',
				'name'   => 'Papua New Guinean Kina',
				'symbol' => 'K'
			),
			'php' => array(
				'code'   => 'PHP',
				'name'   => 'Philippine Peso',
				'symbol' => '₱'
			),
			'pkr' => array(
				'code'   => 'PKR',
				'name'   => 'Pakistani Rupee',
				'symbol' => 'PKR'
			),
			'pln' => array(
				'code'   => 'PLN',
				'name'   => 'Polish Złoty',
				'symbol' => 'zł'
			),
			'pyg' => array(
				'code'   => 'PYG',
				'name'   => 'Paraguayan Guaraní',
				'symbol' => '₲'
			),
			'qar' => array(
				'code'   => 'QAR',
				'name'   => 'Qatari Riyal',
				'symbol' => 'QR'
			),
			'ron' => array(
				'code'   => 'RON',
				'name'   => 'Romanian Leu',
				'symbol' => 'RON'
			),
			'rsd' => array(
				'code'   => 'RSD',
				'name'   => 'Serbian Dinar',
				'symbol' => 'дин'
			),
			'rub' => array(
				'code'   => 'RUB',
				'name'   => 'Russian Ruble',
				'symbol' => 'руб'
			),
			'rwf' => array(
				'code'   => 'RWF',
				'name'   => 'Rwandan Franc',
				'symbol' => 'FRw'
			),
			'sar' => array(
				'code'   => 'SAR',
				'name'   => 'Saudi Riyal',
				'symbol' => 'SR'
			),
			'sbd' => array(
				'code'   => 'SBD',
				'name'   => 'Solomon Islands Dollar',
				'symbol' => 'SI$'
			),
			'scr' => array(
				'code'   => 'SCR',
				'name'   => 'Seychellois Rupee',
				'symbol' => 'SRe'
			),
			'sek' => array(
				'code'   => 'SEK',
				'name'   => 'Swedish Krona',
				'symbol' => 'kr'
			),
			'sgd' => array(
				'code'   => 'SGD',
				'name'   => 'Singapore Dollar',
				'symbol' => 'S$'
			),
			'shp' => array(
				'code'   => 'SHP',
				'name'   => 'Saint Helenian Pound',
				'symbol' => '£'
			),
			'sll' => array(
				'code'   => 'SLL',
				'name'   => 'Sierra Leonean Leone',
				'symbol' => 'Le'
			),
			'sos' => array(
				'code'   => 'SOS',
				'name'   => 'Somali Shilling',
				'symbol' => 'Sh.So.'
			),
			'std' => array(
				'code'   => 'STD',
				'name'   => 'São Tomé and Príncipe Dobra',
				'symbol' => 'Db'
			),
			'srd' => array(
				'code'   => 'SRD',
				'name'   => 'Surinamese Dollar',
				'symbol' => 'SRD'
			),
			'svc' => array(
				'code'   => 'SVC',
				'name'   => 'Salvadoran Colón',
				'symbol' => '₡'
			),
			'szl' => array(
				'code'   => 'SZL',
				'name'   => 'Swazi Lilangeni',
				'symbol' => 'E'
			),
			'thb' => array(
				'code'   => 'THB',
				'name'   => 'Thai Baht',
				'symbol' => '฿'
			),
			'tjs' => array(
				'code'   => 'TJS',
				'name'   => 'Tajikistani Somoni',
				'symbol' => 'TJS'
			),
			'top' => array(
				'code'   => 'TOP',
				'name'   => 'Tongan Paʻanga',
				'symbol' => '$'
			),
			'try' => array(
				'code'   => 'TRY',
				'name'   => 'Turkish Lira',
				'symbol' => '₺'
			),
			'ttd' => array(
				'code'   => 'TTD',
				'name'   => 'Trinidad and Tobago Dollar',
				'symbol' => 'TT$'
			),
			'twd' => array(
				'code'   => 'TWD',
				'name'   => 'New Taiwan Dollar',
				'symbol' => 'NT$'
			),
			'tzs' => array(
				'code'   => 'TZS',
				'name'   => 'Tanzanian Shilling',
				'symbol' => 'TSh'
			),
			'uah' => array(
				'code'   => 'UAH',
				'name'   => 'Ukrainian Hryvnia',
				'symbol' => '₴'
			),
			'ugx' => array(
				'code'   => 'UGX',
				'name'   => 'Ugandan Shilling',
				'symbol' => 'USh'
			),
			'usd' => array(
				'code'   => 'USD',
				'name'   => 'United States Dollar',
				'symbol' => '$'
			),
			'uyu' => array(
				'code'   => 'UYU',
				'name'   => 'Uruguayan Peso',
				'symbol' => '$U'
			),
			'uzs' => array(
				'code'   => 'UZS',
				'name'   => 'Uzbekistani Som',
				'symbol' => 'UZS'
			),
			'vnd' => array(
				'code'   => 'VND',
				'name'   => 'Vietnamese Đồng',
				'symbol' => '₫'
			),
			'vuv' => array(
				'code'   => 'VUV',
				'name'   => 'Vanuatu Vatu',
				'symbol' => 'VT'
			),
			'wst' => array(
				'code'   => 'WST',
				'name'   => 'Samoan Tala',
				'symbol' => 'WS$'
			),
			'xaf' => array(
				'code'   => 'XAF',
				'name'   => 'Central African Cfa Franc',
				'symbol' => 'FCFA'
			),
			'xcd' => array(
				'code'   => 'XCD',
				'name'   => 'East Caribbean Dollar',
				'symbol' => 'EC$'
			),
			'xof' => array(
				'code'   => 'XOF',
				'name'   => 'West African Cfa Franc',
				'symbol' => 'CFA'
			),
			'xpf' => array(
				'code'   => 'XPF',
				'name'   => 'Cfp Franc',
				'symbol' => 'F'
			),
			'yer' => array(
				'code'   => 'YER',
				'name'   => 'Yemeni Rial',
				'symbol' => '﷼'
			),
			'zar' => array(
				'code'   => 'ZAR',
				'name'   => 'South African Rand',
				'symbol' => 'R'
			),
			'zmw' => array(
				'code'   => 'ZMW',
				'name'   => 'Zambian Kwacha',
				'symbol' => 'ZK'
			)
		);
	}

	public static function echo_translated_label( $label ) {
		echo self::translate_label( $label );
	}

	public static function translate_label( $label ) {
		if ( empty( $label ) ) {
			return '';
		}

		return __( sanitize_text_field( $label ), 'wp-full-stripe' );
	}

	public function plugin_action_links( $links, $file ) {
		static $this_plugin;

		if ( ! $this_plugin ) {
			$this_plugin = plugin_basename( 'wp-full-stripe/wp-full-stripe.php' );
		}

		if ( $file == $this_plugin ) {
			$settings_link = '<a href="' . menu_page_url( 'fullstripe-settings', false ) . '">' . esc_html( __( 'Settings', 'fullstripe-settings' ) ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	function fullstripe_payment_form( $atts ) {

		$form = null;

		extract( shortcode_atts( array(
			'form' => 'default',
		), $atts ) );

		//load scripts and styles
		$this->fullstripe_load_css();
		$this->fullstripe_load_js();
		//load form data into scope
		list( $formData, $currencySymbol, $creditCardImage ) = $this->load_payment_form_data( $form );

		//get the form style
		$style = 0;
		if ( ! $formData ) {
			$style = - 1;
		} else {
			$style = $formData->formStyle;
		}

		ob_start();
		include $this->get_payment_form_by_style( $style );
		$content = ob_get_clean();

		return apply_filters( 'fullstripe_payment_form_output', $content );
	}

	function fullstripe_load_css() {
		$options = get_option( 'fullstripe_options' );
		if ( $options['includeStyles'] === '1' ) {
			wp_enqueue_style( 'fullstripe-bootstrap-css', plugins_url( '/css/newstyle.css', dirname( __FILE__ ) ), null, MM_WPFS::VERSION );
		}

		do_action( 'fullstripe_load_css_action' );
	}

	function fullstripe_load_js() {
		$options = get_option( 'fullstripe_options' );
		wp_enqueue_script( 'sprintf-js', plugins_url( 'js/sprintf.min.js', dirname( __FILE__ ) ), null, MM_WPFS::VERSION );
		wp_enqueue_script( 'stripe-js', 'https://js.stripe.com/v2/', array( 'jquery' ) );
		wp_enqueue_script( 'wp-full-stripe-js', plugins_url( 'js/wp-full-stripe.js', dirname( __FILE__ ) ), array(
			'sprintf-js',
			'stripe-js'
		), MM_WPFS::VERSION );
		wp_localize_script( 'wp-full-stripe-js', 'wpfs_L10n', array(
			'plan_details_with_singular_interval'
			                                           => /* translators: 1: currency symbol/code, 2: amount, 3: interval in singular */
				__( 'Plan is %1$s%2$.2f per %3$s', 'wp-full-stripe' ),
			'plan_details_with_plural_interval'
			                                           => /* translators: 1: currency symbol/code, 2: amount, 3: interval count > 1, 4: interval in plural */
				__( 'Plan is %1$s%2$.2f per %3$d %4$s', 'wp-full-stripe' ),
			'plan_details_with_singular_interval_with_coupon'
			                                           => /* translators: 1: currency symbol/count, 2: amount, 3: interval in singular, 4: coupon percentage/amount */
				__( 'Plan is %1$s%2$.2f per %3$s (%4$.2f with coupon)', 'wp-full-stripe' ),
			'plan_details_with_plural_interval_with_coupon'
			                                           => /* translators: 1: currency symbol/count, 2: amount, 3: interval count > 1, 4: interval in plural, 5: coupon percentage/amount */
				__( 'Plan is %1$s%2$.2f per %3$d %4$s (%5$.2f with coupon)', 'wp-full-stripe' ),
			'plan_details_with_singular_interval_with_setupfee'
			                                           => /* translators: 1: currency symbol/code, 2: amount, 3: interval in singular, 4: setup fee currency symbol/code, 5: setup fee amount */
				__( 'Plan is %1$s%2$.2f per %3$s. SETUP FEE: %4$s%5$.2f', 'wp-full-stripe' ),
			'plan_details_with_plural_interval_with_setupfee'
			                                           => /* translators: 1: currency symbol/code, 2: amount, 3: interval count > 1, 4: interval in plural, 5: setup fee currency symbol/code, 6: setup fee amount */
				__( 'Plan is %1$s%2$.2f per %3$d %4$s. SETUP FEE: %5$s%6$.2f', 'wp-full-stripe' ),
			'plan_details_with_singular_interval_with_coupon_with_setupfee'
			                                           => /* translators: 1: currency symbol/count, 2: amount, 3: interval in singular, 4: coupon percentage/amount, 5: setup fee currency symbol/code, 6: setup fee amount */
				__( 'Plan is %1$s%2$.2f per %3$s (%4$.2f with coupon). SETUP FEE: %5$s%6$.2f', 'wp-full-stripe' ),
			'plan_details_with_plural_interval_with_coupon_with_setupfee'
			                                           => /* translators: 1: currency symbol/count, 2: amount, 3: interval count > 1, 4: interval in plural, 5: coupon percentage/amount, 6: setup fee currency symbol/code, 7: setup fee amount */
				__( 'Plan is %1$s%2$.2f per %3$d %4$s (%5$.2f with coupon). SETUP FEE: %6$s%7$.2f', 'wp-full-stripe' ),
			'internal_error'
			                                           => __( 'An internal error occured.', 'wp-full-stripe' ),
			MM_WPFS_Stripe::INVALID_NUMBER_ERROR       => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INVALID_NUMBER_ERROR ),
			MM_WPFS_Stripe::INVALID_EXPIRY_MONTH_ERROR => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INVALID_EXPIRY_MONTH_ERROR ),
			MM_WPFS_Stripe::INVALID_EXPIRY_YEAR_ERROR  => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INVALID_EXPIRY_YEAR_ERROR ),
			MM_WPFS_Stripe::INVALID_CVC_ERROR          => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INVALID_CVC_ERROR ),
			MM_WPFS_Stripe::INCORRECT_NUMBER_ERROR     => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INCORRECT_NUMBER_ERROR ),
			MM_WPFS_Stripe::EXPIRED_CARD_ERROR         => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::EXPIRED_CARD_ERROR ),
			MM_WPFS_Stripe::INCORRECT_CVC_ERROR        => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INCORRECT_CVC_ERROR ),
			MM_WPFS_Stripe::INCORRECT_ZIP_ERROR        => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::INCORRECT_ZIP_ERROR ),
			MM_WPFS_Stripe::CARD_DECLINED_ERROR        => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::CARD_DECLINED_ERROR ),
			MM_WPFS_Stripe::MISSING_ERROR              => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::MISSING_ERROR ),
			MM_WPFS_Stripe::PROCESSING_ERROR           => $this->stripe->resolve_error_message_by_code( MM_WPFS_Stripe::PROCESSING_ERROR )
		) );

		if ( $options['apiMode'] === 'test' ) {
			wp_localize_script( 'wp-full-stripe-js', 'stripekey', $options['publishKey_test'] );
		} else {
			wp_localize_script( 'wp-full-stripe-js', 'stripekey', $options['publishKey_live'] );
		}

		wp_localize_script( 'wp-full-stripe-js', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

		do_action( 'fullstripe_load_js_action' );
	}

	function load_payment_form_data( $form ) {
		list ( $currencySymbol, $creditCardImage ) = $this->get_locale_strings();

		$formData = array(
			$this->database->get_payment_form_by_name( $form ),
			$currencySymbol,
			$creditCardImage
		);

		return $formData;
	}

	function get_locale_strings() {
		$options         = get_option( 'fullstripe_options' );
		$currencySymbol  = MM_WPFS::get_currency_symbol_for( $options['currency'] );
		$creditCardImage = 'creditcards.png';
		if ( $options['currency'] === 'usd' ) {
			$creditCardImage = 'creditcards-us.png';
		} elseif ( $options['currency'] === 'eur' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'jpy' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'gbp' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'aud' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'chf' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'cad' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'mxn' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'sek' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'nok' ) {
			$creditCardImage = 'creditcards.png';
		} elseif ( $options['currency'] === 'dkk' ) {
			$creditCardImage = 'creditcards.png';
		}

		return array(
			$currencySymbol,
			$creditCardImage
		);
	}

	function get_payment_form_by_style( $styleID ) {
		switch ( $styleID ) {
			case - 1:
				return WP_FULL_STRIPE_DIR . '/pages/forms/invalid_shortcode.php';

			case 0:
				return WP_FULL_STRIPE_DIR . '/pages/fullstripe_payment_form.php';

			case 1:
				return WP_FULL_STRIPE_DIR . '/pages/forms/payment_form_compact.php';

			default:
				return WP_FULL_STRIPE_DIR . '/pages/fullstripe_payment_form.php';
		}
	}

	function fullstripe_subscription_form( $atts ) {
		$form = null;

		extract( shortcode_atts( array(
			'form' => 'default',
		), $atts ) );

		$this->fullstripe_load_css();
		$this->fullstripe_load_js();

		//load form data into scope
		list( $formData, $currencySymbol, $creditCardImage ) = $this->load_subscription_form_data( $form );
		//get the form style & plans
		$style = 0;
		$plans = array();
		if ( ! $formData ) {
			$style = - 1;
		} else {
			$style    = $formData->formStyle;
			$allPlans = $this->get_plans();
			if ( count( $allPlans ) === 0 ) {
				$style = - 2;
			} else {
				$planIDs = json_decode( $formData->plans );
				foreach ( $allPlans['data'] as $plan ) {
					$i = array_search( stripslashes( $plan->id ), $planIDs );
					if ( $i !== false ) {
						$plans[ $i ] = $plan;
					}
				}
				ksort( $plans );
			}
		}

		ob_start();
		include $this->get_subscription_form_by_style( $style );
		$content = ob_get_clean();

		return apply_filters( 'fullstripe_subscription_form_output', $content );
	}

	function load_subscription_form_data( $form ) {
		list ( $currencySymbol, $creditCardImage ) = $this->get_locale_strings();

		$formData = array(
			$this->database->get_subscription_form_by_name( $form ),
			$currencySymbol,
			$creditCardImage
		);

		return $formData;
	}

	public function get_plans() {
		return $this->stripe != null ? apply_filters( 'fullstripe_subscription_plans_filter', $this->stripe->get_plans() ) : array();
	}

	function get_subscription_form_by_style( $styleID ) {
		switch ( $styleID ) {
			case - 2:
				return WP_FULL_STRIPE_DIR . '/pages/forms/invalid_plans.php';

			case - 1:
				return WP_FULL_STRIPE_DIR . '/pages/forms/invalid_shortcode.php';

			case 0:
				return WP_FULL_STRIPE_DIR . '/pages/fullstripe_subscription_form.php';

			default:
				return WP_FULL_STRIPE_DIR . '/pages/fullstripe_subscription_form.php';
		}
	}

	function fullstripe_checkout_form( $atts ) {

		$form = null;

		extract( shortcode_atts( array(
			'form' => 'default',
		), $atts ) );

		$this->fullstripe_load_css();
		$this->fullstripe_load_checkout_js();

		$options  = get_option( 'fullstripe_options' );
		$formData = $this->database->get_checkout_form_by_name( $form );

		if (!$formData) {
			ob_start();
			include WP_FULL_STRIPE_DIR . '/pages/forms/invalid_shortcode.php';
			$content = ob_get_clean();
		} else {
			//load form specific options
			$formData['currency'] = $options['currency'];

			ob_start();
			include WP_FULL_STRIPE_DIR . '/pages/fullstripe_checkout_form.php';
			$content = ob_get_clean();
		}
		return apply_filters( 'fullstripe_checkout_form_output', $content );
	}

	function fullstripe_load_checkout_js() {
		$options = get_option( 'fullstripe_options' );
		wp_enqueue_script( 'checkout-js', 'https://checkout.stripe.com/checkout.js', array( 'jquery' ) );
		wp_enqueue_script( 'stripe-checkout-js', plugins_url( 'js/wp-full-stripe-checkout.js', dirname( __FILE__ ) ), array( 'checkout-js' ), MM_WPFS::VERSION );
		wp_localize_script( 'wp-full-stripe-js', 'wpfs_L10n', array(
			'internal_error'
			=> __( 'An internal error.', 'wp-full-stripe' )
		) );
		if ( $options['apiMode'] === 'test' ) {
			wp_localize_script( 'stripe-checkout-js', 'stripekey', $options['publishKey_test'] );
		} else {
			wp_localize_script( 'stripe-checkout-js', 'stripekey', $options['publishKey_live'] );
		}

		wp_localize_script( 'stripe-checkout-js', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

		do_action( 'fullstripe_load_checkout_js_action' );
	}

	function fullstripe_wp_head() {
		//output the custom css
		$options = get_option( 'fullstripe_options' );
		echo '<style type="text/css" media="screen">' . $options['form_css'] . '</style>';
	}

	public function get_recipients() {
		return $this->stripe != null ? apply_filters( 'fullstripe_transfer_receipients_filter', $this->stripe->get_recipients() ) : array();
	}

	public function get_subscription( $customerID, $subscriptionID ) {
		return $this->stripe != null ? apply_filters( 'fullstripe_customer_subscription_filter', $this->stripe->retrieve_subscription( $customerID, $subscriptionID ) ) : array();
	}
	
	/**
	 * @return array
	 */
	private function create_default_email_receipts() {
		$emailReceipts                         = array();
		$paymentMade                           = new stdClass();
		$subscriptionStarted                   = new stdClass();
		$subscriptionFinished                  = new stdClass();
		$paymentMade->subject                  = 'Payment Receipt';
		$paymentMade->html                     = "<html><body><p>Hi,</p><p>Here's your receipt for your payment of %AMOUNT%</p><p>Thanks</p><br/>%NAME%</body></html>";
		$subscriptionStarted->subject          = 'Subscription Receipt';
		$subscriptionStarted->html             = "<html><body><p>Hi,</p><p>Here's your receipt for your subscription of %AMOUNT%</p><p>Thanks</p><br/>%NAME%</body></html>";
		$subscriptionFinished->subject         = 'Subscription Ended';
		$subscriptionFinished->html            = '<html><body><p>Hi,</p><p>Your subscription has ended.</p><p>Thanks</p><br/>%NAME%</body></html>';
		$emailReceipts['paymentMade']          = $paymentMade;
		$emailReceipts['subscriptionStarted']  = $subscriptionStarted;
		$emailReceipts['subscriptionFinished'] = $subscriptionFinished;

		return $emailReceipts;
	}

	/**
	 * Generates a unique random token for authenticating webhook callbacks.
	 *
	 * @return string
	 */
	private function create_webhook_token() {
		$site_url           = get_site_url();
		$session_token      = wp_get_session_token();
		$generated_password = wp_generate_password( 6, false );

		return wp_hash( $site_url . '|' . $session_token . '|' . $generated_password );
	}

}

MM_WPFS::getInstance();
