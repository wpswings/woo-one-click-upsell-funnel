<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://makewebbetter.com/
 * @since             1.0.0
 * @package           Woocommerce_one_click_upsell_funnel
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce One Click Upsell Funnel
 * Plugin URI:        https://makewebbetter.com/woocommerce-one-click-upsell-funnel
 * Description:       Increases your woocommerce store sales instantly by showing special offers on purchased products at checkout page. Customers can buy the offered products on a single click only.
 * Version:           1.0.2
 * Author:            MakeWebBetter
 * Author URI:        http://makewebbetter.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce_one_click_upsell_funnel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$activated = true;

if (function_exists('is_multisite') && is_multisite())
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) )
	{
		$activated = false;
	}
}
else
{
	if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		$activated = false;
	}
}

if($activated)
{

	define('MWB_WOCUF_URL', plugin_dir_url( __FILE__ ));

	define('MWB_WOCUF_DIRPATH', plugin_dir_path( __FILE__ ));

	define('MWB_WOCUF_PLUGIN_VERSION', '1.0.2' );
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel-activator.php
	 */
	function activate_woocommerce_one_click_upsell_funnel() 
	{
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce_one_click_upsell_funnel-activator.php';
		Woocommerce_one_click_upsell_funnel_Activator::activate();
	}

	add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'mwb_wocuf_plugin_settings_link');

	function mwb_wocuf_plugin_settings_link( $links ) 
	{
		$plugin_links = array('<a href="' .
			admin_url( 'admin.php?page=mwb-wocuf-setting' ) .
			'">' . __('Settings',"woocommerce_one_click_upsell_funnel") .'</a>');
		return array_merge($plugin_links,$links);
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-woocommerce_one_click_upsell_funnel-deactivator.php
	 */

	register_activation_hook( __FILE__, 'activate_woocommerce_one_click_upsell_funnel' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce_one_click_upsell_funnel.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_woocommerce_one_click_upsell_funnel() 
	{

		$plugin = new Woocommerce_one_click_upsell_funnel();
		$plugin->run();

	}

	run_woocommerce_one_click_upsell_funnel();
}
else
{
	/**
	 * Show warning message if woocommerce is not install
	 * @since 1.0.0
	 * @name mwb_wuc_plugin_error_notice()
	 * @author makewebbetter<webmaster@makewebbetter.com>
	 * @link http://www.makewebbetter.com/
	 */

	function mwb_wocuf_plugin_error_notice()
 	{ ?>
 		<div class="error notice is-dismissible">
 			<p><?php _e( 'Woocommerce is not activated, Please activate Woocommerce first to install WooCommerce One Click Upsell Funnel', 'woocommerce_one_click_upsell_funnel' ); ?></p>
   		</div>
   		<style>
   		#message{display:none;}
   		</style>
   	<?php 
 	} 

 	add_action('admin_init','mwb_wocuf_plugin_deactivate');  

 	/**
 	 * Call Admin notices
 	 * 
 	 * @name mwb_wocuf_plugin_deactivate()
 	 * @author makewebbetter<webmaster@makewebbetter.com>
 	 * @link http://www.makewebbetter.com/
 	 */ 	
  	function mwb_wocuf_plugin_deactivate()
	{
	   deactivate_plugins( plugin_basename( __FILE__ ) );
	   add_action( 'admin_notices', 'mwb_wocuf_plugin_error_notice' );
	}
}
?>