<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpswings.com
 * @since      3.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/includes
 */

/**
 * The Onboarding-specific functionality of the plugin admin side.
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/includes
 * @author      wpswings <webmaster@wpswings.com>
 */
if ( class_exists( 'WPSwings_Onboarding_Helper' ) ) {
	return;
}

/**
 * Helper module for WP Swings plugins.
 */
class WPSwings_Onboarding_Helper {

	/**
	 * The single instance of the class.
	 *
	 * @var mixed $instance instance.
	 * @since   3.0.0
	 */
	protected static $instance = null;

	/**
	 * Base url of hubspot api.
	 *
	 * @since 3.0.0
	 * @var string base url of API.
	 */
	private $base_url = 'https://api.hsforms.com/';

	/**
	 * Portal id of hubspot api.
	 *
	 * @since 3.0.0
	 * @var string Portal id.
	 */
	private static $portal_id = '25444144'; // Wp Swings portal.

	/**
	 * Form id of hubspot api.
	 *
	 * @since 3.0.0
	 * @var string Form id.
	 */
	private static $onboarding_form_id = '2a2fe23c-0024-43f5-9473-cbfefdb06fe2';

	/**
	 * Form id of hubspot api.
	 *
	 * @since 3.0.0
	 * @var string deactivation Form id.
	 */
	private static $deactivation_form_id = '67feecaa-9a93-4fda-8f85-f73168da2672';

	/**
	 * Plugin Name.
	 *
	 * @var mixed plugin_name.
	 * @since 3.0.0
	 */
	private static $plugin_name;
	/**
	 * Plugin Name.
	 *
	 * @var mixed store_name.
	 * @since 3.0.0
	 */
	private static $store_name;
	/**
	 * Plugin Name.
	 *
	 * @var mixed store_url.
	 * @since 3.0.0
	 */
	private static $store_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0.0
	 */
	public function __construct() {

		self::$store_name = get_bloginfo( 'name' );
		self::$store_url  = home_url();

		if ( defined( 'ONBOARD_PLUGIN_NAME' ) ) {
			self::$plugin_name = ONBOARD_PLUGIN_NAME;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_footer', array( $this, 'add_onboarding_popup_screen' ) );
		add_action( 'admin_footer', array( $this, 'add_deactivation_popup_screen' ) );
		add_filter( 'wps_on_boarding_form_fields', array( $this, 'add_on_boarding_form_fields' ) );
		add_filter( 'wps_deactivation_form_fields', array( $this, 'add_deactivation_form_fields' ) );

		// Ajax to send data.
		add_action( 'wp_ajax_send_onboarding_data', array( $this, 'send_onboarding_data' ) );
		add_action( 'wp_ajax_nopriv_send_onboarding_data', array( $this, 'send_onboarding_data' ) );

		// Ajax to Skip popup.
		add_action( 'wp_ajax_skip_onboarding_popup', array( $this, 'skip_onboarding_popup' ) );
		add_action( 'wp_ajax_nopriv_skip_onboarding_popup', array( $this, 'skip_onboarding_popup' ) );
	}

	/**
	 * Main HubWooConnectionMananager Instance.
	 *
	 * Ensures only one instance of HubWooConnectionMananager is loaded or can be loaded.
	 *
	 * @since 3.0.0
	 * @static
	 * @return HubWooConnectionMananager - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Makewebbetter_Onboarding_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Makewebbetter_Onboarding_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( $this->is_valid_page_screen() ) {

			wp_enqueue_style( 'wpswings-onboarding-style', WPS_WOCUF_URL . 'admin/css/wpswings-onboarding-admin.css', array(), '3.0.0', 'all' );

			// Uncomment Only when your plugin doesn't uses the Select2.
			wp_enqueue_style( 'wpswings-onboarding-select2-style', WPS_WOCUF_URL . 'admin/css/select2.min.css', array(), '3.0.0', 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    3.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Makewebbetter_Onboarding_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Makewebbetter_Onboarding_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( $this->is_valid_page_screen() ) {

			wp_enqueue_script( 'wpswings-onboarding-scripts', WPS_WOCUF_URL . 'admin/js/wpswings-onboarding-admin.js', array( 'jquery' ), '3.0.0', true );

			global $pagenow;
			$current_slug = ! empty( explode( '/', plugin_basename( __FILE__ ) ) ) ? explode( '/', plugin_basename( __FILE__ ) )[0] : '';
			wp_localize_script(
				'wpswings-onboarding-scripts',
				'wps_onboarding',
				array(
					'ajaxurl'                => admin_url( 'admin-ajax.php' ),
					'auth_nonce'             => wp_create_nonce( 'wps_onboarding_nonce' ),
					'current_screen'         => $pagenow,
					'current_supported_slug' => apply_filters( 'wps_deactivation_supported_slug', array( $current_slug ) ),
				)
			);

			// Uncomment Only when your plugin doesn't uses the Select2.
			wp_enqueue_script( 'wpswings-onboarding-select2-script', WPS_WOCUF_URL . 'admin/js/select2.min.js', array( 'jquery' ), '3.0.0', false );
		}
	}

	/**
	 * Get all valid screens to add scripts and templates.
	 *
	 * @since    3.0.0
	 */
	public function add_onboarding_popup_screen() {
		
		if ( $this->is_valid_page_screen() && $this->can_show_onboarding_popup() ) {
			require_once WPS_WOCUF_DIRPATH . 'extra-templates/wpswings-onboarding-template-display.php';
		}
	}


	/**
	 * Get all valid screens to add scripts and templates.
	 *
	 * @since    3.0.0
	 */
	public function add_deactivation_popup_screen() {

		global $pagenow;
		if ( ! empty( $pagenow ) && 'plugins.php' === $pagenow ) {
			require_once WPS_WOCUF_DIRPATH . 'extra-templates/wpswings-deactivation-template-display.php';
		}
	}


	/**
	 * Validate current screen.
	 *
	 * @since    3.0.0
	 */
	public function is_valid_page_screen() {

		global $pagenow;
		$screen = get_current_screen();

		$is_valid = false;

		if ( isset( $screen->id ) && 'toplevel_page_wps-wocuf-setting' == $screen->id ) {
			$is_valid = true;
		}
		

		if ( empty( $is_valid ) && 'plugins.php' === $pagenow ) {
			$is_valid = true;
		}

		return $is_valid;
	}

	/**
	 * Validate the popup to be shown on screen.
	 *
	 * @since    3.0.0
	 */
	public function can_show_onboarding_popup() {

		$is_already_sent = get_option( 'onboarding-data-sent', false );

		// Already submitted the data.
		if ( ! empty( $is_already_sent ) && 'sent' === $is_already_sent ) {
			return false;
		}

		$get_skipped_timstamp = get_option( 'onboarding-data-skipped', false );
		if ( ! empty( $get_skipped_timstamp ) ) {

			$next_show = strtotime( '+2 days', $get_skipped_timstamp );

			$current_time = time();

			$time_diff = $next_show - $current_time;

			if ( 0 < $time_diff ) {
				return false;
			}
		}

		// By default Show.
		return true;
	}

	/**
	 * Add your onboarding form fields.
	 *
	 * @since    3.0.0
	 */
	public function add_on_boarding_form_fields() {

		$current_user = wp_get_current_user();
		if ( ! empty( $current_user ) ) {
			$current_user_email = $current_user->user_email ? $current_user->user_email : '';
		}

		$currency_symbol = get_woocommerce_currency_symbol();
		$store_name      = get_bloginfo( 'name ' );
		$store_url       = get_home_url();

		/**
		 * Do not repeat id index.
		 */

		$fields = array(

			/**
			 * Input field with label.
			 * Radio field with label ( select only one ).
			 * Radio field with label ( select multiple one ).
			 * Checkbox radio with label ( select only one ).
			 * Checkbox field with label ( select multiple one ).
			 * Only Label ( select multiple one ).
			 * Select field with label ( select only one ).
			 * Select2 field with label ( select multiple one ).
			 * Email field with label. ( auto filled with admin email )
			 */

			wp_rand() => array(
				'id'          => 'monthly-revenue',
				'label'       => esc_html__( 'What is your monthly revenue?', 'woo-one-click-upsell-funnel' ),
				'type'        => 'radio',
				'name'        => 'monthly_revenue_',
				'value'       => '',
				'multiple'    => 'no',
				'required'    => 'yes',
				'extra-class' => '',
				'options'     => array(
					'0-500'      => $currency_symbol . '0-' . $currency_symbol . '500',
					'501-5000'   => $currency_symbol . '501-' . $currency_symbol . '5000',
					'5001-10000' => $currency_symbol . '5001-' . $currency_symbol . '10000',
					'10000+'     => $currency_symbol . '10000+',
				),
			),

			wp_rand() => array(
				'id'          => 'industry_type',
				'label'       => esc_html__( 'What industry defines your business?', 'woo-one-click-upsell-funnel' ),
				'type'        => 'select',
				'name'        => 'industry_type_',
				'value'       => '',
				'multiple'    => 'yes',
				'required'    => 'yes',
				'extra-class' => '',
				'options'     => array(
					'agency'                  => 'Agency',
					'consumer-services'       => 'Consumer Services',
					'ecommerce'               => 'Ecommerce',
					'financial-services'      => 'Financial Services',
					'healthcare'              => 'Healthcare',
					'manufacturing'           => 'Manufacturing',
					'nonprofit-and-education' => 'Nonprofit and Education',
					'professional-services'   => 'Professional Services',
					'real-estate'             => 'Real Estate',
					'software'                => 'Software',
					'startups'                => 'Startups',
					'restaurant'              => 'Restaurant',
					'fitness'                 => 'Fitness',
					'jewelry'                 => 'Jewelry',
					'beauty'                  => 'Beauty',
					'celebrity'               => 'Celebrity',
					'gaming'                  => 'Gaming',
					'government'              => 'Government',
					'sports'                  => 'Sports',
					'retail-store'            => 'Retail Store',
					'travel'                  => 'Travel',
					'political-campaign'      => 'Political Campaign',
				),
			),

			wp_rand() => array(
				'id'          => 'onboard-email',
				'label'       => esc_html__( 'What is the best email address to contact you?', 'woo-one-click-upsell-funnel' ),
				'type'        => 'email',
				'name'        => 'email',
				'value'       => $current_user_email,
				'required'    => 'yes',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'onboard-number',
				'label'       => esc_html__( 'What is your contact number?', 'woo-one-click-upsell-funnel' ),
				'type'        => 'text',
				'name'        => 'phone',
				'value'       => '',
				'required'    => 'yes',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'store-name',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'company',
				'value'       => $store_name,
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'store-url',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'website',
				'value'       => $store_url,
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'show-counter',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'show-counter',
				'value'       => get_option( 'onboarding-data-sent', 'not-sent' ),
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'plugin-name',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'org_plugin_name',
				'value'       => self::$plugin_name,
				'required'    => '',
				'extra-class' => '',
			),
		);

		return $fields;
	}


	/**
	 * Add your deactivation form fields.
	 *
	 * @since    3.0.0
	 */
	public function add_deactivation_form_fields() {

		$current_user = wp_get_current_user();
		if ( ! empty( $current_user ) ) {
			$current_user_email = $current_user->user_email ? $current_user->user_email : '';
		}

		$store_name = get_bloginfo( 'name ' );
		$store_url  = get_home_url();

		/**
		 * Do not repeat id index.
		 */

		$fields = array(

			/**
			 * Input field with label.
			 * Radio field with label ( select only one ).
			 * Radio field with label ( select multiple one ).
			 * Checkbox radio with label ( select only one ).
			 * Checkbox field with label ( select multiple one ).
			 * Only Label ( select multiple one ).
			 * Select field with label ( select only one ).
			 * Select2 field with label ( select multiple one ).
			 * Email field with label. ( auto filled with admin email )
			 */

			wp_rand() => array(
				'id'          => 'deactivation-reason',
				'label'       => '',
				'type'        => 'radio',
				'name'        => 'plugin_deactivation_reason',
				'value'       => '',
				'multiple'    => 'no',
				'required'    => 'yes',
				'extra-class' => '',
				'options'     => array(
					'temporary-deactivation-for-debug' => 'It is a temporary deactivation. I am just debugging an issue.',
					'site-layout-broke'                => 'The plugin broke my layout or some functionality.',
					'complicated-configuration'        => 'The plugin is too complicated to configure.',
					'no-longer-need'                   => 'I no longer need the plugin',
					'found-better-plugin'              => 'I found a better plugin',
					'other'                            => 'Other',
				),
			),

			wp_rand() => array(
				'id'          => 'deactivation-reason-text',
				'label'       => 'Let us know why you are deactivating {plugin-name} so we can improve the plugin',
				'type'        => 'textarea',
				'name'        => 'deactivation_reason_text',
				'value'       => '',
				'required'    => '',
				'extra-class' => 'wps-keep-hidden',
			),

			wp_rand() => array(
				'id'          => 'admin-email',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'email',
				'value'       => $current_user_email,
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'store-name',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'company',
				'value'       => $store_name,
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'store-url',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'website',
				'value'       => $store_url,
				'required'    => '',
				'extra-class' => '',
			),

			wp_rand() => array(
				'id'          => 'plugin-name',
				'label'       => '',
				'type'        => 'hidden',
				'name'        => 'org_plugin_name',
				'value'       => '',
				'required'    => '',
				'extra-class' => '',
			),
		);

		return $fields;
	}

	/**
	 * Returns form fields html.
	 *
	 * @since       3.0.0
	 * @param       array  $attr               The attributes of this field.
	 * @param       string $base_class         The basic class for the label.
	 */
	public function render_field_html( $attr = array(), $base_class = 'on-boarding' ) {

		$id       = ! empty( $attr['id'] ) ? $attr['id'] : '';
		$name     = ! empty( $attr['name'] ) ? $attr['name'] : '';
		$label    = ! empty( $attr['label'] ) ? $attr['label'] : '';
		$type     = ! empty( $attr['type'] ) ? $attr['type'] : '';
		$class    = ! empty( $attr['extra-class'] ) ? $attr['extra-class'] : '';
		$value    = ! empty( $attr['value'] ) ? $attr['value'] : '';
		$options  = ! empty( $attr['options'] ) ? $attr['options'] : array();
		$multiple = ! empty( $attr['multiple'] ) && 'yes' === $attr['multiple'] ? 'yes' : 'no';
		$required = ! empty( $attr['required'] ) ? 'required="required"' : '';

		$html = '';

		if ( 'hidden' !== $type ) : ?>
			<div class ="wps-customer-data-form-single-field">
			<?php
		endif;

		switch ( $type ) {

			case 'radio':
				// If field requires multiple answers.
				if ( ! empty( $options ) && is_array( $options ) ) :
					?>

					<label class="on-boarding-label" for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $label ); ?></label>

					<?php
					$is_multiple = ! empty( $multiple ) && 'yes' !== $multiple ? 'name = "' . $name . '"' : '';

					foreach ( $options as $option_value => $option_label ) :
						?>
						<div class="wps-<?php echo esc_html( $base_class ); ?>-radio-wrapper">
							<input type="<?php echo esc_attr( $type ); ?>" class="on-boarding-<?php echo esc_attr( $type ); ?>-field <?php echo esc_attr( $class ); ?>" value="<?php echo esc_attr( $option_value ); ?>" id="<?php echo esc_attr( $option_value ); ?>" <?php echo esc_html( $required ); ?> <?php echo esc_attr( $is_multiple ); ?>>
							<label class="on-boarding-field-label" for="<?php echo esc_html( $option_value ); ?>"><?php echo esc_html( $option_label ); ?></label>
						</div>
					<?php endforeach; ?>

					<?php
				endif;

				break;

			case 'checkbox':
				// If field requires multiple answers.
				if ( ! empty( $options ) && is_array( $options ) ) :
					?>

					<label class="on-boarding-label" for="<?php echo esc_attr( $id ); ?>'"><?php echo esc_attr( $label ); ?></label>	
					<?php foreach ( $options as $option_id => $option_label ) : ?>
						<div class="wps-<?php echo esc_html( $base_class ); ?>-checkbox-wrapper">
						<input type="<?php echo esc_html( $type ); ?>" class="on-boarding-<?php echo esc_html( $type ); ?>-field <?php echo esc_html( $class ); ?>" value="<?php echo esc_html( $value ); ?>" id="<?php echo esc_html( $option_id ); ?>">
						<label class="on-boarding-field-label" for="<?php echo esc_html( $option_id ); ?>"><?php echo esc_html( $option_label ); ?></label>
						</div>
					<?php endforeach; ?>
					<?php
				endif;

				break;

			case 'select':
			case 'select2':
				// If field requires multiple answers.
				if ( ! empty( $options ) && is_array( $options ) ) {

					$is_multiple = 'yes' === $multiple ? 'multiple' : '';
					$select2     = ( 'yes' === $multiple && 'select' === $type ) || 'select2' === $type ? 'on-boarding-select2 ' : '';
					?>

					<label class="on-boarding-label"  for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label>
					<select class="on-boarding-select-field <?php echo esc_html( $select2 ); ?> <?php echo esc_html( $class ); ?>" id="<?php echo esc_html( $id ); ?>" name="<?php echo esc_html( $name ); ?>[]" <?php echo esc_html( $required ); ?> <?php echo esc_html( $is_multiple ); ?>>

						<?php if ( 'select' === $type ) : ?>	
							<option class="on-boarding-options" value=""><?php echo esc_html( 'Select Any One Option...' ); ?></option>
						<?php endif; ?>

						<?php foreach ( $options as $option_value => $option_label ) : ?>	
							<option class="on-boarding-options" value="<?php echo esc_attr( $option_value ); ?>"><?php echo esc_html( $option_label ); ?></option>
						<?php endforeach; ?>
					</select>

					<?php
				}

				break;

			case 'label':
				/**
				 * Only a text in label.
				 */
				?>
				<label class="on-boarding-label <?php echo( esc_html( $class ) ); ?>" for="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_html( $label ) ); ?></label>
				<?php
				break;

			case 'textarea':
				/**
				 * Text Area Field.
				 */
				?>
				<textarea rows="3" cols="50" class="<?php echo( esc_html( $base_class ) ); ?>-textarea-field <?php echo( esc_html( $class ) ); ?>" placeholder="<?php echo( esc_attr( $label ) ); ?>" id="<?php echo( esc_attr( $id ) ); ?>" name="<?php echo( esc_attr( $name ) ); ?>"><?php echo( esc_attr( $value ) ); ?></textarea>

				<?php
				break;

			default:
				/**
				 * Text/ Password/ Email.
				 */
				?>
				<label class="on-boarding-label" for="<?php echo( esc_attr( $id ) ); ?>"><?php echo( esc_html( $label ) ); ?></label>
				<input type="<?php echo( esc_attr( $type ) ); ?>" class="on-boarding-<?php echo( esc_attr( $type ) ); ?>-field <?php echo( esc_attr( $class ) ); ?>" value="<?php echo( esc_attr( $value ) ); ?>"  name="<?php echo( esc_attr( $name ) ); ?>" id="<?php echo( esc_attr( $id ) ); ?>" <?php echo( esc_html( $required ) ); ?>>

				<?php
		}

		if ( 'hidden' !== $type ) :
			?>
			</div>
			<?php
		endif;
	}


	/**
	 * Send the data to WPS server.
	 *
	 * @since    3.0.0
	 */
	public function send_onboarding_data() {

		check_ajax_referer( 'wps_onboarding_nonce', 'nonce' );

		$form_data = ! empty( $_POST['form_data'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['form_data'] ) ) ) : '';

		$formatted_data = array();

		if ( ! empty( $form_data ) && is_array( $form_data ) ) {

			foreach ( $form_data as $key => $input ) {

				if ( 'show-counter' === $input->name ) {
					continue;
				}

				if ( false !== strrpos( $input->name, '[]' ) ) {

					$new_key = str_replace( '[]', '', $input->name );
					$new_key = str_replace( '"', '', $new_key );

					array_push(
						$formatted_data,
						array(
							'name'  => $new_key,
							'value' => $input->value,
						)
					);

				} else {

					$input->name = str_replace( '"', '', $input->name );

					array_push(
						$formatted_data,
						array(
							'name'  => $input->name,
							'value' => $input->value,
						)
					);
				}
			}
		}

		try {

			$found = current(
				array_filter(
					$formatted_data,
					function( $item ) {
						return isset( $item['name'] ) && 'plugin_deactivation_reason' === $item['name'];
					}
				)
			);

			if ( ! empty( $found ) ) {
				$action_type = 'deactivation';
			} else {
				$action_type = 'onboarding';
			}

			if ( ! empty( $formatted_data ) && is_array( $formatted_data ) ) {

				unset( $formatted_data['show-counter'] );

				$this->handle_form_submission_for_hubspot( $formatted_data, $action_type );
			}
		} catch ( Exception $e ) {

			echo wp_json_encode( $e->getMessage() );
			wp_die();
		}

		if ( ! empty( $action_type ) && 'onboarding' === $action_type ) {
			$get_skipped_timstamp = update_option( 'onboarding-data-sent', 'sent' );
		}

		echo wp_json_encode( $formatted_data );
		wp_die();
	}


	/**
	 * Covert array to html.
	 *
	 * @param      array $formatted_data       The parsed data submitted vai form.
	 * @since      3.0.0
	 */
	public function render_form_data_into_table( $formatted_data = array() ) {

		$email_body = '<table border="1" style="text-align:center;"><tr><th>Data</th><th>Value</th></tr>';
		foreach ( $formatted_data as $key => $value ) {

			$key = ucwords( str_replace( '_', ' ', $key ) );
			$key = ucwords( str_replace( '-', ' ', $key ) );

			if ( is_array( $value ) ) {

				$email_body .= '<tr><td>' . $key . '</td><td>';

				foreach ( $value as $k => $v ) {
					$email_body .= ucwords( $v ) . '<br>';
				}

				$email_body .= '</td></tr>';
			} else {

				$email_body .= '  <tr><td>' . $key . '</td><td>' . ucwords( $value ) . '</td></tr>';
			}
		}

		$email_body .= '</table>';

		return $email_body;
	}

	/**
	 * Skip the popup for some days.
	 *
	 * @since    3.0.0
	 */
	public function skip_onboarding_popup() {

		$get_skipped_timstamp = update_option( 'onboarding-data-skipped', time() );
		echo wp_json_encode( 'true' );
		wp_die();
	}

	/**
	 * Add additional validations to onboard screen.
	 *
	 * @param      string $result       The result of this validation.
	 * @since    3.0.0
	 */
	public function add_wps_additional_validation( $result = true ) {

		if ( ! empty( $_GET['tab'] ) && 'settings' !== $_GET['tab'] ) { //phpcs:ignore

			$result = false;
		}

		return $result;
	}

	/**
	 * Handle Hubspot form submission.
	 *
	 * @param mixed $submission submition.
	 * @param mixed $action_type action_type.
	 * @since    3.0.1
	 */
	protected function handle_form_submission_for_hubspot( $submission = false, $action_type = 'onboarding' ) {

		if ( 'onboarding' === $action_type ) {
			array_push(
				$submission,
				array(
					'name'  => 'currency',
					'value' => get_woocommerce_currency(),
				)
			);
		}

		$result = $this->hubwoo_submit_form( $submission, $action_type );

		if ( true === $result['success'] ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Handle Hubspot POST api calls.
	 *
	 * @param mixed $endpoint endpoint.
	 * @param mixed $post_params post params.
	 * @param mixed $headers headers.
	 * @since    3.0.1
	 */
	private function hic_post( $endpoint, $post_params, $headers ) {

		$url = $this->base_url . $endpoint;

		$request = array(
			'httpversion' => '1.0',
			'sslverify'   => false,
			'method'      => 'POST',
			'timeout'     => 45,
			'headers'     => $headers,
			'body'        => $post_params,
			'cookies'     => array(),
		);

		$response = wp_remote_post( $url, $request );

		if ( is_wp_error( $response ) ) {

			$status_code = 500;
			$_response   = esc_html__( 'Unexpected Error Occured', 'woo-one-click-upsell-funnel' );
			$errors      = $response;

		} else {

			$_response   = json_decode( wp_remote_retrieve_body( $response ) );
			$status_code = wp_remote_retrieve_response_code( $response );
			$errors      = $response;
		}

		return array(
			'status_code' => $status_code,
			'response'    => $_response,
			'errors'      => $errors,
		);

	}

	/**
	 *  Hubwoo Onboarding Submission :: Get a form.
	 *
	 * @param array $form_data form data.
	 * @param mixed $action_type action type.
	 * @since       3.0.1
	 */
	protected function hubwoo_submit_form( $form_data = array(), $action_type = 'onboarding' ) {

		if ( 'onboarding' === $action_type ) {
			$form_id = self::$onboarding_form_id;
		} else {
			$form_id = self::$deactivation_form_id;
		}

		$url = 'submissions/v3/integration/submit/' . self::$portal_id . '/' . $form_id;

		$headers = 'Content-Type: application/json';

		$form_data = wp_json_encode(
			array(
				'fields'  => $form_data,
				'context' => array(
					'pageUri'   => self::$store_url,
					'pageName'  => self::$store_name,
					'ipAddress' => $this->get_client_ip(),
				),
			)
		);

		$response = $this->hic_post( $url, $form_data, $headers );

		if ( 200 === $response['status_code'] ) {
			
			$result            = json_decode( $response['response']->inlineMessage );
			$result['success'] = true;
		} else {

			$result = $response;
		}

		return $result;
	}


	/**
	 * Function to get the client IP address.
	 *
	 * @return $ipaddress
	 */
	public function get_client_ip() {
		$ipaddress = '';
		if ( getenv( 'HTTP_CLIENT_IP' ) ) {
			$ipaddress = getenv( 'HTTP_CLIENT_IP' );
		} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$ipaddress = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_X_FORWARDED' ) ) {
			$ipaddress = getenv( 'HTTP_X_FORWARDED' );
		} elseif ( getenv( 'HTTP_FORWARDED_FOR' ) ) {
			$ipaddress = getenv( 'HTTP_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_FORWARDED' ) ) {
			$ipaddress = getenv( 'HTTP_FORWARDED' );
		} elseif ( getenv( 'REMOTE_ADDR' ) ) {
			$ipaddress = getenv( 'REMOTE_ADDR' );
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}

	// End of Class.
}


