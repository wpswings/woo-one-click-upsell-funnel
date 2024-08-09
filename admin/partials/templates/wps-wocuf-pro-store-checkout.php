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
if (!defined('ABSPATH')) {
	exit;
}

?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
	#wps-ufw_main *:focus {
		outline: none;
		box-shadow: none;
	}

	.wps-ufw_sc-body .wps-notice-wrapper {
		display: none;
	}

	#wps-ufw_main .wps-ufw_main-h2 {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 10px;
	}

	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-text {
		font-size: 18px;
		font-weight: 600;
	}

	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-buttons {
		display: flex;
		align-items: center;
		gap: 10px;
	}

	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-buttons>a,
	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-buttons .wps-ufw_btn-act-main {
		text-decoration: none;
		font-size: 14px;
		display: inline-block;
		padding: 8px 15px;
		background: #2196f3;
		color: #fff;
		border-radius: 5px;
		cursor: pointer;
		border: 1px solid;
	}

	#wps-ufw_main .wps-ufw_mh-buttons>a:hover {
		background: #1079cc;
	}

	.wps-ufw_btn-act-desc {
		display: flex;
		flex-direction: column;
		position: absolute;
		top: calc(100% + 10px);
		left: 0;
		right: 0;
		border: 1px solid #e2e2e2;
		border-radius: 5px;
		background: #fff;
		padding: 5px 0;
		visibility: hidden;
		height: 0;
		z-index: -999;
	}

	.wps-ufw_btn-act-desc.wps-ufw_btn-active {
		visibility: visible;
		height: auto;
		z-index: 999;
	}

	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-buttons .wps-ufw_btn-act-main {
		background: #f4f4f4;
		color: #000;
		padding-right: 32px;
		border: 1px solid #e2e2e2;
		position: relative;
	}

	#wps-ufw_main .wps-ufw_main-h2 .wps-ufw_mh-buttons .wps-ufw_btn-act-main:after {
		content: "\f347";
		font-family: dashicons;
		position: absolute;
		right: 10px;
		font-size: 16px;
		top: 9px;
	}

	.wps-ufw_btn-act-main.wps-ufw_btn-active:after {
		transform: rotate(180deg);
	}

	.wps-ufw_mh-but.wps-ufw_btn-act {
		position: relative;
	}

	#wps-ufw_main .wps-ufw_btn-act-desc span {
		padding: 5px 10px;
		cursor: pointer;
		font-size: 14px;
	}

	#wps-ufw_main .wps-ufw_btn-act-desc span:hover {
		color: #2196f3;
	}

	/* Popup css start */
	#wps-ufw_btn-act-desc-pop {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 99999;
	}

	.wps-ufw_btn-act-desc-pop--shadow {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0, 0, 0, 0.5);
	}

	.wps-ufw_btn-act-desc-pop-in {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 1;
		background: #fff;
		padding: 15px;
		border-radius: 5px;
		max-width: 460px;
		width: calc(100% - 30px);
	}

	#wps-ufw_btn-act-desc-pop .wps-ufw_adp-head {
		font-size: 18px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 0 15px;
	}

	#wps-ufw_btn-act-desc-pop .wps-ufw_adp-head .dashicons {
		font-size: 20px;
		cursor: pointer;
	}

	.wps-ufw_adp-main {
		display: flex;
		flex-direction: column;
		gap: 15px;
		max-height: 150px;
		overflow-y: auto;
		margin: 0 0 20px;
	}

	.wps-ufw_adp-main::-webkit-scrollbar {
		width: 5px;
	}

	.wps-ufw_adp-main::-webkit-scrollbar-track {
		background: #f1f1f1;
	}

	.wps-ufw_adp-main::-webkit-scrollbar-thumb {
		background: #2196f3;
	}

	.wps-ufw_adp-main::-webkit-scrollbar-thumb:hover {
		background: #2196f355;
	}

	.wps-ufw_adp-main input[type=text],
	.wps-ufw_adp-main textarea,
	.wps-ufw_adp-main select,
	.wps-ufw_msmsmts-art input[type=text] {
		width: calc(100% - 2px);
		max-width: 100%;
		min-height: 40px;
		font-weight: 400;
		border: 1px solid #e2e2e2;
		box-shadow: none;
		padding: 5px;
	}

	.wps-ufw_adp-main textarea {
		min-height: 100px;
	}

	.wps-ufw_adp-main *::placeholder {
		color: #bcbcbc;
	}

	.wps-ufw_adp-foot {
		display: flex;
		align-items: center;
		justify-content: flex-end;
		gap: 10px;
	}

	.wps-ufw_adpf-btn {
		padding: 5px 10px;
		border-radius: 5px;
		color: #4d4d4d;
		cursor: pointer;
	}

	.wps-ufw_adpf-btn.wps-ufw_adpf-update {
		color: #fff;
		background: #2196f3;
		border-color: #2196f3;
	}

	.wps-ufw_adp-main input[type="text"]:focus,
	.wps-ufw_adp-main textarea:focus,
	.wps-ufw_adp-main select:focus,
	#wps-ufw_main .wps-ufw_msmsh-input input[type=text]:focus,
	.wps-ufw_msmsmts-art input[type=text]:focus {
		border-color: #2196f3;
		outline: none;
		box-shadow: none;
	}

	/* Popup css end */

	/* Notice start */
	.wps-ufw_m-notice {
		padding: 5px 5px 5px 32px;
		background: #fff5f5;
		border-radius: 5px;
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 10px;
		position: relative;
		align-items: center;
		margin: 0 0 15px;
	}

	.wps-ufw_m-notice:before {
		content: "\f14c";
		position: absolute;
		left: 8px;
		font-family: dashicons;
		color: #ff7577;
		font-size: 16px;
		top: 50%;
		transform: translate(0, -50%);
	}

	.wps-ufw_m-notice a {
		background: #ff7577;
		display: inline-block;
		padding: 5px 10px;
		border-radius: 5px;
		text-decoration: none;
		color: #fff;
	}

	.wps-ufw_m-notice a:hover {
		background: #fe5557;
	}


	.wps-ufw_m-notice-enabled {
		padding: 5px 5px 5px 32px;
		background: #f6fff5;
		border-radius: 5px;
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
		gap: 10px;
		position: relative;
		align-items: center;
		margin: 0 0 15px;
	}

	.wps-ufw_m-notice-enabled:before {
		content: "\f14c";
		position: absolute;
		left: 8px;
		font-family: dashicons;
		color: #75ff75;
		font-size: 16px;
		top: 50%;
		transform: translate(0, -50%);
	}

	.wps-ufw_m-notice-enabled a {
		background: #0b5214;
		display: inline-block;
		padding: 5px 10px;
		border-radius: 5px;
		text-decoration: none;
		color: #fff;
	}

	.wps-ufw_m-notice-enabled a:hover {
		background: #0b5214;
	}

	/* Notice end */

	/* Checkout and thank tabs start */

	#wps-ufw_main {
		position: relative;
	}

	.wps-ufw_ms-head {
		display: flex;
		justify-content: space-between;
		gap: 10px;
		padding: 8px;
		border: 1px solid #e2e2e2;
		border-radius: 5px;
		margin: 0 0 15px;
	}

	.wps-ufw_ms-buttons {
		display: flex;
		gap: 10px;
		align-items: center;
	}

	.wps-ufw_ms-but.wps-ufw_btn-ms {
		position: relative;
	}

	.wps-ufw_btn-ms-desc {
		position: absolute;
		background: #fff;
		padding: 5px 0;
		display: flex;
		flex-direction: column;
		right: 0;
		margin: 15px 0 0;
		border: 1px solid #e2e2e2;
		border-radius: 5px;
		height: 0;
		visibility: hidden;
		z-index: -999;
	}

	.wps-ufw_btn-ms-desc.wps-ufw_btn-active {
		height: auto;
		visibility: visible;
		z-index: 999;
	}

	.wps-ufw_ms-buttons .dashicons {
		transform: rotate(90deg);
		cursor: pointer;
	}

	.wps-ufw_btn-ms-desc span {
		padding: 5px 10px 5px 10px;
		display: inline-block;
		cursor: pointer;
	}

	.wps-ufw_btn-ms-desc span:hover {
		color: #2196f3;
	}

	.wps-ufw_ms-head .wps-ufw_ms-btn-link {
		color: #2196f3;
		cursor: pointer;
	}

	.wps-ufw_ms-head a.wps-ufw_ms-but.wps-ufw_btn-con {
		text-decoration: none;
		color: #707070;
		position: relative;
	}

	.wps-ufw_ms-head a.wps-ufw_ms-but.wps-ufw_btn-con:before {
		content: "\f177";
		font-family: dashicons;
		vertical-align: bottom;
		margin-right: 5px;
		font-size: 16px;
	}

	.wps-ufw_ms-head a.wps-ufw_ms-but.wps-ufw_btn-con:hover {
		color: #2196f3;
	}

	.wps-ufw_ms-head .wps-ufw_ms-btn-link:hover {
		color: #1079cc;
	}

	main.wps-ufw_ms-main {
		display: none;
		position: absolute;
		top: 0;
		left: -20px;
		right: -20px;
		background: #fff;
		padding: 0 20px 20px;
		z-index: 1;
	}

	#wps-ufw_main .wps-ufw_msm-head>.dashicons-arrow-left-alt {
		font-size: 20px;
		display: inline-block;
		cursor: pointer;
	}

	#wps-ufw_main .wps-ufw_msm-head {
		display: flex;
		font-size: 18px;
		font-weight: 600;
		align-items: center;
		gap: 10px;
		margin: 0 0 20px;
	}

	.wps-ufw_msmh-in {
		flex: 1;
		text-align: right;
	}

	.wps-ufw_pri-btn {
		text-decoration: none;
		font-size: 16px;
		color: #fff;
		font-weight: 400;
		display: inline-block;
		padding: 8px 15px;
		background: #2196f3;
		border-radius: 5px;
		cursor: pointer;
	}

	.wps-ufw_pri-btn:hover {
		background: #1079cc;
	}

	#wps-ufw_main .wps-ufw_pri-txt-btn {
		display: inline-block;
		font-size: 14px;
		font-weight: 600;
		margin-right: 10px;
		color: #c8c8c8;
		cursor: pointer;
		letter-spacing: 0.4px;
	}

	#wps-ufw_main .wps-ufw_pri-txt-btn:hover,
	.wps-ufw_msmsml-item .dashicons-trash:hover {
		color: #d63638;
	}

	.wps-ufw_msms-head {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 10px;
		justify-content: space-between;
	}

	#wps-ufw_main .wps-ufw_msms-head h3 {
		margin: 0;
		font-size: 32px;
		font-weight: 600;
		color: #c8c8c8;
		letter-spacing: 0.5px;
		line-height: 1.25;
	}

	#wps-ufw_main .wps-ufw_msmsh-input {
		display: flex;
		flex-direction: column;
		gap: 5px;
		max-width: 650px;
		width: 100%;
		align-items: flex-end;
	}

	#wps-ufw_main .wps-ufw_msmsh-input label {
		font-size: 14px;
		font-weight: 600;
	}

	#wps-ufw_main .wps-ufw_msmsh-input input[type=text] {
		width: 100%;
		padding: 5px;
		min-height: 35px;
		line-height: 1.25;
		border: 1px solid #e2e2e2;
	}

	.wps-ufw_msms-main {
		border: 1px solid #e2e2e2;
		margin: 25px 0 0;
		border-radius: 5px;
		display: grid;
		grid-template-columns: 1fr 30%;
	}

	.wps-ufw_msmsm {
		flex: 1;
		padding: 15px;
	}

	.wps-ufw_msmsm.wps-ufw_msmsm-left {
		flex: 0 0 70%;
		border-radius: 3px;
		border-right: 1px solid #e2e2e2;
		padding-bottom: 0;
	}

	#wps-ufw_msms-main .wps-ufw_msmsmli-title {
		font-size: 14px;
		font-weight: 600;
		padding: 5px;
		line-height: 1.5;
		display: inline-block;
		position: relative;
		cursor: default;
	}

	#wps-ufw_msms-main .wps-ufw_msmsmr-head {
		margin: 0;
		font-size: 18px;
		line-height: 1.25;
		padding: 0 0 10px;
		border-bottom: 1px dashed #e2e2e2;
	}

	#wps-ufw_msms-main .wps-ufw_msmsmr-title {
		font-size: 14px;
		padding: 15px 0 10px;
		font-weight: 600;
		line-height: 1.5;
	}

	#wps-ufw_msms-main .wps-ufw_msmsmr-item {
		padding: 5px 10px;
		border: 1px solid #e2e2e2;
		border-radius: 3px;
		cursor: grabbing;
		display: inline-block;
		font-size: 12px;
	}

	.wps-ufw_msmsmr-wrap {
		display: flex;
		gap: 6px;
		flex-wrap: wrap;
	}

	.wps-ufw_msmsml-item {
		border: 1px solid #e2e2e2;
		border-radius: 3px;
		position: relative;
		margin: 0 0 15px;
	}

	.wps-ufw_msmsml-item .dashicons-trash {
		position: absolute;
		top: 5px;
		right: 5px;
		cursor: pointer;
		color: #dbdbdb;
	}

	.wps-ufw_msmsmli-wrap {
		padding: 10px;
		display: flex;
		flex-wrap: wrap;
		gap: 6px;
		border-top: 1px solid #e2e2e2;
		min-height: 52px;
	}

	.wps-ufw_msmsmli-wrap.wps-ufw_msmsmr-wrap {
		border: 1px dashed #e2e2e2;
	}

	#wps-ufw_msms-main .wps-ufw_msmsmli-title:after {
		content: "\f540";
		font-family: dashicons;
		font-size: 14px;
		vertical-align: middle;
		margin: 0 0 0 5px;
		cursor: pointer;
		color: #dbdbdb;
	}

	.wps-ufw_msm-head .wps-ufw_confirmation {
		display: none;
		font-size: 18px;
		font-weight: 400;
		background: rgba(255,255,255,0.9);
		padding: 80px 20px;
		max-width: 400px;
		width: 95%;
		text-align: center;
		border-radius:5px;
		border: 2px solid #2196f3;
		color: #2196f3;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%,-50%);
		letter-spacing: 0.4px;
		z-index: 9;
	}

	.wps-ufw_sc-body #wpfooter {
		display: none;
	}

	.wps-ufw_msmsml-item.last-left-item .dashicons-trash {
		cursor: not-allowed;
		color: #f4f4f4 !important;
	}

	#wps-ufw_main h3.wps-ufw_msmsmt-title {
		margin: 0;
	}

	.wps-ufw_msh-thanks .wps-ufw_msms-main {
		display: block;
		padding: 15px;
	}

	.wps-ufw_msmsmt-sec {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		gap: 15px;
		margin: 15px 0 0;
	}

	.wps-ufw_msmsmts-art {
		display: flex;
		flex-direction: column;
		gap: 5px;
	}

	.wps-ufw_msmsmts-art label {
		font-weight: 600;
	}

	@media only screen and (max-width: 768px) {
		.wps-ufw_msms-main {
			display: flex;
			flex-direction: column-reverse;
		}

		.wps-ufw_msmsm.wps-ufw_msmsm-left {
			border: none;
		}

		#wps-ufw_main .wps-ufw_msm-head>.dashicons-arrow-left-alt {
			font-size: 20px !important;
		}

		#wps-ufw_main .wps-ufw_msmsh-input {
			max-width: 766px;
		}

		.wps-ufw_msmsmt-sec {
			grid-template-columns: 1fr 1fr;
		}
	}

	@media only screen and (max-width: 620px) {

		.wps-ufw_msmsmt-sec {
			grid-template-columns: 1fr;
		}
	}


	.wps-ufw_msmsm-right .wps-ufw_msmsmr-wrap {
    height: calc(100% - 35px);
    display: block;
}

.wps-ufw_msmsm-right .wps-ufw_msmsmr-wrap span {
    margin: 0 6px 6px 0;
}

.tab {
            overflow: hidden;
            border-bottom: 1px solid #ccc;
        }

        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 16px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .tabcontent.show {
            display: block;
        }

	/* Checkout and thank tabs end */

</style>


<?php

$billing_address_default = [
    "billing-information" => [
        'billing_first_name',  // First Name
        'billing_last_name',   // Last Name
       // 'billing_company',     // Company Name
        'billing_country',     // Country
        'billing_address_1',   // Address Line 1
       // 'billing_address_2',   // Address Line 2
        'billing_city',        // City
        'billing_state',       // State
        'billing_postcode',    // Postcode/ZIP
        'billing_phone',       // Phone Number
        'billing_email'        // Email Address
    ]
];

$default_basic_billing_field = array(
	"billing-basic-wrap-id" => array("billing_address_2","billing_company"),
);
$default_basic_shipping_field = array(
	"shipping-basic-wrap-id" => array("shipping_address_2","shipping_company","shipping_phone"),
);
$shipping_address_default = [
    "shipping-information" => [
        'shipping_first_name',  // First Name
        'shipping_last_name',   // Last Name
       // 'shipping_company',     // Company Name
        'shipping_country',     // Country
        'shipping_address_1',   // Address Line 1
       // 'shipping_address_2',   // Address Line 2
        'shipping_city',        // City
        'shipping_state',       // State
        'shipping_postcode',    // Postcode/ZIP
      //  'shipping_phone',       // Phone Number (if used)
        'shipping_email'        // Email Address (if used)
    ]
];






$billing_address_data = get_option('wps_wocuf_store_checkout_fields_billing_data',$billing_address_default);
$shipping_address_data = get_option('wps_wocuf_store_checkout_fields_shipping_data',$shipping_address_default);
$shipping_basic_address_data = get_option('wps_wocuf_store_checkout_basic_fields_shipping_data',$default_basic_shipping_field);
$billing_basic_address_data = get_option('wps_wocuf_store_checkout_basic_fields_billing_data',$default_basic_billing_field);

 wps_upsee_lite_go_pro( 'pro' ); 

?>
<input type='hidden' id='wps_ubo_pro_status' value='inactive'>
<main id="wps-ufw_main" class="wps-ufw_main wps-ufw_store-checkout">
	<h2 class="wps-ufw_main-h2">
		<span class="wps-ufw_mh-text"><?php esc_html_e('Pages', 'wallet-system-for-woocommerce'); ?></span>
		
	</h2>

		
				<div class="wps-ufw_m-notice">
				&nbsp;&nbsp;&nbsp;	<?php esc_html_e('Store Checkout is currently disabled. Click Enable to override the current checkout of this store.', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
				<span class="wps_wupsell_premium_strip"><?php esc_html_e( 'Pro', 'woo-one-click-upsell-funnel' ); ?></span>
					<a href="#" id="wps_store_checkout_enabled" class="ubo_offer_input" ><?php esc_html_e('Enable', 'one-click-upsell-funnel-for-woocommerce-pro' );?></a>
				</div>
			
	
	<section class="wps-ufw_m-sec">
		<article class="wps-ufw_ms-head wps-ufw_msh-check" id="wps-ufw_msh-check">
			<span class="wps-ufw_ms-btn-link"> <?php esc_html_e('Checkout', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
			<div class="wps-ufw_ms-buttons">
				
				<a href="#" class="wps-ufw_ms-but wps-ufw_btn-con ubo_offer_input"><?php esc_html_e('Preview', 'one-click-upsell-funnel-for-woocommerce-pro' );?></a>
				
			</div>
			<main class="wps-ufw_ms-main">
				<header class="wps-ufw_msm-head">
				
					<span class="dashicons dashicons-arrow-left-alt"></span>  <?php esc_html_e('Checkout', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
					<div class="wps-ufw_msmh-in">
						<span class="wps-ufw_pri-txt-btn wps-ufw_reset-confirmation ubo_offer_input"> <?php esc_html_e('Reset', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
						<span class="wps-ufw_pri-btn wps-ufw_msmh-in-btn ubo_offer_input"> <?php esc_html_e('Save', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
					</div>
					<div class="wps-ufw_confirmation"><?php esc_html_e('Saved!', 'one-click-upsell-funnel-for-woocommerce-pro' );?></div>
					<div class="wps-ufw_msms-head" id="wps-section-for-store-checkout">
						<h3></h3>
						
					</div>

				
				
				</header>
				<div class="notice-settings"> </div>
				
				<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'Tab1')" id="defaultOpen"> <?php esc_html_e('Billing Information', 'one-click-upsell-funnel-for-woocommerce-pro' );?></button>
    <button class="tablinks" onclick="openTab(event, 'Tab2')"> <?php esc_html_e('Shipping Information', 'one-click-upsell-funnel-for-woocommerce-pro' );?></button>
    <button class="tablinks" onclick="openTab(event, 'Tab3')"> <?php esc_html_e('Other Settings', 'one-click-upsell-funnel-for-woocommerce-pro' );?></button>
    <button class="tablinks" onclick="openTab(event, 'Tab4')"> <?php esc_html_e('Payment Gateway', 'one-click-upsell-funnel-for-woocommerce-pro' );?></button>
</div>

		<div id="Tab1" class="tabcontent">


				<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item billing-information-wrap" data-id="10">
							<span class="dashicons dashicons-trash">

							</span>
							<div class="wps-ufw_msmsmli-title" id="billing-information-wrap-editable" data-id="10" contenteditable="true">  <?php esc_html_e('Billing Information', 'one-click-upsell-funnel-for-woocommerce-pro' );?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="billing-information-wrap-id">
								<?php
							
							foreach ($billing_address_data as $key => $values) {
							
								if (is_array($values) && !empty($values)) {
									foreach ($values as $value) {
										echo '<span class="wps-ufw_msmsmr-item ' . $value . '" data-id="' . $value . '">' . ucwords(str_replace('-', ' ', $value)) . '</span>';
									}
								}else {
									echo '<span class="wps-ufw_msmsmr-item" data-id="' . $key . '-empty">No Data Available</span>';
								}
							
							}
							
							
							?>
								
								
							</div>
						</div>
							
						</article>
						<article class="wps-ufw_msmsm wps-ufw_msmsm-right">
							<h4 class="wps-ufw_msmsmr-head"><?php esc_html_e('Billing Fields', 'one-click-upsell-funnel-for-woocommerce-pro' );?></h4>
							<div class="wps-ufw_msmsmli-wrap wps-ufw_msmsmr-wrap billing-basic-wrap ubo_offer_input" id="billing-basic-wrap-id">
							<?php
							
							foreach ($billing_basic_address_data as $key => $values) {
								
								if (is_array($values) && !empty($values)) {
									foreach ($values as $value) {
										echo '<span class="wps-ufw_msmsmr-item ' . $value . '" data-id="' . $value . '">' . ucwords(str_replace('-', ' ', $value)) . '</span>';
									}
								}else {
									echo '<span class="wps-ufw_msmsmr-item" data-id="' . $key . '-empty">No Data Available</span>';
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

		<div id="Tab2" class="tabcontent">
		
			<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item shipping-information-wrap" data-id="10">
							<span class="dashicons dashicons-trash">

							</span>
							<div class="wps-ufw_msmsmli-title" id="shipping-information-wrap-editable" data-id="10" contenteditable="true"> <?php esc_html_e('Shipping Information', 'one-click-upsell-funnel-for-woocommerce-pro' );?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="shipping-information-wrap-id">
								<?php
							
							foreach ($shipping_address_data as $key => $values) {
								
								if (is_array($values) && !empty($values)) {
									foreach ($values as $value) {
										echo '<span class="wps-ufw_msmsmr-item ' . $value . '" data-id="' . $value . '">' . ucwords(str_replace('-', ' ', $value)) . '</span>';
									}
								}else {
									echo '<span class="wps-ufw_msmsmr-item" data-id="' . $key . '-empty">No Data Available</span>';
								}
							
							}
							
							
							?>
								
								
							</div>
						</div>
							
						</article>
						<article class="wps-ufw_msmsm wps-ufw_msmsm-right">
							<h4 class="wps-ufw_msmsmr-head"><?php esc_html_e('Shipping Fields', 'one-click-upsell-funnel-for-woocommerce-pro' );?></h4>
							<div class="wps-ufw_msmsmli-wrap wps-ufw_msmsmr-wrap shipping-basic-wrap ubo_offer_input" id="shipping-basic-wrap-id">
							<?php
							
							foreach ($shipping_basic_address_data as $key => $values) {
								
								if (is_array($values) && !empty($values)) {
									foreach ($values as $value) {
										echo '<span class="wps-ufw_msmsmr-item ' . $value . '" data-id="' . $value . '">' . ucwords(str_replace('-', ' ', $value)) . '</span>';
									}
								}else {
									echo '<span class="wps-ufw_msmsmr-item" data-id="' . $key . '-empty">No Data Available</span>';
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
			$checkbox_enabled_coupon_code = 	false;
			

		?>
		<div id="Tab3" class="tabcontent">
			<h3>
			<?php esc_html_e('Other Setting For Checkout Page', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
			</h3>
			<p>
			<label>
				<input type="checkbox" class="ubo_offer_input" name="coupon_field_checkout" id="coupon_field_checkout" value="1" <?php echo $checkbox_enabled_coupon_code === '1' ? 'checked' : ''; ?>>
			
				<?php esc_html_e('Disable Coupon on Checkout page', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
			</label>
			</p>
			<p>
			<label>
				<input type="checkbox"  class="ubo_offer_input" name="order_note_checkout" id="order_note_checkout" value="1" <?php echo $checkbox_enabled_order_note === '1' ? 'checked' : ''; ?>>
			
				<?php esc_html_e('Disable Order Note on Checkout page', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
			</label>
								</p>
		</div>

<div id="Tab4" class="tabcontent">
    <h3>Tab 4</h3>
	<section class="wps-ufw_msm-sec">
					
					<div class="wps-ufw_msms-main" id="wps-ufw_msms-main">
						<article class="wps-ufw_msmsm wps-ufw_msmsm-left">
						<div class="wps-ufw_msmsml-item payment-gateway-wrap" data-id="10">
							<span class="dashicons dashicons-trash">

							</span>
							<div class="wps-ufw_msmsmli-title" id="payment-gateway-wrap-editable" data-id="10" contenteditable="true"><?php	esc_html_e('Payment Gateway', 'one-click-upsell-funnel-for-woocommerce-pro' );?></div>
								<div class="wps-ufw_msmsmli-wrap ui-droppable ubo_offer_input" id="payment-gateway-wrap-id">
								
							<?php	esc_html_e('Note: Payment Information containing gateways will be automatically added to the end of order form.', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
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
			<span class="wps-ufw_ms-btn-link"><?php esc_html_e('ThankYou', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
			<div class="wps-ufw_ms-buttons">
				<a href="#" class="wps-ufw_ms-but wps-ufw_btn-con ubo_offer_input"><?php esc_html_e('Preview', 'one-click-upsell-funnel-for-woocommerce-pro' );?></a>
			
			</div>
			<main class="wps-ufw_ms-main">
				<header class="wps-ufw_msm-head">
					<span class="dashicons dashicons-arrow-left-alt"></span> <?php esc_html_e('ThankYou', 'one-click-upsell-funnel-for-woocommerce-pro' );?>
					<div class="wps-ufw_msmh-in">
						<span class="wps-ufw_pri-txt-btn wps-ufw_thanks-reset-confirmation"><?php esc_html_e('Reset', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
						<span class="wps-ufw_pri-btn wps-ufw_msmhthy-in-btn"><?php esc_html_e('Save', 'one-click-upsell-funnel-for-woocommerce-pro' );?></span>
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
						<h3 class="wps-ufw_msmsmt-title"><?php esc_html_e('Modify Content Thank You Page ', 'one-click-upsell-funnel-for-woocommerce-pro' )  ?> </h3>
						<section class="wps-ufw_msmsmt-sec">
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e('Modify Thank You Page Header Text', 'one-click-upsell-funnel-for-woocommerce-pro' )  ?></label>
								<input type="text" class="ubo_offer_input" id="wps_wocuf_content_page_header_title" name="wps_wocuf_content_page_header_title"  value="<?php   esc_attr_e( empty( $wps_wocuf_content_page_header_title ) ? esc_html__('Thank you. Your order has been received.', 'one-click-upsell-funnel-for-woocommerce-pro' ) : $wps_wocuf_content_page_header_title ) ?>" />
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"> <?php esc_html_e('Add Content Before Order Details', 'one-click-upsell-funnel-for-woocommerce-pro' )  ?></label>
								<textarea id="wps_wocuf_content_before_order_details" class="ubo_offer_input" name="wps_wocuf_content_before_order_details" rows="4" cols="50" placeholder="Enter your text here..." ><?php  esc_html_e( $wps_wocuf_content_before_order_details );?></textarea>
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e('Add Content After Order Details', 'one-click-upsell-funnel-for-woocommerce-pro' )  ?></label>
								<textarea id="wps_wocuf_content_after_order_details" class="ubo_offer_input" name="wps_wocuf_content_after_order_details" rows="4" cols="50" placeholder="Enter your text here..." ><?php  esc_html_e( $wps_wocuf_content_after_order_details );?></textarea>
							</article>
							<article class="wps-ufw_msmsmts-art">
								<label for="wps-ufw_msmsmtsa-input"><?php esc_html_e('Add Content After Billing or Shipping Address', 'one-click-upsell-funnel-for-woocommerce-pro' )  ?></label>
								<textarea id="wps_wocuf_content_billing_and_shipping" class="ubo_offer_input" name="wps_wocuf_content_billing_and_shipping" rows="4" cols="50" placeholder="Enter your text here..."><?php  esc_html_e( $wps_wocuf_content_billing_and_shipping );?></textarea>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>

</script>


<?php
