<?php

namespace WPEasyDonation\Base;

use WPEasyDonation\Helpers\Template;

class MediaButton
{
	/**
	 * init services
	 */
	public function register() {
		add_action( 'media_buttons', array($this, 'button'), 20 );
	}

	/**
	 * Insert media button to classic editor
	 */
	function button() {
		global $pagenow, $typenow;
		if ( !in_array( $pagenow, ['post.php', 'page.php', 'post-new.php', 'post-edit.php'] ) || $typenow === 'download' ) return;
		Template::getTemplate('admin_media_button/button.php');
		add_action( 'admin_footer', function () {
			\WPEasyDonation\Helpers\Template::getTemplate('admin_media_button/popup.php');
		});
	}
}