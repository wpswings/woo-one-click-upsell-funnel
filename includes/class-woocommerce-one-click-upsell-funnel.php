<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpswings.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/includes
 * @author     wpswings <webmaster@wpswings.com>
 */
class Wpswocuf_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpswocuf_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current onboard of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $onboard    The current version of the plugin.
	 */
	protected $onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'wpswocuf_VERSION' ) ) {
			$this->version = wpswocuf_VERSION;
		} else {
			$this->version = '3.6.0';
		}

		$this->plugin_name = 'woocommerce-one-click-upsell-funnel';

		$this->load_dependencies();
		$this->set_locale();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wpswocuf_Loader. Orchestrates the hooks of the plugin.
	 * - Wpswocuf_I18n. Defines internationalization functionality.
	 * - Wpswocuf_Admin. Defines all hooks for the admin area.
	 * - Wpswocuf_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		if ( class_exists( 'WPSwings_Onboarding_Helper' ) ) {

			$this->onboard = new WPSwings_Onboarding_Helper();
		}

		$this->loader = new Wpswocuf_Loader();

		/**
		 * The file responsible for Upsell Widgets added within every page builder.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'page-builders/class-wps-upsell-widget-loader.php';
		if ( class_exists( 'wpswocuf_Upsell_Widget_Loader' ) ) {
			wpswocuf_Upsell_Widget_Loader::get_instance();
		}

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_One_Click_Upsell_Funnel_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpswocuf_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpswocuf_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
// Backward compatibility for legacy class name.
if ( ! class_exists( 'Woocommerce_One_Click_Upsell_Funnel' ) ) {
	class_alias( 'Wpswocuf_Plugin', 'Woocommerce_One_Click_Upsell_Funnel' );
}
if ( ! class_exists( 'Woocommerce_One_Click_Upsell_Funnel_Loader' ) ) {
	class_alias( 'Wpswocuf_Loader', 'Woocommerce_One_Click_Upsell_Funnel_Loader' );
}
if ( ! class_exists( 'Woocommerce_One_Click_Upsell_Funnel_I18n' ) ) {
	class_alias( 'Wpswocuf_I18n', 'Woocommerce_One_Click_Upsell_Funnel_I18n' );
}
