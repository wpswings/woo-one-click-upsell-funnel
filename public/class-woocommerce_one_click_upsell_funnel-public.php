<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_one_click_upsell_funnel
 * @subpackage Woocommerce_one_click_upsell_funnel/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Woocommerce_one_click_upsell_funnel_Public{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) 
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( "mwb-wocuf-public-style", plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		wp_enqueue_script( 'mwb-wocuf-public-script', plugin_dir_url( __FILE__ ) . 'js/mwb-wocuf-public.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * changing the checkout url if a funnel exists for purchased products
	 *
	 * @since   1.0.0
	 * @param 	string  $result  the url to change
	 * @param   object  $order   current order of store
	 * @param   string  $result  url of offers page 
	 */

	public function mwb_wocuf_process_funnel_offers($result,$order)
	{

		$mwb_wocuf_all_funnels = get_option( "mwb_wocuf_funnels_list", array() );

		$mwb_wocuf_flag = 0;

		$mwb_wocuf_enable_plugin = get_option( "mwb_wocuf_enable_plugin", "off" );

		$order_id = $order->get_id();

		$mwb_wocuf_payment_method = get_post_meta( $order_id, '_payment_method', true );

		if( $mwb_wocuf_payment_method !== "cod" )
		{
			return $result;
		}
		elseif( $mwb_wocuf_enable_plugin == "off" )
		{
			return $result;
		}
		elseif( empty( $mwb_wocuf_all_funnels ) )
		{
			return $result;
		}
		elseif( empty( $order ) )
		{
			return $result;
		}
		elseif( !empty( $_REQUEST["mwb_wocuf_verify"] ) )
		{
			return $result;
		}

		if( !empty( $order ) )
		{
			$mwb_wocuf_placed_order_items = $order->get_items();

			$mwb_wocuf_order_key = $order->get_order_key();

			$mwb_wocuf_offer_id = 0;

			foreach( $mwb_wocuf_all_funnels as $mwb_wocuf_single_funnel => $mwb_wocuf_funnel_data )
			{
				$mwb_wocuf_existing_offers = !empty( $mwb_wocuf_funnel_data["mwb_wocuf_applied_offer_number"] )?$mwb_wocuf_funnel_data["mwb_wocuf_applied_offer_number"]:array();

				if( count( $mwb_wocuf_existing_offers ) && $mwb_wocuf_offer_id == 0 )
				{
					foreach( $mwb_wocuf_existing_offers as $key => $value )
					{
						$mwb_wocuf_offer_id = $key;
						break;
					}
				}
			}

			foreach( $mwb_wocuf_all_funnels as $mwb_wocuf_single_funnel => $mwb_wocuf_funnel_data )
			{
				$mwb_wocuf_funnel_target_products = $mwb_wocuf_all_funnels[$mwb_wocuf_single_funnel]["mwb_wocuf_target_pro_ids"];

				if( is_array( $mwb_wocuf_placed_order_items ) && count( $mwb_wocuf_placed_order_items ) )
				{
					foreach ( $mwb_wocuf_placed_order_items as $item_key => $mwb_wocuf_single_item )
					{
						$mwb_wocuf_product_id = $mwb_wocuf_single_item->get_product_id();

						if( in_array( $mwb_wocuf_product_id, $mwb_wocuf_funnel_target_products ) )
						{
							if( !empty( $mwb_wocuf_all_funnels[$mwb_wocuf_single_funnel]["mwb_wocuf_products_in_offer"][$mwb_wocuf_offer_id] ) )
							{
								$mwb_wocuf_flag = 1;
								$funnel_found = $mwb_wocuf_single_funnel;
								break;
							}
						}
					}
				}
				if( $mwb_wocuf_flag )
				{
					break;
				}
			}

			if( !$mwb_wocuf_flag )
			{
				foreach( $mwb_wocuf_all_funnels as $mwb_wocuf_single_funnel => $mwb_wocuf_funnel_data )
				{
					$mwb_wocuf_global_funnel = !empty( $mwb_wocuf_funnel_data["mwb_wocuf_global_funnel"] )?$mwb_wocuf_funnel_data["mwb_wocuf_global_funnel"]:'no';

					if( $mwb_wocuf_global_funnel == "yes" )
					{
						$mwb_wocuf_flag = 1;
						$funnel_found = $mwb_wocuf_single_funnel;
						break;
					}
				}
			}

			if( $mwb_wocuf_flag )
			{
				$mwb_wocuf_offer_page_id = get_option( "mwb_wocuf_funnel_default_offer_page", "" );

				if( isset( $mwb_wocuf_all_funnels[$funnel_found]["mwb_wocuf_offer_custom_page_url"][$mwb_wocuf_offer_id] ) && !empty( $mwb_wocuf_all_funnels[$funnel_found]["mwb_wocuf_offer_custom_page_url"][$mwb_wocuf_offer_id] ) )
				{
					$result = $mwb_wocuf_all_funnels[$funnel_found]["mwb_wocuf_offer_custom_page_url"][$mwb_wocuf_offer_id];
				}
				elseif( get_post_status( $mwb_wocuf_offer_page_id ) == "publish" )
				{
					$result = get_page_link( $mwb_wocuf_offer_page_id );
				}
				else
				{
					return $result;
				}

				$mwb_wocuf_nonce = wp_create_nonce("funnel_offers");

				$result .= '?mwb_wocuf_verify='.$mwb_wocuf_nonce.'&mwb_wocuf_funnel_id='.$funnel_found.'&mwb_wocuf_order_key='.$mwb_wocuf_order_key.'&mwb_wocuf_offer_id='.$mwb_wocuf_offer_id;
			}
		}
		
		return $result;
	}

	/**
	 * if customer rejects to buy upsell products then redirect to thankyou page
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_process_the_funnel()
	{
		if( is_admin() )
		{
			return;
		}
	
		if( isset( $_GET["mwb_wocuf_verify"] ) && isset( $_GET["mwb_wocuf_thanks"] ) )
		{
			$offer_id = sanitize_text_field( $_GET["mwb_wocuf_offer_id"] );

			$funnel_id = sanitize_text_field( $_GET["mwb_wocuf_funnel_id"] );

			$order_key = sanitize_text_field( $_GET["mwb_wocuf_order_key"] );

			$mwb_wocuf_all_funnels = get_option("mwb_wocuf_funnels_list",array());

			$mwb_wocuf_action_on_no = $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_attached_offers_on_no"];

			$mwb_wocuf_check_action = $mwb_wocuf_action_on_no[$offer_id];

			if( $mwb_wocuf_check_action == "thanks" )
			{
				$order_id = wc_get_order_id_by_order_key($order_key);

				$order = wc_get_order($order_id);

				$order_received_url = $order->get_checkout_order_received_url();

				wp_redirect($order_received_url);

				exit();
			}
			elseif( $mwb_wocuf_check_action!="thanks" )
			{
				$offer_id = $mwb_wocuf_check_action;

				$mwb_wocuf_upcoming_offer = isset( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_products_in_offer"][$offer_id] )?$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_products_in_offer"][$offer_id]:array();

				if( empty( $mwb_wocuf_upcoming_offer ) )
				{
					$order_id = wc_get_order_id_by_order_key( $order_key );

					$order = wc_get_order( $order_id );

					$order_received_url = $order->get_checkout_order_received_url();

					wp_redirect( $order_received_url );

					exit();
				}

				$mwb_wocuf_offer_page_id = get_option( "mwb_wocuf_funnel_default_offer_page", "" );

				if( isset( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id] ) && !empty( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id] ) )
				{
					$mwb_wocuf_next_offer_url = $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id];
				}
				elseif( get_post_status( $mwb_wocuf_offer_page_id ) == "publish" )
				{
					$mwb_wocuf_next_offer_url = get_page_link( $mwb_wocuf_offer_page_id );
				}
				else
				{
					$order_id = wc_get_order_id_by_order_key( $order_key );

					$order = wc_get_order( $order_id );

					$order_received_url = $order->get_checkout_order_received_url();

					wp_redirect( $order_received_url );

					exit();
				}
				$mwb_wocuf_next_offer_url =  $mwb_wocuf_next_offer_url.'?mwb_wocuf_verify='.$_GET["mwb_wocuf_verify"].'&mwb_wocuf_offer_id='.$offer_id.'&mwb_wocuf_order_key='.$order_key.'&mwb_wocuf_funnel_id='.$funnel_id;

				wp_redirect($mwb_wocuf_next_offer_url);

				exit;
			}
		}
		
	}

	/**
	 * adding shortcode for funnel offer page
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_create_funnel_offer_shortcode()
	{

		add_shortcode('mwb_wocuf_funnel_default_offer_page',array($this,'mwb_wocuf_funnel_offers_shortcode'));
	}

	/**
	 * shortcode content for offer page
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_funnel_offers_shortcode( $content )
	{
		if(!isset($_GET["mwb_wocuf_offer_id"]) || !isset($_GET["mwb_wocuf_funnel_id"]))
		{
			$mwb_wocuf_no_offer_text = get_option("mwb_wocuf_no_offer_text");

			$content.="<h2>".trim($mwb_wocuf_no_offer_text,'"')."</h2>";
		
			$content.='<a class="button wc-backward" href="'.esc_url(apply_filters('woocommerce_return_to_shop_redirect',wc_get_page_permalink('shop'))).'">'.__( 'Go to Shop', 'woocommerce_one_click_upsell_funnel').'</a>';

			return $content;
		}
	}


	/**
	 * adding custom buy and skip button for simple products
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_add_buy_link()
	{
		global $product;

		$saved_product = $product;

		if(isset($_GET["mwb_wocuf_verify"]) && wp_verify_nonce($_GET["mwb_wocuf_verify"] , "funnel_offers") && isset($_GET["mwb_wocuf_offer_id"]) && isset($_GET["mwb_wocuf_funnel_id"]) && isset($_GET["mwb_wocuf_order_key"]))
		{
			$order_key 	= sanitize_text_field( $_GET["mwb_wocuf_order_key"] );
			$wp_nonce 	= sanitize_text_field( $_GET["mwb_wocuf_verify"] );
			$funnel_id 	= sanitize_text_field( $_GET["mwb_wocuf_funnel_id"] );
			$offer_id 	= sanitize_text_field( $_GET["mwb_wocuf_offer_id"] );
			$mwb_wocuf_all_funnels = get_option("mwb_wocuf_funnels_list");

			$mwb_wocuf_discount	=	$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id];

			if(empty($mwb_wocuf_discount))
			{
				$mwb_wocuf_discount = '50%';
			}

			$mwb_wocuf_product_price = $product->get_price();

			if(strpos( $mwb_wocuf_discount, '%' ) !== FALSE )
			{
				$mwb_wocuf_discount = trim($mwb_wocuf_discount,'%');

				$mwb_wocuf_discount = floatval( $mwb_wocuf_product_price ) * ( floatval( $mwb_wocuf_discount ) / 100 );

				if( $mwb_wocuf_product_price > 0 )
				{
					$mwb_wocuf_discount = $mwb_wocuf_product_price - $mwb_wocuf_discount;
				}
				else
				{
					$mwb_wocuf_discount = $mwb_wocuf_product_price;
				}

				$product->set_price($mwb_wocuf_discount);
			}
			else
			{
				$mwb_wocuf_discount = floatval( $mwb_wocuf_discount );

				$product->set_price( $mwb_wocuf_discount );
			}

			$mwb_wocuf_buy_text = get_option("mwb_wocuf_buy_text","");
			$mwb_wocuf_no_text = get_option("mwb_wocuf_no_text","");
			$mwb_wocuf_buy_color = get_option("mwb_wocuf_buy_button_color","black");
			$mwb_wocuf_skip_color = get_option("mwb_wocuf_thanks_button_color","grey");

			if( $product->is_type('simple') )
			{
				$mwb_wocuf_before_offer_price_text = !empty(get_option("mwb_wocuf_before_offer_price_text"))?get_option("mwb_wocuf_before_offer_price_text"):"";
				?>
				<div class="mwb_wocuf_offer_price">
					<p class="mwb_wocuf_offer_price_html">
					<?php echo $mwb_wocuf_before_offer_price_text ?>
					<?php echo $product->get_price_html() ?>
					</p>
				</div>
				<form method="post">
					<input type="hidden" name="mwb_wocuf_verify" value="<?php echo $wp_nonce ?>">
					<input type="hidden" name="mwb_wocuf_funnel_id" value="<?php echo $funnel_id ?>">
					<input type="hidden" name="product_id" value="<?php echo absint($product->get_id())?>">
					<input type="hidden" name="mwb_wocuf_offer_id" value="<?php echo $offer_id ?>">
					<input type="hidden" name="mwb_wocuf_order_key" value="<?php echo $order_key ?>">
					<button style="background-color:<?php echo $mwb_wocuf_buy_color ?>" class="button mwb_wocuf_buy" type="submit" name="mwb_wocuf_buy"><?php echo $mwb_wocuf_buy_text ?></button>
					<a style="background-color:<?php echo $mwb_wocuf_skip_color ?>" class="button mwb_wocuf_skip" href="?mwb_wocuf_verify=<?php echo $wp_nonce ?>&mwb_wocuf_thanks=1&mwb_wocuf_order_key=<?php echo $order_key ?>&mwb_wocuf_offer_id=<?php echo $offer_id ?>&mwb_wocuf_funnel_id=<?php echo $funnel_id ?>"><?php echo $mwb_wocuf_no_text ?></a>
				</form>
			<?php	
			}
		}

		$product = $saved_product;
	}

	/**
	 * modifiying woocommerce product page : content and other hooks 
	 *
	 * @since    1.0.0
	 * @param    string    $content    page content
	 * @return   string    $content    new page content
	 */

	public function mwb_wocuf_funnel_product_page($content)
	{
		if(isset($_GET["mwb_wocuf_verify"]) && wp_verify_nonce($_GET["mwb_wocuf_verify"] , "funnel_offers"))
		{
			if(isset($_GET["mwb_wocuf_offer_id"]) && isset($_GET["mwb_wocuf_funnel_id"]))
			{

				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
				
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

				remove_action( 'woocommerce_after_single_product_summary','woocommerce_upsell_display', 15 );

				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

				remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );

				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

				if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) 
				{
                        wp_enqueue_script( 'zoom' );
                }
                if ( current_theme_supports( 'wc-product-gallery-slider' ) ) 
                {
                    wp_enqueue_script( 'flexslider' );
                }
                if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) 
                {
                    wp_enqueue_script( 'photoswipe-ui-default' );
                    wp_enqueue_style( 'photoswipe-default-skin' );
                    add_action( 'wp_footer', 'woocommerce_photoswipe' );
                }

                wp_enqueue_script( 'wc-single-product' );

				$offer_id = sanitize_text_field( $_GET["mwb_wocuf_offer_id"] );

				$funnel_id = sanitize_text_field( $_GET["mwb_wocuf_funnel_id"] );

				$mwb_wocuf_all_funnels = get_option("mwb_wocuf_funnels_list",array());

				$mwb_wocuf_offer_text = get_option("mwb_wocuf_offer_banner_text","");
				
				$mwb_wocuf_offered_products	=	$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_products_in_offer"];

				foreach($mwb_wocuf_offered_products[$offer_id] as $key=>$mwb_wocuf_single_offered_product):
					if(!empty($mwb_wocuf_offer_text))
					{
						$content .= '<br><center><h1 class="mwb_wocuf_offer_head">'.$mwb_wocuf_offer_text.'</h1></center><br>';
					}
					$content .= do_shortcode('[product_page id="'.$mwb_wocuf_single_offered_product.'"]');
					break;
				endforeach;

				return $content;
			}
		}
		else
		{
			if(isset($_GET["mwb_wocuf_order_key"]))
			{
				$order_key = sanitize_text_field( $_GET["mwb_wocuf_order_key"] );

				$order_id = wc_get_order_id_by_order_key( $order_key );

				if(!empty($order_id))
				{
					$mwb_wocuf_order = wc_get_order($order_id);
				}
				$content .= __("You ran out of the offers session","woocommerce_one_click_upsell_funnel");
				$content .='<a href="'.$mwb_wocuf_order->get_checkout_order_received_url(). '" class="button">'.__('Go to the "Order details" page','woocommerce_one_click_upsell_funnel').'</a>';
				return $content;
			}
		}	
		return $content;
	}

	/**
	 * applying offer on product price 
	 *
	 * @since    1.0.0
	 * @param    object   $temp_product    object of product
	 * @param    string   $price           offer price
	 * @return   object   $temp_product    object of product with new offer price
	 */

	public function mwb_wocuf_change_offered_product_price($temp_product,$price)
	{

		if( empty( $price ) )
		{
			$price = '50%';
		}

		if( !empty( $temp_product ) )
		{
			$mwb_wocuf_product_price = $temp_product->get_price();

			if( strpos( $price, '%' ) !== FALSE )
			{
				$price = trim( $price, '%' );

				$price = floatval( $mwb_wocuf_product_price ) * ( floatval( $price ) / 100 );

				if( $mwb_wocuf_product_price > 0.0 )
				{
					$price = $mwb_wocuf_product_price - $price;
				}
				else
				{
					$price = $mwb_wocuf_product_price;
				}

				$temp_product->set_price( $price );
			}
			else
			{
				$price = floatval( $price );

				$temp_product->set_price( $price );
			}
		}

		return $temp_product;
	}

	/**
	 * processing the upsell offers payment on being purchased
	 *
	 * @since    1.0.0
	 */

	public function mwb_wocuf_charge_the_offer()
	{

		if( is_admin() )
		{
			return;
		}
		
		if( isset( $_POST["mwb_wocuf_buy"] ) )
		{
			unset( $_POST["mwb_wocuf_buy"] );

			if( isset( $_POST["mwb_wocuf_verify"] ) && isset( $_POST["mwb_wocuf_order_key"] ) && isset( $_POST["mwb_wocuf_offer_id"] ) && isset( $_POST["product_id"] ) && isset( $_POST["mwb_wocuf_funnel_id"] ) )
			{

				$order_key = sanitize_text_field( $_POST["mwb_wocuf_order_key"] );

				$wp_nonce = sanitize_text_field( $_POST["mwb_wocuf_verify"] );

				$offer_id = sanitize_text_field( $_POST["mwb_wocuf_offer_id"] );

				$product_id = sanitize_text_field( $_POST["product_id"] );

				$funnel_id = sanitize_text_field( $_POST["mwb_wocuf_funnel_id"] );

				$order_id = wc_get_order_id_by_order_key( $order_key );

				$order_received_url = wc_get_endpoint_url('order-received',$order_id, wc_get_page_permalink( 'checkout' ) );

				$order_received_url = add_query_arg( 'key', $order_key, $order_received_url );

				if(!empty($order_id))
				{
					$order = wc_get_order($order_id);
			    }

				if(!empty($order))
				{
					$mwb_wocuf_purchased_product = wc_get_product($product_id);

					if(!empty($mwb_wocuf_purchased_product))
					{

						$result = $this->mwb_wocuf_process_final_payment($funnel_id,$order_key,$offer_id,$order->get_payment_method(),$product_id);
					}
					if($result)
					{
						$mwb_wocuf_all_funnels = get_option("mwb_wocuf_funnels_list",array());

						$mwb_wocuf_buy_action	=	$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_attached_offers_on_buy"];

						$url = "";

						if($mwb_wocuf_buy_action[$offer_id]=="thanks")
						{

							$url = $order->get_checkout_order_received_url();

							wp_redirect($url);

							exit;
						}
						elseif($mwb_wocuf_buy_action[$offer_id]!="thanks")
						{

							$offer_id = $mwb_wocuf_buy_action[$offer_id];

							$mwb_wocuf_upcoming_offer = isset( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_products_in_offer"][$offer_id] )?$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_products_in_offer"][$offer_id]:"";

							if(empty($mwb_wocuf_upcoming_offer))
							{
								$url = $order->get_checkout_order_received_url();
							}
							else
							{
								$mwb_wocuf_offer_page_id = get_option( "mwb_wocuf_funnel_default_offer_page", "" );

								if( isset( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id] ) && !empty( $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id] ) )
								{
									$mwb_wocuf_next_offer_url = $mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_custom_page_url"][$offer_id];
								}
								elseif( get_post_status( $mwb_wocuf_offer_page_id ) == "publish" )
								{
									$mwb_wocuf_next_offer_url = get_page_link( $mwb_wocuf_offer_page_id );
								}
								else
								{
									$url = $order->get_checkout_order_received_url();
									wp_redirect( $url );
									exit();
								}
								
								$mwb_wocuf_next_offer_url =  $mwb_wocuf_next_offer_url.'?mwb_wocuf_verify='.$wp_nonce.'&mwb_wocuf_offer_id='.$offer_id.'&mwb_wocuf_order_key='.$order_key.'&mwb_wocuf_funnel_id='.$funnel_id;

								$url = $mwb_wocuf_next_offer_url;
							}

							wp_redirect($url);

							exit;
						}
					}
					else
					{
						wp_redirect($order_received_url);
						
						exit;
					}
				}
			}
		}
	}

	/**
	 * creating new orders on upsell puchases and charging the offer
	 *
	 * @since    1.0.0
	 * @param    int      $funnel_id    id of the target funnel
	 * @param    int      $order_key    order key
	 * @param    int      $offer_id     id of the applicable offer
	 * @param    int   	  $offer_id     id of the applicable offer
	 * @param    string   $pay_method   id of order payment method
	 * @param    int   	  $product_id   id of product purchased
	 * @return   bool     $result       indicator for success/failure payments
	 */

	public function mwb_wocuf_process_final_payment($funnel_id,$order_key,$offer_id,$pay_method,$product_id)
	{
	
		global $woocommerce;

		$result = FALSE;

		$mwb_wocuf_payment="";

		$gateways = $woocommerce->payment_gateways->get_available_payment_gateways();

		$mwb_wocuf_all_funnels = get_option("mwb_wocuf_funnels_list");

		$mwb_wocuf_offered_discount	=	$mwb_wocuf_all_funnels[$funnel_id]["mwb_wocuf_offer_discount_price"][$offer_id];

		if(empty($mwb_wocuf_offered_discount))
		{
			$mwb_wocuf_offered_discount = 50;
		}
		if(!empty($order_key) && !empty($pay_method) && !empty($product_id))
		{
			if(!empty($gateways[$pay_method]) && ($pay_method == 'cod'))
			{
				global $product;

				$mwb_wocuf_saved_product = $product;

				$mwb_wocuf_purchased_product=wc_get_product($product_id);

				$product = $mwb_wocuf_purchased_product;

				if( $product->is_purchasable() )
				{
					$mwb_wocuf_parent_order = wc_get_order_id_by_order_key( $order_key );
					$mwb_wocuf_parent_order = wc_get_order( $mwb_wocuf_parent_order );

					if( !empty( $mwb_wocuf_parent_order ) )
					{
						$parent_order_billing = $mwb_wocuf_parent_order->get_address('billing');

						if( !empty( $parent_order_billing['email'] ) )
						{
							$mwb_wocuf_current_user_id = get_current_user_id();

							$mwb_wocuf_product_original_price = $product->get_price();

							$product = $this->mwb_wocuf_change_offered_product_price($product,$mwb_wocuf_offered_discount);

							$mwb_wocuf_new_upsell_order = wc_create_order( array(
								'customer_id' => $mwb_wocuf_current_user_id,
							));

							$mwb_wocuf_new_upsell_order->add_product( $product, 1 );

							$mwb_wocuf_new_upsell_order->set_address($mwb_wocuf_parent_order->get_address('billing'),'billing');

							$mwb_wocuf_new_upsell_order->set_address($mwb_wocuf_parent_order->get_address('shipping'), 'shipping' );

							$mwb_wocuf_new_upsell_order->set_payment_method($gateways[$pay_method]);

							$mwb_wocuf_new_upsell_order->calculate_totals();

							update_post_meta($mwb_wocuf_new_upsell_order->get_id(),'mwb_wocuf_upsell_parent_order',$mwb_wocuf_parent_order->get_id());

							$product->set_price($mwb_wocuf_product_original_price);

							$product = $mwb_wocuf_saved_product;
						
							if($pay_method =='cod')
							{
								$result = $gateways[$pay_method]->process_payment($mwb_wocuf_new_upsell_order->get_id());
							}
						}
					}
				}
			}
		}
		return $result;
	}

	/**
	 * displaying all purchased products including upsells on thankyou page
	 *
	 * @since    1.0.0
	 * @param    object   $parent_order     object of parent order
	 */

	public function mwb_wocuf_order_items_table($parent_order)
	{
	
		$output = "";

		if(!empty($parent_order))
		{
			$mwb_wocuf_order_id = $parent_order->get_id();

			$mwb_wocuf_order_purchase_note = $parent_order->has_status(apply_filters('woocommerce_purchase_note_order_statuses',array('completed','processing')));

			$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $mwb_wocuf_order_id,
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));

			if( !empty( $mwb_wocuf_order ) )
			{
				ob_start();

				foreach( $mwb_wocuf_order as $mwb_wocuf_single_order ):

					$mwb_wocuf_new_order = wc_get_order( $mwb_wocuf_single_order->ID );

					foreach( $mwb_wocuf_new_order->get_items() as $mwb_wocuf_item_id => $mwb_wocuf_item_name )
					{
						$mwb_wocuf_item_name->set_name( $mwb_wocuf_item_name->get_name());

						$mwb_wocuf_product = apply_filters( 'woocommerce_order_item_product', $mwb_wocuf_item_name->get_product(), $mwb_wocuf_item_name);

						wc_get_template( 'order/order-details-item.php', array(
							'order'			     => $mwb_wocuf_new_order,
							'item_id'		     => $mwb_wocuf_item_id,
							'item'			     => $mwb_wocuf_item_name,
							'show_purchase_note' => $mwb_wocuf_order_purchase_note,
							'purchase_note'	     => $mwb_wocuf_product ? $mwb_wocuf_product->get_purchase_note() : '',
							'product'	         => $mwb_wocuf_product,
						));
					}

				endforeach;

				$output = ob_get_clean();
			}
		}
		echo $output;
	}

	/**
	 * calculating new total for all purchased items
	 *
	 * @since    1.0.0
	 * @param    array    $total_rows    array of prices including tax,subtotal,total etc.
	 * @param    object   $parent_order  object of parent order
	 * @return   object   $total_rows    updated array of prices including tax,subtotal,total etc.
	 */

	public function mwb_wocuf_get_order_item_totals($total_rows, $parent_order, $tax_display)
	{

		if( !empty( $parent_order ) )
		{
			$mwb_wocuf_order_id = $parent_order->get_id();

			$tax_total_display = get_option( 'woocommerce_tax_total_display' );

			$woocommerce_prices_include_tax = get_option( 'woocommerce_prices_include_tax' );
			
			$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $mwb_wocuf_order_id,
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));

			if( !empty( $mwb_wocuf_order ) )
			{
				$mwb_wocuf_parent_order_items 		= array();
				$mwb_wocuf_new_order_total 			= 0;
				$mwb_wocuf_new_order_subtotal 		= 0;
				$mwb_wocuf_new_order_shipping 		= 0;
				$mwb_wocuf_new_order_tax 			= 0;
				$mwb_wocuf_new_order_discount 		= 0;

				$mwb_wocuf_parent_order_items = $parent_order->get_items();

				foreach( $mwb_wocuf_parent_order_items as $mwb_wocuf_single_item )
				{
					$subtotal = $parent_order->get_line_subtotal( $mwb_wocuf_single_item, TRUE);

					if( $tax_display === 'excl' )
					{
						$subtotal = $parent_order->get_line_subtotal( $mwb_wocuf_single_item, TRUE) - $mwb_wocuf_single_item ->get_subtotal_tax();
					}

					if( $tax_display === 'incl' )
					{
						$subtotal = $subtotal;
					}

					$mwb_wocuf_new_order_subtotal += $subtotal;

				}

				$mwb_wocuf_new_order_total = $parent_order->get_total();

                $mwb_wocuf_new_order_shipping += $parent_order->get_total_shipping();

				$mwb_wocuf_new_order_tax += $parent_order->get_total_tax();

				$mwb_wocuf_new_order_discount += $parent_order->get_total_discount();

				$mwb_wocuf_order_factory = new WC_Order_Factory();

				foreach( $mwb_wocuf_order as $mwb_wocuf_single_order ):

					$mwb_wocuf_upsell_order = $mwb_wocuf_order_factory->get_order($mwb_wocuf_single_order->ID);

					$mwb_wocuf_upsell_order_items = $mwb_wocuf_upsell_order->get_items();

					if( !empty( $mwb_wocuf_upsell_order_items ) )
					{
						foreach( $mwb_wocuf_upsell_order_items as $mwb_wocuf_single_upsell_order_item )
						{
			                $subtotal = $mwb_wocuf_upsell_order->get_line_subtotal( $mwb_wocuf_single_upsell_order_item, TRUE);

			                if( $tax_display === 'excl' )
							{
								$subtotal = $mwb_wocuf_upsell_order->get_line_subtotal( $mwb_wocuf_single_upsell_order_item, TRUE) - $mwb_wocuf_single_upsell_order_item->get_subtotal_tax();
							}

							if( $tax_display === 'incl' )
							{
								$subtotal = $subtotal;
							}

							$mwb_wocuf_new_order_subtotal += $subtotal;
						}

						$mwb_wocuf_new_order_total += $mwb_wocuf_upsell_order->get_total();

						$mwb_wocuf_new_order_shipping += $mwb_wocuf_upsell_order->get_total_shipping();

						$mwb_wocuf_new_order_tax += $mwb_wocuf_upsell_order->get_total_tax();

						$mwb_wocuf_new_order_discount += $mwb_wocuf_upsell_order->get_total_discount();

					}

				endforeach;
				
				if( !empty( $mwb_wocuf_new_order_subtotal ) )
				{
					$total_rows['cart_subtotal']['value'] = wc_price( $mwb_wocuf_new_order_subtotal );
				}

				if( !empty( $mwb_wocuf_new_order_discount ) )
				{
					$total_rows['discount']['value'] = wc_price( $mwb_wocuf_new_order_discount );
				}

				if( !empty( $mwb_wocuf_new_order_shipping ) )
				{
					$total_rows['shipping']['value'] = wc_price( $mwb_wocuf_new_order_shipping ) . '&nbsp;<small class="shipped_via">' . sprintf( __( 'via %s', 'woocommerce_one_click_upsell_funnel' ), $parent_order->get_shipping_method() ) . '</small>';
				}

				if( !empty( $mwb_wocuf_new_order_total ) )
				{
					$total_rows['order_total']['value'] = wc_price( $mwb_wocuf_new_order_total );
				}

				if( !empty( $mwb_wocuf_new_order_tax ) )
				{
					if ( 'excl' === $tax_display ) {
						if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
							foreach ( $parent_order->get_tax_totals() as $code => $tax ) {
								$total_rows[ sanitize_title( $code ) ] = array(
									'label' => $tax->label . ':',
									'value' => $mwb_wocuf_new_order_tax,
								);
							}
						} else {
							$total_rows['tax'] = array(
								'label' => WC()->countries->tax_or_vat() . ':',
								'value' => wc_price( $mwb_wocuf_new_order_tax, array( 'currency' => $parent_order->get_currency() ) ),
							);
						}
					}
				}
			}
		}

		return $total_rows;		
	}

	/**
	 * updating total after upsell purchases
	 *
	 * @since    1.0.0
	 * @param    object   $parent_order     object of parent order
	 * @param    int      $total            total price value of order
	 * @return   int      $total            new tiatl price including upsell purchases
	 */
	
	public function mwb_wocuf_get_new_total( $total, $parent_order, $tax_display, $display_refunded ) 
	{
		if( is_admin() )
		{
			return $total;
		}

		$total = $parent_order->get_total();

		$mwb_wocuf_new_total = 0;

		if( !empty( $parent_order ) )
		{
			$mwb_wocuf_order_id = $parent_order->get_id();

			$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $mwb_wocuf_order_id,
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));
		}

		if( !empty( $parent_order ) )
		{
			if( !empty( $mwb_wocuf_order ) )
			{
				$mwb_wocuf_order_factory = new WC_Order_Factory();

				foreach( $mwb_wocuf_order as $mwb_wocuf_single_order ):

					$mwb_wocuf_upsell_order = $mwb_wocuf_order_factory->get_order($mwb_wocuf_single_order->ID);

					$mwb_wocuf_new_total += $mwb_wocuf_upsell_order->get_total();

				endforeach;

			}
		}

		$total = $total + $mwb_wocuf_new_total;

		$total = wc_price( $total , array( 'currency' => $parent_order->get_currency() ) );

		return $total;
	}
	/**
	 * pushing values in associative array
	 *
	 * @since    1.0.0
	 * @param    array   		$array     original array
	 * @param    int/string     $key       index of array at which to save value
	 * @return   int/string     $value     value to save
	 */

	public function mwb_wocuf_array_push_assoc($array, $key, $value)
	{
		$array[$key] = $value;
		
		return $array;
	}

	/**
	 * modifying list of orders to show on front end
	 *
	 * @since    1.0.0
	 * @param    $orders     query of orders on front end
	 * @return   $orders     modified query of orders
	 */

	public function mwb_wocuf_my_account_my_orders_query($orders)
	{
		$orders['meta_key'] = "mwb_wocuf_upsell_parent_order";
		$orders['meta_compare'] = 'NOT EXISTS';
		return $orders;
	}


	/**
	 * modifying items count to show on front end
	 *
	 * @since    1.0.0
	 * @param    $count      		count of items 
	 * @param    $item_type     	type of item purchased 
	 * @return   $parent_order      object of parent order
	 */

	public function mwb_wocuf_get_item_count($count, $item_type, $parent_order)
	{
		if(!empty($parent_order))
		{
			$mwb_wocuf_order_id = $parent_order->get_id();

			$mwb_wocuf_order = get_posts(array(
				'posts_per_page' =>  -1,
				'post_type'      =>  'shop_order',
				'post_status'    =>  'any',
				'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
				'meta_value'     =>   $mwb_wocuf_order_id,
				'orderby'        =>  'ID',
				'order'          =>  'ASC'
			));

			if(!empty($mwb_wocuf_order))
			{
				$count += count($mwb_wocuf_order);
				return $count;
			}
		}

		return $count;
	}


	/*
		adding offer products which are downloadable
	*/

	public function mwb_wocuf_order_downloads( $downloads, $order )
	{
		$parent_order_id = $order->get_id();
		
		$mwb_wocuf_order = get_posts(array(
			'posts_per_page' =>  -1,
			'post_type'      =>  'shop_order',
			'post_status'    =>  'any',
			'meta_key'       =>  'mwb_wocuf_upsell_parent_order',
			'meta_value'     =>   $parent_order_id,
			'orderby'        =>  'ID',
			'order'          =>  'ASC'
		));
		
		if( !empty( $mwb_wocuf_order ) )
		{
			foreach( $mwb_wocuf_order as $mwb_wocuf_single_order ):

				$mwb_wocuf_new_order = wc_get_order( $mwb_wocuf_single_order->ID );

				foreach( $mwb_wocuf_new_order->get_items() as $mwb_wocuf_item_name )
				{
					$mwb_wocuf_product_id = $mwb_wocuf_item_name->get_product_id();
					$product = wc_get_product( $mwb_wocuf_product_id );

					if( $product->is_downloadable() )
					{	
						$item_downloads = $mwb_wocuf_item_name->get_item_downloads();
						if( $item_downloads )
						{
							foreach ( $item_downloads as $file ) {
								$downloads[] = array(
									'download_url'        => $file['download_url'],
									'download_id'         => $file['id'],
									'product_id'          => $product->get_id(),
									'product_name'        => $product->get_name(),
									'product_url'         => $product->is_visible() ? $product->get_permalink() : '', // Since 3.3.0.
									'download_name'       => $file['name'],
									'order_id'            => $mwb_wocuf_single_order->ID,
									'order_key'           => $mwb_wocuf_new_order->get_order_key(),
									'downloads_remaining' => $file['downloads_remaining'],
									'access_expires'      => $file['access_expires'],
								);
							}
						}
					}
				}

			endforeach;
		}

		return $downloads;
	}
	//end of class
}