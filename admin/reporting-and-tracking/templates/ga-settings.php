<?php
/**
 * Provide a admin area view for the plugin
 *
 * Google Analytics Settings.
 *
 * @link       https://makewebbetter.com/
 * @since      3.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/admin/reporting-and-tracking/templates/
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

	$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options['facebook-pixel'] ) ? $mwb_upsell_analytics_options['facebook-pixel'] : array();

	$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options['google-analytics'] ) ? $mwb_upsell_analytics_options['google-analytics'] : array();


	// Handle Data is POST here.
	$mwb_upsell_ga_analytics_config = array(
		'ga_account_id' => ! empty( $_POST['ga_account_id'] ) ? sanitize_text_field( wp_unslash( $_POST['ga_account_id'] ) ) : '',
		'enable_ga_gst' => ! empty( $_POST['enable_ga_gst'] ) ? 'yes' : 'no',
		'enable_purchase_event' => ! empty( $_POST['enable_purchase_event'] ) ? 'yes' : 'no',
	);

	if ( ! empty( $mwb_upsell_fb_pixel_config ) || ! empty( $mwb_upsell_ga_analytics_config ) ) {

		$mwb_upsell_analytics_options = array(
			'facebook-pixel'    => $mwb_upsell_fb_pixel_config,
			'google-analytics'  => $mwb_upsell_ga_analytics_config,
		);

		// Save.
		update_option( 'mwb_upsell_analytics_configuration', $mwb_upsell_analytics_options );
	}

	?>

	<!-- Settings saved notice. -->
	<div class="notice notice-success is-dismissible"> 
		<p><strong><?php esc_html_e( 'Settings saved', 'woo-one-click-upsell-funnel' ); ?></strong></p>
	</div>
	<?php
}

$mwb_upsell_analytics_options = get_option( 'mwb_upsell_analytics_configuration', array() );

$mwb_upsell_fb_pixel_config = ! empty( $mwb_upsell_analytics_options['facebook-pixel'] ) ? $mwb_upsell_analytics_options['facebook-pixel'] : array();

$mwb_upsell_ga_analytics_config = ! empty( $mwb_upsell_analytics_options['google-analytics'] ) ? $mwb_upsell_analytics_options['google-analytics'] : array();

// Form Fields Mapping.
$google_analytics_fields = array(

	'mwb_wocuf_ga_account_id'   => array(
		'name'  => 'ga_account_id',
		'label' => 'Google Analytics ID',
		'type'  => 'text',
		'required'  => true,
		'attribute_description' => esc_html__( 'Log into your google analytics account to find your ID. eg: UA-XXXXXX-X', 'woo-one-click-upsell-funnel' ),
		'placeholder'   => esc_html__( 'UA-XXXXXX-X', 'woo-one-click-upsell-funnel' ),
		'value' => ! empty( $mwb_upsell_ga_analytics_config['ga_account_id'] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config['ga_account_id'] ) ) : '',
	),



	'mwb_wocuf_enable_basecode' => array(
		'name'  => 'enable_ga_gst',
		'label' => 'Enable Global Site Tag',
		'type'  => 'checkbox',
		'required'  => false,
		'attribute_description' => esc_html__( 'Add Global Site Tag \'gtag.js\' to your website', 'woo-one-click-upsell-funnel' ),
		'note'  => esc_html__( 'Only Enable this when you are not using any other Google analytics tracking on your website.', 'woo-one-click-upsell-funnel' ),
		'value' => ! empty( $mwb_upsell_ga_analytics_config['enable_ga_gst'] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config['enable_ga_gst'] ) ) : 'no',
	),

	'mwb_wocuf_enable_purchase_event'   => array(
		'name'  => 'enable_purchase_event',
		'label' => 'Enable Purchase Event',
		'type'  => 'checkbox',
		'required'  => false,
		'attribute_description' => esc_html__( 'This will trigger Google Analytics Purchase Event for Parent Order and for Upsells accordingly with respect to payment gateways.', 'woo-one-click-upsell-funnel' ),
		'note'  => esc_html__( 'Make sure you disable your Purchase event if you are using any other Google analytics tracking on your website else it will track data twice.', 'woo-one-click-upsell-funnel' ),
		'value' => ! empty( $mwb_upsell_ga_analytics_config['enable_purchase_event'] ) ? sanitize_text_field( wp_unslash( $mwb_upsell_ga_analytics_config['enable_purchase_event'] ) ) : 'no',
	),
);

?>

<!-- Other Tracking Plugins Compatibilities - Start -->
<div class="mwb_upsell_slide_down_title">
	<h2><?php esc_html_e( 'Other Tracking Plugins Compatibilities', 'woo-one-click-upsell-funnel' ); ?></h2>
	<a href="#" class="mwb_upsell_slide_down_link"><img src="<?php echo esc_url( MWB_WOCUF_URL . 'admin/resources/down.png' ); ?>"></a>
</div>

<div class="mwb_upsell_table mwb_upsell_slide_down_content">
	<table class="form-table mwb_wocuf_pro_creation_setting mwb_upsell_slide_down_table">
		<tbody>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><a target="_blank" href="https://wordpress.org/plugins/enhanced-e-commerce-for-woocommerce-store/"><?php esc_html_e( 'Enhanced Ecommerce Google Analytics Plugin for WooCommerce', 'woo-one-click-upsell-funnel' ); ?></a></label>
					<span class="mwb_upsell_other_plugin_author_name"><?php esc_html_e( 'By Tatvic', 'woo-one-click-upsell-funnel' ); ?></span>
				</th>
				<td class="forminp forminp-text">
					<span class="mwb_upsell_global_description">
						<?php esc_html_e( 'We have added inbuilt Compatibility with Enhanced Ecommerce Google Analytics plugin so it\'s Google Analytics Purchase Event will be automatically disabled as soon as you Enable Google Analytics Purchase Event by Upsell.', 'woo-one-click-upsell-funnel' ); ?>
					</span>		
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><a target="_blank" href="https://wordpress.org/plugins/pixelyoursite/"><?php esc_html_e( 'PixelYourSite', 'woo-one-click-upsell-funnel' ); ?></a></label>
					<label><a target="_blank" href="https://www.pixelyoursite.com/"><?php esc_html_e( 'PixelYourSite PRO', 'woo-one-click-upsell-funnel' ); ?></a></label>
					<span class="mwb_upsell_other_plugin_author_name light"><?php esc_html_e( 'By PixelYourSite', 'woo-one-click-upsell-funnel' ); ?></span>
				</th>
				<td class="forminp forminp-text">
					<span class="mwb_upsell_global_description">
						<?php
						printf(
							'%s <b>%s</b> %s <b>%s</b> %s <b>%s</b> %s <b>%s</b> %s <b>%s</b> %s <b>%s</b> %s <b>%s</b> %s',
							esc_html__( 'Please Go to', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Wordpress Admin Dashboard', 'woo-one-click-upsell-funnel' ),
							esc_html__( '>', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'PixelYourSite', 'woo-one-click-upsell-funnel' ),
							esc_html__( '>', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'WooCommerce tab', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Scroll down to', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Default E-Commerce events', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'and click on', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Track Purchases', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'settings icon and Toggle Off the', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Enable the purchase event on Google Analytics', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'and', 'woo-one-click-upsell-funnel' ),
							esc_html__( 'Save', 'woo-one-click-upsell-funnel' ),
							esc_html__( '.', 'woo-one-click-upsell-funnel' )
						);
						?>
					</span>		
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label><?php esc_html_e( 'Other Google Analytics Tracking Plugins', 'woo-one-click-upsell-funnel' ); ?></label>
				</th>
				<td class="forminp forminp-text">
					<span class="mwb_upsell_global_description">
						<?php esc_html_e( 'Please make sure to Disable the Purchase Event from your plugin\'s settings before you Enable Google Analytics Purchase Event by Upsell. If you can\'t find the settings or in case of any confusion please contact our support', 'woo-one-click-upsell-funnel' ); ?> <a target="_blank" href="https://makewebbetter.com/contact-us/"><?php esc_html_e( 'here', 'woo-one-click-upsell-funnel' ); ?></a><?php esc_html_e( '.', 'woo-one-click-upsell-funnel' ); ?>
					</span>		
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- Other Tracking Plugins Compatibilities - End -->

<form action="" method="POST">
	<div class="mwb_upsell_table">
		<table class="form-table mwb_wocuf_pro_creation_setting">
			<tbody>

				<!-- Nonce field here. -->
				<?php wp_nonce_field( 'mwb_wocuf_pro_setting_nonce', 'mwb_wocuf_pro_nonce' ); ?>

				<?php if ( ! empty( $google_analytics_fields ) && is_array( $google_analytics_fields ) ) : ?>
					<?php foreach ( $google_analytics_fields as $field_id => $field_data ) : ?>
						
						<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_html( $field_id ); ?>"><?php echo esc_html( $field_data['label'] ); ?></label>
							</th>

							<td class="forminp forminp-text">
								<?php echo wc_help_tip( $field_data['attribute_description'] ); ?>

								<?php if ( 'text' == $field_data['type'] ) : ?>

									<input <?php echo( ! empty( $field_data['required'] ) ? esc_html( 'required' ) : '' ); ?> class="mwb_wocuf_pro_enable_plugin_input" type="text"  name="<?php echo esc_html( $field_data['name'] ); ?>" value="<?php echo esc_html( $field_data['value'] ); ?>" id="<?php echo esc_html( $field_id ); ?>"
									placeholder="<?php echo ! empty( $field_data['placeholder'] ) ? esc_html( $field_data['placeholder'] ) : ''; ?>">

								<?php else : ?>

									<label class="mwb_wocuf_pro_enable_plugin_label">
										<input <?php echo( ! empty( $field_data['required'] ) ? esc_html( 'required' ) : '' ); ?> class="mwb_wocuf_pro_enable_plugin_input" type="checkbox" name="<?php echo esc_html( $field_data['name'] ); ?>" id="<?php echo esc_html( $field_id ); ?>" <?php checked( 'yes', $field_data['value'] ); ?>>
										<span class="mwb_wocuf_pro_enable_plugin_span"></span>
									</label>

								<?php endif; ?>

								<span class="mwb_upsell_global_description"><?php echo ! empty( $field_data['note'] ) ? esc_html( $field_data['note'] ) : ''; ?></span>
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
