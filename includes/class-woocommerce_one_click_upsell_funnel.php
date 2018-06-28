<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
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
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_one_click_upsell_funnel_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MWB_WOCUF_PLUGIN_VERSION' ) ) {
			$this->version = MWB_WOCUF_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.2';
		}
		$this->plugin_name = 'woocommerce_one_click_upsell_funnel';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_one_click_upsell_funnel_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_one_click_upsell_funnel_i18n. Defines internationalization functionality.
	 * - Woocommerce_one_click_upsell_funnel_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_one_click_upsell_funnel_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce_one_click_upsell_funnel-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce_one_click_upsell_funnel-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce_one_click_upsell_funnel-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce_one_click_upsell_funnel-public.php';


		$this->loader = new Woocommerce_one_click_upsell_funnel_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_one_click_upsell_funnel_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_one_click_upsell_funnel_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woocommerce_one_click_upsell_funnel_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin,'mwb_wocuf_admin_menu', 10, 2 );

		$this->loader->add_action( 'wp_ajax_mwb_wocuf_return_offer_content', $plugin_admin,'mwb_wocuf_return_offer_content');

		$this->loader->add_action('wp_ajax_seach_products_for_targets_and_offers',$plugin_admin,'seach_products_for_targets_and_offers');

		$this->loader->add_action('woocommerce_admin_order_data_after_order_details' , $plugin_admin,'mwb_wocuf_change_admin_order_details');

		$this->loader->add_filter('manage_edit-shop_order_columns',$plugin_admin,'mwb_wocuf_add_columns_to_admin_orders',11);

		$this->loader->add_action('manage_shop_order_posts_custom_column',$plugin_admin,'mwb_wocuf_add_upsell_orders_to_parent',10,2);

		$this->loader->add_filter('restrict_manage_posts',$plugin_admin,'mwb_wocuf_restrict_manage_posts');

		$this->loader->add_filter('request',$plugin_admin,'mwb_wocuf_request_query');

		$this->loader->add_filter( 'page_template', $plugin_admin, 'mwb_wocuf_page_template' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woocommerce_one_click_upsell_funnel_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('init',$plugin_public,'mwb_wocuf_create_funnel_offer_shortcode');

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_filter('woocommerce_get_checkout_order_received_url',$plugin_public,'mwb_wocuf_process_funnel_offers',20,2);

		$this->loader->add_action('wp_loaded',$plugin_public,'mwb_wocuf_process_the_funnel');

		$this->loader->add_action('wp_loaded',$plugin_public,'mwb_wocuf_charge_the_offer');

		if( $this->mwb_wocuf_woocommerce_version_check() >= '3.3.1'){

			$this->loader->add_action('woocommerce_order_details_after_order_table_items',$plugin_public,'mwb_wocuf_order_items_table' );

		}
		else{

			$this->loader->add_action('woocommerce_order_items_table',$plugin_public,'mwb_wocuf_order_items_table' );
		}
		
		$this->loader->add_filter('the_content',$plugin_public,'mwb_wocuf_funnel_product_page',11,1);

		$this->loader->add_action("woocommerce_single_product_summary",$plugin_public,"mwb_wocuf_add_buy_link",31);

		$this->loader->add_filter('woocommerce_get_order_item_totals',$plugin_public,'mwb_wocuf_get_order_item_totals',1,3);

		$this->loader->add_filter( 'woocommerce_get_formatted_order_total', $plugin_public, 'mwb_wocuf_get_new_total', 10, 4 );

		$this->loader->add_filter('woocommerce_my_account_my_orders_query',$plugin_public,'mwb_wocuf_my_account_my_orders_query',11,1);

		$this->loader->add_filter('woocommerce_get_item_count',$plugin_public,'mwb_wocuf_get_item_count',11,3);

		$this->loader->add_filter( 'woocommerce_order_get_downloadable_items', $plugin_public, 'mwb_wocuf_order_downloads', 10, 2 );
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
	 * @return    Woocommerce_one_click_upsell_funnel_Loader    Orchestrates the hooks of the plugin.
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

	public function mwb_wocuf_woocommerce_version_check() {

		require_once( ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php' );
		
		global $woocommerce;
	
		return $woocommerce->version;
		
	}
}
