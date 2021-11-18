<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/?utm_source=MWB-upsell-backend&utm_medium=MWB-ORG-backend&utm_campaign=MWB-backend
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/admin
 */

/**
 * Template Name: MWB OneClick Upsell Template
 * This template will only display the content you entered in the page editor
 */

?>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>

	<?php // Add tracking scripts. ?>
</head>
<body>
<?php
while ( have_posts() ) :
	the_post();
	the_content();
	endwhile;
?>
<?php wp_footer(); ?>
</body>
</html>
