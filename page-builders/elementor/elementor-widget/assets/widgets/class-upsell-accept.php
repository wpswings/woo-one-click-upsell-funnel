<?php
/**
 * Upsell elementor widgets collection loader file.
 *
 * @link       https://makewebbetter.com/?utm_source=MWB-upsell-backend&utm_medium=MWB-ORG-backend&utm_campaign=MWB-backend
 * @since      3.0.0
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
 * @since 1.0.0
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

		wp_register_style( 'awesomesauce', plugins_url( '/assets/css/awesomesauce.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesomesauce';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Awesdfdsfdfdsfdsfsomesauce', 'elementor-awesomesauce' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
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
		return array( 'awesomesauce' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Condfdsfdsftent', 'elementor-awesomesauce' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __( 'Tidsfdsftle', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Titdsfdsfsdle', 'elementor-awesomesauce' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'   => __( 'Descsdfdsfsdription', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Descrdsfsdfsdfiption', 'elementor-awesomesauce' ),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => __( 'Contedsdsfnt', 'elementor-awesomesauce' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'Contdsfsdfent', 'elementor-awesomesauce' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_inline_editing_attributes( 'content', 'advanced' );
		?>
		<h2 <?php echo $this->get_render_attribute_string( 'title' ); ?><?php echo wp_kses( $settings['title'], array() ); ?></h2>
		<div <?php echo $this->get_render_attribute_string( 'description' ); ?><?php echo wp_kses( $settings['description'], array() ); ?></div>
		<div <?php echo $this->get_render_attribute_string( 'content' ); ?><?php echo wp_kses( $settings['content'], array() ); ?></div>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
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
