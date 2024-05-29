<?php
/**
 * Class Upgrade
 *
 * @package SmartCrawl
 */

namespace SmartCrawl\Admin\Pages;

use SmartCrawl\Controllers\Assets;
use SmartCrawl\Simple_Renderer;
use SmartCrawl\Singleton;

class Upgrade extends Page {

	use Singleton;

	const MENU_SLUG = 'wds_upgrade';

	protected function init() {
		parent::init();

		add_action( 'admin_menu', array( $this, 'add_page' ), 100 );
	}

	public function add_page() {
		$submenu_page = add_submenu_page(
			'wds_wizard',
			esc_html__( 'SmartCrawl Pro', 'smartcrawl-seo' ),
			esc_html__( 'SmartCrawl Pro', 'smartcrawl-seo' ),
			'manage_options',
			self::MENU_SLUG,
			array( $this, 'upgrade_page' )
		);

		add_action( "admin_print_styles-{$submenu_page}", array( $this, 'admin_styles' ) );
	}

	public function admin_styles() {
		wp_enqueue_style( Assets::APP_CSS );
	}

	public function upgrade_page() {
		wp_enqueue_script( Assets::ADMIN_JS );

		Simple_Renderer::render( 'upgrade-page' );
	}

	public function get_menu_slug() {
		return self::MENU_SLUG;
	}
}
