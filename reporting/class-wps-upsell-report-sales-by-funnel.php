<?php
/**
 * Upsell Sales by Funnel Data handling and Stats.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      3.0.0
 *
 * @package    woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/reporting
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.
}

if ( class_exists( 'WPS_Upsell_Report_Sales_By_Funnel' ) ) {
	return;
}

/**
 * WPS_Upsell_Report_Sales_By_Funnel.
 */
class WPS_Upsell_Report_Sales_By_Funnel {

	/**
	 * Upsell Funnel ID for operations.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      int    $funnel_id    Upsell Funnel ID.
	 */
	protected $funnel_id;

	/**
	 * Upsell Funnel Series array.
	 *
	 * @since    3.0.0
	 * @access   protected
	 * @var      array    $funnel_series    Upsell Funnel Series.
	 */
	protected $funnel_series = array();

	/**
	 * Initialize the Class.
	 *
	 * @param mixed $funnel_id funnel id.
	 * @since    3.0.0
	 */
	public function __construct( $funnel_id = 0 ) {

		$this->funnel_id = $funnel_id;

		$this->set_funnel_series();
	}

	/**
	 * Get all Upsell funnels.
	 *
	 * @since    3.0.0
	 * @access   protected
	 */
	protected function set_funnel_series() {

		$this->funnel_series = get_option( 'wps_wocuf_funnels_list', array() );
	}

	/**
	 * Validate Upsell funnel series and check for Funnel ID index.
	 *
	 * @since    3.0.0
	 * @access   protected
	 */
	protected function validate_funnel_series() {

		if ( ! empty( $this->funnel_series ) && is_array( $this->funnel_series ) && ! empty( $this->funnel_series[ $this->funnel_id ] ) ) {

			return true;
		} else {

			return false;
		}
	}

	/**
	 * Save the Upsell series with the Updated data.
	 *
	 * @param mixed $funnel_series funnel series.
	 * @since    3.0.0
	 * @access   protected
	 */
	protected function save_funnel_series( $funnel_series = array() ) {

		update_option( 'wps_wocuf_funnels_list', $funnel_series );
	}

	/**
	 * Add Offer View Count for the current Funnel.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_offer_view_count() {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['offers_view_count'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['offers_view_count'] += 1;
			} else {

				$this->funnel_series[ $this->funnel_id ]['offers_view_count'] = 1;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}

	/**
	 * Add Offer Accept Count for the current Funnel.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_offer_accept_count() {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['offers_accept_count'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['offers_accept_count'] += 1;
			} else {

				$this->funnel_series[ $this->funnel_id ]['offers_accept_count'] = 1;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}

	/**
	 * Add Offer Reject Count for the current Funnel.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_offer_reject_count() {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['offers_reject_count'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['offers_reject_count'] += 1;
			} else {

				$this->funnel_series[ $this->funnel_id ]['offers_reject_count'] = 1;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}

	/**
	 * Add Funnel Triggered Count for the current Funnel.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_funnel_triggered_count() {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['funnel_triggered_count'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['funnel_triggered_count'] += 1;
			} else {

				$this->funnel_series[ $this->funnel_id ]['funnel_triggered_count'] = 1;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}

	/**
	 * Add Funnel Success Count ( When Payment processes and Funnel Reaches Thankyou Page
	 * and atleast 1 Offer is Accepted ) for the current Funnel.
	 *
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_funnel_success_count() {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['funnel_success_count'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['funnel_success_count'] += 1;
			} else {

				$this->funnel_series[ $this->funnel_id ]['funnel_success_count'] = 1;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}

	/**
	 * Add Funnel Total Sales ( Upsell items ) without tax.
	 *
	 * @param mixed $upsell_item_total upsell_item_total.
	 * @since    3.0.0
	 * @access   public
	 */
	public function add_funnel_total_sales( $upsell_item_total = 0 ) {

		if ( $this->validate_funnel_series() ) {

			if ( ! empty( $this->funnel_series[ $this->funnel_id ]['funnel_total_sales'] ) ) {

				$this->funnel_series[ $this->funnel_id ]['funnel_total_sales'] += $upsell_item_total;
			} else {

				$this->funnel_series[ $this->funnel_id ]['funnel_total_sales'] = $upsell_item_total;
			}

			$this->save_funnel_series( $this->funnel_series );
		}
	}
}
