<?php
/**
 * Upsell elementor widgets collection loader file.
 *
 * @link       https://wpswings.com/?utm_source=wpswings-official&utm_medium=upsell-org-backend&utm_campaign=official
 * @since      3.1.2
 *
 * @package    woo-one-click-upsell-funnel
 * @subpackage woo-one-click-upsell-funnel/widgets
 */

namespace ElementorUpsellWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Awesomesauce widget class.
 *
 * @since 3.1.2
 */
class Upsell_Reject extends Widget_Button {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_style( 'upsell-widgets-css', plugins_url( 'woo-one-click-upsell-funnel/page-builders/elementor/elementor-widget/assets/css/upsell-widgets.css', WPS_WOCUF_DIRPATH ), array(), '3.1.2' );
		wp_register_script( 'upsell-widgets-js', plugins_url( 'woo-one-click-upsell-funnel/page-builders/elementor/elementor-widget/assets/js/upsell-widgets.js', WPS_WOCUF_DIRPATH ), array( 'elementor-frontend' ), '3.1.2', true );

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
		return 'upsell-no-button';
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
		return __( 'Upsell No Button', 'woo-one-click-upsell-funnel' );
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
		return array( 'upsell-widgets-css' );
	}

	/**
	 * Enqueue scripts.
	 */
	public function get_script_depends() {
		return array( 'upsell-widgets-js' );
	}

	/**
	 * Register button widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_button',
			array(
				'label' => esc_html__( 'Button', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'button_type',
			array(
				'label'        => esc_html__( 'Type', 'woo-one-click-upsell-funnel' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'danger',
				'options'      => array(
					''        => esc_html__( 'Default', 'woo-one-click-upsell-funnel' ),
					'info'    => esc_html__( 'Info', 'woo-one-click-upsell-funnel' ),
					'success' => esc_html__( 'Success', 'woo-one-click-upsell-funnel' ),
					'warning' => esc_html__( 'Warning', 'woo-one-click-upsell-funnel' ),
					'danger'  => esc_html__( 'Danger', 'woo-one-click-upsell-funnel' ),
				),
				'prefix_class' => 'elementor-button-',
			)
		);

		$this->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'woo-one-click-upsell-funnel' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Reject this offer', 'woo-one-click-upsell-funnel' ),
				'placeholder' => esc_html__( 'Reject button text', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'woo-one-click-upsell-funnel' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => esc_html__( 'Add Upsell no shortcode here', 'woo-one-click-upsell-funnel' ),
				'default'     => array(
					'url' => '[wps_upsell_no]',
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'        => esc_html__( 'Alignment', 'woo-one-click-upsell-funnel' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'woo-one-click-upsell-funnel' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'woo-one-click-upsell-funnel' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'woo-one-click-upsell-funnel' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'woo-one-click-upsell-funnel' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'prefix_class' => 'elementor%s-align-',
				'default'      => 'center',
			)
		);

		$this->add_control(
			'size',
			array(
				'label'          => esc_html__( 'Size', 'woo-one-click-upsell-funnel' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'sm',
				'options'        => self::get_button_sizes(),
				'style_transfer' => true,
			)
		);

		$this->add_control(
			'selected_icon',
			array(
				'label'            => esc_html__( 'Icon', 'woo-one-click-upsell-funnel' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
			)
		);

		$this->add_control(
			'icon_align',
			array(
				'label'     => esc_html__( 'Icon Position', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => esc_html__( 'Before', 'woo-one-click-upsell-funnel' ),
					'right' => esc_html__( 'After', 'woo-one-click-upsell-funnel' ),
				),
				'condition' => array(
					'selected_icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_indent',
			array(
				'label'     => esc_html__( 'Icon Spacing', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'view',
			array(
				'label'   => esc_html__( 'View', 'woo-one-click-upsell-funnel' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			)
		);

		$this->add_control(
			'button_css_id',
			array(
				'label'       => esc_html__( 'Button ID', 'woo-one-click-upsell-funnel' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'woo-one-click-upsell-funnel' ),
				'description' => sprintf(
					/* translators: 1: Code open tag, 2: Code close tag. */
					esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows %1$sA-z 0-9%2$s & underscore chars without spaces.', 'woo-one-click-upsell-funnel' ),
					'<code>',
					'</code>'
				),
				'separator'   => 'before',

			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Button', 'woo-one-click-upsell-funnel' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_animation',
			array(
				'label' => esc_html__( 'Hover Animation', 'woo-one-click-upsell-funnel' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_tab();

		$this->add_control(
			'border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'woo-one-click-upsell-funnel' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_padding',
			array(
				'label'      => esc_html__( 'Padding', 'woo-one-click-upsell-funnel' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->end_controls_section();
	}

}
