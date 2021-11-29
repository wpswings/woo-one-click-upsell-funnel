<?php
/**
 * Upsell elementor widgets collection loader file.
 *
 * @link       https://makewebbetter.com/?utm_source=MWB-upsell-backend&utm_medium=MWB-ORG-backend&utm_campaign=MWB-backend
 * @since      3.1.2
 *
 * @package    woo-one-click-upsell-funnel
 * @subpackage woo-one-click-upsell-funnel/widgets
 */

namespace ElementorUpsellWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Awesomesauce widget class.
 *
 * @since 3.1.2
 */
class Upsell_Accept extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'upsell-yes-button-design', plugins_url( 'woo-one-click-upsell-funnel/page-builders/elementor/elementor-widget/assets/css/upsell-widgets.css', MWB_WOCUF_DIRPATH ), array(), '3.1.2' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 3.1.2
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'upsell-yes-button';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 3.1.2
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Upsell Yes Button', 'woo-one-click-upsell-funnel' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 3.1.2
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 3.1.2
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'upsell-yes-button-design' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.2
	 *
	 * @access protected
	 */
	protected function _register_controls() { //phpcs:ignore
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Upsell Accept Button', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __( 'Button', 'woo-one-click-upsell-funnel' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Title', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Description', 'woo-one-click-upsell-funnel' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Description', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => __( 'Content', 'woo-one-click-upsell-funnel' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'Content', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 3.1.2
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'content', 'advanced' );
		?>
		<h2> <?php echo esc_html( $this->get_render_attribute_string( 'title' ) ); ?><?php echo wp_kses( $settings['title'], array() ); ?></h2>
		<div> <?php echo esc_html( $this->get_render_attribute_string( 'description' ) ); ?><?php echo wp_kses( $settings['description'], array() ); ?></div>
		<div> <?php echo esc_html( $this->get_render_attribute_string( 'content' ) ); ?><?php echo wp_kses( $settings['content'], array() ); ?></div>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 3.1.2
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		view.addInlineEditingAttributes( 'title', 'none' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'content', 'advanced' );
		#>
		<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div>
		<?php
	}
}
