<?php
/**
 * Widget Name: Dynamic Categories
 * Description: Different style of Terms of categories listing layouts.
 * Author: Theplus
 * Author URI: https://posimyth.com
 *
 * @package ThePlus
 */

namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class L_ThePlus_Dynamic_Categories
 */
class L_ThePlus_Dynamic_Categories extends Widget_Base {

	/**
	 * Get Widget Name
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function get_name() {
		return 'tp-dynamic-categories';
	}

	/**
	 * Get Widget Title
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function get_title() {
		return esc_html__( 'Dynamic Categories', 'theplus' );
	}

	/**
	 * Get Widget Icon
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function get_icon() {
		return 'fa fa-paw theplus_backend_icon';
	}

	/**
	 * Get Widget Categories
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function get_categories() {
		return array( 'plus-listing' );
	}

	/**
	 * Get Widget Keywords
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function get_keywords() {
		return array( 'Dynamic Category', 'Category', 'Category Widget', 'Dynamic Category Widget', 'Elementor Dynamic Category', 'Elementor Category Widget', 'Elementor Dynamic Category Widget', 'Dynamic Category Elementor Addon', 'Category Elementor Addon', 'Dynamic Category Plus Addons', 'Category Plus Addons', 'Dynamic Category The Plus Addons', 'Category The Plus Addons' );
	}

	/**
	 * is_reload_preview_required
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Register controls.
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	protected function register_controls() {

		/** Content Section Start*/
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content Layout', 'theplus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => array(
					'style_1' => esc_html__( 'Style-1', 'theplus' ),
					'style_2' => esc_html__( 'Style-2', 'theplus' ),
					'style_3' => esc_html__( 'Style-3', 'theplus' ),
				),
			)
		);
		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'tpebl' ),
					'masonry'  => esc_html__( 'Masonry', 'tpebl' ),
					'metro'    => esc_html__( 'Metro', 'tpebl' ),
					'carousel' => esc_html__( 'Carousel (PRO)', 'tpebl' ),
				),
			)
		);
		$this->add_control(
			'layout_pro_options',
			array(
				'label'       => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => theplus_pro_ver_notice(),
				'classes'     => 'plus-pro-version',
				'condition'   => array(
					'layout' => 'carousel',
				),
			)
		);
		$this->add_control(
			'post_taxonomies',
			array(
				'label'     => esc_html__( 'Taxonomies', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => l_theplus_get_post_taxonomies(),
				'default'   => 'category',
				'condition' => array(
					'layout!' => 'carousel',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_align_section',
			array(
				'label'     => esc_html__( 'Content Alignment', 'theplus' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'style!' => 'style_3',
				),
			)
		);
		$this->add_control(
			'text_alignment_st1',
			array(
				'label'     => esc_html__( 'Alignment', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'theplus' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Bottom', 'theplus' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_1 .pt-dynamic-hover-content' => 'justify-content:{{VALUE}};',
				),
				'condition' => array(
					'style' => 'style_1',
				),
				'toggle'    => true,
			)
		);
		$this->add_control(
			'text_alignment_st2',
			array(
				'label'     => esc_html__( 'Alignment', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content-inner' => 'text-align:{{VALUE}};',
				),
				'condition' => array(
					'style' => 'style_2',
				),
				'toggle'    => true,
			)
		);
		$this->add_control(
			'align_offset',
			array(
				'label'     => esc_html__( 'Offset', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content' => 'align-items:{{VALUE}};',
				),
				'toggle'    => true,
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_source_section',
			array(
				'label' => esc_html__( 'Content Source', 'theplus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'hide_empty',
			array(
				'label'        => esc_html__( 'Hide Empty', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'hide_sub_cat',
			array(
				'label'        => esc_html__( 'Hide Sub Categories', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			)
		);
		$this->add_control(
			'post_category',
			array(
				'label'       => esc_html__( 'Include Terms ID', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => 'Use Terms Id,if you want to use multiple id so use comma as separator.',
			)
		);
		$this->add_control(
			'post_category_exc',
			array(
				'label'       => esc_html__( 'Exclude Terms ID', 'theplus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => 'Use Terms Id,if you want to use multiple id so use comma as separator.',
			)
		);
		$this->add_control(
			'display_posts',
			array(
				'label'     => esc_html__( 'Maximum Categories Display', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 200,
				'step'      => 1,
				'default'   => 8,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'post_offset',
			array(
				'label'       => esc_html__( 'Offset Categories', 'theplus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 50,
				'step'        => 1,
				'default'     => '',
				'description' => esc_html__( 'Hide categories from the beginning of listing.', 'theplus' ),
			)
		);
		$this->add_control(
			'post_order_by',
			array(
				'label'     => esc_html__( 'Order By', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'separator' => 'before',
				'options'   => l_theplus_orderby_arr(),
			)
		);
		$this->add_control(
			'post_order',
			array(
				'label'   => esc_html__( 'Order', 'theplus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => l_theplus_order_arr(),
			)
		);
		$this->add_control(
			'hide_pro_count',
			array(
				'label'     => esc_html__( 'Display Product Count', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
				'default'   => 'yes',
			)
		);
		$this->add_control(
			'display_description',
			array(
				'label'     => esc_html__( 'Display Description', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'theplus' ),
				'label_off' => esc_html__( 'Disable', 'theplus' ),
				'separator' => 'before',
				'default'   => 'no',
				'condition' => array(
					'style!' => 'style_3',
				),
			)
		);
		$this->add_control(
			'desc_text_limit',
			array(
				'label'     => esc_html__( 'Display Description Limit', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default'   => 'no',
				'condition' => array(
					'style!'              => 'style_3',
					'display_description' => 'yes',
				),
			)
		);
		$this->add_control(
			'display_description_by',
			array(
				'type'      => Controls_Manager::SELECT,
				'label'     => esc_html__( 'Limit on', 'theplus' ),
				'default'   => 'char',
				'options'   => array(
					'char' => esc_html__( 'Character', 'theplus' ),
					'word' => esc_html__( 'Word', 'theplus' ),
				),
				'condition' => array(
					'style!'              => 'style_3',
					'display_description' => 'yes',
					'desc_text_limit'     => 'yes',
				),
			)
		);
		$this->add_control(
			'display_description_input',
			array(
				'label'     => esc_html__( 'Description Count', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 1000,
				'step'      => 1,
				'condition' => array(
					'style!'              => 'style_3',
					'display_description' => 'yes',
					'desc_text_limit'     => 'yes',
				),
			)
		);
		$this->add_control(
			'display_title_3_dots',
			array(
				'label'     => esc_html__( 'Display Dots', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default'   => 'yes',
				'condition' => array(
					'style!'              => 'style_3',
					'display_description' => 'yes',
					'desc_text_limit'     => 'yes',
				),
			)
		);
		$this->add_control(
			'display_thumbnail',
			array(
				'label'     => esc_html__( 'Display Image Size', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'theplus' ),
				'label_off' => esc_html__( 'Hide', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'default'   => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'exclude'   => array( 'custom' ),
				'condition' => array(
					'display_thumbnail' => 'yes',
				),
			)
		);
		$this->add_control(
			'on_hover_bg_image',
			array(
				'label'        => esc_html__( 'On Hover Background Image', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Enable', 'theplus' ),
				'label_off'    => esc_html__( 'Disable', 'theplus' ),
				'return_value' => 'yes',
				'condition'    => array(
					'style' => 'style_3',
				),
			)
		);
		$this->add_control(
			'hide_parent_cat',
			array(
				'label'        => esc_html__( 'Hide Parent Categories', 'theplus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'separator'    => 'before',
				'return_value' => 'yes',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'columns_section',
			array(
				'label'     => esc_html__( 'Columns Manage', 'theplus' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'layout!' => array( 'carousel' ),
				),
			)
		);
		$this->add_control(
			'desktop_column',
			array(
				'label'     => esc_html__( 'Desktop Column', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => l_theplus_get_columns_list(),
				'condition' => array(
					'layout!' => array( 'metro', 'carousel' ),
				),
			)
		);
		$this->add_control(
			'tablet_column',
			array(
				'label'     => esc_html__( 'Tablet Column', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4',
				'options'   => l_theplus_get_columns_list(),
				'condition' => array(
					'layout!' => array( 'metro', 'carousel' ),
				),
			)
		);
		$this->add_control(
			'mobile_column',
			array(
				'label'     => esc_html__( 'Mobile Column', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '6',
				'options'   => l_theplus_get_columns_list(),
				'condition' => array(
					'layout!' => array( 'metro', 'carousel' ),
				),
			)
		);
		$this->add_control(
			'metro_column',
			array(
				'label'     => esc_html__( 'Metro Column', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'3' => esc_html__( 'Column 3', 'tpebl' ),
					'4' => esc_html__( 'Column 4 (PRO)', 'tpebl' ),
					'5' => esc_html__( 'Column 5 (PRO)', 'tpebl' ),
					'6' => esc_html__( 'Column 6 (PRO)', 'tpebl' ),
				),
				'condition' => array(
					'layout' => array( 'metro' ),
				),
			)
		);
		$this->add_control(
			'metro_style_3',
			array(
				'label'     => esc_html__( 'Metro Style', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'style-1',
				'options'   => l_theplus_get_style_list( 1 ),
				'condition' => array(
					'metro_column' => '3',
					'layout'       => array( 'metro' ),
				),
			)
		);
		$this->add_responsive_control(
			'columns_gap',
			array(
				'label'      => esc_html__( 'Columns Gap/Space Between', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15',
				),
				'separator'  => 'before',
				'condition'  => array(
					'layout!' => array( 'carousel' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .post-inner-loop .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => esc_html__( 'Title', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'theplus' ),
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name a',
			)
		);
		$this->start_controls_tabs( 'tabs_title_style' );
		$this->start_controls_tab(
			'tab_title_normal',
			array(
				'label' => esc_html__( 'Normal', 'theplus' ),
			)
		);
		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name a' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title_shadow',
				'label'    => esc_html__( 'Text Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-name a',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_title_hover',
			array(
				'label' => esc_html__( 'Hover', 'theplus' ),
			)
		);
		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Title Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name a' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title_shadow_h',
				'label'    => esc_html__( 'Text Shadow', 'theplus' ),
				'selector' => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name a',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'title_bg',
			array(
				'label'     => esc_html__( 'Title Background', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'title_bg_padding',
			array(
				'label'      => esc_html__( 'Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
				'condition'  => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->start_controls_tabs(
			'tabs_title_bg_style',
			array(
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->start_controls_tab(
			'tab_title_bg_n',
			array(
				'label'     => esc_html__( 'Normal', 'theplus' ),
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'title_background',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'title_bg_border',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'title_bg_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'title_bg_shadow',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_title_bg_h',
			array(
				'label'     => esc_html__( 'Hover', 'theplus' ),
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'title_background_h',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'title_bg_border_h',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'title_bg_border_radius_h',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'title_bg_shadow_h',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name',
				'condition' => array(
					'title_bg' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'title_underline',
			array(
				'label'     => esc_html__( 'Title Underline', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			't_underline_top_offset',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Top Offset', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name:after' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->start_controls_tabs(
			'tabs_title_uline_style',
			array(
				'condition' => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->start_controls_tab(
			'tab_t_underline_n',
			array(
				'label'     => esc_html__( 'Normal', 'theplus' ),
				'condition' => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			't_underline_height',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Height', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name:after' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			't_underline_size',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Size', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'     => array(
					'unit' => 'px',
					'size' => 30,
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name:after' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->add_control(
			't_underline_color',
			array(
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#313131',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-name:after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_t_underline_h',
			array(
				'label'     => esc_html__( 'Hover', 'theplus' ),
				'condition' => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			't_underline_size_h',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Size', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'     => array(
					'unit' => 'px',
					'size' => 60,
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name:after' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'   => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->add_control(
			't_underline_color_h',
			array(
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-name:after' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'title_underline' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_count_style',
			array(
				'label' => esc_html__( 'Product Count', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'count_padding',
			array(
				'label'      => esc_html__( 'Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .pt-dynamic-wrapper .pt-dynamic-hover-cat-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'style' => 'style_1',
				),
				'separator'  => 'after',
			)
		);
		$this->add_control(
			'count_extra_text',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Product Count After Text', 'theplus' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);
		$this->add_control(
			'count_width_height_opt',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Width and Height', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 250,
						'step' => 1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-count' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'style' => 'style_1',
				),
			)
		);
		$this->add_control(
			'count_top_bottom',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Top/Bottom Offset', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-count' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'style' => 'style_1',
				),
			)
		);
		$this->add_control(
			'count_left_right',
			array(
				'type'        => Controls_Manager::SLIDER,
				'label'       => esc_html__( 'Left/Right Offset', 'theplus' ),
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-count' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'   => array(
					'style' => 'style_1',
				),
				'separator'   => 'after',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'count_typography',
				'label'    => esc_html__( 'Typography', 'theplus' ),
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-count',
			)
		);
		$this->start_controls_tabs( 'tabs_count_style' );
		$this->start_controls_tab(
			'tab_count_normal',
			array(
				'label' => esc_html__( 'Normal', 'theplus' ),
			)
		);
		$this->add_control(
			'count_color',
			array(
				'label'     => esc_html__( 'Count Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-hover-cat-count' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'count_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'selectors' => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content-inner  .pt-dynamic-hover-cat-count' => 'opacity: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'style_2',
				),
			)
		);
		$this->add_control(
			'count_transform',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content-inner .pt-dynamic-hover-cat-count' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'style' => 'style_2',
				),
			)
		);
		$this->add_control(
			'count_bg_switch',
			array(
				'label'     => esc_html__( 'Background Option', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default'   => 'no',
				'condition' => array(
					'style' => 'style_1',
				),
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'count_bg_n',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper .pt-dynamic-hover-cat-count',
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'count_border_n',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper .pt-dynamic-hover-cat-count',
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'count_border_radius_n',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pt-dynamic-wrapper .pt-dynamic-hover-cat-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'count_bg_switch' => 'yes',
				),
				'separator'  => 'after',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'wcp_count_shadow_n',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-count',
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_count_hover',
			array(
				'label' => esc_html__( 'Hover', 'theplus' ),
			)
		);
		$this->add_control(
			'count_hover_color',
			array(
				'label'     => esc_html__( 'Count Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-count' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'count_opacity_h',
			array(
				'label'     => esc_html__( 'Opacity', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'selectors' => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2:hover .pt-dynamic-hover-content-inner  .pt-dynamic-hover-cat-count' => 'opacity: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'style_2',
				),
			)
		);
		$this->add_control(
			'count_transform_h',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2:hover .pt-dynamic-hover-content-inner .pt-dynamic-hover-cat-count' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'style' => 'style_2',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'count_bg_h',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-count',
				'separator' => 'before',
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
			)
		);
		$this->add_control(
			'count_border_h',
			array(
				'label'     => esc_html__( 'Border Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-count' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
				'separator' => 'after',
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'count_h_shadow',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-count',
				'condition' => array(
					'count_bg_switch' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_description_style',
			array(
				'label'     => esc_html__( 'Description Style', 'theplus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style!'              => 'style_3',
					'display_description' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'desc_margin',
			array(
				'label'      => esc_html__( 'Margin', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
			)
		);
		$this->add_control(
			'description_alignment_st',
			array(
				'label'     => esc_html__( 'Text Alignment', 'theplus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'theplus' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'theplus' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'theplus' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'theplus' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc' => 'text-align:{{VALUE}};',
				),
				'toggle'    => true,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Typography', 'theplus' ),
				'global'   => array(
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc',
			)
		);
		$this->start_controls_tabs( 'tabs_desc_style' );
		$this->start_controls_tab(
			'tab_desc_normal',
			array(
				'label' => esc_html__( 'Normal', 'theplus' ),
			)
		);
		$this->add_control(
			'desc_color',
			array(
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'desc_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'selectors' => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content-inner  .pt-dynamic-hover-cat-desc' => 'opacity: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'style_2',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_desc_hover',
			array(
				'label' => esc_html__( 'Hover', 'theplus' ),
			)
		);
		$this->add_control(
			'desc_color_h',
			array(
				'label'     => esc_html__( 'Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-desc' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'desc_opacity_h',
			array(
				'label'     => esc_html__( 'Opacity', 'theplus' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'selectors' => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_2:hover .pt-dynamic-hover-content-inner  .pt-dynamic-hover-cat-desc' => 'opacity: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'style_2',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'desc_bg',
			array(
				'label'     => esc_html__( 'Description Background', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'desc_bg_padding',
			array(
				'label'      => esc_html__( 'Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after',
				'condition'  => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->start_controls_tabs(
			'tabs_desc_bg_style',
			array(
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->start_controls_tab(
			'tab_desc_bg_n',
			array(
				'label'     => esc_html__( 'Normal', 'theplus' ),
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'desc_background',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'desc_bg_border',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'desc_bg_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'desc_bg_shadow',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_desc_bg_h',
			array(
				'label'     => esc_html__( 'Hover', 'theplus' ),
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'desc_background_h',
				'label'     => esc_html__( 'Background', 'theplus' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'desc_bg_border_h',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'desc_bg_border_radius_h',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'desc_bg_shadow_h',
				'label'     => esc_html__( 'Box Shadow', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-cat-desc',
				'condition' => array(
					'desc_bg' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_loop_style3',
			array(
				'label'     => esc_html__( 'Content Loop', 'theplus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style' => 'style_3',
				),
			)
		);
		$this->add_responsive_control(
			'cl_st3_padding',
			array(
				'label'      => esc_html__( 'Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_cl_st3' );
		$this->start_controls_tab(
			'tab_cl_st3_n',
			array(
				'label' => esc_html__( 'Normal', 'theplus' ),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'cl_st3_background',
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a',
				'condition' => array(
					'on_hover_bg_image!' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_st3_border',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'cl_st3_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cl_st3_shadow',
				'selector' => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a',
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_cl_st3_h',
			array(
				'label' => esc_html__( 'Hover', 'theplus' ),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'cl_st3_background_h',
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a:hover',
				'condition' => array(
					'on_hover_bg_image!' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_st3_border_h',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a:hover',
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'cl_st3_radius_h',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cl_st3_shadow_h',
				'selector' => '{{WRAPPER}} .pt-dynamic-wrapper.style_3 .pt-dynamic-content a:hover',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_loop_style',
			array(
				'label'     => esc_html__( 'Content Loop', 'theplus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'style!' => 'style_3',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_content_loop' );
		$this->start_controls_tab(
			'tab_content_loop_n',
			array(
				'label' => esc_html__( 'Normal', 'theplus' ),
			)
		);
		$this->add_control(
			'cl_bg_ol_color',
			array(
				'label'     => esc_html__( 'Whole Overlay Color', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content' => 'background-color: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);
		$this->add_control(
			'cl_hover_content_swich',
			array(
				'label'     => esc_html__( 'Hover Content Only', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Disable', 'theplus' ),
				'label_off' => esc_html__( 'Enable', 'theplus' ),
				'default'   => 'no',
				'condition' => array(
					'style' => 'style_1',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_border',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper',
				'condition' => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'cl_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_border_hc',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .extra-wcc-inn',
				'condition' => array(
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'cl_border_radius_hc',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .extra-wcc-inn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->add_control(
			'cl_transform',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper img,					
					{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout!' => 'metro',
				),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'cl_transform_m',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .dynamic-cat-bg-image-metro' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout' => 'metro',
				),
				'separator'   => 'before',
			)
		);
		$this->add_responsive_control(
			'transition_duration',
			array(
				'label'     => esc_html__( 'Transition Duration', 'theplus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.5,
				),
				'range'     => array(
					'px' => array(
						'step' => 0.1,
						'min'  => 0.1,
						'max'  => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper img,
					{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content' => 'transition: all {{SIZE}}s ease-in-out;-webkit-transition: all {{SIZE}}s ease-in-out;',
				),
				'condition' => array(
					'layout!' => 'metro',
				),
			)
		);
		$this->add_responsive_control(
			'transition_duration_m',
			array(
				'label'     => esc_html__( 'Transition Duration', 'theplus' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0.5,
				),
				'range'     => array(
					'px' => array(
						'step' => 0.1,
						'min'  => 0.1,
						'max'  => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .dynamic-cat-bg-image-metro' => 'transition: all {{SIZE}}s ease-in-out;-webkit-transition: all {{SIZE}}s ease-in-out;',
				),
				'condition' => array(
					'layout' => 'metro',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'content_loop_css',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper img,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .dynamic-cat-bg-image-metro',
				'separator' => 'after',
				'condition' => array(
					'layout!' => 'metro',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'content_loop_css_m',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .dynamic-cat-bg-image-metro',
				'separator' => 'after',
				'condition' => array(
					'layout' => 'metro',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'content_loop_shadow',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper',
				'condition' => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'content_loop_shadow_hc',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .extra-wcc-inn',
				'condition' => array(
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_content_loop_h',
			array(
				'label' => esc_html__( 'Hover', 'theplus' ),
			)
		);
		$this->add_control(
			'cl_bg_ol_color_h',
			array(
				'label'     => esc_html__( 'Whole Overlay Color', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-content' => 'background-color: {{VALUE}};',
				),
				'separator' => 'after',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_border_h',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover',
				'condition' => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'cl_border_radius_h',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'cl_hover_content_swich!' => 'yes',
				),
				'separator'  => 'after',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_border_h_hc',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .extra-wcc-inn',
				'condition' => array(
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'cl_border_radius_h_hc',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .extra-wcc-inn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'cl_hover_content_swich' => 'yes',
				),
				'separator'  => 'after',
			)
		);
		$this->add_control(
			'cl_transform_swich',
			array(
				'label'     => esc_html__( 'With Content Transform', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Disable', 'theplus' ),
				'label_off' => esc_html__( 'Enable', 'theplus' ),
				'default'   => 'no',
			)
		);
		$this->add_control(
			'cl_transform_h',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover img' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout!'             => 'metro',
					'cl_transform_swich!' => 'yes',
				),
			)
		);
		$this->add_control(
			'cl_transform_h_m',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .dynamic-cat-bg-image-metro' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout'              => 'metro',
					'cl_transform_swich!' => 'yes',
				),
			)
		);
		$this->add_control(
			'cl_transform_h_all',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover img,
					{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-content' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout!'                 => 'metro',
					'cl_transform_swich'      => 'yes',
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_control(
			'cl_transform_h_all_m',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .dynamic-cat-bg-image-metro,
					{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .dynamic-cat-bg-image-metro .pt-dynamic-hover-content' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout'             => 'metro',
					'cl_transform_swich' => 'yes',

				),
			)
		);
		$this->add_control(
			'cl_transform_h_all_hc',
			array(
				'label'       => esc_html__( 'Transform css', 'theplus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'theplus' ),
				'selectors'   => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .extra-wcc-inn' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};transform-style: preserve-3d;-ms-transform-style: preserve-3d;-moz-transform-style: preserve-3d;-webkit-transform-style: preserve-3d;',
				),
				'condition'   => array(
					'layout!'                => 'metro',
					'cl_transform_swich'     => 'yes',
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'content_loop_css_h',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover img',
				'separator' => 'after',
				'condition' => array(
					'layout!' => 'metro',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'      => 'content_loop_css_h_m',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .dynamic-cat-bg-image-metro',
				'separator' => 'after',
				'condition' => array(
					'layout' => 'metro',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'content_loop_shadow_h',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover',
				'condition' => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'content_loop_shadow_h_hc',
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .extra-wcc-inn',
				'condition' => array(
					'cl_hover_content_swich' => 'yes',
				),
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'cl_inner_heading',
			array(
				'label'     => esc_html__( 'Inner Content Option', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'cl_inner_switch',
			array(
				'label'     => esc_html__( 'Inner Content Option', 'theplus' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'theplus' ),
				'label_off' => esc_html__( 'No', 'theplus' ),
			)
		);
		$this->add_responsive_control(
			'cl_outer_padding',
			array(
				'label'      => esc_html__( 'Outer Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15',
				),
				'condition'  => array(
					'cl_inner_switch' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_1 .pt-dynamic-hover-content,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'cl_inner_padding',
			array(
				'label'      => esc_html__( 'Inner Padding', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15',
				),
				'condition'  => array(
					'cl_inner_switch' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'cl_inner_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.70)',
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content-inner' => 'background-color: {{VALUE}};',
				),
				'separator' => 'before',
				'condition' => array(
					'cl_inner_switch' => 'yes',
				),
			)
		);
		$this->add_control(
			'cl_inner_h_bg_color',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-content-inner' => 'background-color: {{VALUE}};',
				),
				'separator' => 'before',
				'condition' => array(
					'cl_inner_switch' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'cl_inner_border',
				'label'     => esc_html__( 'Border', 'theplus' ),
				'selector'  => '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content-inner',
				'condition' => array(
					'cl_inner_switch' => 'yes',
				),
			)
		);$this->add_control(
			'cl_inner_border_h',
			array(
				'label'     => esc_html__( 'Hover Border Color', 'theplus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper:hover .pt-dynamic-hover-content-inner' => 'border-color: {{VALUE}};',
				),
				'separator' => 'before',
				'condition' => array(
					'cl_inner_switch' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'cl_inner_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'theplus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'cl_inner_switch' => 'yes',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_extra_options_styling',
			array(
				'label' => esc_html__( 'Extra Options', 'theplus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'overflow_hidden_opt',
			array(
				'label'     => esc_html__( 'Overflow', 'theplus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'hidden',
				'options'   => array(
					'hidden'  => esc_html__( 'Hidden', 'theplus' ),
					'visible' => esc_html__( 'Visible', 'theplus' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_1,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_2' => 'overflow:{{VALUE}} !important;',
				),
				'condition' => array(
					'cl_hover_content_swich!' => 'yes',
				),
			)
		);
		$this->add_control(
			'overflow_pro_options',
			array(
				'label'       => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => theplus_pro_ver_notice(),
				'classes'     => 'plus-pro-version',
				'condition'   => array(
					'overflow_hidden_opt' => 'visible',
				),
			)
		);
		$this->add_control(
			'plus_mouse_move_parallax',
			array(
				'label'       => esc_html__( 'Mouse Move Parallax', 'theplus' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'theplus' ),
				'label_off'   => esc_html__( 'No', 'theplus' ),
				'description' => esc_html__( 'This effect will be parallax on scroll effect. It will move image as you scroll your page.', 'theplus' ),
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'plus_mouse_pro_options',
			array(
				'label'       => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => theplus_pro_ver_notice(),
				'classes'     => 'plus-pro-version',
				'condition'   => array(
					'plus_mouse_move_parallax' => 'yes',
				),
			)
		);
		$this->add_control(
			'messy_column',
			array(
				'label'     => esc_html__( 'Messy Columns', 'theplus' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'On', 'theplus' ),
				'label_off' => esc_html__( 'Off', 'theplus' ),
				'default'   => 'no',
				'separator' => 'before',
			)
		);
		$this->add_control(
			'messy_pro_options',
			array(
				'label'       => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => theplus_pro_ver_notice(),
				'classes'     => 'plus-pro-version',
				'condition'   => array(
					'messy_column' => 'yes',
				),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Render World limit
	 *
	 * @param string $string The attribute slug for string.
	 * @param string $word_limit The attribute slug for word limit.
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	protected function limit_words( $string, $word_limit ) {
		$words = explode( ' ', $string );
		return implode( ' ', array_splice( $words, 0, $word_limit ) );
	}

	/**
	 * Render Dynamic Categories
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$dynamic_categories = $this->get_query_args();

		$style  = ! empty( $settings['style'] ) ? $settings['style'] : 'style_1';
		$layout = ! empty( $settings['layout'] ) ? $settings['layout'] : 'grid';

		$thumbnail = $settings['thumbnail_size'];

		$post_taxonomies = ! empty( $settings['post_taxonomies'] ) ? $settings['post_taxonomies'] : 'category';
		$hide_parent_cat = isset( $settings['hide_parent_cat'] ) ? $settings['hide_parent_cat'] : 'no';

		$display_thumbnail = isset( $settings['display_thumbnail'] ) ? $settings['display_thumbnail'] : 'no';
		$on_hover_bg_image = isset( $settings['on_hover_bg_image'] ) ? $settings['on_hover_bg_image'] : 'no';

		$onhoverbgclass = '';
		if ( 'yes' === $on_hover_bg_image ) {
			$onhoverbgclass = ' tp-dc-st3-bgimg';
		}

		/** Columns*/
		$desktop_class = '';
		$tablet_class  = '';
		$mobile_class  = '';
		if ( 'carousel' !== $layout && 'metro' !== $layout ) {
			if ( '5' === $settings['desktop_column'] ) {
				$desktop_class = 'theplus-col-5';
			} else {
				$desktop_class = 'tp-col-lg-' . esc_attr( $settings['desktop_column'] );
			}
			$tablet_class  = 'tp-col-md-' . esc_attr( $settings['tablet_column'] );
			$mobile_class  = 'tp-col-sm-' . esc_attr( $settings['mobile_column'] );
			$mobile_class .= ' tp-col-' . esc_attr( $settings['mobile_column'] );
		}

		/** Layout*/
		$layout_attr = '';
		$data_class  = '';
		if ( ! empty( $layout ) ) {
			$data_class .= l_theplus_get_layout_list_class( $layout );
			$layout_attr = l_theplus_get_layout_list_attr( $layout );
		} else {
			$data_class .= ' list-isotope';
		}
		if ( 'metro' === $layout ) {
			$metro_columns = ! empty( $settings['metro_column'] ) ? $settings['metro_column'] : '';

			$layout_attr .= ' data-metro-columns="' . esc_attr( $metro_columns ) . '" ';
			$layout_attr .= ' data-metro-style="' . esc_attr( $settings[ 'metro_style_' . $metro_columns ] ) . '" ';

		}

		$data_class .= ' dynamic-cat-' . $style;

		$output    = '';
		$data_attr = '';

		$ji = 1;
		$ij = '';

		$uid = uniqid( 'post' );
		if ( ! empty( $settings['carousel_unique_id'] ) ) {
			$uid = 'tpca_' . $settings['carousel_unique_id'];
		}
		$data_attr .= ' data-id="' . esc_attr( $uid ) . '"';
		$data_attr .= ' data-style="' . esc_attr( $style ) . '"';

		$tablet_metro_class = '';
		$tablet_ij          = '';

		if ( ! $dynamic_categories ) {
			$output .= '<h3 class="theplus-posts-not-found">' . esc_html__( 'Terms are not found', 'theplus' ) . '</h3>';
		} elseif ( 'carousel' === $layout ) {
			$output .= '<h3 class="theplus-posts-not-found">' . esc_html__( 'This Style Premium Version', 'tpebl' ) . '</h3>';
			echo $output;
		} else {
			if ( ! is_object( $dynamic_categories ) ) {
				$output .= '<div id="pt-plus-dynamic-cat-list" class="dynamic-cat-list ' . esc_attr( $uid ) . ' ' . esc_attr( $data_class ) . ' ' . esc_attr( $onhoverbgclass ) . '" ' . $layout_attr . ' ' . $data_attr . ' data-enable-isotope="1">';

				$output .= '<div id="' . esc_attr( $uid ) . '" class="tp-row post-inner-loop ' . esc_attr( $uid ) . ' ">';
				foreach ( $dynamic_categories as $prod_cat ) :
					$featured_image = '';
					if ( $prod_cat->parent == 0 && 'yes' === $hide_parent_cat ) {
						/** Code*/
					} else {
						$cat_thumb_id = get_term_meta( $prod_cat->term_id, 'tp_taxonomy_image', true );
						if ( ! empty( $cat_thumb_id ) ) {
							$cat_img = $cat_thumb_id;
							if ( ( 'grid' === $layout ) && ! empty( $cat_thumb_id ) ) {
								if ( ( 'yes' === $display_thumbnail ) && ! empty( $thumbnail ) ) {
									$cat_thumb_id = wp_get_attachment_image_url( get_term_meta( $prod_cat->term_id, 'tp_taxonomy_image_id', true ), $thumbnail );
								} else {
									$cat_thumb_id = wp_get_attachment_image_url( get_term_meta( $prod_cat->term_id, 'tp_taxonomy_image_id', true ), 'tp-image-grid' );
								}
							} elseif ( ( 'masonry' === $layout || 'metro' === $layout ) && ! empty( $cat_thumb_id ) ) {
								if ( ( 'yes' === $display_thumbnail ) && ! empty( $thumbnail ) ) {
									$cat_thumb_id = wp_get_attachment_image_url( get_term_meta( $prod_cat->term_id, 'tp_taxonomy_image_id', true ), $thumbnail );
								} else {
									$cat_thumb_id = wp_get_attachment_image_url( get_term_meta( $prod_cat->term_id, 'tp_taxonomy_image_id', true ), 'full' );
								}
							}
							$featured_image = '<img src="' . esc_url( $cat_thumb_id ) . '" alt="' . esc_attr( get_the_title() ) . '">';
						} elseif ( 'product_cat' === $post_taxonomies || 'product_tag' === $post_taxonomies ) {

							$cat_thumb_id = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );

							$shop_catalog_img = '';

							if ( ( 'grid' === $layout ) && ! empty( $cat_thumb_id ) ) {
								if ( ( 'yes' === $display_thumbnail ) && ! empty( $thumbnail ) ) {
									$shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, $thumbnail );
								} else {
									$shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'tp-image-grid' );
								}
							} elseif ( ( 'masonry' === $layout || 'metro' === $layout ) && ! empty( $cat_thumb_id ) ) {
								if ( ( 'yes' === $display_thumbnail ) && ! empty( $thumbnail ) ) {
									$shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, $thumbnail );
								} else {
									$shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'full' );
								}
							}

							if ( ! empty( $shop_catalog_img ) && ! empty( $cat_thumb_id ) ) {
								$cat_img = $shop_catalog_img[0];

								$featured_image = '<img src="' . esc_url( $cat_img ) . '" alt="' . esc_attr( get_the_title() ) . '">';
							} else {
								$cat_img = l_theplus_get_thumb_url();

								$featured_image = '<img src="' . esc_url( $cat_img ) . '" alt="' . esc_attr( get_the_title() ) . '">';
							}
						} else {
							$cat_img = l_theplus_get_thumb_url();

							$featured_image = '<img src="' . esc_url( $cat_img ) . '" alt="' . esc_attr( get_the_title() ) . '">';
						}

						$category_link = get_term_link( $prod_cat, $post_taxonomies );
						$category_name = $prod_cat->name;

						if ( ( ! empty( $settings['desc_text_limit'] ) && 'yes' === $settings['desc_text_limit'] ) && ! empty( $settings['display_description_input'] ) ) {
							if ( ! empty( $settings['display_description_by'] ) ) {
								if ( 'char' === $settings['display_description_by'] ) {
									$category_description = substr( $prod_cat->description, 0, $settings['display_description_input'] );
								} elseif ( 'word' === $settings['display_description_by'] ) {
									$category_description = $this->limit_words( $prod_cat->description, $settings['display_description_input'] );
								}
							}
							if ( 'char' === $settings['display_description_by'] ) {
								if ( strlen( $prod_cat->description ) > $settings['display_description_input'] ) {
									if ( ! empty( $settings['display_title_3_dots'] ) && 'yes' === $settings['display_title_3_dots'] ) {
										$category_description .= '...';
									}
								}
							} elseif ( 'word' === $settings['display_description_by'] ) {
								if ( str_word_count( $prod_cat->description ) > $settings['display_description_input'] ) {
									if ( ! empty( $settings['display_title_3_dots'] ) && 'yes' === $settings['display_title_3_dots'] ) {
										$category_description .= '...';
									}
								}
							}
						} else {
							$category_description = $prod_cat->description;
						}
						$category_product_count = $prod_cat->count;

						if ( 'metro' === $layout ) {
							$metro_columns = $settings['metro_column'];
							if ( ! empty( $settings[ 'metro_style_' . $metro_columns ] ) ) {
								$ij = l_theplus_metro_style_layout( $ji, $settings['metro_column'], $settings[ 'metro_style_' . $metro_columns ] );
							}
						}

						/** Grid item loop*/
						$output .= '<div class="grid-item metro-item' . esc_attr( $ij ) . ' ' . esc_attr( $tablet_metro_class ) . ' ' . $desktop_class . ' ' . $tablet_class . ' ' . $mobile_class . ' " >';

						if ( 'product_cat' === $post_taxonomies || 'product_tag' === $post_taxonomies ) {
							$cat_img = $cat_img;
						} else {
							$cat_img = $cat_thumb_id;
						}

						$cdclass = '';
						if ( empty( $category_description ) ) {
							$cdclass = ' tp-cd-empty-dsc';
						}

						if ( 'style_1' === $style ) {
							$output .= '<div class="pt-dynamic-wrapper-main " >';

								$output .= '<div class="pt-dynamic-wrapper ' . esc_attr( $style ) . '">';

									$output .= '<div class="pt-dynamic-content">';
							if ( 'metro' === $layout ) {
								$output .= '<a href="' . esc_url( $category_link ) . '">';
								if ( 'yes' === $settings['cl_hover_content_swich'] ) {
									$output .= '<div class="extra-wcc-inn">';
								}
								$output .= '<div class="dynamic-cat-bg-image-metro" style="background:url(' . $cat_img . ') center/cover"></div>';
							} else {
								$output .= '<a href="' . esc_url( $category_link ) . '">';
								if ( 'yes' === $settings['cl_hover_content_swich'] ) {
									$output .= '<div class="extra-wcc-inn">';
								}
								$output .= $featured_image;
							}

							$output .= '<div class="pt-dynamic-hover-content ">';

							$output .= '<div class="pt-dynamic-hover-content-inner ">';

							$output .= '<div class="pt-dynamic-hover-cat-name">' . esc_attr( $category_name ) . ' </div>';

							if ( ! empty( $settings['hide_pro_count'] ) && 'yes' === $settings['hide_pro_count'] ) {
								$output .= '<div class="pt-dynamic-hover-cat-count">' . $category_product_count . '';

								if ( ! empty( $settings['count_extra_text'] ) ) {
									$output .= '<span class="count_extra_txt">' . $settings['count_extra_text'] . '</span>';
								}

								$output .= '</div>';
							}

							$output .= '</div>';

							if ( ! empty( $settings['display_description'] ) && 'yes' === $settings['display_description'] ) {
								$output .= '<div class="pt-dynamic-hover-cat-desc ' . esc_attr( $cdclass ) . '">' . $category_description . ' </div>';
							}

							$output .= '</div>';
							if ( 'yes' === $settings['cl_hover_content_swich'] ) {
								$output .= '</div>';
							}

							$output .= '</a>';

							$output .= '</div>';

							$output .= '</div>';

							$output .= '</div>';

						} elseif ( 'style_2' === $style ) {
							$output .= '<div class="pt-dynamic-wrapper-main " >';

							$output .= '<div class="pt-dynamic-wrapper ' . $style . '">';

							$output .= '<div class="pt-dynamic-content">';

							if ( 'metro' === $layout ) {
								$output .= '<a href="' . esc_url( $category_link ) . '"> <div class="dynamic-cat-bg-image-metro" style="background:url(' . $cat_img . ') center/cover"></div>';
							} else {
								$output .= '<a href="' . esc_url( $category_link ) . '"> ' . $featured_image . ' ';
							}

							$output .= '<div class="pt-dynamic-hover-content">';

							$output .= '<div class="pt-dynamic-hover-content-inner " >';

							$output .= '<div class="pt-dynamic-hover-cat-name">' . esc_attr( $category_name ) . ' </div>';

							if ( ! empty( $settings['hide_pro_count'] ) && 'yes' === $settings['hide_pro_count'] ) {
								$output .= '<div class="pt-dynamic-hover-cat-count">' . $category_product_count . '';
								if ( ! empty( $settings['count_extra_text'] ) ) {
									$output .= '<span class="count_extra_txt">' . wp_kses_post( $settings['count_extra_text'] ) . '</span>';
								}

								$output .= '</div>';
							}

							if ( ! empty( $settings['display_description'] ) && 'yes' === $settings['display_description'] ) {
								$output .= '<div class="pt-dynamic-hover-cat-desc ' . esc_attr( $cdclass ) . '">' . wp_kses_post( $category_description ) . ' </div>';
							}

							$output .= '</div>';

							$output .= '</div>';

							$output .= '</a>';

							$output .= '</div>';

							$output .= '</div>';

							$output .= '</div>';

						} elseif ( 'style_3' === $style ) {
							$output .= '<div class="pt-dynamic-wrapper-main " >';

							$output .= '<div class="pt-dynamic-wrapper ' . esc_attr( $style ) . '" data-bgimage="' . $cat_img . '">';

							$output .= '<div class="pt-dynamic-content">';

							if ( 'metro' === $layout ) {
								$output .= '<a href="' . esc_url( $category_link ) . '"> <div class="dynamic-cat-bg-image-metro" style="background:url(' . $cat_img . ') center/cover"></div>';
							} else {
								$output .= '<a href="' . esc_url( $category_link ) . '">';
							}

							$output .= '<div class="pt-dynamic-hover-content">';

							$output .= '<div class="pt-dynamic-hover-content-inner " >';

							$output .= '<div class="pt-dynamic-hover-cat-name">' . $category_name . ' </div>';

							if ( ! empty( $settings['hide_pro_count'] ) && 'yes' === $settings['hide_pro_count'] ) {
								$output .= '<div class="pt-dynamic-hover-cat-count">' . $category_product_count . '';

								if ( ! empty( $settings['count_extra_text'] ) ) {
									$output .= '<span class="count_extra_txt">' . wp_kses_post( $settings['count_extra_text'] ) . '</span>';
								}

								$output .= '</div>';
							}

							$output .= '</div>';

							$output .= '</div>';

							$output .= '</a>';

							$output .= '</div>';

							$output .= '</div>';

							$output .= '</div>';
						}

						$output .= '</div>';

						++$ji;
					}

				endforeach;
				$output .= '</div>';

				$output .= '</div>';
			}

			echo $output;
			wp_reset_postdata();
		}
	}

	/**
	 * Render queries
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	protected function get_query_args() {
		$settings = $this->get_settings_for_display();

		$post_offset   = ! empty( $settings['post_offset'] ) ? $settings['post_offset'] : 0;
		$display_posts = ! empty( $settings['display_posts'] ) ? $settings['display_posts'] : 0;
		$post_category = $settings['post_category'] ? explode( ',', $settings['post_category'] ) : array();

		$post_taxonomies   = $settings['post_taxonomies'];
		$post_category_exc = $settings['post_category_exc'] ? explode( ',', $settings['post_category_exc'] ) : array();

		$dynamic_categories = get_terms(
			$post_taxonomies,
			array(
				'orderby'    => $settings['post_order_by'],
				'order'      => $settings['post_order'],
				'number'     => $display_posts,
				'offset'     => $post_offset,
				'include'    => $post_category,
				'exclude'    => $post_category_exc,
				'hide_empty' => ( 'yes' === $settings['hide_empty'] ) ? 1 : 0,
				'parent'     => ( ( $settings['hide_sub_cat'] ) && 'yes' === $settings['hide_sub_cat'] ) ? 0 : '',
			)
		);

		return $dynamic_categories;
	}

	/**
	 * Render content_template
	 *
	 * @since 3.0.0
	 * @version 5.4.2
	 */
	protected function content_template() {}
}
