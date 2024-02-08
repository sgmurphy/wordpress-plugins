<?php

namespace ILJ\Backend\MenuPage;

use ILJ\Core\Options;
use ILJ\Core\IndexBuilder;
use ILJ\Backend\AdminMenu;
use ILJ\Backend\MenuPage\AbstractMenuPage;
use ILJ\Backend\MenuPage\Includes\SidebarTrait;
use ILJ\Backend\MenuPage\Includes\HeadlineTrait;

/**
 * The settings menu page
 *
 * Responsible for displaying the settings section
 *
 * @package ILJ\Backend\Menupage
 *
 * @since 1.0.0
 */
class Settings extends AbstractMenuPage {

	use HeadlineTrait;
	use SidebarTrait;

	const ILJ_MENUPAGE_SETTINGS_SLUG        = 'settings';
	const ILJ_MENUPAGE_SETTINGS_FILTER_TABS = 'ilj_menupage_settings_filter_tabs';

	/**
	 * Tabs
	 *
	 * @var   array
	 * @since 1.0.0
	 */
	protected $tabs;

	public function __construct() {
		$this->page_slug = self::ILJ_MENUPAGE_SETTINGS_SLUG;
		$this->page_title = __('Settings', 'internal-links');

		$this->tabs = array(
			array(
				'slug'     => Options::ILJ_OPTION_SECTION_GENERAL,
				'title'    => __('General', 'internal-links'),
				'callback' => function () {
					settings_fields(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_GENERAL);
					do_settings_sections(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_GENERAL);
				},
			),
			array(
				'slug'     => Options::ILJ_OPTION_SECTION_CONTENT,
				'title'    => __('Content', 'internal-links'),
				'callback' => function () {
					settings_fields(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_CONTENT);
					do_settings_sections(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_CONTENT);
				},
			),
			array(
				'slug'     => Options::ILJ_OPTION_SECTION_LINKS,
				'title'    => __('Links', 'internal-links'),
				'callback' => function () {
					settings_fields(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_LINKS);
					do_settings_sections(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_LINKS);
				},
			),
			array(
				'slug'     => Options::ILJ_OPTION_SECTION_ACTIONS,
				'title'    => __('Actions', 'internal-links'),
				'callback' => function () {
					settings_fields(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_ACTIONS);
					do_settings_sections(Options::ILJ_OPTION_PREFIX_PAGE . Options::ILJ_OPTION_SECTION_ACTIONS);
				},
			),
		);
	}
	/**
	 * register
	 *
	 * @return void
	 */
	public function register() {
		$this->addSubMenuPage();

		wp_register_script('ilj_select2', ILJ_URL . 'admin/js/select2.js', array(), ILJ_VERSION);
		wp_localize_script(
			'ilj_select2',
			'ilj_select2_translation',
			array(
				'error_loading'   => __('The results could not be loaded.', 'internal-links'),
				'input_too_short' => __('Minimum characters to start search', 'internal-links'),
				'loading_more'    => __('Loading more results…', 'internal-links'),
				'no_results'      => __('No results found', 'internal-links'),
				'searching'       => __('Searching…', 'internal-links'),
				'success_message' => __('Success', 'internal-links'),
			)
		);

		wp_register_script('ilj_menu_settings', ILJ_URL . 'admin/js/ilj_menu_settings.js', array(), ILJ_VERSION);
		wp_localize_script(
			'ilj_menu_settings',
			'ilj_menu_settings_translation',
			array(
				'success_message' 		 => __('Success', 'internal-links'),
				'confirm_cancel_message' => __('This will cancel all pending link building schedules - are you sure you want to do this?', 'internal-links'),
			)
		);

		$this->addAssets(
			array(
				'tipso'             => ILJ_URL . 'admin/js/tipso.js',
				'ilj_menu_settings' => ILJ_URL . 'admin/js/ilj_menu_settings.js',
				'ilj_select2'       => ILJ_URL . 'admin/js/select2.js',
				'ilj_promo'         => ILJ_URL . 'admin/js/ilj_promo.js',

			),
			array(
				'tipso'             => ILJ_URL . 'admin/css/tipso.css',
				'ilj_menu_settings' => ILJ_URL . 'admin/css/ilj_menu_settings.css',
				'ilj_ui'            => ILJ_URL . 'admin/css/ilj_ui.css',
				'ilj_grid'          => ILJ_URL . 'admin/css/ilj_grid.css',
				'ilj_select2'       => ILJ_URL . 'admin/css/select2.css',
			)
		);
	}

	/**
	 * render
	 *
	 * @return void
	 */
	public function render() {
		if (!current_user_can('manage_options')) {
			return;
		}

		$active_tab = 'general';

		if (isset($_GET['tab']) && in_array($_GET['tab'], array('general', 'content', 'links', 'actions'))) {
			$active_tab = $_GET['tab'];
		}

		$tabs = apply_filters(self::ILJ_MENUPAGE_SETTINGS_FILTER_TABS, $this->tabs);

		echo '<div class="wrap ilj-menu-settings">';
		$this->renderHeadline(__('Settings', 'internal-links'));
		echo '<div class="ilj-row">';
		echo '<div class="col-9">';
		echo '<h2 class="nav-tab-wrapper">';

		foreach ($tabs as $tab) {
			echo '<a href="?page=' . AdminMenu::ILJ_MENUPAGE_SLUG . '-' . $this->getSlug() . '&tab=' . strtolower($tab['slug']) . '" class="nav-tab' . ($active_tab == $tab['slug'] ? ' nav-tab-active' : '') . '">' . $tab['title'] . '</a>';
		}

		if (!\ILJ\ilj_fs()->is__premium_only() || !\ILJ\ilj_fs()->can_use_premium_code()) {
			echo '<a href="' . get_admin_url(null, 'admin.php?page=' . AdminMenu::ILJ_MENUPAGE_SLUG . '-pricing') . '" class="ilj-upgrade">' . __('Upgrade to Pro now - unlock all features', 'internal-links') . ' <span class="dashicons dashicons-unlock"></span></a>';
		}

		echo '</h2>';
		echo '<form action="options.php" method="post">';
		echo '<section class="section">';

		settings_errors('internal-links');

		foreach ($tabs as $tab) {
			if ($tab['slug'] == $active_tab) {
				$tab['callback']();
			}
		}
		
		echo '<footer class="actions">';
		if ('actions' != $active_tab) {
			echo '<div class="action">';
			submit_button(__('Save changes', 'internal-links'));
			echo '</div>';
		}
		
		echo '</form>';
		echo '<form class="action" action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';

		wp_nonce_field(Options::KEY);
		echo '<input type="hidden" name="action" value="' . esc_attr(Options::KEY) . '">';
		echo '<input type="hidden" name="section" value="' . esc_attr($active_tab) . '" >';

		echo '<div>';
		echo '<p class="submit">';
		echo '<input type="submit" name="ilj-reset-keywords" style="margin-right: 10px" class="button button-secondary" value="' . __('Reset all keywords', 'internal-links') . '" onclick="return confirm(\'' . __('This will delete all existing keywords in your site - are you sure you want to do this?', 'internal-links') . '\');">';
		echo '<input type="submit" name="ilj-reset-options" class="button button-secondary" value="' . __('Reset options', 'internal-links') . '" onclick="return confirm(\'' . __('You are going to overwrite the existing settings in this section with the defaults.', 'internal-links') . '\');">';
		echo '</p>';
		echo '</div>';

		echo '</footer>';

		echo '</section>';
		echo '</form>';

		echo '</div>';
		echo '<div class="col-3">';
		$this->renderSidebar();
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Handles the index rebuilding process after settings got updated
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private static function processIndexRebuilding() {
		if (!isset($_GET['settings-updated']) || 'true' !== $_GET['settings-updated']) {
			return;
		}

		do_action(IndexBuilder::ILJ_INITIATE_BATCH_REBUILD);
	}
}
