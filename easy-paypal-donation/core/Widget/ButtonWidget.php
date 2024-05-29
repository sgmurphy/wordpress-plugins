<?php

namespace WPEasyDonation\Widget;

use WP_Widget;
use WPEasyDonation\Helpers\Template;

class ButtonWidget extends WP_Widget
{
	/**
	 * constructor
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'wpedon_widget',
			'description' => 'Easy Donation Button',
		);
		parent::__construct('wpedon_widget', 'Easy Donation Button', $widget_ops);
	}

	/**
	 * public output
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract($args);

		if (!empty($instance['idvalue'])) {
			$idvalue = $instance['idvalue'];

			$code = "[wpedon id='$idvalue' widget='true']";

			echo do_shortcode($code);
		}

		echo $after_widget;
	}

	/**
	 * private save
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance = 			$old_instance;
		$instance['title'] = 	strip_tags($new_instance['title']);
		$instance['idvalue'] = 	strip_tags($new_instance['idvalue']);
		return $instance;
	}

	/**
	 * private output
	 * @param array $instance
	 * @return string|void
	 */
	function form( $instance ) {
		if (empty($instance['title'])) {
			$instance['title'] = "";
		}
		if (empty($instance['idvalue'])) {
			$instance['idvalue'] = "";
		}

		$title = 		esc_attr($instance['title']);
		$idvalue = 		esc_attr($instance['idvalue']);
		$field_id = $this->get_field_id('title');
		$field_name_title = $this->get_field_name('title');
		$field_name_idvalue = $this->get_field_name('idvalue');
		$args = array('post_type' => 'wpplugin_don_button', 'posts_per_page' => -1);
		$posts = get_posts($args);


		Template::getTemplate('widgets/button_widget.php', true, [
			'title'=>$title, 'idvalue'=>$idvalue, 'field_id'=>$field_id, 'field_name_title' => $field_name_title,
			'field_name_idvalue'=>$field_name_idvalue, 'posts'=>$posts]);
	}
}