<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class BWFAN_DB_Update
 *
 * @package Autonami
 *
 * @since 3.0.0
 */
#[AllowDynamicProperties]
class BWFAN_DB_Update {
	private static $ins = null;

	public $db_changes = [];

	/**
	 * 0 - Null | nothing to do
	 * 1 - DB update can start
	 * 2 - DB update started
	 * 3 - DB update complete
	 */

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'db_update' ], 11 );
		add_action( 'bwfan_db_update_2_11', array( $this, 'db_update_2_11_cb' ) );

		$this->db_changes = array(
			'2.11' => '2_11',
		);
	}

	/**
	 * Return the object of current class
	 *
	 * @return null|BWFAN_DB_Update
	 */
	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	/**
	 * Update pro db function for setting value
	 */
	public function db_update() {
		$db_status  = $this->get_saved_data( 'status' );
		$db_version = $this->get_saved_data();
		$db_version = ( false === $db_version ) ? '2.8.4' : $db_version;

		/** Status 1 = ready for run, 2 = in progress, 3 = complete */
		if ( in_array( $db_status, [ 1, 2, 3 ] ) ) {
			return;
		}

		foreach ( $this->db_changes as $version => $version_value ) {
			if ( version_compare( $db_version, $version, '<' ) ) {
				$value = [ $version => 1 ];

				/** Should run or not */
				if ( method_exists( $this, 'should_run_' . $version_value ) && false === call_user_func( [ $this, 'should_run_' . $version_value ] ) ) {
					$value = [ $version => 0 ];
				}

				update_option( 'bwfan_db_update', $value, true );

				return;
			}
		}
	}

	/**
	 * Return version or status from the DB saved value
	 *
	 * @param string $type
	 *
	 * @return false|int|mixed|string|null
	 */
	public function get_saved_data( $type = 'version' ) {
		$data = get_option( 'bwfan_db_update', [] );

		if ( ! is_array( $data ) ) {
			return ( 'version' === $type ) ? false : 0;
		}

		/** Return version */
		if ( 'version' === $type ) {
			return key( $data );
		}

		$status = (int) current( $data );

		/** If status is 2 (in processing) then check if action is scheduled  */
		if ( 2 === $status ) {
			$this->is_action_scheduled( $data );
		}

		/** Return status */
		return $status;
	}

	/**
	 * Schedule DB update action
	 *
	 * @return bool
	 */
	public function start_db_update() {
		/** Status */
		$status = $this->get_saved_data( 'status' );
		if ( 0 === $status ) {
			return false;
		}

		/** Check if already scheduled */
		if ( in_array( $status, [ 2, 3 ] ) ) {
			return true;
		}

		/** Version */
		$version = $this->get_saved_data();

		/** Schedule recurring action */
		$this->schedule_action( $version );

		return true;
	}

	/**
	 * Set the DB update current version value to 0
	 *
	 * @return bool
	 */
	public function dismiss_db_update() {
		/** Version */
		$version = $this->get_saved_data();
		if ( false === $version ) {
			return false;
		}

		return update_option( 'bwfan_db_update', [ $version => 0 ], true );
	}

	/**
	 * Mark version complete and check for next DB update.
	 * If available then start it
	 *
	 * @param $version_no
	 */
	protected function mark_complete( $version_no ) {
		$version_name = str_replace( ".", "_", $version_no );
		BWFAN_Core()->logger->log( 'mark complete: ' . $version_no, 'db_update_' . $version_name );

		/** Mark complete */
		update_option( 'bwfan_db_update', [ $version_no => 3 ], true );

		/** Un-schedule action */
		$version_name = str_replace( ".", "_", $version_no );
		bwf_unschedule_actions( 'bwfan_db_update_' . $version_name );

		/** Maybe schedule next version */
		if ( ! is_array( $this->db_changes ) || 0 === count( $this->db_changes ) ) {
			return;
		}
		foreach ( $this->db_changes as $version => $version_value ) {
			if ( version_compare( $version_no, $version, '<' ) ) {
				/** Schedule recurring action */
				$this->schedule_action( $version );

				return;
			}
		}
	}

	/**
	 * Schedule recurring action
	 *
	 * @param $version
	 */
	protected function schedule_action( $version ) {
		if ( empty( $version ) ) {
			return false;
		}

		/** Mark DB update started */
		update_option( 'bwfan_db_update', [ $version => 2 ], true );

		$version_name = str_replace( ".", "_", $version );
		$action       = 'bwfan_db_update_' . $version_name;
		$args         = array( 'datetime' => current_time( 'mysql', 1 ) );

		/** Check if action is already scheduled */
		if ( ! bwf_has_action_scheduled( $action, $args, 'bwf_update' ) ) {
			bwf_schedule_recurring_action( time(), 60, $action, $args, 'bwf_update' );

			BWFAN_Core()->logger->log( 'scheduling action: ' . $version, 'db_update_' . $version_name );
		}

		return true;
	}

	/**
	 * Check if time limit or memory passed
	 *
	 * @param $time
	 *
	 * @return bool
	 */
	protected function should_run( $time ) {
		/** If time exceeds */
		if ( ( time() - $time ) > $this->get_threshold_time() ) {
			return false;
		}

		/** If memory exceeds */
		$ins = BWF_AS::instance();

		return ! $ins->memory_exceeded();
	}

	/**
	 * Return call duration time in seconds
	 *
	 * @return mixed|void
	 */
	protected function get_threshold_time() {
		return apply_filters( 'bwfan_db_update_call_duration', 20 );
	}

	public function db_update_2_11_cb() {

		global $wpdb;
		$start_time = time();
		$key        = 'bwfan_db_update_2_11_cb';
		BWFAN_Core()->logger->log( 'call starts for: 2.11', 'db_update_2_11' );

		$post_statuses = apply_filters( 'bwfan_recovered_cart_excluded_statuses', array(
			'wc-pending',
			'wc-failed',
			'wc-cancelled',
			'wc-refunded',
			'trash',
			'draft'
		) );
		$post_statuses = implode( "','", $post_statuses );

		/** Get if conversion table is empty */
		$is_conversion_empty = bwf_options_get( 'is_conversion_empty' );
		if ( empty( $is_conversion_empty ) ) {
			$is_conversion_empty = BWFAN_Common::is_conversion_empty();
			bwf_options_update( 'is_conversion_empty', $is_conversion_empty );
		}

		do {
			$last_order_id = bwf_options_get( 'last_index_order' );
			$last_order    = intval( $last_order_id ) > 0 ? " AND p.`id` > $last_order_id " : "";

			if ( BWF_WC_Compatibility::is_hpos_enabled() ) {
				$query = "SELECT p.id AS id FROM {$wpdb->prefix}wc_orders as p LEFT JOIN {$wpdb->prefix}wc_orders_meta as m ON p.id = m.order_id WHERE p.type = 'shop_order' AND p.status NOT IN ('$post_statuses') AND m.meta_key = '_bwfan_ab_cart_recovered_a_id' $last_order ORDER BY p.`id` ASC LIMIT 10";
			} else {
				$query = "SELECT p.ID as id FROM {$wpdb->prefix}posts as p LEFT JOIN {$wpdb->prefix}postmeta as m ON p.ID = m.post_id WHERE p.post_type = 'shop_order' AND p.post_status NOT IN ('$post_statuses') AND m.meta_key = '_bwfan_ab_cart_recovered_a_id' $last_order ORDER BY p.`id` ASC LIMIT 10";
			}

			$order_ids = $wpdb->get_col( $query );
			if ( ! is_array( $order_ids ) || 0 === count( $order_ids ) ) {
				bwf_options_delete( 'last_index_order' );
				bwf_options_delete( 'is_conversion_empty' );
				delete_option( $key );
				$this->mark_complete( '2.11' );

				return;
			}
			$order_id = 0;
			foreach ( $order_ids as $order_id ) {
				$order = wc_get_order( $order_id );
				if ( ! $order instanceof WC_Order ) {
					continue;
				}

				/** Check order is already exists in table if table is not empty */
				if ( ! $is_conversion_empty ) {
					$already_exists = BWFAN_Model_Conversions::get_specific_rows( 'wcid', $order_id );
					if ( ! empty( $already_exists ) ) {
						continue;
					}
				}

				$cid = BWF_WC_Compatibility::get_order_meta( $order, '_woofunnel_cid' );
				$oid = BWF_WC_Compatibility::get_order_meta( $order, '_bwfan_ab_cart_recovered_a_id' );

				$data = array(
					'wcid'    => intval( $order_id ),
					'cid'     => intval( $cid ),
					'oid'     => intval( $oid ),
					'otype'   => 1,
					'wctotal' => $order->get_total(),
					'date'    => $order->get_date_created()->date( 'Y-m-d H:i:s' )
				);
				BWFAN_Model_Conversions::insert( $data );
			}
			/** Save last order id to fetch next orders ids */
			bwf_options_update( 'last_index_order', $order_id );
			BWFAN_Core()->logger->log( 'updated: ' . implode( ', ', $order_ids ), 'db_update_2_11' );
		} while ( $this->should_run( $start_time ) ); // keep going until we run out of time, or memory

	}

	/**
	 * Check DB upgrade action scheduler is scheduled or not
	 *
	 * @return void
	 */
	public function is_action_scheduled( $versions ) {
		if ( empty( $versions ) ) {
			return;
		}

		foreach ( $versions as $version => $status ) {
			if ( 2 !== intval( $status ) ) {
				continue;
			}

			if ( ! in_array( $version, $this->db_changes, true ) ) {
				delete_option( 'bwfan_db_update' );
				break;
			}

			$version_name = str_replace( ".", "_", $version );
			$action       = 'bwfan_db_update_' . $version_name;

			/** Check if action is already scheduled */
			if ( ! bwf_has_action_scheduled( $action ) ) {
				$args = array( 'datetime' => current_time( 'mysql', 1 ) );
				bwf_schedule_recurring_action( time(), 60, $action, $args, 'bwf_update' );
			}
		}
	}
}

BWFAN_DB_Update::get_instance();
