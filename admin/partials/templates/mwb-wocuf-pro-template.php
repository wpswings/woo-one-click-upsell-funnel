<?php
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

	<?php // add tracking scripts ?>
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
