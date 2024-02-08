<?php

namespace ILJ\Backend;

use ILJ\Core\Options;

/**
 * Admin Notices
 *
 * Manages everything related to notices
 *
 * @package ILJ\Backend
 * @since   2.23.5
 */
class Notices {

	const ILJ_DISMISS_ADMIN_WARNING_LITESPEED = "ilj_dismiss_admin_warning_litespeed";

	/**
	 * Paint a div for a dashboard warning
	 *
	 * @param String $message - the HTML for the message (already escaped)
	 * @param String $class   - CSS class to use for the div
	 */
	public static function show_admin_warning($message, $class = 'updated') {
		echo "<div class='iljmessage " . esc_attr($class) . "'><p>" . $message . "</p></div>";
	}

	/**
	 * show_admin_warning_litespeed
	 *
	 * @return void
	 */
	public static function show_admin_warning_litespeed() {
		self::show_admin_warning('<strong>' . __('Warning', 'internal-links') . ':</strong> ' . sprintf(__('Your website is hosted using the %s web server.', 'internal-links'), 'LiteSpeed') . ' <a href="https://www.internallinkjuicer.com/faqs/" target="_blank">' . __('Please consult this FAQ if you have problems building links.', 'internal-links') . '</a>', 'updated admin-warning-litespeed notice is-dismissible');
	}

	/**
	 * This function will add ilj_dismiss_admin_warning_litespeed option to hide litespeed admin warning after dismissed
	 *
	 * @return void
	 */
	public static function dismiss_admin_warning_litespeed() {
		Options::setOption(self::ILJ_DISMISS_ADMIN_WARNING_LITESPEED, true);
		wp_die();
	}
}
