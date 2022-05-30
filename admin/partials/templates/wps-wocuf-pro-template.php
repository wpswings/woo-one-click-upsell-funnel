<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      1.0.0
 *
 * @package     woo_one_click_upsell_funnel
 * @subpackage  woo_one_click_upsell_funnel/admin/partials/templates
 */

/**
 * Template Name: WPS OneClick Upsell Template
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
