<?php

namespace UiCoreAnimate;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Plugin;

/**
 * Scripts and Styles Class
 */
class Elementor
{
    function __construct()
    {
        // Register new custom animations
        add_filter('elementor/controls/animations/additional_animations', [$this, 'new_animations'], 4);

        //only if UICORE_VERION is newer than 5.0.7 TODO: remove this check after 6.0.0 is released
        if (!defined('UICORE_VERSION') || (defined('UICORE_VERSION') && version_compare(UICORE_VERSION, '5.0.7', '>='))) {
            // Split text Heading animation
            add_action('elementor/element/heading/section_title_style/after_section_end', [$this, 'split_animation'], 55);
            add_action('elementor/element/text-editor/section_drop_cap/after_section_end', [$this, 'split_animation'], 55);
            add_action('elementor/element/highlighted-text/section_style_text/after_section_end', [$this, 'split_animation'], 55);
            //TODO: ADD uicore-the-title and uicore-page-description widgets

            //Floating Widget
            add_action('elementor/element/before_section_end', [$this, 'register_controls_for_float'], 10, 3);

            //Fluid Gradient extender
            add_action('elementor/element/section/section_advanced/before_section_start', [$this, 'fluid_gradient_controls']);
            add_action('elementor/element/container/section_background/before_section_end', [$this, 'fluid_gradient_controls']);

            //Animated Border
            add_action('elementor/element/before_section_end', [$this, 'animated_border'], 10, 2);
            add_action('elementor/element/container/section_border/before_section_end', [$this, 'animated_border_in_elements'], 10, 2);
            add_action('elementor/element/uicore-advanced-post-grid/section_style_item/before_section_end', [$this, 'animated_border_in_elements'], 10, 2);
            // add_action('elementor/element/uicore-advanced-post-carousel/section_style_item/before_section_end', [$this, 'animated_border_in_elements'], 10, 2);
            add_action('elementor/element/uicore-icon-list/section_list_items/before_section_end', [$this, 'animated_border_in_elements'], 10, 2);


            //Onscroll Effects
            if (class_exists('\UiCore\Elementor\Extender')) {
                $class = new \ReflectionClass('\UiCore\Elementor\Extender');
                if (!$class->hasMethod('container_onscroll_effect')) {
                    add_action('elementor/element/container/section_effects/after_section_end', [$this, 'container_onscroll_effect'], 2, 2);
                }
            }

            //required assets for extending
            add_action('elementor/frontend/section/before_render', [$this, 'should_script_enqueue']);
            add_action('elementor/frontend/container/before_render', [$this, 'should_script_enqueue']);
            add_action('elementor/frontend/widget/before_render', [$this, 'should_script_enqueue']);
            add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_scripts']);
        }
    }

    /**
     * Get all registered scripts
     *
     * @return array
     */
    public static function new_animations($animations)
    {
        $new_animations = [
            'ZoomOut - UiCore Animate' => [
                'zoomOut' => 'Zoom Out',
                'zoomOutDown' => 'Zoom Out Down',
                'zoomOutLeft' => 'Zoom Out Left',
                'zoomOutRight' => 'Zoom Out Right',
                'zoomOutUp' => 'Zoom Out Up',
            ],
        ];

        return \array_merge($animations, $new_animations);
    }



    static function split_animation(Controls_Stack $widget)
    {

        $widget->start_controls_section(
            'section_ui_split_animation',
            [
                'label' => UICORE_ANIMATE_BADGE . esc_html__('Split Text Animation', 'uicore-animate'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $widget->add_control(
            'ui_animate_split',
            [
                'label'              => esc_html__('Animate by Characters', 'uicore-animate'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'return_value'       => 'ui-split-animate',
                'frontend_available' => true,
                'prefix_class'       => ' ',
                // 'render_type'		 => 'none'
            ]
        );
        $widget->add_control(
            'ui_animate_split_by',
            [
                'label' => __('Split by', 'uicore-animate'),
                'type' => Controls_Manager::SELECT,
                'default' => 'chars',
                'options' => [
                    'chars' => __('Char', 'uicore-animate'),
                    'words' => __('word', 'uicore-animate'),
                    'lines' => __('line', 'uicore-animate'),
                ],
                'frontend_available' => true,
                'condition' => array(
                    'ui_animate_split' => 'ui-split-animate',
                ),
                'prefix_class'       => 'ui-splitby-',
                // 'render_type'		=> 'none'
            ]
        );
        $widget->add_control(
            'ui_animate_split_style',
            [
                'label' => __('Animation', 'uicore-animate'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fadeInUp',
                'options' => Helper::get_split_animations_list(),
                'frontend_available' => true,
                'condition' => array(
                    'ui_animate_split' => 'ui-split-animate',
                ),
                // 'render_type'		=> 'none'
            ]
        );


        $widget->add_control(
            'ui_animate_split_speed',
            [
                'label' => __('Speed', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'condition' => array(
                    'ui_animate_split' => 'ui-split-animate',
                ),
                'default' => [
                    'unit' => 'px',
                    'size' => 1500,
                ],
                'range' => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 3000,
                        'step' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' => '---ui-speed: {{SIZE}}ms',
                ],
            ]
        );
        $widget->add_control(
            'ui_animate_split_delay',
            [
                'label' => __('Animation Delay', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'condition' => array(
                    'ui_animate_split' => 'ui-split-animate',
                ),
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1500,
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' => '---ui-delay: {{SIZE}}ms',
                ],
            ]
        );
        $widget->add_control(
            'ui_animate_split_stager',
            [
                'label' => __('Stagger', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'condition' => array(
                    'ui_animate_split' => 'ui-split-animate',
                ),
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min'  => 2,
                        'max'  => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' => '---ui-stagger: {{SIZE}}ms',
                ],
            ]
        );

        $widget->end_controls_section();
    }


    public function enqueue_scripts($type)
    {
        $list = [
            'split' => [
                'script'    => true,
                'style'     => true
            ],
            'fluid' => [
                'script'    => true,
                'style'     => true
            ],
            'animated-border' => [
                'script'    => true,
                'style'     => true
            ],
            'onscroll-effects' => [
                'script'    => true,
                'style'     => false,
            ]
        ];
        if ($type) {
            $list = [$type => $list[$type]];
        }
        foreach ($list as $type => $data) {
            if ($data['script']) {
                wp_enqueue_script('ui-e-' . $type, UICORE_ANIMATE_URL . '/assets/js/' . $type . '.js', ['jquery'], UICORE_ANIMATE_VERSION, true);
            }
            if ($data['style']) {
                wp_enqueue_style('ui-e-' . $type, UICORE_ANIMATE_URL . '/assets/css/' . $type . '.css', [], UICORE_ANIMATE_VERSION,);
            }
        }
    }

    public function should_script_enqueue(\Elementor\Controls_Stack $widget)
    {

        // TODO: if cache experiment is enabled, we can't get control settings for display
        //if (Plugin::$instance->experiments->is_feature_active('e_element_cache')) {}

        if ('ui-split-animate' === $widget->get_settings_for_display('ui_animate_split')) {
            $this->enqueue_scripts('split');
        }
        if ('yes' === $widget->get_settings_for_display('section_fluid_on')) {
            $this->enqueue_scripts('fluid');
        }
        if ('' != $widget->get_settings_for_display('uicore_animated_border') || '' != $widget->get_settings_for_display('uicore_animated_border_item')) {
            $this->enqueue_scripts('animated-border');
        }
        if ('' != $widget->get_settings_for_display('uicore_onscroll_effect')) {
            $this->enqueue_scripts('onscroll-effects');
        }
    }

    function register_controls_for_float($widget, $widget_id, $args)
    {
        static $widgets = [
            'section_effects', /* Section */
        ];

        if (!in_array($widget_id, $widgets)) {
            return;
        }

        $widget->add_control(
            'uicore_enable_float',
            [
                'label'        => UICORE_ANIMATE_BADGE . esc_html__('Floating effect', 'uicore-animate'),
                'description'  => esc_html__('Add a looping up-down animation.', 'uicore-animate'),
                'type'         => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => '',
                'prefix_class' => 'ui-float-',
                'return_value' => 'widget',
                'frontend_available' => false,
            ]
        );
        $widget->add_control(
            'uicore_float_size',
            [
                'label' => __('Floating height', 'uicore-animate'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'ui-float-s' => __('Small', 'uicore-animate'),
                    '' => __('Default', 'uicore-animate'),
                    'ui-float-l' => __('Large', 'uicore-animate'),
                ],
                'condition' => array(
                    'uicore_enable_float' => 'widget',
                ),
                'prefix_class' => ' ',
            ]
        );
    }

    /**
     * Fluid Gradient extender
     *
     * @param \Elementor\Controls_Stack $element
     * @param string $section_id
     * @return void
     * @author Andrei Voica <andrei@uicore.co>
     * @since 3.2.1
     */
    function fluid_gradient_controls(Controls_Stack $section)
    {
        $section->start_injection(
            [
                'type' => 'control',
                'at'   => 'after',
                'of'   => 'background_background',
            ]
        );

        $section->add_control(
            'section_fluid_on',
            [
                'label'        => UICORE_ANIMATE_BADGE . esc_html__('Fluid Gradient', 'uicore-animate'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'yes',
                'description'  => esc_html__('Enable Fluid Gradient background.', 'uicore-animate'),
                'separator'    => ['before'],
                'render_type'  => 'template',
                'frontend_available' => true,
            ]
        );

        $section->add_control(
            'uicore_fluid_animation',
            [
                'label' => __('Animation', 'uicore-animate'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('None', 'uicore-animate'),
                    'ui-fluid-animation-1' => __('Style 1', 'uicore-animate'),
                    'ui-fluid-animation-2' => __('Style 2', 'uicore-animate'),
                    'ui-fluid-animation-3' => __('Style 3', 'uicore-animate'),
                    'ui-fluid-animation-4' => __('Style 4', 'uicore-animate'),
                    'ui-fluid-animation-5' => __('Style 5', 'uicore-animate'),
                    'ui-fluid-animation-6' => __('Style 6', 'uicore-animate'),
                ],
                'condition' => array(
                    'section_fluid_on' => 'yes',
                ),
                'prefix_class' => ' ',
            ]
        );

        $section->add_control(
            'ui_fluid_opacity',
            [
                'label' => __('Opacity', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'section_fluid_on' => 'yes',
                ],
                'range' => [
                    'px' => [
                        'min'  => 0.05,
                        'max'  => 1,
                        'step' => 0.05,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ui-e-fluid-canvas' => 'opacity: {{SIZE}}',
                ],
            ]
        );

        $section->add_control(
            'section_fluid_color_1',
            [
                'label'     => esc_html__('Color 1', 'uicore-animate'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'section_fluid_on' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ui-e-fluid-canvas' => '--ui-fluid-1: {{VALUE}}',
                ],
            ]
        );
        $section->add_control(
            'section_fluid_color_2',
            [
                'label'     => esc_html__('Color 2', 'uicore-animate'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'section_fluid_on' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ui-e-fluid-canvas' => '--ui-fluid-2: {{VALUE}}',
                ],
            ]
        );
        $section->add_control(
            'section_fluid_color_3',
            [
                'label'     => esc_html__('Color 3', 'uicore-animate'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'section_fluid_on' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ui-e-fluid-canvas' => '--ui-fluid-3: {{VALUE}}',
                ],
            ]
        );
        $section->add_control(
            'section_fluid_color_4',
            [
                'label'     => esc_html__('Color 4', 'uicore-animate'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'section_fluid_on' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ui-e-fluid-canvas' => '--ui-fluid-4: {{VALUE}}',
                ],
            ]
        );

        $section->end_injection();
    }

    public function fluid_gradient_print_template($template)
    {
        $template =     '
        <#
        if ( settings.section_fluid_on === \'yes\' ) {
            if ( settings.uicore_fluid_animation != \'ui-fluid-animation-5\' ) {
            #>
                <div class="ui-fluid-gradient-wrapper">
                    <div class="ui-fluid-gradient"></div>
                </div>
            <# } else {
            #>
            <div class="ui-fluid-gradient-wrapper">
                <canvas id="ui-gradient-canvas-<?php echo $section->get_id(); ?>" data-transition-in />
            </div>
            <# }
        }
        #>
            ' . $template;
        return $template;
    }

    public function fluid_gradient_render($section)
    {
        $active = $section->get_settings('section_fluid_on');
        $type = $section->get_settings('uicore_fluid_animation');

        if ('yes' === $active) {
            $section->add_render_attribute('_wrapper', 'class', 'has-ui-fluid-gradient');
            if ($type != 'ui-fluid-animation-5') {
?>
                <div class="ui-fluid-gradient-pre">
                    <div class="ui-fluid-gradient"></div>
                </div>
            <?php
            } else {
            ?>
                <div class="ui-fluid-gradient-pre">
                    <canvas id="ui-gradient-canvas-<?php echo $section->get_id(); ?>" data-transition-in />
                </div>
<?php
            }
        }
    }



    public function animated_border($element, $section_id)
    {
        // Check if the section is 'section_border'
        if ('_section_border' !== $section_id) {
            return;
        }
        $this->add_border_controlls($element);
    }


    public function animated_border_in_elements(Controls_Stack $element, $section_id)
    {
        $suffix = $element->get_type() == 'container' ? '' : 'item';
        $this->add_border_controlls($element, $suffix);
    }


    function add_border_controlls(Controls_Stack $element, $suffix = '')
    {
        $suffix = $suffix ? '_' . $suffix : '';
        $is_container = $element->get_type() == 'container';
        $options = [
            '' => __('None', 'uicore-animate'),
            'ui-borderanim-hover' . $suffix => __('Hover Glow', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix => __('Rotate', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix . ' ui-gradient' => __('Gradient Rotate', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix . ' ui-gradient-dual' => __('Gradient Rotate (2)', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix . ' ui-multicolor' => __('Multicolor Rotate (4)', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix . ' ui-multicolor-8' => __('Multicolor Rotate (8)', 'uicore-animate'),
            'ui-borderanim-rotate' . $suffix . ' ui-multicolor-12' => __('Multicolor Rotate (12)', 'uicore-animate'),
        ];

        $condition = [
            'relation' => 'or',
            'terms' => [
                [
                    'name' => '_border_border',
                    'operator' => '!in',
                    'value' => ['none', '']
                ]
            ]
        ];
        if ($is_container) {
            $condition = [
                "terms" => [
                    [
                        'name' => 'border_border',
                        'operator' => '!in',
                        'value' => ['none', '']
                    ]
                ]
            ];
        } elseif ($element->get_name() == 'uicore-advanced-post-grid' || $element->get_name() == 'uicore-advanced-post-carousel') {
            $condition = [
                "terms" => [
                    [
                        'name' => 'item_border_border',
                        'operator' => '!in',
                        'value' => ['none', '']
                    ]
                ]
            ];
        } elseif ($element->get_name() == 'uicore-icon-list') {
            $condition = [
                "terms" => [
                    [
                        'name' => 'list_item_border_border',
                        'operator' => '!in',
                        'value' => ['none', '']
                    ]
                ]
            ];
        }

        //raw html with description
        // $element->add_control(
        //     'uicore_notice' . $suffix,
        //     [
        //         'type' => \Elementor\Controls_Manager::RAW_HTML,
        //         'raw' => $suffix . ' - ' . $element->get_name() . '<div class="elementor-panel-alert elementor-panel-alert-warning"> ' . print_r($condition, true) . '</div>',
        //     ]
        // );

        $element->add_control(
            'uicore_animated_border' . $suffix,
            [
                'label' => __('Animated Border', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
                'prefix_class' => '',
                'default' => '',
                'conditions' =>  $condition,
            ]
        );

        $requires_bg_widgets = [
            'uicore-advanced-post-grid',
            'uicore-advanced-post-carousel',
            'uicore-icon-list'
        ];
        if (in_array($element->get_name(), $requires_bg_widgets)) {
            error_log('condition met ' . $element->get_name());
            $element->add_control(
                'uicore_animated_border_warning' . $suffix,
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => esc_html__('*requires current widget to have a background.', 'uicore-animate'),
                    'content_classes' => 'elementor-control-field-description',
                    'condition' => [
                        'uicore_animated_border' . $suffix => ['ui-borderanim-hover' . $suffix],
                    ],
                ]
            );
        }

        $element->add_control(
            'uicore_animated_border_color' . $suffix,
            [
                'label' => __('Animated Border Color', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f546c4',
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-borderanim-color:{{VALUE}}',
                ],
                'condition' => [
                    'uicore_animated_border' . $suffix . '!' => '',
                ],
            ]
        );
        $element->add_control(
            'uicore_animated_border_color2' . $suffix,
            [
                'label' => __('Animated Border Color 2', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4668f5',
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-borderanim-color2:{{VALUE}}',
                ],
                'condition' => [
                    'uicore_animated_border' . $suffix => ['ui-borderanim-rotate' . $suffix . ' ui-multicolor-8', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor-12', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor'],
                ],
            ]
        );
        $element->add_control(
            'uicore_animated_border_color3' . $suffix,
            [
                'label' => __('Animated Border Color 3', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a2f546',
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-borderanim-color3:{{VALUE}}',
                ],
                'condition' => [
                    'uicore_animated_border' . $suffix => ['ui-borderanim-rotate' . $suffix . ' ui-multicolor-8', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor-12', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor'],
                ],
            ]
        );
        $element->add_control(
            'uicore_animated_border_color4' . $suffix,
            [
                'label' => __('Animated Border Color 4', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f56d46',
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-borderanim-color4:{{VALUE}}',
                ],
                'condition' => [
                    'uicore_animated_border' . $suffix => ['ui-borderanim-rotate' . $suffix . ' ui-multicolor-8', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor-12', 'ui-borderanim-rotate' . $suffix . ' ui-multicolor'],
                ],
            ]
        );
        //speed control slider
        $element->add_control(
            'uicore_animated_border_speed' . $suffix,
            [
                'label' => __('Speed (seconds)', 'uicore-animate'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' =>  5,
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-borderanim-speed: {{SIZE}}s',
                ],
                'condition' => [
                    'uicore_animated_border' . $suffix . '!' => ['', 'ui-borderanim-hover' . $suffix . ''],
                ],
            ]
        );
    }

    function container_onscroll_effect(Controls_Stack $element, $section_id)
    {
        $element->start_controls_section(
            'section_onscroll_effect',
            [
                'label' => UICORE_ANIMATE_BADGE . __('Scroll Effect', 'uicore-animate'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );
        // add select control
        $element->add_control(
            'uicore_onscroll_effect',
            [
                'label' => __('Scroll Effect', 'uicore-animate'),
                'description' => __('Sticky effects will make all the child sticky while Reveal will reveal the current section (it needs a parent for background)', 'uicore-animate'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'uicore-animate'),
                    'simple-sticky' => __('Simple Sticky', 'uicore-animate'),
                    'sticky-scale' => __('Sticky Scale', 'uicore-animate'),
                    'sticky-scale-small' => __('Sticky Scale Small', 'uicore-animate'),
                    'sticky-scale-alt' => __('Sticky Scale Alt', 'uicore-animate'),
                    'sticky-scale-blur' => __('Sticky Scale & Blur', 'uicore-animate'),
                    'sticky-scale-blur-small' => __('Sticky Scale & Blur Small', 'uicore-animate'),
                    'sticky-parallax' => __('Sticky Parallax', 'uicore-animate'),
                    'sticky-mask' => __('Sticky Mask', 'uicore-animate'),
                    'sticky-mask-grow' => __('Sticky Mask Grow', 'uicore-animate'),
                    'mask-reveal' => __('Reveal Mask', 'uicore-animate'),

                ],
                'default' => '',
                'frontend_available' => true,
            ]
        );


        //offset control if value diffrent from none
        $element->add_control(
            'uicore_onscroll_offset',
            [
                'label' => __('TOP Offset', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-e-onscroll-offset: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'uicore_onscroll_effect!' => [''],
                ]
            ]
        );
        //items stack offset top
        $element->add_control(
            'uicore_onscroll_items_offset',
            [
                'label' => __('Items Offset', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-e-onscroll-items-offset: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'uicore_onscroll_effect!' => ['', 'mask-reveal', 'simple-sticky'],
                ]
            ]
        );
        $element->add_control(
            'uicore_onscroll_reveal_height',
            [
                'label' => __('Total Min Height', 'uicore-animate'),
                'description' => __('Adjust this based on the revealed content to minimize extra scroll', 'uicore-animate'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'vh',
                    'size' => 170,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--ui-e-onscroll-reveal-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'uicore_onscroll_effect' => ['mask-reveal'],
                ]
            ]
        );


        //end section
        $element->end_controls_section();
    }
}
