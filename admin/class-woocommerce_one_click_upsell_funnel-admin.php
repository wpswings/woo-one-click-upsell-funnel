<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel_Admin 
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) 
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() 
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_one_click_upsell_funnel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_one_click_upsell_funnel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if(isset($screen->id))
		{
			$pagescreen = $screen->id;

			if($pagescreen == 'woocommerce_page_mwb-wocuf-setting')
			{
				wp_register_style('mwb_wocuf_admin_style', plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel-admin.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'mwb_wocuf_admin_style' );

				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

				wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

				wp_enqueue_style( 'woocommerce_admin_menu_styles' );
				
				wp_enqueue_style( 'woocommerce_admin_styles' );
			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() 
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_one_click_upsell_funnel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_one_click_upsell_funnel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$screen = get_current_screen();

		if(isset($screen->id))
		{
			$pagescreen = $screen->id;

			if($pagescreen == 'woocommerce_page_mwb-wocuf-setting')
			{
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
				
				wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION );

				wp_register_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), WC_VERSION, true );	
					$locale  = localeconv();
					$decimal = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
					$params = array(
						/* translators: %s: decimal */
						'i18n_decimal_error'                => sprintf( __( 'Please enter in decimal (%s) format without thousand separators.', $this->plugin_name ), $decimal ),
						/* translators: %s: price decimal separator */
						'i18n_mon_decimal_error'            => sprintf( __( 'Please enter in monetary decimal (%s) format without thousand separators and currency symbols.', 'woocommerce_one_click_upsell_funnel' ), wc_get_price_decimal_separator() ),
						'i18n_country_iso_error'            => __( 'Please enter in country code with two capital letters.', 'woocommerce_one_click_upsell_funnel' ),
						'i18_sale_less_than_regular_error'  => __( 'Please enter in a value less than the regular price.', 'woocommerce_one_click_upsell_funnel' ),
						'decimal_point'                     => $decimal,
						'mon_decimal_point'                 => wc_get_price_decimal_separator(),
						'strings' => array(
							'import_products' => __( 'Import', 'woocommerce_one_click_upsell_funnel' ),
							'export_products' => __( 'Export', 'woocommerce_one_click_upsell_funnel' ),
						),
						'urls' => array(
							'import_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_importer' ) ),
							'export_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_exporter' ) ),
						),
					);

				wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );
				
				wp_enqueue_script( 'woocommerce_admin' );

				wp_enqueue_script('mwb-wocuf-new-offer-script',plugin_dir_url( __FILE__ ) . 'js/mwb_wocuf_add_new_offer_script.js', array('woocommerce_admin','wc-enhanced-select'), $this->version,false);

				wp_localize_script( 'mwb-wocuf-new-offer-script', 'ajaxurl',admin_url('admin-ajax.php'));

				wp_localize_script( 'mwb-wocuf-new-offer-script', 'mwb_wocuf_confirm_deletion' , __( "Are you sure to delete this offer", "woocommerce_one_click_upsell_funnel" ) );

				wp_enqueue_style( 'wp-color-picker' ); 		       

				wp_enqueue_script('mwb-wocuf-color-picker-handle', plugin_dir_url( __FILE__ ) . 'js/mwb_wocuf_color_picker_handle.js', array('jquery','wp-color-picker' ), $this->version, true);
				
			}
		}
	}

	/**
	 * adding upsell menu page
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_admin_menu()
	{

		add_submenu_page( "woocommerce", __("One Click Upsell Funnel","woocommerce_one_click_upsell_funnel" ), __("One Click Upsell Funnel","woocommerce_one_click_upsell_funnel" ), "manage_woocommerce", "mwb-wocuf-setting", array($this, "mwb_wocuf_admin_setting"));
	}

	/**
	 * callable function for upsell menu page
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_admin_setting()
	{
		require_once plugin_dir_path( __FILE__ ).'/partials/woocommerce_one_click_upsell_funnel-admin-display.php';
	}

	/**
	 * creating html template for new offer block
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_return_offer_content()
	{

		if( isset( $_POST["mwb_wocuf_flag"] ) && isset( $_POST["mwb_wocuf_funnel"] ) )
		{
			$index = sanitize_text_field( $_POST["mwb_wocuf_flag"] );

			$funnel = sanitize_text_field( $_POST["mwb_wocuf_funnel"] );

			unset($_POST["mwb_wocuf_flag"]);

			unset($_POST["mwb_wocuf_funnel"]);

			$mwb_wocuf_funnel = get_option("mwb_wocuf_funnels_list",array());

			$mwb_wocuf_offers_to_add = !empty( $mwb_wocuf_funnel[$funnel]["mwb_wocuf_applied_offer_number"] )?$mwb_wocuf_funnel[$funnel]["mwb_wocuf_applied_offer_number"]:array();

			$mwb_wocuf_buy_offers='<select name="mwb_wocuf_attached_offers_on_buy['.$index.']"><option value="thanks">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>';

			$mwb_wocuf_no_offers='<select name="mwb_wocuf_attached_offers_on_no['.$index.']"><option value="thanks">'.__('ThankYou Page','woocommerce_one_click_upsell_funnel').'</option>';

			if(!empty($mwb_wocuf_offers_to_add))
			{
				foreach($mwb_wocuf_offers_to_add as $mwb_single_offer_to_add):
					$mwb_wocuf_buy_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
					$mwb_wocuf_no_offers.='<option value='.$mwb_single_offer_to_add.'>'.__('Offer','woocommerce_one_click_upsell_funnel').$mwb_single_offer_to_add.'</option>';
				endforeach;
			}

			$mwb_wocuf_buy_offers.='</select>';

			$mwb_wocuf_no_offers.='</select>';

			$data = '<div style="display:none;" data-id="'.$index.'" class="new_created_offers"><h2>'.__('Offer #','woocommerce_one_click_upsell_funnel').$index.'</h2>
			<table>
			<tr><th><label><h4>'.__('Product Search : ','woocommerce_one_click_upsell_funnel').'</h4></label></th><td><select class="wc-funnel-product-search" multiple="multiple" style="" name="mwb_wocuf_products_in_offer['.$index.'][]" data-placeholder="'.__( 'Search for a product', 'woocommerce_one_click_upsell_funnel').'" data-action="woocommerce_json_search_products_and_variations" id="mwb_wocuf_target_pro_ids"></select></td></tr>
			<tr><th><label><h4>'.__('Offer Price : ','woocommerce_one_click_upsell_funnel').'</h4></label></th><td><input type="text" placeholder="'.__('enter in percentage','woocommerce_one_click_upsell_funnel').'" name="mwb_wocuf_offer_discount_price['.$index.']" style="width:50%;height:40px;" value="50%"><span style="color:green">'.__(" Note: Enter in % or a new offer price","woocommerce_one_click_upsell_funnel").'</span></td></tr>
		    <tr><th><label><h4>'.__('After "Buy Now" Go to:','woocommerce_one_click_upsell_funnel').'</h4></label></th>
			    <td>'.$mwb_wocuf_buy_offers.'</td></tr>
		    <tr><th><label><h4>'.__('After "No thanks" Go to: ','woocommerce_one_click_upsell_funnel').'</h4></label></th><td>'.$mwb_wocuf_no_offers.'</td></tr>
		    <tr><th><label><h4>'.__('Custom Page Url For Offer: ','woocommerce_one_click_upsell_funnel').'</h4></label></th><td><input type="text" placeholder="'.__('enter page url for special offers','woocommerce_one_click_upsell_funnel').'" name="mwb_wocuf_offer_custom_page_url['.$index.']" style="width:50%;height:40px;" class="mwb_wocuf_offer_custom_page_url"><span style="color:green">'.__(" Note : Leave it blank to use default page ","woocommerce_one_click_upsell_funnel").'</span></td></tr>
		    <tr><td colspan="2"><button style="color:white;background-color:red;height:30px;cursor: pointer;" class="mwb_wocuf_delete_new_created_offers" data-id="'.$index.'">'.__("Remove","woocommerce_one_click_upsell_funnel").'</button></td></tr>
		    </table>
		    <input type="hidden" name="mwb_wocuf_applied_offer_number['.$index.']" value="'.$index.'">
		    </div>';

		    $new_data = apply_filters("mwb_wocuf_add_more_to_offers",$data);

			echo $new_data;
		}
		wp_die();
	}


	/**
	 * select2 search for adding offer products
	 *
	 * @since    1.0.0
	 */

	public function seach_products_for_targets_and_offers()
	{
		
		$return = array();

		$search_results = new WP_Query( array( 
			's'=> sanitize_text_field( $_GET['q'] ),
			'post_type' => array('product'), 
			'ignore_sticky_posts' => 1,
			'posts_per_page' => 50 
		) );

		if($search_results->have_posts()) :
			while( $search_results->have_posts()): 

				$search_results->the_post();	
				$title =( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
				$product = wc_get_product($search_results->post->ID);
				$stock = $product->get_stock_status();
				if($product->is_type('simple') && $stock !== "outofstock")
				{
					$return[] = array( $search_results->post->ID, $title ); 
				}

			endwhile;
		endif;

		echo json_encode( $return );

		die;
	}

	/**
	 * displaying upsell purchases in parent order details in  backend
	 *
	 * @since    1.0.0
	 * @param    object   $order   object of parent order
	 */

	public function mwb_wocuf_change_admin_order_details($order)
	{

		$output = "";

		$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $order->get_id(),
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));

		

		if(!empty($mwb_wocuf_order))
		{
			$output.='<h3>'.__('Funnel Orders','woocommerce_one_click_upsell_funnel').'</h3><br>';

			foreach($mwb_wocuf_order as $mwb_wocuf_single_order)
			{
				$mwb_wocuf_upsell_order = wc_get_order($mwb_wocuf_single_order->ID);

				$output .='<div><a href="'.get_edit_post_link($mwb_wocuf_upsell_order->get_id()).'">'.__('Upsell order #','woocommerce_one_click_upsell_funnel').$mwb_wocuf_upsell_order->get_order_number().'</div>';
			}
		}

		echo $output;

	}

	/**
	 * adding custom column in orders table at backend
	 *
	 * @since    1.0.0
	 * @param    array    $columns    array of columns on orders table 
	 * @return   array    $columns    array of columns on orders table alongwith upsell column
	 */

	public function mwb_wocuf_add_columns_to_admin_orders($columns)
	{

	  	$columns['upsell-orders'] = __('Upsell Orders','woocommerce_one_click_upsell_funnel');

    	return $columns;
	}

	/**
	 * populating "Upsell order" column in orders table at backend
	 * for orders(with upsell funnel orders), a list of all upsell orders is used as a key.
	 * for orders(with no upsell funnel orders), "Single Order" key is used.
	 * for each upsell order, "_" key is used.
	 *
	 * @since    1.0.0
	 * @param    array   $column    array of available columns
	 * @param    int     $post_id   cuurent post id 
	 */

	public function mwb_wocuf_add_upsell_orders_to_parent($column, $post_id)
	{

		$output = "";

		$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $post_id,
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));

		$mwb_wocuf_upsell_order = get_post_meta($post_id,"mwb_wocuf_upsell_parent_order",true);

		switch($column)
		{
			case 'upsell-orders':

			$data = "";

			if(!empty($mwb_wocuf_order))
			{
				foreach($mwb_wocuf_order as $mwb_wocuf_single_order)
				{
					$mwb_wocuf_upsell_order = wc_get_order($mwb_wocuf_single_order->ID);

					$data .= '<p><a href="'.get_edit_post_link($mwb_wocuf_upsell_order->get_id()).'">'.__('Upsell order #','woocommerce_one_click_upsell_funnel').$mwb_wocuf_upsell_order->get_order_number().'</a></p>';
				}	
			}
			elseif(empty($mwb_wocuf_upsell_order))
			{
				$data .= __("Single Order","woocommerce_one_click_upsell_funnel");
			}
			else
			{
				$data = '<p style="">_</p>';
			}

			echo $data;
			
			break;	
		}	
	}



	/**
	 * adding select dropdown for filtering:- "upsells orders","single parent order" or "parent orders with linked upsell orders"
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_restrict_manage_posts()
	{

		if(isset($_GET["post_type"]) && $_GET["post_type"]=="shop_order")
		{
			if(isset($_GET["mwb_wocuf_upsell_filter"])):?>
				<select name="mwb_wocuf_upsell_filter">
					<option value="select" <?php echo sanitize_text_field( $_GET["mwb_wocuf_upsell_filter"] ) == "select" ? "selected=selected" : ""?>><?php _e('All Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_single" <?php echo sanitize_text_field( $_GET["mwb_wocuf_upsell_filter"] ) == "all_single" ? "selected=selected":""?>><?php _e('All excluding Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_upsells" <?php echo sanitize_text_field( $_GET["mwb_wocuf_upsell_filter"] ) == "all_upsells" ? "selected=selected" : ""?>><?php _e('Only Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
				</select>
			<?php endif;

			if(!isset($_GET["mwb_wocuf_upsell_filter"])):?>
				<select name="mwb_wocuf_upsell_filter">
					<option value="select"><?php _e('All Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_single"><?php _e('All excluding Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
					<option value="all_upsells"><?php _e('Only Upsell Orders','woocommerce_one_click_upsell_funnel')?></option>
				</select>
			<?php endif;
		}
	}

	/**
	 * modifying query vars for filtering orders
	 *
	 * @since    1.0.0
	 * @param    array    $vars    array of queries
	 * @return   array    $vars    array of queries alongwith select dropdown query for upsell
	 */

	public function mwb_wocuf_request_query($vars)
	{

		if(isset($_GET["mwb_wocuf_upsell_filter"]) && $_GET["mwb_wocuf_upsell_filter"]=="all_upsells")
		{
			$vars = array_merge($vars,array('meta_key'=>'mwb_wocuf_upsell_parent_order'));
		}
		elseif(isset($_GET["mwb_wocuf_upsell_filter"]) && $_GET["mwb_wocuf_upsell_filter"]=="all_single")
		{
			$vars = array_merge($vars,array('meta_key'=>'mwb_wocuf_upsell_parent_order','meta_compare'=>'NOT EXISTS'));
		}

		return $vars;
	}


	/**
	 * adding distraction free mode to the offers page.
	 *
	 * @since    	1.0.0
	 * @param  		$page_template 		default template for the page
	 */

	public function mwb_wocuf_page_template( $page_template )
	{
		$pages_available = get_posts(array(
			'posts_per_page' 		=> -1,
			'post_type' 			=> 'any',
			'post_status' 			=> 'publish',
			's' 					=> '[mwb_wocuf_funnel_default_offer_page]',
			'orderby' 				=> 'ID',
			'order' 				=> 'ASC',
		));

		foreach( $pages_available as $single_page )
		{
			if( is_page( $single_page->ID ) )
			{
				$page_template = dirname( __FILE__ ) .'/partials/templates/mwb-wocuf-template.php';
			}
		}

		return $page_template;
	} 

	//end of class
}
?>