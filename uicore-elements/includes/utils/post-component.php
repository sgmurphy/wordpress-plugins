<?php
namespace UiCoreElements\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Plugin;

use UiCoreElements\Helper;
use UiCoreElements\Controls\Query;
use UiCoreElements\Controls\Post_Filter;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Includes\Widgets\Traits\Button_Trait;
use UiCoreElements\Utils\Meta_Trait;

defined('ABSPATH') || exit();

/**
 * Post Component
 *
 * @since 1.0.4
 */

trait Post_Trait {

    use Button_Trait,
        Meta_Trait;

    // Control Register Content functions
    function TRAIT_register_post_item_controls($section = true)
    {
        if($section) {
            $this->start_controls_section(
                'section_item_content',
                [
                    'label' => esc_html__('Item', 'uicore-elements'),
                ]
            );
        }
            $this->add_control(
                'box_style',
                [
                    'label' => __('Item Style', 'uicore-elements'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'classic',
                    'options' => [
                        'classic'  => __('Classic', 'uicore-elements'),
                        'split' => __('Split', 'uicore-elements'),
                        'overlay' => __('Overlay', 'uicore-elements'),
                    ],
                    'render_type' => 'template',
                    'prefix_class' => 'ui-e-apg-',
                ]
            );
            $this->add_control(
                'image',
                [
                    'label' => __('Image', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                    'default' => 'yes'
                ]
            );
            $this->add_control(
                'image_size_select',
                [
                    'label' => __('Image Size', 'uicore-elements'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'uicore-medium',
                    'options' => Helper::get_images_sizes(),
                    'condition' => [
                        'image' => 'yes',
                    ]
                ]
            );
            // $this->add_control('cat_type',[
            //         'label' => __( 'Cat Type', 'uicore-elements' ),
            //         'type' => Controls_Manager::SELECT,
            //         'default' => 'category',
            //         'options' => [
            //             'category'  => __( 'Category', 'uicore-elements' ),
            //             'custom' => __( 'Custom Taxonomy', 'uicore-elements' ),
            //         ],
            //         'condition' => array(
            //             'category' => 'yes',
            //         ),
            //     ]
            // );
            //     $this->add_control('cat_type_name',[
            //             'label' => __( 'Taxonomy', 'uicore-elements' ),
            //             'type' => Controls_Manager::TEXT,
            //             'placeholder' => __( 'my_custom_tax', 'uicore-elements' ),
            //             'condition' => array(
            //                 'cat_type' => 'custom',
            //             ),
            //         ]
            //     );
            $this->add_control(
                'title',
                [
                    'label' => __('Title', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                    'default' => 'yes'
                ]
            );
            $this->add_control(
                'excerpt',
                [
                    'label' => __('Excerpt', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                    'default' => 'yes'
                ]
            );
            $this->add_control(
                'excerpt_trim',
                [
                    'label' => __('Excerpt Length (words)', 'uicore-elements'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 5,
                    'max' => 100,
                    'step' => 1,
                    'default' => 55,
                    'condition' => array(
                        'excerpt' => 'yes',
                    ),
                ]
            );
            $this->add_control(
                'show_button',
                [
                    'label' => __('Read More Button', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                    'default' => 'no'
                ]
            );
        if($section) {
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_button_controls($section = true)
    {
        if($section){
            $this->start_controls_section(
                'section_button_content',
                [
                    'label' => esc_html__('Button', 'uicore-elements'),
                    'condition' => array(
                        'show_button' => 'yes',
                    ),
                ]
            );
        }

            $this->register_button_content_controls(
                [
                    'section_condition' => [
                        'show_button' => 'yes'
                    ],
                    'button_default_text' => 'Read More'
                ]
            );
            $this->remove_control('button_type');
            $this->remove_control('link');
            $this->remove_control('button_css_id');
            $this->remove_control('size');
            $this->remove_control('align');

        if($section){
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_meta_controls($section = true)
    {
        if($section){
            $this->start_controls_section(
                'section_extra_item_content',
                [
                    'label' => esc_html__('Meta', 'uicore-elements'),
                ]
            );
        }

            $this->add_control(
                'top_meta',
                [
                    'label' => esc_html__('Top Meta', 'uicore-elements'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $this->get_meta_content_controls(),
                    'default' => [
                        [
                            'type' => 'author'
                        ],
                    ],
                    'title_field' => '<span style="text-transform: capitalize">{{{ type }}}</span>',
                    'prevent_empty' => false,
                    'separator' => 'before'
                ]
            );
            $this->add_control(
                'before_title_meta',
                [
                    'label' => esc_html__('Before Title Meta', 'uicore-elements'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $this->get_meta_content_controls(),
                    'default' => [
                        [
                            'type' => 'author'
                        ],
                    ],
                    'title_field' => '<span style="text-transform: capitalize">{{{ type }}}</span>',
                    'prevent_empty' => false,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'after_title_meta',
                [
                    'label' => esc_html__('After Title Meta', 'uicore-elements'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $this->get_meta_content_controls(),
                    'default' => [
                        [
                            'type' => 'author'
                        ],
                    ],
                    'title_field' => '<span style="text-transform: capitalize">{{{ type }}}</span>',
                    'prevent_empty' => false,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'bottom_meta',
                [
                    'label' => esc_html__('Bottom Meta', 'uicore-elements'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $this->get_meta_content_controls(),
                    'default' => [
                        [
                            'type' => 'author'
                        ],
                    ],
                    'title_field' => '<span style="text-transform: capitalize">{{{ type }}}</span>',
                    'prevent_empty' => false,
                    'separator' => 'before',
                ]
            );
        if($section){
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_query_controls($section = true)
    {
        if($section){
            $this->start_controls_section(
                'section_post_grid_def',
                [
                    'label' => esc_html__('Query', 'uicore-elements'),
                ]
            );
        }

            $this->add_group_control(
                Post_Filter::get_type(),
                [
                    'name' => 'posts-filter',
                    'label' => esc_html__('Posts', 'uicore-elements'),
                    'description' => esc_html__('Current Query Settings > Reading', 'uicore-elements'),
                ]
            );
            $this->add_control(
                'item_limit',
                [
                    'label' => esc_html__('Item Limit', 'uicore-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'reder_type' => 'template',
                    'range' => [
                        'px' => [
                            'min' => -1,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 3,
                    ],
                    'condition' => array(
                        'posts-filter_post_type!' => 'current',
                    ),
                ]
            );

            $this->add_control(
                'offset',
                [
                    'label' => esc_html__('Query Offset', 'uicore-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'render_type' => 'template',
                    'range' => [
                        'px' => [
                            'min' => -1,
                            'max' => 10,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                    ],
                    'condition' => [
                        'pagination_type' => 'numbers',
                    ]
                ]
            );

            $this->add_control(
                'offset_alert',
                [
                    'type' => Controls_Manager::ALERT,
                    'alert_type' => 'info',
                    'content' => esc_html__('Offset is disabled with Load More pagination.', 'uicore-elements'),
                    'condition' => [
                        'pagination_type!' => 'numbers',
                    ]
                ]
            );

            $this->add_control(
                'sticky',
                [
                    'label' => esc_html__('Sticky Posts', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Show', 'uicore-elements'),
                    'label_off' => esc_html__('Hide', 'uicore-elements'),
                    'description' => esc_html__('Sticky posts works only on the front-end.', 'uicore-elements'),
                    'return_value' => 1,
                    'default' => 0,
                    'condition' => [
                        'pagination!' => 'yes',
                    ],
                ]
            );

        if($section){
            $this->end_controls_section();
        }
    }

    // Styles
    function TRAIT_register_post_item_style_controls($section = true, $active_tab = false)
    {
        if($section){
            $this->start_controls_section(
                'section_style_item',
                [
                    'label' => __('Item Style', 'uicore-elements'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
        }

            $this->start_controls_tabs(
                'item_border_shadow'
            );

                $this->start_controls_tab(
                    'item_bs_normal_tab',
                    [
                        'label' => esc_html__('Normal', 'plugin-name'),
                    ]
                );
                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'item_border',
                            'selector' => '{{WRAPPER}} .ui-e-item article',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'item_shadow',
                            'selector' => '{{WRAPPER}} .ui-e-item article',
                        ]
                    );
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'item_bs_hover_tab',
                    [
                        'label' => esc_html__('Hover', 'plugin-name'),
                    ]
                );
                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'item_border_hover',
                            'selector' => '{{WRAPPER}} .ui-e-item:hover article',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'item_shadow_hover',
                            'selector' => '{{WRAPPER}} .ui-e-item:hover article',
                        ]
                    );
                $this->end_controls_tab();

                if($active_tab){
                    $this->start_controls_tab(
                        'item_bs_active_tab',
                        [
                            'label' => esc_html__('Active', 'plugin-name'),
                        ]
                    );
                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'item_border_active',
                                'selector' => '{{WRAPPER}} .ui-e-item.ui-e-active article',
                            ]
                        );
                        $this->add_group_control(
                            Group_Control_Box_Shadow::get_type(),
                            [
                                'name' => 'item_shadow_active',
                                'selector' => '{{WRAPPER}} .ui-e-item.ui-e-active article',
                            ]
                        );
                    $this->end_controls_tab();
                }

            $this->end_controls_tabs();

            $this->add_control(
                'item_radius',
                [
                    'label'       => esc_html__('Border Radius', 'uicore-elements'),
                    'type'        => Controls_Manager::DIMENSIONS,
                    'separator' => 'before',
                    'selectors'   => [
                        '{{WRAPPER}} ' => '--ui-e-border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
                    ],
                ]
            );

        if($section){
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_content_style_controls($section = true)
    {
        if($section){
            $this->start_controls_section(
                'section_style_content',
                [
                    'label' => __('Content Style', 'uicore-elements'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
        }
            $this->add_control(
                'image_size',
                [
                    'label' => __('Image Height (%)', 'uicore-elements'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 500,
                    'step' => 1,
                    'default' => 57,
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-top' => '--ui-e-img-size: {{VALUE}}',
                    ],
                    'condition' => [
                        'masonry!' => 'ui-e-maso',
                    ],
                ]
            );
            $this->add_control(
                'image_overflow',
                [
                    'label' => __('Independent Border Radius and Shadow', 'uicore-elements'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'prefix_class' => 'ui-e-post-ovf-',
                    'condition' => array(
                        'box_style!' => 'overlay',
                    ),
                ]
            );
            $this->add_control(
                'image_radius',
                [
                    'label'       => esc_html__('Border Radius', 'uicore-elements'),
                    'type'        => Controls_Manager::DIMENSIONS,
                    'selectors'   => [
                        '{{WRAPPER}} .ui-e-post-top' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;'
                    ],
                    'condition' => array(
                        'image_overflow' => 'yes',
                    ),
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'image_shadow',
                    'label' => esc_html__('Box Shadow', 'uicore-elements'),
                    'selector' => '{{WRAPPER}} .ui-e-post-top',
                    'condition' => array(
                        'image_overflow' => 'yes',
                    ),
                ]
            );
            $this->add_responsive_control(
                'content_alignment',
                [
                    'label' => esc_html__('Content Alignment', 'uicore-elements'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => esc_html__('Left', 'uicore-elements'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__('Center', 'uicore-elements'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'stretch' => [
                            'title' => esc_html__('Justified', 'uicore-elements'),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-content' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__('Title Color', 'uicore-elements'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'separator' => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-title' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_hcolor',
                [
                    'label' => esc_html__('Title Hover Color', 'uicore-elements'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-title:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => esc_html__('Title Typography', 'uicore-elements'),
                    'selector' => '{{WRAPPER}} .ui-e-post-title',
                ]
            );
            $this->add_control(
                'title_gap',
                [
                    'label' => __('Title Top Space', 'uicore-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['em'],
                    'separator' => 'after',
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'em',
                        'size' => 1.2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-title' => 'margin-top: {{SIZE}}em;',
                    ],
                ]
            );
            $this->add_control(
                'text_color',
                [
                    'label' => esc_html__('Excerpt Color', 'uicore-elements'),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-text' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => esc_html__('Excerpt Typography', 'uicore-elements'),
                    'selector' => '{{WRAPPER}} .ui-e-post-text',
                ]
            );
            $this->add_control(
                'text_gap',
                [
                    'label' => __('Excerpt Top Space', 'uicore-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['em'],
                    'separator' => 'after',
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'em',
                        'size' => 0.8,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-post-text' => 'margin-top: {{SIZE}}em;',
                    ],
                ]
            );
            $this->add_responsive_control(
                'content_padding',
                [
                    'label'      => esc_html__('Content Padding', 'uicore-elements'),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .ui-e-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
            $this->add_control(
                'content_gap',
                [
                    'label' => __('Content Space', 'uicore-elements'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => ['em'],
                    'separator' => 'after',
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'em',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} ' => '--ui-e-content-space: {{SIZE}}em;',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'content_bg',
                    'selector' => '{{WRAPPER}} .ui-e-post-content',
                ]
            );

        if($section){
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_button_style_controls($section = true)
    {
        if($section){
            $this->start_controls_section(
                'section_button_style',
                [
                    'label' => esc_html__('Button Style', 'uicore-elements'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => array(
                        'show_button' => 'yes',
                    ),
                ]
            );
        }
            $this->add_responsive_control(
                'button_align',
                [
                    'label' => esc_html__( 'Alignment', 'elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'start'    => [
                            'title' => esc_html__( 'Left', 'elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => esc_html__( 'Center', 'elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'end' => [
                            'title' => esc_html__( 'Right', 'elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'normal' => [
                            'title' => esc_html__( 'Justified', 'elementor' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'default' => 'start',
                    'selectors' => [
                        '{{WRAPPER}} .ui-e-readmore' => 'align-self: {{VALUE}};',
                    ],

                ]
            );
            $this->register_button_style_controls(
                [
                    'section_condition' => [
                        'show_button' => 'yes'
                    ]
                ]
            );
            // Remove button alignment from Elementor button traits because (seens to be a bug), updating Selector CSS with update_control(), don't work as expected with responsiveness
            $this->remove_responsive_control('align');

            $this->TRAIT_register_post_specific_controls('button_gap');

        if($section) {
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_meta_style_controls($section = true)
    {
        if($section) {
            $this->start_controls_section(
                'section_style_extra_content',
                [
                    'label' => __('Meta Style', 'uicore-elements'),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );
        }
            $this->start_controls_tabs('style_extra_tabs');
                $this->start_controls_tab(
                    'style_top_tab',
                    [
                        'label' => esc_html__('Top', 'uicore-elements'),
                    ]
                );
                    $this->get_meta_style_controls('top');
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'style_before_title_tab',
                    [
                        'label' => esc_html__('Before Title', 'uicore-elements'),
                    ]
                );
                    $this->get_meta_style_controls('before_title');
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'style_after_title_tab',
                    [
                        'label' => esc_html__('After Title', 'uicore-elements'),
                    ]
                );
                    $this->get_meta_style_controls('after_title');
                $this->end_controls_tab();

                $this->start_controls_tab(
                    'style_bottom_tab',
                    [
                        'label' => esc_html__('Bottom', 'uicore-elements'),
                    ]
                );
                $this->get_meta_style_controls('bottom');
                $this->end_controls_tab();
            $this->end_controls_tabs();

        if($section) {
            $this->end_controls_section();
        }
    }
    function TRAIT_register_post_animation_controls()
    {
        $this->add_control(
            'anim_image',
            [
                'label' => __('Image Hover Animation', 'uicore-elements'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'ui-e-img-anim-zoom',
                'options' => [
                    '' => __('None', 'uicore-elements'),
                    'ui-e-img-anim-zoom' => __('Zoom', 'uicore-elements'),
                ],
                'prefix_class'       => '',
            ]
        );
        $this->add_control(
            'anim_meta',
            [
                'label' => __('Meta Hover Animation', 'uicore-elements'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => '',
                'options' => [
                    '' => __('None', 'uicore-elements'),
                    'ui-e-meta-anim-show' => __('Show', 'uicore-elements'),
                ],
                'prefix_class'       => '',
            ]
        );
        $this->add_control(
            'important_note',
            [
                'label' => esc_html__('Important Note', 'uicore-elements'),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-control-field-description" style="margin-top: -7px;">' . esc_html__('This works only for Below Title Meta.', 'uicore-elements') . '</div>',
                'show_label'    => false,
                'condition' => array(
                    'box_style' => 'overlay',
                ),
            ]
        );
        $this->add_control(
            'anim_title',
            [
                'label' => __('Title Hover Animation', 'uicore-elements'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => '',
                'options' => [
                    '' => __('None', 'uicore-elements'),
                    'ui-e-title-anim-underline' => __('Underline', 'uicore-elements'),
                ],
                'prefix_class'       => '',
            ]
        );
        $this->add_control(
            'anim_content',
            [
                'label' => __('Content Hover Animation', 'uicore-elements'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => '',
                'options' => [
                    '' => __('None', 'uicore-elements'),
                    'ui-e-content-anim-show' => __('Show', 'uicore-elements'),
                ],
                'prefix_class'       => '',
                'condition' => array(
                    'box_style' => 'overlay',
                ),
            ]
        );
        $this->add_control(
            'anim_btn',
            [
                'label' => __('Button Hover Animation', 'uicore-elements'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => '',
                'options' => [
                    '' => __('None', 'uicore-elements'),
                    'ui-e-btn-anim-show' => __('Show', 'uicore-elements'),
                ],
                'prefix_class'       => '',
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );
    }

    /**
     * Registers specific controls that can't be registered in blocks because of diferent use by different widgets or some other reason.
     *
     * @param string $control The control to register.
     * @return void
     */
    function TRAIT_register_post_specific_controls($control)
    {
        switch ($control) {
            case 'button_gap':
                $this->add_control(
                    'button_gap',
                    [
                        'label' => __('Button Top Space', 'uicore-elements'),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => ['em'],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 3,
                                'step' => 0.1,
                            ],
                        ],
                        'default' => [
                            'unit' => 'em',
                            'size' => 0.8,
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .elementor-button' => 'margin-top: {{SIZE}}em;',
                        ],
                    ]
                );
                break;
        }
    }

    // Helper functions
    function TRAIT_query_posts($settings)
    {
        $post_type = $settings['posts-filter_post_type'];

        if ( $post_type === 'related' ) {
            $this->_query = Helper::get_related('random', $settings['item_limit']['size']);

        } else {
            $query_args = Query::get_query_args('posts-filter', $settings, get_the_ID());

            if ($post_type === 'portfolio') {
                $query_args['orderby'] = 'menu_order date';
            }

            if ($post_type === 'current') {
                unset($query_args['posts_per_page']);
            }

            $this->_query = new \WP_Query($query_args);
        }
    }


     // Render functions
    function get_post_image()
    {

        if ($this->get_settings_for_display('image') === 'yes') {
            $pic_id = get_post_thumbnail_id();
            if (!$pic_id)
                return;
            $size = $this->get_settings_for_display('image_size_select') ?? 'uicore-medium';
            ?>
            <a class="ui-e-post-img-wrapp" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr__('View Post:', 'uicore-elements') . the_title_attribute(['echo' => false]); ?>">
                <?php if ($this->get_settings_for_display('masonry') === 'ui-e-maso') { ?>
                    <?php the_post_thumbnail($size, ['class' => 'ui-e-post-img']); ?>
                <?php } else { ?>
                    <div class="ui-e-post-img" style="background-image:url(<?php echo wp_get_attachment_image_url($pic_id, $size) ?>)"></div>
                <?php } ?>
            </a>
        <?php
        }
    }
    function get_post_title()
    {
        if ($this->get_settings_for_display('title') === 'yes')
        ?>
        <a href="<?php echo esc_url( get_permalink() );?>" title="<?php echo esc_attr__('View Post:','uicore-elements') . esc_html(the_title_attribute(['echo'=>false])); ?>">
            <h4 class="ui-e-post-title"><span><?php echo esc_html(get_the_title()); ?></span></h4>
        </a>
        <?php
    }
    function get_post_meta($position)
    {
        $meta_list = $this->get_settings_for_display($position . '_meta');
        if (!isset($meta_list[0]) || $meta_list[0]['type'] == '') {
            return;
        }
        echo ($position == 'top') ? '<div class="ui-e-post-top-meta">' :  '';
        echo ($position == 'after_title') ? '<div class="ui-e-meta-wrapp">' :  '';
        echo '<div class="ui-e-post-meta ui-e-'.esc_attr($position).'">';
            foreach ($meta_list as $meta) {
                if($meta['type'] != 'none'){
                    echo '<div class="ui-e-meta-item">';
                    $this->display_meta($meta);
                    echo '</div>';

                    if( next( $meta_list ) && $this->get_settings_for_display( $position.'_meta_separator' ) ) {
                        echo '<span class="ui-e-separator">'.esc_html($this->get_settings_for_display( $position.'_meta_separator' )).'</span>';
                    }
                }
            }
        echo '</div>';
        echo ($position == 'top' || $position == 'after_title') ? '</div>' : '';
    }
    function get_button()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('button', [
            'class' => ['elementor-button-link', 'elementor-button', 'ui-e-readmore'],
            'role'  => 'button',
        ]);
        $this->add_render_attribute('content-wrapper', 'class', 'elementor-button-content-wrapper');

        if (!empty($settings['button_css_id'])) {
            $this->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        if (!empty($settings['size'])) {
            $this->add_render_attribute('button', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['hover_animation'])) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }
        $this->add_render_attribute([
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ]);

        $tbn_content = '<span ' . $this->get_render_attribute_string('content-wrapper') . '>';

        if (!empty($settings['icon']) || !empty($settings['selected_icon']['value'])) {
            $tbn_content .= '<span ' . $this->get_render_attribute_string('icon-align') . '>';
            \ob_start();
            Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
            $tbn_content .= \ob_get_clean();
            $tbn_content .= '</span>';
        }

        $tbn_content .= '<span ' . $this->get_render_attribute_string('text') . '>' . $this->get_settings_for_display('text') . '</span>';
        $tbn_content .= '</span>';

        if ('product' === get_post_type()) {
            // WooCommerce product
            global $product;

            if ($product) {
                // Display WooCommerce add to cart button
                echo wp_kses_post(apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" %s>%s</a>',
                        esc_url($product->add_to_cart_url()),
                        esc_attr(1),
                        $this->get_render_attribute_string('button'),
                        $tbn_content
                    ),
                    $product
                ));
            }
        } else {

            // Default button
        ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" <?php $this->print_render_attribute_string('button'); ?>>
                <?php echo Helper::esc_svg( $tbn_content ); ?>
            </a>
        <?php
        }
    }
    function TRAIT_render_item($carousel = false, $legacy = false)
    {
        $settings       = $this->get_settings_for_display();
        $excerpt_length = $settings['excerpt_trim'];

        // TODO: remove `ui-e-item-wrp`, at least, 2 releases after 1.0.6

        // Classnames but checking if we the widget is APG (legacy version)
        $item_classes     = $legacy ? ['ui-e-post-item', 'ui-e-item', 'ui-e-item-wrp'] : ['ui-e-item', 'ui-e-item-wrp'] ; // Single item lower wrap class receptor
        $hover_item_class = $legacy ? 'anim_item' : 'item_hover_animation'; // item hover animation class

        // If widget is not carousel type, we set animations classes directly on item selector
        if(!$carousel) {
            $item_classes[] = 'ui-e-animations-wrp';
            $item_classes[] = $settings['animate_items'] === 'ui-e-grid-animate' ? 'elementor-invisible' : '';
            $item_classes[] = $settings[$hover_item_class] !== '' ? $settings[$hover_item_class] : '';

        } else {
            // Get entrance and item hover animation classes
            $entrance   = (isset($settings['animate_items']) &&  $settings['animate_items'] == 'ui-e-grid-animate') ? 'elementor-invisible' : '';
            $hover      = isset($settings[$hover_item_class]) ? $settings[$hover_item_class] : ''; //$settings[$hover_item_class] : null;
            $animations = sprintf('%s %s', $entrance, $hover);

            // Check if entrance or hover animation are set
            $has_animation = !empty($entrance) || !empty($hover)

            // Prints extra wrappers required by the carousel script
            ?>
            <div class="ui-e-wrp swiper-slide">
            <?php if($has_animation) : ?>
                <div class="ui-e-animations-wrp <?php echo esc_attr($animations);?>">
            <?php endif; ?>

        <?php } ?>

            <div class="<?php echo esc_attr( implode(' ', $item_classes));?>">
                <article <?php post_class(); ?>>
                    <div class="ui-e-post-top">
                        <?php $this->get_post_image(); ?>
                        <?php $this->get_post_meta('top'); ?>
                    </div>
                    <div class="ui-e-post-content">
                        <?php $this->get_post_meta('before_title'); ?>
                        <?php
                        if ($this->get_settings_for_display('title') === 'yes')
                            $this->get_post_title();
                        ?>
                        <?php $this->get_post_meta('after_title'); ?>
                        <?php
                        if ($this->get_settings_for_display('excerpt'))
                            echo wp_kses_post('<div class="ui-e-post-text">' . wp_trim_words(get_the_excerpt(), $excerpt_length) . '</div>');
                        ?>
                        <?php $this->get_post_meta('bottom');  // button
                        ?>
                        <?php
                        if ($this->get_settings_for_display('show_button') === 'yes') {
                            // Add match height spacing element if carousel. May look intrusive, but is the simplest method compared
                            // to absolute positioning or catching last content element to apply margin.
                            if($carousel && $settings['match_height'] === 'yes'){
                                ?>
                                    <span class="ui-e-match-height"></span>
                                <?php
                            }
                            $this->get_button();
                        }
                        ?>
                    </div>
                </article>
            </div>

        <?php if($carousel) { ?>
            </div>
            <?php if($has_animation) : ?>
                </div>
            <?php endif; ?>

        <?php }
    }
}
