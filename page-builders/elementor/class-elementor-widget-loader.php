<?php
/**
 * Upsell elementor widgets collection loader file.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      3.0.0
 *
 * @package    woo-one-click-upsell-funnel
 * @subpackage woo-one-click-upsell-funnel/page-builders/elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Widgets loader for elementor.
 */
final class Elementor_Widget_Loader {

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Initialize the plugin.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		};
		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our widgets.
		require_once 'elementor-widget/class-elementor-widget.php';
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		?>
		<div class="notice notice-warning is-dismissible"><p><strong><?php esc_html_e( 'Elementor Widgets ', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( 'requires ', 'woo-one-click-upsell-funnel' ); ?><strong> <?php esc_html_e( 'Elementor ', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( ' version ', 'woo-one-click-upsell-funnel' ); ?><?php echo esc_html( self::MINIMUM_ELEMENTOR_VERSION ); ?><?php esc_html__( ' or greater.', 'woo-one-click-upsell-funnel' ); ?></p></div>
		<?php
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		?>
		<div class="notice notice-warning is-dismissible"><p><strong><?php esc_html_e( 'Elementor Widgets ', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( 'requires ', 'woo-one-click-upsell-funnel' ); ?><strong> <?php esc_html_e( 'PHP ', 'woo-one-click-upsell-funnel' ); ?></strong><?php esc_html_e( ' version ', 'woo-one-click-upsell-funnel' ); ?><?php echo esc_html( self::MINIMUM_PHP_VERSION ); ?><?php esc_html__( ' or greater.', 'woo-one-click-upsell-funnel' ); ?></p></div>
		<?php
	}
}

// Instantiate Elementor Widgets.
new Elementor_Widget_Loader();
