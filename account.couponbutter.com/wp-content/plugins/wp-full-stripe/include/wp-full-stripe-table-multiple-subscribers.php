<?php

/**
 * Created by PhpStorm.
 * User: tnagy
 * Date: 2016.02.18.
 * Time: 9:17
 */
class WPFS_Multiple_Subscribers_Table extends WP_List_Table {

	public function __construct() {
		parent::__construct( array(
			'singular' => __( 'Subscriber', 'wp-full-stripe' ),
			'plural'   => __( 'Subscribers', 'wp-full-stripe' ),
			'ajax'     => false
		) );
	}

	protected function get_table_classes() {
		$table_classes = parent::get_table_classes();

		return array_diff( $table_classes, array( 'fixed' ) );
	}

	protected function extra_tablenav( $which ) {
		if ( $which == "top" ) {
			echo '<div class="wrap">';
		}
		if ( $which == "bottom" ) {
			echo '</div>';
		}
	}

	public function get_columns() {
		return array(
			'subscriber'          => $this->format_column_header_title( __( 'Subscriber', 'wp-full-stripe' ), array(
				__( 'Name', 'wp-full-stripe' ),
				__( 'E-mail', 'wp-full-stripe' )
			) ),
			'subscription_plan'   => $this->format_column_header_title( __( 'Subscription', 'wp-full-stripe' ), array(
				__( 'Plan', 'wp-full-stripe' ),
				__( 'ID', 'wp-full-stripe' )
			) ),
			'subscription_status' => $this->format_column_header_title( __( 'Subscription', 'wp-full-stripe' ), array(
				__( 'Status', 'wp-full-stripe' ),
				__( 'Mode', 'wp-full-stripe' )
			) ),
			'created'             => __( 'Created at', 'wp-full-stripe' ),
			'action'              => __( 'Action', 'wp-full-stripe' )
		);
	}

	protected function get_sortable_columns() {
		return array(
			'created' => array( 'created', false )
		);
	}

	public function no_items() {
		_e( 'No subscriptions found.', 'wp-full-stripe' );
	}

	public function prepare_items() {
		global $wpdb;

		$params = array();

		$query = "SELECT subscriberID,stripeCustomerID,stripeSubscriptionID,chargeMaximumCount,chargeCurrentCount,status,name,email,planID,addressLine1,addressLine2,addressCity,addressState,addressZip,addressCountry,created,cancelled,livemode FROM {$wpdb->prefix}fullstripe_subscribers";

		$whereStatement = null;

		$subscriber   = ! empty( $_REQUEST["subscriber"] ) ? esc_sql( trim( $_REQUEST["subscriber"] ) ) : null;
		$subscription = ! empty( $_REQUEST["subscription"] ) ? esc_sql( trim( $_REQUEST["subscription"] ) ) : null;
		$mode         = ! empty( $_REQUEST["mode"] ) ? esc_sql( trim( $_REQUEST["mode"] ) ) : null;

		if ( isset( $subscriber ) ) {
			if ( ! isset( $whereStatement ) ) {
				$whereStatement = ' WHERE ';
			} else {
				$whereStatement .= ' AND ';
			}
			$whereStatement .= sprintf( "(LOWER(name) LIKE LOWER('%s') OR LOWER(email) LIKE LOWER('%s') OR stripeCustomerID LIKE '%s')", "%$subscriber%", "%$subscriber%", "%$subscriber%" );
		}

		if ( isset( $subscription ) ) {
			if ( ! isset( $whereStatement ) ) {
				$whereStatement = ' WHERE ';
			} else {
				$whereStatement .= ' AND ';
			}
			$whereStatement .= sprintf( "(stripeSubscriptionID LIKE '%s')", "%$subscription%" );
		}

		if ( isset( $mode ) ) {
			if ( ! isset( $whereStatement ) ) {
				$whereStatement = ' WHERE ';
			} else {
				$whereStatement .= ' AND ';
			}
			$whereStatement .= sprintf( '(livemode = %d)', $mode == 'live' ? 1 : 0 );
		}

		if ( isset( $whereStatement ) ) {
			$query .= $whereStatement;
		}

		$orderby = ! empty( $_REQUEST["orderby"] ) ? esc_sql( $_REQUEST["orderby"] ) : 'created';
		$order   = ! empty( $_REQUEST["order"] ) ? esc_sql( $_REQUEST["order"] ) : ( empty( $_REQUEST['orderby'] ) ? 'DESC' : 'ASC' );
		if ( ! empty( $orderby ) && ! empty( $order ) ) {
			$query .= ' ORDER BY ' . $orderby . ' ' . $order;
		}

		$total_items = $wpdb->query( $query );
		$per_page    = 10;
		$paged       = ! empty( $_GET["paged"] ) ? esc_sql( $_GET["paged"] ) : '';
		if ( empty( $paged ) || ! is_numeric( $paged ) || $paged <= 0 ) {
			$paged = 1;
		}
		$total_pages = ceil( $total_items / $per_page );
		if ( ! empty( $paged ) && ! empty( $per_page ) ) {
			$offset = ( $paged - 1 ) * $per_page;
			$query .= ' LIMIT ' . (int) $offset . ',' . (int) $per_page;
		}

		$this->set_pagination_args( array(
			"total_items" => $total_items,
			"total_pages" => $total_pages,
			"per_page"    => $per_page,
		) );

		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->items = $wpdb->get_results( $query );
	}

	public function display_rows() {
		$items = $this->items;

		list( $columns, $hidden ) = $this->get_column_info();

		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				$row = '';
				$row .= "<tr id=\"record_{$item->subscriberID}\">";
				foreach ( $columns as $column_name => $column_display_name ) {
					$class = "class=\"$column_name column-$column_name\"";
					$style = "";
					if ( in_array( $column_name, $hidden ) ) {
						$style = "style=\"display:none;\"";
					}
					$attributes = "{$class} {$style}";

					switch ( $column_name ) {
						case "subscriber":
							$href               = $this->build_stripe_customer_link( $item->stripeCustomerID, $item->livemode );
							$stripeCustomerLink = "<a href=\"{$href}\" target=\"_blank\">{$item->email}</a>";
							$name               = $item->name;
							if ( ! empty( $name ) ) {
								$nameLabel = stripslashes( $name );
							} else {
								$nameLabel = __( '&lt;Not specified&gt;', 'wp-full-stripe' );
							}
							$row .= "<td {$attributes}><b>" . $nameLabel . "</b><br/>{$stripeCustomerLink}</td>";
							break;
						case "subscription_plan":
							$href                   = $this->build_stripe_customer_link( $item->stripeCustomerID, $item->livemode );
							$stripeSubscriptionLink = "<a href=\"{$href}\" target=\"_blank\">{$item->stripeSubscriptionID}</a>";
							$row .= "<td {$attributes}><b>{$item->planID}</b><br/>{$stripeSubscriptionLink}</td>";
							break;
						case "subscription_status":
							$statusLabel = ucfirst( $item->status );
							if ( $item->chargeMaximumCount > 0 ) {
								$statusLabel = sprintf( "%s (%d/%d)", ucfirst( $item->status ), $item->chargeCurrentCount, $item->chargeMaximumCount );
							}
							$row .= "<td {$attributes}><b>{$statusLabel}</b><br/>" . ( $item->livemode == 0 ? __( 'Test', 'wp-full-stripe' ) : __( 'Live', 'wp-full-stripe' ) ) . "</td>";
							break;
						case "created":
							$row .= "<td {$attributes}>" . date( 'F jS Y H:i', strtotime( $item->created ) ) . "</td>";
							break;
						case "action":
							if ( $item->status == 'cancelled' || $item->status == 'ended' ) {
								$row .= "<td {$attributes}></td>";
							} else {
								$row .= "<td {$attributes}><button class=\"button delete\" data-id=\"{$item->subscriberID}\" data-type=\"subscriber\">" . __( 'Cancel', 'wp-full-stripe' ) . "</button></td>";
							}
							break;
					}
				}

				$row .= "</tr>";

				echo $row;
			}
		}
	}

	/**
	 * @param $title
	 *
	 * @param $aggregated_columns
	 *
	 * @return string
	 */
	private function format_column_header_title( $title, array $aggregated_columns = null ) {
		$column_label = "<b>{$title}</b>";
		if ( ! empty( $aggregated_columns ) ) {
			$size = sizeof( $aggregated_columns );
			$column_label .= '<br>';
			foreach ( $aggregated_columns as $key => $value ) {
				$column_label .= $value;
				if ( $key < $size - 1 ) {
					$column_label .= ' / ';
				}
			}
		}

		return $column_label;
	}

	/**
	 * @param $stripeCustomerID
	 * @param $liveMode
	 *
	 * @return string
	 */
	private function build_stripe_customer_link( $stripeCustomerID, $liveMode ) {
		$href = $this->build_stripe_base_url( $liveMode );
		$href .= "customers/{$stripeCustomerID}";

		return $href;
	}

	/**
	 * @param $liveMode
	 *
	 * @return string
	 */
	private function build_stripe_base_url( $liveMode ) {
		$href = "https://dashboard.stripe.com/";
		if ( $liveMode == 0 ) {
			$href .= "test/";
		}

		return $href;
	}

}