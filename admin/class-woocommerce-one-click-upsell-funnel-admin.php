<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/admin
 * @author     wpswings <webmaster@wpswings.com>
 */
class Woocommerce_One_Click_Upsell_Funnel_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_one_click_upsell_funnel_pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_one_click_upsell_funnel_pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if ( isset( $screen->id ) ) {
			$pagescreen = $screen->id;

			if ( 'toplevel_page_wps-wocuf-setting' === $pagescreen || '1-click-upsell_page_wps-wocuf-setting-tracking' === $pagescreen ) {

				wp_register_style( 'wps_wocuf_pro_admin_style', plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel_pro-admin.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'wps_wocuf_pro_admin_style' );

				wp_enqueue_script( 'wps-upsell-sweet-alert-2-js', plugin_dir_url( __FILE__ ) . 'js/sweet-alert.js', array(), '2.1.2', false );

				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

				wp_register_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), WC_VERSION );

				wp_enqueue_style( 'woocommerce_admin_menu_styles' );

				wp_enqueue_style( 'woocommerce_admin_styles' );
			}
			if ( 'woocommerce_page_wc-settings' === $pagescreen ) {
				wp_register_style( 'wps_wocuf_pro_banner_admin_style', plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel_pro_banner_payment.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'wps_wocuf_pro_banner_admin_style' );
			}

			if ( isset( $screen->id ) && 'product' == $screen->id ) {

				wp_register_style( 'woocommerce_one_click_upsell_funnel_product_shipping', plugin_dir_url( __FILE__ ) . 'css/woocommerce_one_click_upsell_funnel_product_shipping.css', array(), $this->version, 'all' );

				wp_enqueue_style( 'woocommerce_one_click_upsell_funnel_product_shipping' );

			}
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in woocommerce_one_click_upsell_funnel_pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The woocommerce_one_click_upsell_funnel_pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$screen = get_current_screen();

		if ( isset( $screen->id ) ) {
			$pagescreen = $screen->id;

			if ( 'woocommerce_page_wc-settings' === $pagescreen ) {
				wp_enqueue_script( 'wps_wocuf_pro_banner_admin_script', plugin_dir_url( __FILE__ ) . 'js/woocommerce_one_click_upsell_funnel_pro-banner-admin.js', array( 'jquery' ), $this->version, false );

			}

			if ( 'toplevel_page_wps-wocuf-setting' === $pagescreen || '1-click-upsell_page_wps-wocuf-setting-tracking' === $pagescreen ) {

				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );

				wp_enqueue_media();

				wp_enqueue_script( 'wps_wocuf_pro_admin_script', plugin_dir_url( __FILE__ ) . 'js/woocommerce_one_click_upsell_funnel_pro-admin.js', array( 'jquery' ), $this->version, false );

				wp_register_script( 'woocommerce_admin', WC()->plugin_url() . '/assets/js/admin/woocommerce_admin.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip', 'wc-enhanced-select' ), WC_VERSION, false );

				wp_register_script( 'jquery-tiptip', WC()->plugin_url() . '/assets/js/jquery-tiptip/jquery.tipTip.js', array( 'jquery' ), WC_VERSION, true );
				$locale  = localeconv();
				$decimal = isset( $locale['decimal_point'] ) ? $locale['decimal_point'] : '.';
				$params  = array(
					/* translators: %s: decimal */
					'i18n_decimal_error'               => sprintf( esc_html__( 'Please enter in decimal (%s) format without thousand separators.', 'woo-one-click-upsell-funnel' ), $decimal ),
					/* translators: %s: price decimal separator */
					'i18n_mon_decimal_error'           => sprintf( esc_html__( 'Please enter in monetary decimal (%s) format without thousand separators and currency symbols.', 'woo-one-click-upsell-funnel' ), wc_get_price_decimal_separator() ),
					'i18n_country_iso_error'           => esc_html__( 'Please enter in country code with two capital letters.', 'woo-one-click-upsell-funnel' ),
					'i18_sale_less_than_regular_error' => esc_html__( 'Please enter in a value less than the regular price.', 'woo-one-click-upsell-funnel' ),
					'decimal_point'                    => $decimal,
					'mon_decimal_point'                => wc_get_price_decimal_separator(),
					'strings'                          => array(
						'import_products' => esc_html__( 'Import', 'woo-one-click-upsell-funnel' ),
						'export_products' => esc_html__( 'Export', 'woo-one-click-upsell-funnel' ),
					),
					'urls'                             => array(
						'import_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_importer' ) ),
						'export_products' => esc_url_raw( admin_url( 'edit.php?post_type=product&page=product_exporter' ) ),
					),
				);

				wp_localize_script(
					'wps_wocuf_pro_admin_script',
					'wps_wocuf_pro_obj',
					array(
						'ajaxUrl'               => admin_url( 'admin-ajax.php' ),
						'alert_preview_title'   => esc_html__( 'Attention Required', 'woo-one-click-upsell-funnel' ),
						'alert_preview_content' => esc_html__( 'We are preparing your migration to WP Swings. Please give a few time and get the plugin started.', 'woo-one-click-upsell-funnel' ),
					)
				);

				wp_enqueue_script( 'wps_wocuf_pro_admin_script' );

				wp_localize_script( 'woocommerce_admin', 'woocommerce_admin', $params );

				wp_enqueue_script( 'woocommerce_admin' );

				$wocuf_js_data = array(
					'ajaxurl'         => admin_url( 'admin-ajax.php' ),
					'auth_nonce'      => wp_create_nonce( 'wps_wocuf_nonce' ),
					'current_version' => WPS_WOCUF_VERSION,
				);

				wp_enqueue_script( 'wps-wocuf-pro-add_new-offer-script', plugin_dir_url( __FILE__ ) . 'js/wps_wocuf_pro_add_new_offer_script.js', array( 'woocommerce_admin', 'wc-enhanced-select' ), $this->version, false );

				wp_localize_script( 'wps-wocuf-pro-add_new-offer-script', 'wps_upsell_lite_js_obj', $wocuf_js_data );

				$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
				$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

				if ( ! $id_nonce_verified ) {
					wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
				}

				if ( ! empty( $_GET['wps-upsell-offer-section'] ) ) {

					$upsell_offer_section['value'] = isset( $_GET['wps-upsell-offer-section'] ) ? sanitize_text_field( wp_unslash( $_GET['wps-upsell-offer-section'] ) ) : '';

					wp_localize_script( 'wps-wocuf-pro-add_new-offer-script', 'offer_section_obj', $upsell_offer_section );
				}

				wp_enqueue_style( 'wp-color-picker' );

				wp_enqueue_script( 'wps-wocuf-pro-color-picker-handle', plugin_dir_url( __FILE__ ) . 'js/wps_wocuf_pro_color_picker_handle.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
			}
		}
	}

	/**
	 * Include Upsell screen for Onboarding pop-up.
	 *
	 * @param mixed $valid_screens valid screens.
	 * @since    3.0.0
	 */
	public function add_wps_frontend_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'toplevel_page_wps-wocuf-setting' );
		}

		return $valid_screens;
	}

	/**
	 * Include Upsell plugin for Deactivation pop-up.
	 *
	 * @param mixed $valid_screens valid screens.
	 * @since    3.0.0
	 */
	public function add_wps_deactivation_screens( $valid_screens = array() ) {

		if ( is_array( $valid_screens ) ) {

			// Push your screen here.
			array_push( $valid_screens, 'woo-one-click-upsell-funnel' );
		}

		return $valid_screens;
	}

	/**
	 * Adding upsell menu page.
	 *
	 * @since    1.0.0
	 */
	public function wps_wocuf_pro_admin_menu() {

		/**
		 * Add main menu.
		 */
		add_menu_page(
			'1 Click Upsell',
			'1 Click Upsell',
			'manage_woocommerce',
			'wps-wocuf-setting',
			array( $this, 'upsell_menu_html' ),
			'dashicons-chart-area',
			57
		);

		/**
		 * Add sub-menu for funnel settings.
		 */
		add_submenu_page( 'wps-wocuf-setting', 'Funnels & Settings', 'Funnels & Settings', 'manage_options', 'wps-wocuf-setting' );

		/**
		 * Add sub-menu for reportings settings.
		 */
		add_submenu_page( 'wps-wocuf-setting', 'Reports, Analytics & Tracking', 'Reports, Analytics & Tracking', 'manage_options', 'wps-wocuf-setting-tracking', array( $this, 'add_submenu_page_reporting_callback' ) );
	}

	/**
	 * Callable function for upsell menu page.
	 *
	 * @since    1.0.0
	 */
	public function upsell_menu_html() {

		if ( ! empty( $_GET['reset_migration'] ) && true == $_GET['reset_migration'] ) {  //phpcs:ignore
			$nonce = ! empty( $_GET['wocuf_nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['wocuf_nonce'] ) ) : '';
			if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'wocuf_lite_migration' ) ) {
				die( 'Nonce not verified' );
			}
			delete_option( 'wocuf_lite_migration_status' );
			wp_safe_redirect( admin_url() . '?page=wps-wocuf-setting&tab=funnels-list' );
		}

		require_once plugin_dir_path( __FILE__ ) . '/partials/woocommerce-one-click-upsell-funnel-pro-admin-display.php';
	}

	/**
	 * Offer Html for appending in funnel when add new offer is clicked - ajax handle function.
	 * Also Dynamic page post is created while adding new offer.
	 *
	 * @since    1.0.0
	 */
	public function return_funnel_offer_section_content() {

		check_ajax_referer( 'wps_wocuf_nonce', 'nonce' );

		if ( isset( $_POST['wps_wocuf_pro_flag'] ) && isset( $_POST['wps_wocuf_pro_funnel'] ) ) {

			// New Offer id.
			$offer_index = sanitize_text_field( wp_unslash( $_POST['wps_wocuf_pro_flag'] ) );
			// Funnel id.
			$funnel_id = sanitize_text_field( wp_unslash( $_POST['wps_wocuf_pro_funnel'] ) );

			unset( $_POST['wps_wocuf_pro_flag'] );
			unset( $_POST['wps_wocuf_pro_funnel'] );

			$funnel_offer_post_html = '<input type="hidden" name="wps_upsell_post_id_assigned[' . $offer_index . ']" value="">';

			$funnel_offer_template_section_html = '';
			$funnel_offer_post_id               = '';

			if ( wps_upsell_lite_elementor_plugin_active() ) {

				// Create post for corresponding funnel and offer id.
				$funnel_offer_post_id = wp_insert_post(
					array(
						'comment_status' => 'closed',
						'ping_status'    => 'closed',
						'post_content'   => '',
						'post_name'      => uniqid( 'special-offer-' ), // post slug.
						'post_title'     => 'Special Offer',
						'post_status'    => 'publish',
						'post_type'      => 'page',
						'page_template'  => 'elementor_canvas',
					)
				);

				if ( $funnel_offer_post_id ) {

					$elementor_data = wps_upsell_lite_elementor_offer_template_1();
					update_post_meta( $funnel_offer_post_id, '_elementor_data', $elementor_data );
					update_post_meta( $funnel_offer_post_id, '_elementor_edit_mode', 'builder' );

					$wps_upsell_funnel_data = array(
						'funnel_id' => $funnel_id,
						'offer_id'  => $offer_index,
					);

					update_post_meta( $funnel_offer_post_id, 'wps_upsell_funnel_data', $wps_upsell_funnel_data );

					$funnel_offer_post_html = '<input type="hidden" name="wps_upsell_post_id_assigned[' . $offer_index . ']" value="' . $funnel_offer_post_id . '">';

					$funnel_offer_template_section_html = $this->get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id );

					// Save an array of all created upsell offer-page post ids.
					$upsell_offer_post_ids = get_option( 'wps_upsell_lite_offer_post_ids', array() );

					$upsell_offer_post_ids[] = $funnel_offer_post_id;

					update_option( 'wps_upsell_lite_offer_post_ids', $upsell_offer_post_ids );

				}
			} else { // When Elementor is not active.

				// Will return 'Feature not supported' part as $funnel_offer_post_id is empty.
				$funnel_offer_template_section_html = $this->get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id );
			}

			// Get all funnels.
			$wps_wocuf_pro_funnel = get_option( 'wps_wocuf_funnels_list' );

			// Funnel offers array.
			$wps_wocuf_pro_offers_to_add = isset( $wps_wocuf_pro_funnel[ $funnel_id ]['wps_wocuf_applied_offer_number'] ) ? $wps_wocuf_pro_funnel[ $funnel_id ]['wps_wocuf_applied_offer_number'] : array();

			// Buy now action select html.
			$buy_now_action_select_html = '<select name="wps_wocuf_attached_offers_on_buy[' . $offer_index . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

			// No thanks action select html.
			$no_thanks_action_select_html = '<select name="wps_wocuf_attached_offers_on_no[' . $offer_index . ']"><option value="thanks">' . esc_html__( 'Order ThankYou Page', 'woo-one-click-upsell-funnel' ) . '</option>';

			// If there are other offers then add them to select html.
			if ( ! empty( $wps_wocuf_pro_offers_to_add ) ) {

				foreach ( $wps_wocuf_pro_offers_to_add as $offer_id ) {

					$buy_now_action_select_html .= '<option value=' . $offer_id . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $offer_id . '</option>';

					$no_thanks_action_select_html .= '<option value=' . $offer_id . '>' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $offer_id . '</option>';
				}
			}

			$buy_now_action_select_html   .= '</select>';
			$no_thanks_action_select_html .= '</select>';

			$offer_scroll_id_val = "#offer-section-$offer_index";

			$allowed_html = wps_upsell_lite_allowed_html();

			$data = '<div style="display:none;" data-id="' . $offer_index . '" data-scroll-id="' . $offer_scroll_id_val . '" class="new_created_offers wps_upsell_single_offer">
			<h2 class="wps_upsell_offer_title">' . esc_html__( 'Offer #', 'woo-one-click-upsell-funnel' ) . $offer_index . '</h2>
			<table>
			<tr>
			<th><label><h4>' . esc_html__( 'Offer Product', 'woo-one-click-upsell-funnel' ) . '</h4></label></th>
			<td><select class="wc-offer-product-search wps_upsell_offer_product" name="wps_wocuf_products_in_offer[' . $offer_index . ']" data-placeholder="' . esc_html__( 'Search for a product&hellip;', 'woo-one-click-upsell-funnel' ) . '"></select></td>
			</tr>
			<tr>
			<th><label><h4>' . esc_html__( 'Offer Price / Discount', 'woo-one-click-upsell-funnel' ) . '</h4></label></th>
			<td>
			<input type="text" class="wps_upsell_offer_price" name="wps_wocuf_offer_discount_price[' . $offer_index . ']" value="50%" >
			<span class="wps_upsell_offer_description" >' . esc_html__( 'Specify new offer price or discount %', 'woo-one-click-upsell-funnel' ) . '</span>
			</td>
			<tr>
				<th><label><h4>' . esc_html__( 'Offer Image', 'woo-one-click-upsell-funnel' ) . '</h4></label>
				</th>
				<td>' . $this->wps_wocuf_pro_image_uploader_field( $offer_index ) . '</td>
			</tr>
			</tr>
			<tr>
			<th><label><h4>' . esc_html__( 'After \'Buy Now\' go to', 'woo-one-click-upsell-funnel' ) . '</h4></label></th>
			<td>' . $buy_now_action_select_html . '<span class="wps_upsell_offer_description">' . esc_html__( 'Select where the customer will be redirected after accepting this offer', 'woo-one-click-upsell-funnel' ) . '</span></td>
			</tr>
			<tr>
			<th><label><h4>' . esc_html__( 'After \'No thanks\' go to', 'woo-one-click-upsell-funnel' ) . '</h4></label></th>
			<td>' . $no_thanks_action_select_html . '<span class="wps_upsell_offer_description">' . esc_html__( 'Select where the customer will be redirected after rejecting this offer', 'woo-one-click-upsell-funnel' ) . '</td>
			</tr>' . $funnel_offer_template_section_html . '
			<tr>
			<th><label><h4>' . esc_html__( 'Offer Custom Page Link', 'woo-one-click-upsell-funnel' ) . '</h4></label></th>
			<td>
			<input type="text" class="wps_upsell_custom_offer_page_url" name="wps_wocuf_offer_custom_page_url[' . $offer_index . ']" >
			</td>
			</tr>
			<tr>
			<td colspan="2">
			<button class="button wps_wocuf_pro_delete_new_created_offers" data-id="' . $offer_index . '">' . esc_html__( 'Remove', 'woo-one-click-upsell-funnel' ) . '</button>
			</td>
			</tr>
			</table>
			<input type="hidden" name="wps_wocuf_applied_offer_number[' . $offer_index . ']" value="' . $offer_index . '">
			' . $funnel_offer_post_html . '</div>';

			$new_data = apply_filters( 'wps_wocuf_pro_add_more_to_offers', $data );

			echo wp_kses( $new_data, $allowed_html );
			// It just displayes the html itself. Content in it is already escaped if required.
		}

		wp_die();
	}

	/**
	 * Add attribute to styles allowed properties in wp_kses.
	 *
	 * @param array $styles Allowed properties.
	 * @return array
	 *
	 * @since    3.6.7
	 */
	public function wocuf_lite_add_style_attribute( $styles ) {

		$styles[] = 'display';
		return $styles;
	}

	/**
	 * Returns Funnel Offer Template section html.
	 *
	 * @param mixed $funnel_offer_post_id funnel offer post id.
	 * @param mixed $offer_index offer index.
	 * @param mixed $funnel_id funnel id.
	 * @since    2.0.0
	 */
	public function get_funnel_offer_template_section_html( $funnel_offer_post_id, $offer_index, $funnel_id ) {

		ob_start();

		?>

		<!-- Section : Offer template start -->
		<tr>
			<th><label><h4><?php esc_html_e( 'Offer Template', 'woo-one-click-upsell-funnel' ); ?></h4></label>
			</th>
			<?php
			$assigned_post_id        = ! empty( $funnel_offer_post_id ) ? $funnel_offer_post_id : '';
			$current_offer_id        = $offer_index;
			$wps_wocuf_pro_funnel_id = $funnel_id;
			?>
			<td>

				<?php if ( ! empty( $assigned_post_id ) ) : ?>

					<?php

					// As default is "one".
					$offer_template_active = 'one';

					$offer_templates_array = array(
						'one'   => esc_html__( 'STANDARD TEMPLATE', 'woo-one-click-upsell-funnel' ),
						'two'   => esc_html__( 'CREATIVE TEMPLATE', 'woo-one-click-upsell-funnel' ),
						'three' => esc_html__( 'VIDEO TEMPLATE', 'woo-one-click-upsell-funnel' ),
					//	'four' => esc_html__( 'Fitness TEMPLATE', 'woo-one-click-upsell-funnel' ),
					);

					?>

					<!-- Offer templates parent div start -->
					<div class="wps_upsell_offer_templates_parent">

						<input class="wps_wocuf_pro_offer_template_input" type="hidden" name="wps_wocuf_pro_offer_template[<?php echo esc_html( $current_offer_id ); ?>]" value="<?php echo esc_html( $offer_template_active ); ?>">

						<?php

						foreach ( $offer_templates_array as $template_key => $template_name ) :
							?>
							<!-- Offer templates foreach start-->

							<div class="wps_upsell_offer_template 
							<?php
							echo $template_key === $offer_template_active ? 'active' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							// It just displayes the html itself. Content in it is already escaped if required.
							?>
							">
								<div class="wps_upsell_offer_template_sub_div"> 

									<h5><?php echo esc_html( $template_name ); ?></h5>

									<div class="wps_upsell_offer_preview">

										<a href="javascript:void(0)" class="wps_upsell_view_offer_template" data-template-id="<?php echo esc_html( $template_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" ><img src="<?php echo esc_url( WPS_WOCUF_URL . "admin/resources/offer-thumbnails/offer-template-$template_key.jpg" ); ?>"></a>
									</div>

									<div class="wps_upsell_offer_action">

										<?php if ( $template_key !== $offer_template_active ) : ?>

										
										<?php else : ?>

											<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

											<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

										<?php endif; ?>
									</div>
								</div>	
							</div>
							<!-- Offer templates foreach end-->
						<?php endforeach; ?>
						
						<!-- Offer templates 4 foreach start-->
						
						<div class="wps_upsell_offer_template ">
								<div class="wps_upsell_offer_template_sub_div"> 

									<h5> <?php esc_html_e( 'FITNESS TEMPLATE', 'woo-one-click-upsell-funnel' ); ?></h5>

									<div class="wps_upsell_offer_preview">

										<a href="javascript:void(0)" class="wps_upsell_view_offer_template" data-template-id="four" ><img src="<?php echo esc_url( WPS_WOCUF_URL . "admin/resources/offer-thumbnails/offer-template-four.jpg" ); ?>"></a>
									</div>

									<div class="wps_upsell_offer_action">

										<?php if ( $template_key !== $offer_template_active ) : ?>

										<button class="button-primary wps_upsell_activate_offer_template" data-template-id="four" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $wps_wocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Insert and Activate', 'woo-one-click-upsell-funnel' ); ?></button>

										<?php else : ?>

											<a class="button" href="<?php echo esc_url( get_permalink( $assigned_post_id ) ); ?>" target="_blank"><?php esc_html_e( 'View &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

											<a class="button" href="<?php echo esc_url( admin_url( "post.php?post=$assigned_post_id&action=elementor" ) ); ?>" target="_blank"><?php esc_html_e( 'Customize &rarr;', 'woo-one-click-upsell-funnel' ); ?></a>

										<?php endif; ?>
									</div>
								</div>	
										</div>

						<!-- Offer templates 4 foreach start-->
						
						<!-- Offer link to custom page start-->
						<div class="wps_upsell_offer_template wps_upsell_custom_page_link_div <?php echo esc_html( 'custom' === $offer_template_active ? 'active' : '' ); ?>">

							<h5><?php esc_html_e( 'LINK TO CUSTOM PAGE', 'woo-one-click-upsell-funnel' ); ?></h5>

							<?php if ( 'custom' !== $offer_template_active ) : ?>

								<button class="button-primary wps_upsell_activate_offer_template" data-template-id="custom" data-offer-id="<?php echo esc_html( $current_offer_id ); ?>" data-funnel-id="<?php echo esc_html( $wps_wocuf_pro_funnel_id ); ?>" data-offer-post-id="<?php echo esc_html( $assigned_post_id ); ?>" ><?php esc_html_e( 'Activate', 'woo-one-click-upsell-funnel' ); ?></button>

							<?php else : ?>

								<h5><?php esc_html_e( 'Activated', 'woo-one-click-upsell-funnel' ); ?></h5>
								<p><?php esc_html_e( 'Please enter and save your custom page link below.', 'woo-one-click-upsell-funnel' ); ?></p>

							<?php endif; ?>
						</div>
						<!-- Offer link to custom page end-->
					</div>
					<!-- Offer templates parent div end -->

				<?php else : ?>

					<div class="wps_upsell_offer_template_unsupported">	
					<h4><?php esc_html_e( 'Please activate Elementor if you want to use our Pre-defined Templates, else make a custom page yourself and add link below.', 'woo-one-click-upsell-funnel' ); ?></h4>
					</div>

				<?php endif; ?>
			</td>
		</tr>
		<!-- Section : Offer template end -->

		<?php

		return ob_get_clean();
	}

	/**
	 * Insert and Activate respective template ajax handle function.
	 *
	 * @since    2.0.0
	 */
	public function activate_respective_offer_template() {

		check_ajax_referer( 'wps_wocuf_nonce', 'nonce' );

		$funnel_id     = isset( $_POST['funnel_id'] ) ? sanitize_text_field( wp_unslash( $_POST['funnel_id'] ) ) : '';
		$offer_id      = isset( $_POST['offer_id'] ) ? sanitize_text_field( wp_unslash( $_POST['offer_id'] ) ) : '';
		$template_id   = isset( $_POST['template_id'] ) ? sanitize_text_field( wp_unslash( $_POST['template_id'] ) ) : '';
		$offer_post_id = isset( $_POST['offer_post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['offer_post_id'] ) ) : '';

		// IF custom then don't update and just return.
		if ( 'custom' === $template_id ) {

			echo wp_json_encode( array( 'status' => true ) );
			wp_die();
		}

		$offer_templates_array = array(
			'one'   => 'wps_upsell_lite_elementor_offer_template_1',
			'two'   => 'wps_upsell_lite_elementor_offer_template_2',
			'three' => 'wps_upsell_lite_elementor_offer_template_3',
		);

		foreach ( $offer_templates_array as $template_key => $callback_function ) {

			if ( $template_id === $template_key ) {

				// Delete previous elementor css.
				delete_post_meta( $offer_post_id, '_elementor_css' );

				$elementor_data = $callback_function();
				update_post_meta( $offer_post_id, '_elementor_data', $elementor_data );

				break;
			}
		}

		echo wp_json_encode( array( 'status' => true ) );

		wp_die();
	}

	/**
	 * Select2 search for adding funnel target products
	 *
	 * @since    1.0.0
	 */
	public function seach_products_for_funnel() {

		check_ajax_referer( 'wps_wocuf_nonce', 'nonce' );
		$return = array();

		$search_results = new WP_Query(
			array(
				's'                   => ! empty( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '',
				'post_type'           => array( 'product' ),
				'post_status'         => array( 'publish' ),
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => -1,
			)
		);

		if ( $search_results->have_posts() ) :

			while ( $search_results->have_posts() ) :

				$search_results->the_post();

				$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;

				/**
				 * Check for post type as query sometimes returns posts even after mentioning post_type.
				 * As some plugins alter query which causes issues.
				 */
				$post_type = get_post_type( $search_results->post->ID );

				if ( 'product' !== $post_type ) {
					continue;
				}

				$product      = wc_get_product( $search_results->post->ID );
				$downloadable = $product->is_downloadable();
				$stock        = $product->get_stock_status();

				if ( $product->is_type( 'variable' ) || $product->is_type( 'subscription' ) || $product->is_type( 'grouped' ) || $product->is_type( 'external' ) || 'outofstock' === $stock ) {
					continue;
				}

				$return[] = array( $search_results->post->ID, $title );

			endwhile;

		endif;

		echo wp_json_encode( $return );

		wp_die();
	}

	/**
	 * Select2 search for adding offer products.
	 *
	 * @since    1.0.0
	 */
	public function seach_products_for_offers() {

		check_ajax_referer( 'wps_wocuf_nonce', 'nonce' );
		$return = array();

		$search_results = new WP_Query(
			array(
				's'                   => ! empty( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '',
				'post_type'           => array( 'product' ),
				'post_status'         => array( 'publish' ),
				'ignore_sticky_posts' => 1,
				'posts_per_page'      => -1,
			)
		);

		if ( $search_results->have_posts() ) :

			while ( $search_results->have_posts() ) :

				$search_results->the_post();

				$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;

				/**
				 * Check for post type as query sometimes returns posts even after mentioning post_type.
				 * As some plugins alter query which causes issues.
				 */
				$post_type = get_post_type( $search_results->post->ID );

				if ( 'product' !== $post_type ) {

					continue;
				}

				$product      = wc_get_product( $search_results->post->ID );
				$downloadable = $product->is_downloadable();
				$stock        = $product->get_stock_status();

				if ( $product->is_type( 'variable' ) || $product->is_type( 'subscription' ) || $product->is_type( 'grouped' ) || $product->is_type( 'external' ) || 'outofstock' === $stock ) {
					continue;
				}

				$return[] = array( $search_results->post->ID, $title );

			endwhile;

		endif;

		echo wp_json_encode( $return );

		wp_die();
	}

	/**
	 * Adding custom column in orders table at backend
	 *
	 * @since    1.0.0
	 * @param    array $columns    array of columns on orders table.
	 * @return   array    $columns    array of columns on orders table alongwith upsell column
	 */
	public function wps_wocuf_pro_add_columns_to_admin_orders( $columns ) {

		$columns['wps-upsell-orders'] = esc_html__( 'Upsell Orders', 'woo-one-click-upsell-funnel' );

		return $columns;
	}

	/**
	 * Populating Upsell Orders column with Single Order or Upsell order.
	 *
	 * @since    1.0.0
	 * @param    array $column    Array of available columns.
	 * @param    int   $post_id   Current Order post id.
	 */
	public function wps_wocuf_pro_populate_upsell_order_column( $column, $post_id ) {

		$upsell_order = get_post_meta( $post_id, 'wps_wocuf_upsell_order', true );

		switch ( $column ) {

			case 'wps-upsell-orders':
				if ( 'true' === $upsell_order ) :
					?>
					<a href="<?php echo esc_url( get_edit_post_link( $post_id ) ); ?>" ><?php esc_html_e( 'Upsell Order', 'woo-one-click-upsell-funnel' ); ?></a>
				<?php else : ?>
					<?php esc_html_e( 'Single Order', 'woo-one-click-upsell-funnel' ); ?>
					<?php
				endif;
				break;
		}
	}

	/**
	 * Add Upsell Filtering dropdown for All Orders, No Upsell Orders, Only Upsell Orders.
	 *
	 * @since    1.0.0
	 */
	public function wps_wocuf_pro_restrict_manage_posts() {

		$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
		$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

		if ( ! $id_nonce_verified ) {
			wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
		}

		if ( isset( $_GET['post_type'] ) && 'shop_order' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) ) {

			if ( isset( $_GET['wps_wocuf_pro_upsell_filter'] ) ) :

				?>
				<select name="wps_wocuf_pro_upsell_filter">
					<option value="all" <?php echo 'all' === sanitize_key( wp_unslash( $_GET['wps_wocuf_pro_upsell_filter'] ) ) ? 'selected=selected' : ''; ?>><?php esc_html_e( 'All Orders', 'woo-one-click-upsell-funnel' ); ?></option>
					<option value="no_upsells" <?php echo 'no_upsells' === sanitize_key( wp_unslash( $_GET['wps_wocuf_pro_upsell_filter'] ) ) ? 'selected=selected' : ''; ?>><?php esc_html_e( 'No Upsell Orders', 'woo-one-click-upsell-funnel' ); ?></option>
					<option value="all_upsells" <?php echo 'all_upsells' === sanitize_key( wp_unslash( $_GET['wps_wocuf_pro_upsell_filter'] ) ) ? 'selected=selected' : ''; ?>><?php esc_html_e( 'Only Upsell Orders', 'woo-one-click-upsell-funnel' ); ?></option>
				</select>
				<?php
			endif;

			if ( ! isset( $_GET['wps_wocuf_pro_upsell_filter'] ) ) :
				?>
				<select name="wps_wocuf_pro_upsell_filter">
					<option value="all"><?php esc_html_e( 'All Orders', 'woo-one-click-upsell-funnel' ); ?></option>
					<option value="no_upsells"><?php esc_html_e( 'No Upsell Orders', 'woo-one-click-upsell-funnel' ); ?></option>
					<option value="all_upsells"><?php esc_html_e( 'Only Upsell Orders', 'woo-one-click-upsell-funnel' ); ?></option>
				</select>
				<?php
			endif;
		}
	}

	/**
	 * Modifying query vars for filtering Upsell Orders.
	 *
	 * @since    1.0.0
	 * @param    array $vars    array of queries.
	 * @return   array    $vars    array of queries alongwith select dropdown query for upsell
	 */
	public function wps_wocuf_pro_request_query( $vars ) {

		$secure_nonce      = wp_create_nonce( 'wps-upsell-auth-nonce' );
		$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'wps-upsell-auth-nonce' );

		if ( ! $id_nonce_verified ) {
			wp_die( esc_html__( 'Nonce Not verified', ' woo-one-click-upsell-funnel' ) );
		}

		if ( isset( $_GET['wps_wocuf_pro_upsell_filter'] ) && 'all_upsells' === $_GET['wps_wocuf_pro_upsell_filter'] ) {

			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'wps_wocuf_upsell_order',     // phpcs:ignore
				)
			);

		} elseif ( isset( $_GET['wps_wocuf_pro_upsell_filter'] ) && 'no_upsells' === $_GET['wps_wocuf_pro_upsell_filter'] ) {

			$vars = array_merge(
				$vars,
				array(
					'meta_key'     => 'wps_wocuf_upsell_order',    // phpcs:ignore
					'meta_compare' => 'NOT EXISTS',
				)
			);
		}

		return $vars;
	}

	/**
	 * Adding distraction free mode to the offers page.
	 *
	 * @since       1.0.0
	 * @param mixed $page_template default template for the page.
	 */
	public function wps_wocuf_pro_page_template( $page_template ) {

		$pages_available = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type'      => 'any',
				'post_status'    => 'publish',
				's'              => '[wps_wocuf_pro_funnel_default_offer_page]',
				'orderby'        => 'ID',
				'order'          => 'ASC',
			)
		);

		foreach ( $pages_available as $single_page ) {

			if ( is_page( $single_page->ID ) ) {

				$page_template = dirname( __FILE__ ) . '/partials/templates/wps-wocuf-pro-template.php';
			}
		}

		return $page_template;
	}

	/**
	 * Hide Upsell offer pages in admin panel 'Pages'.
	 *
	 * @param mixed $query query.
	 * @since       2.0.0
	 */
	public function hide_upsell_offer_pages_in_admin( $query ) {

		// Make sure we're in the admin and it's the main query.
		if ( ! is_admin() && ! $query->is_main_query() ) {
			return;
		}

		global $typenow;

		// Only do this for pages.
		if ( ! empty( $typenow ) && 'page' === $typenow ) {

			$saved_offer_post_ids = get_option( 'wps_upsell_lite_offer_post_ids', array() );

			if ( ! empty( $saved_offer_post_ids ) && is_array( $saved_offer_post_ids ) && count( $saved_offer_post_ids ) ) {

				// Don't show the special pages.
				$query->set( 'post__not_in', $saved_offer_post_ids );

				return;
			}
		}

	}

	/**
	 * Add 'Upsell Support' column on payment gateways page.
	 *
	 * @param mixed $default_columns default columns.
	 * @since       2.0.0
	 */
	public function upsell_support_in_payment_gateway( $default_columns ) {

		$new_column['wps_upsell'] = esc_html__( 'Upsell Supported', 'woo-one-click-upsell-funnel' );
		wps_upsee_lite_go_pro( 'pro' );
		// Place at second last position.
		$position = count( $default_columns ) - 1;

		$default_columns = array_slice( $default_columns, 0, $position, true ) + $new_column + array_slice( $default_columns, $position, count( $default_columns ) - $position, true );

		return $default_columns;
	}

	/**
	 * 'Upsell Support' content on payment gateways page.
	 *
	 * @param mixed $gateway gateway.
	 * @since       2.0.0
	 */
	public function upsell_support_content_in_payment_gateway( $gateway ) {

		$supported_gateways = wps_upsell_lite_supported_gateways();

		$supported_gateways_pro = wps_upsell_pro_supported_gateways();

		echo '<td class="wps_upsell_supported">';

		if ( in_array( $gateway->id, $supported_gateways, true ) ) {

			echo '<span class="status-enabled">' . esc_html__( 'Yes', 'woo-one-click-upsell-funnel' ) . '</span>';

		} else {

			if ( in_array( $gateway->id, $supported_gateways_pro, true ) ) {

				echo '	<span class="wps_wupsell_premium_strip">' . esc_html__( 'pro', 'woo-one-click-upsell-funnel' ) . '</span>';

			} else {

				echo '<span class="status-disabled">' . esc_html__( 'No', 'woo-one-click-upsell-funnel' ) . '</span>';
			}
		}

		echo "<input type='hidden' id='wps_ubo_pro_status' value='inactive'>
		</td>";

	}

	/**
	 * Dismiss Elementor inactive notice.
	 *
	 * @since       2.0.0
	 */
	public function dismiss_elementor_inactive_notice() {

		set_transient( 'wps_upsell_elementor_inactive_notice', 'notice_dismissed' );

		wp_die();
	}


	/**
	 * Add custom image upload.
	 *
	 * @param mixed $hidden_field_index hidden field index.
	 * @param mixed $image_post_id image post id.
	 * @since       3.0.0
	 */
	public function wps_wocuf_pro_image_uploader_field( $hidden_field_index, $image_post_id = '' ) {

		$image   = ' button">' . esc_html__( 'Upload image', 'woo-one-click-upsell-funnel' );
		$display = 'none'; // Display state ot the "Remove image" button.

		if ( ! empty( $image_post_id ) ) {

			// $image_attributes[0] - Image URL.
			// $image_attributes[1] - Image width.
			// $image_attributes[2] - Image height.
			$image_attributes = wp_get_attachment_image_src( $image_post_id, 'thumbnail' );

			$image   = '"><img src="' . $image_attributes[0] . '" style="max-width:150px;display:block;" />';
			$display = 'inline-block';
		}

		return '<div class="wps_wocuf_saved_custom_image">
		<a href="#" class="wps_wocuf_pro_upload_image_button' . $image . '</a>
		<input type="hidden" name="wps_upsell_offer_image[' . $hidden_field_index . ']" id="wps_upsell_offer_image_for_' . $hidden_field_index . '" value="' . esc_attr( $image_post_id ) . '" />
		<a href="#" class="wps_wocuf_pro_remove_image_button button" style="margin-top: 10px;display:' . $display . '">Remove image</a>
		</div>';
	}

	/**
	 * Add Upsell Reporting in Woo Admin reports.
	 *
	 * @param mixed $reports reports.
	 * @since       3.0.0
	 */
	public function add_upsell_reporting( $reports ) {

		$reports['upsell'] = array(

			'title'   => esc_html__( '1 Click Upsell', 'woo-one-click-upsell-funnel' ),
			'reports' => array(

				'sales_by_date'     => array(
					'title'       => esc_html__( 'Upsell Sales by date', 'woo-one-click-upsell-funnel' ),
					'description' => '',
					'hide_title'  => 1,
					'callback'    => array( 'Woocommerce_One_Click_Upsell_Funnel_Admin', 'upsell_reporting_callback' ),
				),

				'sales_by_product'  => array(
					'title'       => esc_html__( 'Upsell Sales by product', 'woo-one-click-upsell-funnel' ),
					'description' => '',
					'hide_title'  => 1,
					'callback'    => array( 'Woocommerce_One_Click_Upsell_Funnel_Admin', 'upsell_reporting_callback' ),
				),

				'sales_by_category' => array(
					'title'       => esc_html__( 'Upsell Sales by category', 'woo-one-click-upsell-funnel' ),
					'description' => '',
					'hide_title'  => 1,
					'callback'    => array( 'Woocommerce_One_Click_Upsell_Funnel_Admin', 'upsell_reporting_callback' ),
				),
			),
		);

		return $reports;
	}

	/**
	 * Add custom report. callback.
	 *
	 * @param mixed $report_type report type.
	 * @since       3.0.0
	 */
	public static function upsell_reporting_callback( $report_type ) {

		$report_file      = ! empty( $report_type ) ? str_replace( '_', '-', $report_type ) : '';
		$preformat_string = ! empty( $report_type ) ? ucwords( str_replace( '_', ' ', $report_type ) ) : '';
		$class_name       = ! empty( $preformat_string ) ? 'WPS_Upsell_Report_' . str_replace( ' ', '_', $preformat_string ) : '';

		/**
		 * The file responsible for defining reporting.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'reporting/class-wps-upsell-report-' . $report_file . '.php';

		if ( class_exists( $class_name ) ) {

			$report = new $class_name();
			$report->output_report();

		} else {

			?>
			<div class="wps_wocuf_report_error_wrap" style="text-align: center;">
				<h2 class="wps_wocuf_report_error_text">
					<?php esc_html_e( 'Some Error Occured while creating report.', 'woo-one-click-upsell-funnel' ); ?>
				</h2>
			</div>
			<?php
		}
	}

	/**
	 * Reporting and Funnel Stats Sub menu callback.
	 *
	 * @since       3.0.0
	 */
	public function add_submenu_page_reporting_callback() {

		require_once WPS_WOCUF_DIRPATH . 'admin/reporting-and-tracking/upsell-reporting-and-tracking-config-panel.php';
	}


	/**
	 * Product simple product.
	 *
	 * @return void
	 */
	public function upsell_simple_product_settings() {
			$upsell_shipping_product = get_post_meta( get_the_ID(), 'wps_upsell_simple_shipping_product_' . get_the_ID(), true );
		if ( function_exists( 'wp_nonce_field' ) ) {
			wp_nonce_field( 'simple-product', 'upsell-custom-shipping-simple-nonce' );
		}

		?>
			<div class="wps_product_custom_field product_custom_field options_group show_if_simple show_if_external ">
			<h4> 
					<?php
						echo esc_html__( 'Upsell setting', 'woo-one-click-upsell-funnel' );
					?>
					<span class="wps-help-tip"></span>
					<p>
						<?php
							echo esc_html__( 'Add shipping price of this product for upsell offer.', 'woo-one-click-upsell-funnel' );
						?>
					</p>
				</h4>
				<p class="form-field _sale_price_field">
				<label><?php echo esc_html__( 'Upsell shipping Price', 'woo-one-click-upsell-funnel' ); ?></label>	
				<input type="number" class="wps_product_shipping_input"  name="wps_upsell_simple_shipping_product_<?php echo esc_attr( get_the_ID() ); ?>" id="wps_upsell_simple_shipping_product_<?php echo esc_attr( get_the_ID() ); ?>" value="<?php echo esc_attr( $upsell_shipping_product ); ?>"  >
				</p>
			</div>
			<?php

	}

	/**
	 * Upsell saving for simple products.
	 *
	 * @param [type] $post_id Is the post id.
	 * @return void
	 */
	public function upsell_saving_simple_product_dynamic_shipping( $post_id ) {
		if ( isset( $_POST['upsell-custom-shipping-simple-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['upsell-custom-shipping-simple-nonce'] ) ), 'simple-product' ) ) {
				wp_die();
			}
		}
		 $upsell_shipping_price = ! empty( $_POST[ 'wps_upsell_simple_shipping_product_' . $post_id ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wps_upsell_simple_shipping_product_' . $post_id ] ) ) : '';

		update_post_meta( $post_id, 'wps_upsell_simple_shipping_product_' . $post_id, $upsell_shipping_price );
	}




	/**
	 * Upsell setting for variable products.
	 *
	 * @param [type] $loop Is the loop.
	 * @param [type] $variation_data Is the variation data.
	 * @param [type] $variation Is the variation object.
	 * @return void
	 */
	public function upsell_add_custom_price_to_variations( $loop, $variation_data, $variation ) {
		$upsell_shipping_product = get_post_meta( $variation->ID, 'wps_upsell_simple_shipping_product_' . $variation->ID, true );

		if ( 0 === $loop ) {
			wp_nonce_field( 'variable-product', 'wps-upsell-price-variation-nonce' );
		}

		?>
			<div class="wps_product_custom_field product_custom_field options_group show_if_simple show_if_external ">
			<h4> 
					<?php
						echo esc_html__( 'Upsell setting', 'woo-one-click-upsell-funnel' );
					?>
					<span class="wps-help-tip"></span>
					<p>
						<?php
							echo esc_html__( 'Add shipping price of this product for upsell offer.', 'woo-one-click-upsell-funnel' );
						?>
					</p>
				</h4>

				<label>
				<?php echo esc_html__( 'Upsell shipping Price', 'woo-one-click-upsell-funnel' ); ?>	
				</label>
				<input type="number" class="wps_product_shipping_input"  name="wps_upsell_simple_shipping_product_<?php echo esc_attr( $variation->ID ); ?>" id="wps_upsell_simple_shipping_product_<?php echo esc_attr( $variation->ID ); ?>" value="<?php echo esc_attr( $upsell_shipping_product ); ?>"  >
			
			</div>
			<?php
	}



	/**
	 * Upsell save data setting for variable.
	 *
	 * @param [type] $variation_id Is the variation id.
	 * @param [type] $i Is the number of variation.
	 * @return void
	 */
	public function upsell_save_custom_price_variations( $variation_id, $i ) {

		if ( isset( $_POST['wps-upsell-price-variation-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wps-upsell-price-variation-nonce'] ) ), 'variable-product' ) ) {
				wp_die();
			}
		}

		$upsell_shipping_price = ! empty( $_POST[ 'wps_upsell_simple_shipping_product_' . $variation_id ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'wps_upsell_simple_shipping_product_' . $variation_id ] ) ) : '';
		update_post_meta( $variation_id, 'wps_upsell_simple_shipping_product_' . $variation_id, $upsell_shipping_price );

	}

}




?>
