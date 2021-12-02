<?php
/**
 * Upsell elementor widgets collection loader file.
 *
 * @link       https://makewebbetter.com/?utm_source=MWB-upsell-backend&utm_medium=MWB-ORG-backend&utm_campaign=MWB-backend
 * @since      3.0.0
 *
 * @package    woo-one-click-upsell-funnel
 * @subpackage woo-one-click-upsell-funnel/widgets
 */

namespace ElementorUpsellWidgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Widgets loader for elementor.
 */
class Elementor_Widget {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {

		$widget_files = array(
			'upsell-accept',
			'upsell-reject',
			'upsell-image',
			'upsell-variations',
		);

		foreach ( $widget_files as $key => $file_name ) {
			require 'assets/widgets/class-' . $file_name . '.php';
		}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {

		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Upsell_Accept() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Upsell_Reject() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Upsell_Image() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Upsell_Variations() );
	}

	/**
	 * Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Register the widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}
}

// Instantiate the Widgets class.
Elementor_Widget::instance();
