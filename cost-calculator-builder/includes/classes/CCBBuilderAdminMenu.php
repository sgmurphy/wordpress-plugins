<?php

namespace cBuilder\Classes;

class CCBBuilderAdminMenu {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 20 );
	}

	public static function init() {
		return new CCBBuilderAdminMenu();
	}

	public function settings_menu() {
		$root_page = array( $this, 'render_page' );

		if ( $this::show_welcome_ccb_page() && ! defined( 'CCB_PRO_VERSION' ) ) {
			$root_page = array( $this, 'ccb_welcome_render' );
		}

		add_menu_page(
			esc_html__( 'Cost Calculator', 'cost-calculator-builder' ),
			esc_html__( 'Cost Calculator', 'cost-calculator-builder' ),
			'manage_options',
			'cost_calculator_builder',
			$root_page,
			CALC_URL . '/frontend/dist/img/icon.png',
			110
		);
		add_submenu_page(
			'cost_calculator_builder',
			esc_html__( 'Calculators', 'cost-calculator-builder' ),
			esc_html__( 'Calculators', 'cost-calculator-builder' ),
			'manage_options',
			'cost_calculator_builder',
			$root_page
		);
		add_submenu_page(
			'cost_calculator_builder',
			esc_html__( 'Templates', 'cost-calculator-builder' ),
			esc_html__( 'Templates', 'cost-calculator-builder' ),
			'manage_options',
			'cost_calculator_templates',
			array( $this, 'render_templates' )
		);

		if ( defined( 'CALC_DEV_MODE' ) ) {
			add_submenu_page(
				'cost_calculator_builder',
				esc_html__( 'Categories', 'cost-calculator-builder' ),
				esc_html__( 'Categories', 'cost-calculator-builder' ),
				'manage_options',
				'cost_calculator_categories',
				array( $this, 'render_categories' )
			);
		}

		add_submenu_page(
			'cost_calculator_builder',
			esc_html__( 'Settings', 'cost-calculator-builder' ),
			esc_html__( 'Settings', 'cost-calculator-builder' ),
			'manage_options',
			'cost_calculator_builder&tab=settings',
			array( $this, 'render_page' )
		);

		if ( defined( 'CCB_PRO_VERSION' ) ) {
			add_submenu_page(
				'cost_calculator_builder',
				esc_html__( 'Orders', 'cost-calculator-builder' ),
				esc_html__( 'Orders', 'cost-calculator-builder' ),
				'manage_options',
				'cost_calculator_orders',
				array( $this, 'calc_orders_page' )
			);
		} else {
			add_submenu_page(
				'cost_calculator_builder',
				esc_html__( 'Orders', 'cost-calculator-builder' ),
				esc_html__( 'Orders', 'cost-calculator-builder' ),
				'manage_options',
				'cost_calculator_orders',
				array( $this, 'calc_orders_page_demo' )
			);

			add_submenu_page(
				'cost_calculator_builder',
				esc_html__( 'Upgrade', 'cost-calculator-builder' ),
				'<span style="color: #adff2f;"><span style="font-size: 16px;text-align: left;" class="dashicons dashicons-star-filled stm_go_pro_menu"></span>' . esc_html__( 'Upgrade', 'cost-calculator-builder' ) . '</span>',
				'manage_options',
				'cost_calculator_gopro',
				array( $this, 'calc_gopro_page' )
			);

			add_submenu_page(
				'cost_calculator_builder',
				esc_html__( 'Pro Features', 'cost-calculator-builder' ),
				esc_html__( 'Pro Features', 'cost-calculator-builder' ),
				'manage_options',
				'cost_calculator_pro_features',
				array( $this, 'calc_pro_features' )
			);
		}
	}

	public function ccb_welcome_render() {
		$this::mark_as_visited_ccb_welcome();
		echo CCBTemplate::load( 'admin/pages/welcome' ); //phpcs:ignore
		exit;
	}

	public static function show_welcome_ccb_page(): bool {
		return get_option( 'ccb__show_welcome_page' );
	}

	public static function mark_as_visited_ccb_welcome() {
		delete_option( 'ccb__show_welcome_page' );
	}

	public function render_templates() {
		echo CCBTemplate::load( 'admin/pages/templates' ); //phpcs:ignore
	}

	public function render_categories() {
		echo CCBTemplate::load( 'admin/pages/categories' ); //phpcs:ignore
	}

	public function render_page() {
		echo CCBTemplate::load( 'admin/index' ); //phpcs:ignore
	}

	public function calc_orders_page() {
		echo CCBTemplate::load( 'admin/pages/orders' ); //phpcs:ignore
	}

	public function calc_orders_page_demo() {
		echo CCBTemplate::load( 'admin/pages/orders-demo' ); //phpcs:ignore
	}

	public function calc_gopro_page() {
		echo CCBTemplate::load( 'admin/pages/go-pro' ); //phpcs:ignore
	}

	public function calc_pro_features() {
		echo CCBTemplate::load( 'admin/pages/pro-features' ); //phpcs:ignore
	}
}
