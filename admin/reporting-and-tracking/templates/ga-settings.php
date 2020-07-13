<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/tracking/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Save settings on Save changes.
if ( isset( $_POST['mwb_wocuf_pro_common_settings_save'] ) ) {

	// Nonce verification.
	$mwb_wocuf_pro_create_nonce = ! empty( $_POST['mwb_wocuf_pro_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wocuf_pro_nonce'] ) ) : '';

	if ( empty( $mwb_wocuf_pro_create_nonce ) || ! wp_verify_nonce( $mwb_wocuf_pro_create_nonce, 'mwb_wocuf_pro_setting_nonce' ) ) {

		esc_html_e( 'Sorry, due to some security issue, your settings could not be saved.', 'woo-one-click-upsell-funnel' );
		wp_die();
	}

	$mwb_upsell_analytics_options = get_option( 'mwb_upsell_analytics_configuration', array() );

	$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options[ 'facebook-pixel' ] ) ? $mwb_upsell_analytics_options[ 'facebook-pixel' ] : array();

	$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options[ 'google-analytics' ] ) ? $mwb_upsell_analytics_options[ 'google-analytics' ] : array();


	// Handle Data is POST here.
	$mwb_upsell_ga_analytics_config = array(
		'mwb_upsell_enable_ga_tracking' => ! empty( $_POST[ 'mwb_upsell_enable_ga_tracking' ] ) ? 'yes' : 'no',
		'mwb_upsell_enable_ga_account_id' => ! empty( $_POST[ 'mwb_upsell_enable_ga_account_id' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'mwb_upsell_enable_ga_account_id' ] ) ) : '',
		'mwb_upsell_enable_purchase_event' => ! empty( $_POST[ 'mwb_upsell_enable_purchase_event' ] ) ? 'yes' : 'no',
		'mwb_upsell_enable_pageview_event' => ! empty( $_POST[ 'mwb_upsell_enable_pageview_event' ] ) ? 'yes' : 'no',
		'mwb_upsell_enable_debug_mode' => ! empty( $_POST[ 'mwb_upsell_enable_debug_mode' ] ) ? 'yes' : 'no',
	);

	if( ! empty( $mwb_upsell_fb_pixel_config ) || ! empty( $mwb_upsell_ga_analytics_config ) ) {

		$mwb_upsell_analytics_options = array(
			'facebook-pixel'	=>	$mwb_upsell_fb_pixel_config,
			'google-analytics'	=>	$mwb_upsell_ga_analytics_config,
		);

		// Save.
		update_option( 'mwb_upsell_analytics_configuration' , $mwb_upsell_analytics_options );
	}

	?>

	<!-- Settings saved notice. -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'woo-one-click-upsell-funnel' ); ?></strong></p>
	</div>
	<?php
}

$mwb_upsell_analytics_options = get_option( 'mwb_upsell_analytics_configuration', array() );

$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options[ 'facebook-pixel' ] ) ? $mwb_upsell_analytics_options[ 'facebook-pixel' ] : array();

$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options[ 'google-analytics' ] ) ? $mwb_upsell_analytics_options[ 'google-analytics' ] : array();

// Form Fields Mapping.
$google_analytics_fields = array(

	'mwb_wocuf_enable_ga_tracking'	=>	array(
			'name'	=>	'mwb_upsell_enable_ga_tracking',
			'label'	=>	'Enable GA Tracking',
			'type'	=>	'checkbox',
			'required'	=>	false,
			'attribute_description'	=>	esc_html__( 'Enable Google Analytics Tracking on the main site.', 'woo-one-click-upsell-funnel' ),
			'value'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_tracking' ] ) ) : 'no',
	),

	'mwb_wocuf_ga_account_id'	=>	array(
			'name'	=>	'mwb_upsell_enable_ga_account_id',
			'label'	=>	'Google Analytics ID',
			'type'	=>	'text',
			'required'	=>	true,
			'attribute_description'	=>	esc_html__( 'Log into your google analytics account to find your ID. eg: UA-XXXXXX-X.', 'woo-one-click-upsell-funnel' ),
			'value'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_ga_account_id' ] ) ) : '',
	),

	'mwb_wocuf_enable_purchase_event'	=>	array(
			'name'	=>	'mwb_upsell_enable_purchase_event',
			'label'	=>	'Enable Purchase Event',
			'type'	=>	'checkbox',
			'required'	=>	false,
			'attribute_description'	=>	esc_html__( 'Enable Google Analytics Purchase Event.', 'woo-one-click-upsell-funnel' ),
			'value'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_purchase_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_purchase_event' ] ) ) : 'no',
	),

	'mwb_wocuf_enable_pageview_event'	=>	array(
			'name'	=>	'mwb_upsell_enable_pageview_event',
			'label'	=>	'Enable Pageview Event',
			'type'	=>	'checkbox',
			'required'	=>	false,
			'attribute_description'	=>	esc_html__( 'Enable Google Analytics Pageview Event.', 'woo-one-click-upsell-funnel' ),
			'value'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_pageview_event' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_pageview_event' ] ) ) : 'no',
	),

	'mwb_wocuf_enable_debug_mode'	=>	array(
		'name'	=>	'mwb_upsell_enable_debug_mode',
		'label'	=>	'Enable Debug Mode',
		'type'	=>	'checkbox',
		'required'	=>	false,
		'attribute_description'	=>	esc_html__( 'Enable Debug mode to see if data is processing correctly or not.', 'woo-one-click-upsell-funnel' ),
		'value'	=>	! empty( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_debug_mode' ] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config[ 'mwb_upsell_enable_debug_mode' ] ) ) : 'no',
	),
);

?>

<form action="" method="POST">
	<div class="mwb_upsell_table">
		<table class="form-table mwb_wocuf_pro_creation_setting">
			<tbody>

				<!-- Nonce field here. -->
				<?php wp_nonce_field( 'mwb_wocuf_pro_setting_nonce', 'mwb_wocuf_pro_nonce' ); ?>

				<?php if( ! empty( $google_analytics_fields ) && is_array( $google_analytics_fields ) ) : ?>
					<?php foreach ( $google_analytics_fields as $field_id => $field_data ) : ?>
						
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_html( $field_id ); ?>"><?php echo esc_html( $field_data[ 'label' ] ); ?></label>
							</th>

							<td class="forminp forminp-text">
								<?php echo wc_help_tip( $field_data[ 'attribute_description' ] ); ?>

								<?php if( 'text' == $field_data[ 'type' ] ) : ?>

									<input <?php echo( ! empty( $field_data[ 'required' ] ) ? esc_html( 'required' ) : '' ); ?> class="mwb_wocuf_pro_enable_plugin_input" type="text"  name="<?php echo esc_html( $field_data[ 'name' ] ); ?>" value="<?php echo esc_html( $field_data[ 'value' ] ); ?>" id="<?php echo esc_html( $field_id ); ?>">

								<?php else : ?>

									<label class="mwb_wocuf_pro_enable_plugin_label">
										<input <?php echo( ! empty( $field_data[ 'required' ] ) ? esc_html( 'required' ) : '' ); ?> class="mwb_wocuf_pro_enable_plugin_input" type="checkbox" name="<?php echo esc_html( $field_data[ 'name' ] ); ?>" id="<?php echo esc_html( $field_id ); ?>" <?php checked( 'yes', $field_data[ 'value' ] ); ?>>
										<span class="mwb_wocuf_pro_enable_plugin_span"></span>
									</label>

								<?php endif; ?>
							</td>
						</tr>

					<?php endforeach; ?>
				<?php endif; ?>
				
				<?php do_action( 'mwb_wocuf_pro_create_more_settings' ); ?>
			</tbody>
		</table>
	</div>

	<p class="submit">
	<input type="submit" value="<?php esc_html_e( 'Save Changes', 'woo-one-click-upsell-funnel' ); ?>" class="button-primary woocommerce-save-button" name="mwb_wocuf_pro_common_settings_save" id="mwb_wocuf_pro_creation_setting_save" >
	</p>
</form>