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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

/**
 * Elementor text editor widget.
 *
 * Elementor widget that displays a WYSIWYG text editor, just like the WordPress
 * editor.
 *
 * @since 1.0.0
 */
class Upsell_Short_Desc extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve text editor widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Upsell-product-short-desc';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve text editor widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Upsell Short Description', 'woo-one-click-upsell-funnel' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve text editor widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-description';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the text editor widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'basic' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'text', 'editor' );
	}

	/**
	 * Register text editor widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_editor',
			array(
				'label' => esc_html__( 'Text Editor', 'woo-one-click-upsell-funnel' ),
			)
		);

		$this->add_control(
			'editor',
			array(
				'label'   => '',
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>[wps_upsell_desc_short]</p>',
			)
		);

		$this->add_control(
			'drop_cap',
			array(
				'label'              => esc_html__( 'Drop Cap', 'woo-one-click-upsell-funnel' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_off'          => esc_html__( 'Off', 'woo-one-click-upsell-funnel' ),
				'label_on'           => esc_html__( 'On', 'woo-one-click-upsell-funnel' ),
				'prefix_class'       => 'elementor-drop-cap-',
				'frontend_available' => true,
			)
		);

		$text_columns     = range( 1, 10 );
		$text_columns     = array_combine( $text_columns, $text_columns );
		$text_columns[''] = esc_html__( 'Default', 'woo-one-click-upsell-funnel' );

		$this->add_responsive_control(
			'text_columns',
			array(
				'label'     => esc_html__( 'Columns', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'options'   => $text_columns,
				'selectors' => array(
					'{{WRAPPER}}' => 'columns: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'      => esc_html__( 'Columns Gap', 'woo-one-click-upsell-funnel' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em', 'vw' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
					'%'  => array(
						'max'  => 10,
						'step' => 0.1,
					),
					'vw' => array(
						'max'  => 10,
						'step' => 0.1,
					),
					'em' => array(
						'max'  => 10,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Text Editor', 'woo-one-click-upsell-funnel' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'   => 'typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_drop_cap',
			array(
				'label'     => esc_html__( 'Drop Cap', 'woo-one-click-upsell-funnel' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'drop_cap' => 'yes',
				),
			)
		);

		$this->add_control(
			'drop_cap_view',
			array(
				'label'        => esc_html__( 'View', 'woo-one-click-upsell-funnel' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'default' => esc_html__( 'Default', 'woo-one-click-upsell-funnel' ),
					'stacked' => esc_html__( 'Stacked', 'woo-one-click-upsell-funnel' ),
					'framed'  => esc_html__( 'Framed', 'woo-one-click-upsell-funnel' ),
				),
				'default'      => 'default',
				'prefix_class' => 'elementor-drop-cap-view-',
			)
		);

		$this->add_control(
			'drop_cap_primary_color',
			array(
				'label'     => esc_html__( 'Primary Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-default .elementor-drop-cap' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
			)
		);

		$this->add_control(
			'drop_cap_secondary_color',
			array(
				'label'     => esc_html__( 'Secondary Color', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'drop_cap_view!' => 'default',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'drop_cap_shadow',
				'selector' => '{{WRAPPER}} .elementor-drop-cap',
			)
		);

		$this->add_control(
			'drop_cap_size',
			array(
				'label'     => esc_html__( 'Size', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'max' => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-drop-cap' => 'padding: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'drop_cap_view!' => 'default',
				),
			)
		);

		$this->add_control(
			'drop_cap_space',
			array(
				'label'     => esc_html__( 'Space', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'body:not(.rtl) {{WRAPPER}} .elementor-drop-cap' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .elementor-drop-cap' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'drop_cap_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'woo-one-click-upsell-funnel' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => '%',
				),
				'range'      => array(
					'%' => array(
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-drop-cap' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'drop_cap_border_width',
			array(
				'label'     => esc_html__( 'Border Width', 'woo-one-click-upsell-funnel' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}} .elementor-drop-cap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'drop_cap_view' => 'framed',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'drop_cap_typography',
				'selector' => '{{WRAPPER}} .elementor-drop-cap-letter',
				'exclude'  => array(
					'letter_spacing',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render text editor widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$is_dom_optimized             = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' );
		$is_edit_mode                 = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$should_render_inline_editing = ( ! $is_dom_optimized || $is_edit_mode );

		$editor_content = $this->get_settings_for_display( 'editor' );
		$editor_content = $this->parse_text_editor( $editor_content );

		if ( $should_render_inline_editing ) {
			$this->add_render_attribute( 'editor', 'class', array( 'elementor-text-editor', 'elementor-clearfix' ) );
		}

		$this->add_inline_editing_attributes( 'editor', 'advanced' );
		?>
		<?php if ( $should_render_inline_editing ) { ?>
			<div <?php $this->print_render_attribute_string( 'editor' ); ?>>
		<?php } ?>
		<?php
		// PHPCS - the main text of a widget should not be escaped.
				echo esc_html( $editor_content ); // phpcs:ignore WordPress.Security.EscapeOutput 
		?>
		<?php if ( $should_render_inline_editing ) { ?>
			</div>
		<?php } ?>
		<?php
	}

	/**
	 * Render text editor widget as plain content.
	 *
	 * Override the default behavior by printing the content without rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {
		// In plain mode, render without shortcode.
		$this->print_unescaped_setting( 'editor' );
	}

	/**
	 * Render text editor widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		const isDomOptimized = ! ! elementorFrontend.config.experimentalFeatures.e_dom_optimization,
			isEditMode = elementorFrontend.isEditMode(),
			shouldRenderInlineEditing = ( ! isDomOptimized || isEditMode );

		if ( shouldRenderInlineEditing ) {
			view.addRenderAttribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );
		}

		view.addInlineEditingAttributes( 'editor', 'advanced' );

		if ( shouldRenderInlineEditing ) { #>
			<div {{{ view.getRenderAttributeString( 'editor' ) }}}>
		<# } #>

			{{{ settings.editor }}}

		<# if ( shouldRenderInlineEditing ) { #>
			</div>
		<# } #>
		<?php
	}
}
