<?php

namespace WPEasyDonation\Base;

use WPEasyDonation\Widget\ButtonWidget;

class WidgetController
{
	/**
	 * init services
	 */
	public function register()
	{
		add_action('widgets_init', [$this, 'button']);
	}

	/**
	 * button widget
	 */
	public function button()
	{
		register_widget( new ButtonWidget() );
	}
}