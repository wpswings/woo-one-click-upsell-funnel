<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpswings.com
 * @since      1.0.0
 *
 * @package    woo_one_click_upsell_funnel
 * @subpackage woo_one_click_upsell_funnel/extra-templates
 */

?>
<?php

global $pagenow;
if ( empty( $pagenow ) || 'plugins.php' !== $pagenow ) {
	return false;
}

$form_fields = apply_filters( 'wps_deactivation_form_fields', array() );
?>
<?php if ( ! empty( $form_fields ) ) : ?>
	<div class="wps-onboarding-section-one-click-upsell">
		<div class="wps-on-boarding-wrapper-background">
		<div class="wps-on-boarding-wrapper">
			<div class="wps-on-boarding-close-btn">
				<a href="#">
					<span class="close-form">x</span>
				</a>
			</div>
			<h3 class="wps-on-boarding-heading"></h3>
			<p class="wps-on-boarding-desc"><?php esc_html_e( 'May we have a little info about why you are deactivating?', 'woo-one-click-upsell-funnel' ); ?></p>
			<form action="#" method="post" class="wps-on-boarding-form">
				<?php foreach ( $form_fields as $key => $field_attr ) : ?>
					<?php $this->render_field_html( $field_attr, 'deactivating' ); ?>
				<?php endforeach; ?>
				<div class="wps-on-boarding-form-btn__wrapper">
					<div class="wps-on-boarding-form-submit wps-on-boarding-form-verify ">
					<input type="submit" class="wps-on-boarding-submit wps-on-boarding-verify " value="Send Us">
				</div>
				<div class="wps-on-boarding-form-no_thanks">
					<a href="#" class="wps-deactivation-no_thanks"><?php esc_html_e( 'Skip and Deactivate Now', 'woo-one-click-upsell-funnel' ); ?></a>
				</div>
				</div>
			</form>
		</div>
	</div>
	</div>
<?php endif; ?>
