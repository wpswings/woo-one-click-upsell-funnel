<?php
/**
 * The migration-specific functionality of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      3.2.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/migration
 */

/**
 * The migration-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the migration-specific stylesheet and JavaScript.
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/migration
 * @author      wpswings <webmaster@wpswings.com>
 */
class WPS_OCU_Migration {

	/**
	 * Version
	 *
	 * @var string
	 */
	public $version = WPS_WOCUF_VERSION;

	/**
	 * Register the stylesheets for the migration area.
	 *
	 * @since    3.2.0
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
				wp_register_style( 'wps_wocuf_pro_migrator_style', plugin_dir_url( __FILE__ ) . 'css/wps-ocu-migrator.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'wps_wocuf_pro_fafa=style', plugin_dir_url( __FILE__ ) . 'css/fa-fa-lib.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'wps_wocuf_pro_migrator_style' );
			}
		}
	}

	/**
	 * Register the JavaScript for the migration area.
	 *
	 * @since    3.2.0
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

			if ( 'toplevel_page_wps-wocuf-setting' === $pagescreen || '1-click-upsell_page_wps-wocuf-setting-tracking' === $pagescreen ) {

				wp_enqueue_script( 'wps_wocuf_pro_migrator_script', plugin_dir_url( __FILE__ ) . 'js/wps-ocu-migrator.js', array( 'jquery' ), $this->version, false );

				wp_localize_script(
					'wps_wocuf_pro_migrator_script',
					'wps_ocu_migrator_obj',
					array(
						'ajaxUrl' => admin_url( 'admin-ajax.php' ),
						'nonce'   => wp_create_nonce( 'ajax_nonce' ),
						'title'   => array(
							'settings' => esc_html__( 'Attention Required', 'woo-one-click-upsell-funnel' ),
							'metas'    => esc_html__( 'Attention Required', 'woo-one-click-upsell-funnel' ),
						),
						'content' => array(
							'settings' => esc_html__( 'Attention Required', 'woo-one-click-upsell-funnel' ),
							'metas'    => esc_html__( 'Attention Required', 'woo-one-click-upsell-funnel' ),
						),
						'data'    => apply_filters(
							'wps_mirgation_localised_data',
							array(
								'settings' => $this->get_options_keys(),
								'metas'    => $this->get_post_meta_keys(),
								'pages'    => $this->get_pages_ids_with_shortcodes(),
							)
						),
					)
				);
			}
		}
	}

	/**
	 * Check for all the options saved via current crm plugin.
	 *
	 * @return array.
	 */
	private function get_options_keys() {

		global $wpdb;

		wp_cache_delete( 'wps_migration_option_keys' );
		if ( empty( wp_cache_get( 'wps_migration_option_keys' ) ) ) {

			$options = $wpdb->get_results( //phpcs:ignore
				$wpdb->prepare(
					'SELECT option_name FROM ' . $wpdb->prefix . 'options WHERE `option_name` LIKE %s OR `option_name` LIKE %s',
					'%mwb_wocuf%',
					'%mwb_upsell%'
				),
				ARRAY_A
			);

			wp_cache_set(
				'wps_migration_option_keys',
				$options
			);
		}

		return $options;
	}

	/**
	 * Check for all the options saved via current crm plugin.
	 *
	 * @return array.
	 */
	private function get_post_meta_keys() {

		global $wpdb;

		wp_cache_delete( 'wps_migration_post_meta_keys' );
		if ( empty( wp_cache_get( 'wps_migration_post_meta_keys' ) ) ) {

			$meta_keys = $wpdb->get_results( //phpcs:ignore
				$wpdb->prepare(
					'SELECT DISTINCT `meta_key` FROM ' . $wpdb->prefix . 'postmeta WHERE `meta_key` LIKE %s OR `meta_key` LIKE %s OR `meta_key` LIKE %s',
					'%mwb_wocuf%',
					'%mwb_upsell%',
					'%mwb_ocuf%'
				),
				ARRAY_A
			);

			wp_cache_set(
				'wps_migration_post_meta_keys',
				$meta_keys
			);
		}

		return $meta_keys;
	}
	/**
	 * Check for all the options saved via current crm plugin.
	 *
	 * @return array.
	 */
	private function get_pages_ids_with_shortcodes() {

		global $wpdb;

		wp_cache_delete( 'wps_migration_shortcode_content_pages_keys' );
		if ( empty( wp_cache_get( 'wps_migration_shortcode_content_pages_keys' ) ) ) {

			$content_pages = $wpdb->get_results( //phpcs:ignore
				$wpdb->prepare(
					'SELECT DISTINCT ID FROM ' . $wpdb->prefix . 'posts WHERE ( post_type = %s OR post_type = %s ) AND post_content LIKE %s',
					'revision',
					'page',
					'%[mwb_%'
				),
				ARRAY_A
			);

			wp_cache_set(
				'wps_migration_shortcode_content_pages_keys',
				$content_pages
			);
		}

		wp_cache_delete( 'wps_migration_shortcode_meta_pages_keys' );
		if ( empty( wp_cache_get( 'wps_migration_shortcode_meta_pages_keys' ) ) ) {

			$meta_pages = $wpdb->get_results( //phpcs:ignore
				$wpdb->prepare(
					'SELECT `post_id` FROM ' . $wpdb->prefix . 'postmeta WHERE `meta_value` LIKE %s',
					'%[mwb_%'
				),
				ARRAY_A
			);

			wp_cache_set(
				'wps_migration_shortcode_meta_pages_keys',
				$meta_pages
			);
		}

		$ids = array_merge( $meta_pages, $content_pages );

		return $ids;
	}


	/**
	 * Ajax Call back
	 */
	public function process_ajax_events() {
		check_ajax_referer( 'ajax_nonce', 'nonce' );
		$event = ! empty( $_POST['event'] ) ? sanitize_text_field( wp_unslash( $_POST['event'] ) ) : '';
		if ( method_exists( $this, $event ) ) {
			$data = $this->$event( $_POST );
		} else {
			$data = esc_html__( 'Method not found', 'woo-one-click-upsell-funnel' );
		}
		wp_send_json( $data );
	}

	/**
	 * Import Single option.
	 *
	 * @param array $posted_data the posted data.
	 * @since       3.2.0
	 */
	public function import_single_option( $posted_data = array() ) {

		$settings = ! empty( $posted_data['settings'] ) ? $posted_data['settings'] : array();

		if ( empty( $settings ) ) {
			return array();
		}

		foreach ( $settings as $key => $value ) {
			$old_key = ! empty( $value['option_name'] ) ? $value['option_name'] : '';
			unset( $settings[ $key ] );
			break;
		}

		$this->import_option( $old_key );
		return $settings;
	}

	/**
	 * Import Single option.
	 *
	 * @param array $posted_data the posted data.
	 * @since       3.2.0
	 */
	public function import_single_page( $posted_data = array() ) {

		$pages = ! empty( $posted_data['pages'] ) ? $posted_data['pages'] : array();

		if ( empty( $pages ) ) {
			return array();
		}

		foreach ( $pages as $key => $value ) {
			$page_id = ! empty( $value['ID'] ) ? $value['ID'] : '';
			if ( empty( $page_id ) ) {
				$page_id = ! empty( $value['post_id'] ) ? $value['post_id'] : '';
			}
			unset( $pages[ $key ] );
			break;
		}

		$page_obj = get_post( $page_id );

		if ( ! empty( $page_obj ) ) {
			$content = $page_obj->post_content;
			$content = str_replace( 'mwb_', 'wps_', $content );
			$my_post = array(
				'ID'           => $page_id,
				'post_content' => $content,
			);
			wp_update_post( $my_post );

			$elementor_data = get_post_meta( $page_id, '_elementor_data', true );
			if ( ! empty( $elementor_data ) ) {
				$elementor_data = str_replace( 'mwb_', 'wps_', $elementor_data );
				update_post_meta( $page_id, '_elementor_data', $elementor_data );
			}
		}

		if ( empty( $pages ) ) {
			update_option( 'wocuf_lite_migration_status', true );
		}

		return $pages;
	}

	/**
	 * Modify Single option.
	 *
	 * @param string|array $option_name The option key.
	 * @since       3.2.0
	 */
	public function import_option( $option_name = '' ) {

		if ( empty( $option_name ) ) {
			return;
		}

		$new_option_name = str_replace( 'mwb', 'wps', $option_name );
		$option_value    = get_option( $option_name );

		// Update the same value to wps key.
		if ( ! empty( $option_value ) ) {
			if ( is_array( $option_value ) ) {

				switch ( $option_name ) {
					case 'mwb_upsell_global_options':
					case 'mwb_upsell_lite_global_options':
						$option_value = $this->moderate_keys( $option_value );
						break;

					case 'mwb_wocuf_pro_funnels_list':
					case 'mwb_wocuf_funnels_list':
						foreach ( $option_value as $key => $value ) {
							$option_value[ $key ] = $this->moderate_keys( $value );
						}
						break;
				}
			}

			// Delete Old key and Add New key.
			update_option( $new_option_name, $option_value );
			delete_option( $option_name );
		}
	}

	/**
	 * Import Single meta in all posts at once.
	 *
	 * @param array $posted_data the posted data.
	 * @since       3.2.0
	 */
	public function import_single_meta( $posted_data = array() ) {

		$meta_keys = ! empty( $posted_data['metas'] ) ? $posted_data['metas'] : array();

		if ( empty( $meta_keys ) ) {
			return array();
		}

		foreach ( $meta_keys as $key => $value ) {
			$old_key = ! empty( $value['meta_key'] ) ? $value['meta_key'] : '';
			unset( $meta_keys[ $key ] );
			break;
		}

		$this->import_postmeta( $old_key );
		return $meta_keys;
	}

	/**
	 * Init Migration for postmeta.
	 *
	 * @param string $meta_key meta key to import.
	 * @since       3.2.0
	 */
	public function import_postmeta( $meta_key = false ) {

		if ( ! empty( $meta_key ) ) {

			$new_meta_key = str_replace( 'mwb', 'wps', $meta_key );
			global $wpdb;

			wp_cache_delete( 'wps_migration_post_meta_keys' );
			if ( empty( wp_cache_get( 'wps_migration_post_meta_keys' ) ) ) {

				$import_keys = $wpdb->get_results( //phpcs:ignore
					$wpdb->prepare(
						'UPDATE ' . $wpdb->prefix . 'postmeta SET `meta_key` = %s WHERE `meta_key` = %s',
						$new_meta_key,
						$meta_key
					),
					ARRAY_A
				);

				wp_cache_set(
					'wps_migration_post_meta_keys',
					$import_keys
				);
			}
		}
	}

	/**
	 * Init Migration formatting.
	 *
	 * @param array $array Values.
	 * @since       3.2.0
	 */
	public function moderate_keys( $array = array() ) {

		if ( ! empty( $array ) && is_array( $array ) ) {
			foreach ( $array as $key => $value ) {
				$new_key           = str_replace( 'mwb', 'wps', $key );
				$array[ $new_key ] = $value;

				if ( $new_key !== $key ) {
					unset( $array[ $key ] );
				}
			}
			return $array;
		}

		return $array;
	}

	// End of class.
}

