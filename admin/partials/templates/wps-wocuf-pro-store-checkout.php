<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link        https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-pro-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package    woocommerce-one-click-upsell-funnel-pro
 * @subpackage woocommerce-one-click-upsell-funnel-pro/admin/partials/templates
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



$billing_address_default = array(
	'billing-information' => array(
		'billing_first_name',  // First Name.
		'billing_last_name',   // Last Name.
		'billing_country',     // Country.
		'billing_address_1',   // Address Line 1.
		'billing_city',        // City.
		'billing_state',       // State.
		'billing_postcode',    // Postcode/ZIP.
		'billing_phone',       // Phone Number.
		'billing_email',        // Email Address.
	),
);

$default_basic_billing_field = array(
	'billing-basic-wrap-id' => array( 'billing_address_2', 'billing_company' ),
);
$default_basic_shipping_field = array(
	'shipping-basic-wrap-id' => array( 'shipping_address_2', 'shipping_company', 'shipping_phone' ),
);
$shipping_address_default = array(
	'shipping-information' => array(
		'shipping_first_name',  // First Name.
		'shipping_last_name',   // Last Name.
		'shipping_country',     // Country.
		'shipping_address_1',   // Address Line 1.
		'shipping_city',        // City.
		'shipping_state',       // State.
		'shipping_postcode',    // Postcode/ZIP.
		'shipping_email',        // Email Address.
	),
);


$billing_address_data = get_option( 'wps_wocuf_store_checkout_fields_billing_data', $billing_address_default );
$shipping_address_data = get_option( 'wps_wocuf_store_checkout_fields_shipping_data', $shipping_address_default );
$shipping_basic_address_data = get_option( 'wps_wocuf_store_checkout_basic_fields_shipping_data', $default_basic_shipping_field );
$billing_basic_address_data = get_option( 'wps_wocuf_store_checkout_basic_fields_billing_data', $default_basic_billing_field );

 wps_upsee_lite_go_pro( 'pro' );

?>
<input type='hidden' id='wps_ubo_pro_status' value='inactive'>
<main id="wps-ufw_main" class="wps-ufw_main wps-ufw_store-checkout">
	<h2 class="wps-ufw_main-h2">
		
		
	</h2>

	<?php
	$is_store_checkout_enabled = 'off';
	?>
	<table class="form-table wps_wocuf_pro_creation_setting" style="border:0 ! important;">
		<tbody>

			<!-- Enable Plugin start -->
			<tr valign="top">

				<th scope="row" class="titledesc">
				<span class="wps_wupsell_premium_strip">Pro</span>
					<label for="wps_wocuf_pro_enable_plugin_store_checkout"><?php esc_html_e( 'Enable Upsell Store Checkout', 'woo-one-click-upsell-funnel' ); ?></label>
				</th>

				<td class="forminp forminp-text">
					<?php
					$attribut_description = esc_html__( 'Enable store checkout functionality to use our custom checkout for upsell.', 'woo-one-click-upsell-funnel' );
					wps_upsell_lite_wc_help_tip( $attribut_description );
					?>

					<label class="wps_wocuf_pro_enable_plugin_label">
						<input class="wps_wocuf_pro_enable_plugin_input ubo_offer_input"  type="checkbox" <?php echo ( 'enabled' === $is_store_checkout_enabled ) ? esc_html( "checked='checked'" ) : ''; ?> name="wps_wocuf_pro_enable_plugin_store_checkout" id="wps_wocuf_pro_enable_plugin_store_checkout" >	
						<span class="wps_wocuf_pro_enable_plugin_span"></span>
					</label>
				</td>
			</tr>
		</tbody>
	</table>
			
	
	<section class="wps-ufw_m-sec">
		<article class="wps-ufw_ms-head wps-ufw_msh-check" id="wps-ufw_msh-check">
			<span class="wps-ufw_ms-btn-link"> <?php esc_html_e( 'Checkout', 'woo-one-click-upsell-funnel' ); ?></span>
			
			<main class="wps-ufw_ms-main">
				<header class="wps-ufw_msm-head">
				
					<span class="dashicons dashicons-arrow-left-alt"></span>  <?php esc_html_e( 'Checkout', 'woo-one-click-upsell-funnel' ); ?>
					<div class="wps-ufw_msmh-in">
						<span class="wps-ufw_pri-txt-btn wps-ufw_reset-confirmation ubo_offer_input"> <?php esc_html_e( 'Reset', 'woo-one-click-upsell-funnel' ); ?></span>
						<span class="wps-ufw_pri-btn wps-ufw_msmh-in-btn ubo_offer_input"> <?php esc_html_e( 'Save', 'woo-one-click-upsell-funnel' ); ?></span>
						<span class="wps-ufw_pri-btn-preview wps-ufw_msmh-in-btn-data ubo_offer_input"><a href="#" > <?php esc_html_e( 'Preview', 'woo-one-click-upsell-funnel' ); ?></a></span>
				
					</div>
					<div class="wps-ufw_confirmation"><?php esc_html_e( 'Saved!', 'woo-one-click-upsell-funnel' ); ?></div>
					<div class="wps-ufw_msms-head" id="wps-section-for-store-checkout">
						<h3></h3>
						
					</div>

				
				
				</header>
				<div class="notice-settings"> </div>
				
				<div class="wps_wocuf_tab">
	<button class="wps_wocuf_tablinks" onclick="openTab(event, 'Tab1')" id="defaultOpen"> <?php esc_html_e( 'Billing Information', 'woo-one-click-upsell-funnel' ); ?></button>
	<button class="wps_wocuf_tablinks" onclick="openTab(event, 'Tab2')"> <?php esc_html_e( 'Shipping Information', 'woo-one-click-upsell-funnel' ); ?></button>
	<button class="wps_wocuf_tablinks" onclick="openTab(event, 'Tab3')"> <?php esc_html_e( 'Other Settings', 'woo-one-click-upsell-funnel' ); ?></button>
	<button class="wps_wocuf_tablinks" onclick="openTab(event, 'Tab4')"> <?php esc_html_e( 'Payment Gateway', 'woo-one-click-upsell-funnel' ); ?></button>
</div>

		<div id="Tab1" class="wps_wocuf_tabcontent">


				<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item billing-information-wrap" data-id="10">
							
							<div class="wps-ufw_msmsmli-title" id="billing-information-wrap-editable" data-id="10" contenteditable="true">  <?php esc_html_e( 'Billing Information', 'woo-one-click-upsell-funnel' ); ?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="billing-information-wrap-id">
								<?php

								foreach ( $billing_address_data as $key => $values ) {

									if ( is_array( $values ) && ! empty( $values ) ) {
										foreach ( $values as $value ) {
											echo '<span class="wps-ufw_msmsmr-item ' . esc_html( $value ) . '" data-id="' . esc_html( $value ) . '">' . esc_html( ucwords( str_replace( '-', ' ', $value ) ) ) . '</span>';
										}
									}
								}


								?>
								
								
							</div>
						</div>
							
						</article>
						<article class="wps-ufw_msmsm wps-ufw_msmsm-right">
							<h4 class="wps-ufw_msmsmr-head"><?php esc_html_e( 'Billing Fields', 'woo-one-click-upsell-funnel' ); ?></h4>
							<div class="wps-ufw_msmsmli-wrap wps-ufw_msmsmr-wrap billing-basic-wrap ubo_offer_input" id="billing-basic-wrap-id">
							<?php

							foreach ( $billing_basic_address_data as $key => $values ) {

								if ( is_array( $values ) && ! empty( $values ) ) {
									foreach ( $values as $value ) {
										echo '<span class="wps-ufw_msmsmr-item ' . esc_html( $value ) . '" data-id="' . esc_html( $value ) . '">' . esc_html( ucwords( str_replace( '-', ' ', $value ) ) ) . '</span>';
									}
								}
							}


							?>
						
							</div>
						</article>
					</div>
					<div class="wps-ufw_msms-foot">
					</div>
				</section>
  
		</div>

		<div id="Tab2" class="wps_wocuf_tabcontent">
		
			<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item shipping-information-wrap" data-id="10">
							
							<div class="wps-ufw_msmsmli-title" id="shipping-information-wrap-editable" data-id="10" contenteditable="true"> <?php esc_html_e( 'Shipping Information', 'woo-one-click-upsell-funnel' ); ?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="shipping-information-wrap-id">
								<?php

								foreach ( $shipping_address_data as $key => $values ) {

									if ( is_array( $values ) && ! empty( $values ) ) {
										foreach ( $values as $value ) {
											echo '<span class="wps-ufw_msmsmr-item ' . esc_html( $value ) . '" data-id="' . esc_html( $value ) . '">' . esc_html( ucwords( str_replace( '-', ' ', $value ) ) ) . '</span>';
										}
									}
								}


								?>
								
								
							</div>
						</div>
							
						</article>
						<article class="wps-ufw_msmsm wps-ufw_msmsm-right">
							<h4 class="wps-ufw_msmsmr-head"><?php esc_html_e( 'Shipping Fields', 'woo-one-click-upsell-funnel' ); ?></h4>
							<div class="wps-ufw_msmsmli-wrap wps-ufw_msmsmr-wrap shipping-basic-wrap ubo_offer_input" id="shipping-basic-wrap-id">
							<?php

							foreach ( $shipping_basic_address_data as $key => $values ) {

								if ( is_array( $values ) && ! empty( $values ) ) {
									foreach ( $values as $value ) {
										echo '<span class="wps-ufw_msmsmr-item ' . esc_html( $value ) . '" data-id="' . esc_html( $value ) . '">' . esc_html( ucwords( str_replace( '-', ' ', $value ) ) ) . '</span>';
									}
								}
							}
							?>
							
								
							</div>
						</article>
					</div>
					<div class="wps-ufw_msms-foot">
					</div>
				</section>
		</div>
		<?php

			$checkbox_enabled_order_note = false;
			$checkbox_enabled_coupon_code = false;


		?>
		<div id="Tab3" class="wps_wocuf_tabcontent">
			<h3>
			<?php esc_html_e( 'Other Setting For Checkout Page', 'woo-one-click-upsell-funnel' ); ?>
			</h3>
			<p>
			<label>
				<input type="checkbox" class="ubo_offer_input" name="coupon_field_checkout" id="coupon_field_checkout" value="1" <?php echo '1' === $checkbox_enabled_coupon_code ? 'checked' : ''; ?>>
			
				<?php esc_html_e( 'Disable Coupon on Checkout page', 'woo-one-click-upsell-funnel' ); ?>
			</label>
			</p>
			<p>
			<label>
				<input type="checkbox"  class="ubo_offer_input" name="order_note_checkout" id="order_note_checkout" value="1" <?php echo '1' === $checkbox_enabled_order_note ? 'checked' : ''; ?>>
			
				<?php esc_html_e( 'Disable Order Note on Checkout page', 'woo-one-click-upsell-funnel' ); ?>
			</label>
								</p>
		</div>

<div id="Tab4" class="wps_wocuf_tabcontent">
 
	<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item payment-gateway-wrap" data-id="10">
							
							<div class="wps-ufw_msmsmli-title" id="payment-gateway-wrap-editable" data-id="10" contenteditable="true"><?php	esc_html_e( 'Payment Gateway', 'woo-one-click-upsell-funnel' ); ?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="payment-gateway-wrap-id">
								
							<?php	esc_html_e( 'Note: Payment Information containing gateways will be automatically added to the end of order form.', 'woo-one-click-upsell-funnel' ); ?>
							</div>
						</div>
							
						</article>
						
					</div>
					<div class="wps-ufw_msms-foot">
					</div>
				</section>
</div>



				
			</main>
		</article>
		<article class="wps-ufw_ms-head wps-ufw_msh-thanks" id="wps-ufw_msh-thanks">
			<span class="wps-ufw_ms-btn-link"><?php esc_html_e( 'ThankYou', 'woo-one-click-upsell-funnel' ); ?></span>

			<main class="wps-ufw_ms-main">
				<header class="wps-ufw_msm-head">
					<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e( 'ThankYou', 'woo-one-click-upsell-funnel' ); ?>
					<div class="wps-ufw_msmh-in">
						<span class="wps-ufw_pri-txt-btn wps-ufw_thanks-reset-confirmation ubo_offer_input"><?php esc_html_e( 'Reset', 'woo-one-click-upsell-funnel' ); ?></span>
						<span class="wps-ufw_pri-btn wps-ufw_msmhthy-in-btn ubo_offer_input"><?php esc_html_e( 'Save', 'woo-one-click-upsell-funnel' ); ?></span>
					</div>
					<div class="wps-ufw_confirmation">Saved!</div>
				</header>
				<section class="wps-ufw_msm-sec">
					<div class="wps-ufw_msms-head">
						

						<?php
							$wps_wocuf_content_before_order_details = '';
							$wps_wocuf_content_page_header_title = '';
							$wps_wocuf_content_after_order_details = '';
							$wps_wocuf_content_billing_and_shipping = '';
						?>
						
					</div>
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<h3 class="wps-ufw_msmsmt-title"><?php esc_html_e( 'Modify Content Thank You Page ', 'woo-one-click-upsell-funnel' ); ?> </h3>
						<section class="wps-ufw_msmsmt-sec">
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e( 'Modify Thank You Page Header Text', 'woo-one-click-upsell-funnel' ); ?></label>
								<input type="text" class="ubo_offer_input" id="wps_wocuf_content_page_header_title" name="wps_wocuf_content_page_header_title"  value="<?php esc_attr_e( 'Thank you. Your order has been received.', 'woo-one-click-upsell-funnel' ); ?>" />
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"> <?php esc_html_e( 'Add Content Before Order Details', 'woo-one-click-upsell-funnel' ); ?></label>
								<textarea id="wps_wocuf_content_before_order_details" class="ubo_offer_input" name="wps_wocuf_content_before_order_details" rows="4" cols="50" placeholder="Enter your text here..." ></textarea>
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e( 'Add Content After Order Details', 'woo-one-click-upsell-funnel' ); ?></label>
								<textarea id="wps_wocuf_content_after_order_details" class="ubo_offer_input" name="wps_wocuf_content_after_order_details" rows="4" cols="50" placeholder="Enter your text here..." ></textarea>
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e( 'Add Content After Billing or Shipping Address', 'woo-one-click-upsell-funnel' ); ?></label>
								<textarea id="wps_wocuf_content_billing_and_shipping" class="ubo_offer_input" name="wps_wocuf_content_billing_and_shipping" rows="4" cols="50" placeholder="Enter your text here..."></textarea>
							</article>
						</section>
					</div>
					<div class="wps-ufw_msms-foot">
					</div>
				</section>
			</main>
		</article>
	</section>
</main>
<?php
