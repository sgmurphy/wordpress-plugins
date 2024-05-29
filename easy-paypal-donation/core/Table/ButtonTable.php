<?php

namespace WPEasyDonation\Table;

use WP_List_Table;

class ButtonTable extends WP_List_Table
{
	/**
	 * construct
	 */
	function __construct()
	{
		global $status, $page;

		parent::__construct(array(
			'singular' => 'product',
			'plural' => 'products',
			'ajax' => false
		));
	}

	/**
	 * get data
	 * @return array
	 */
	function get_data()
	{
		$args = array('post_type' => 'wpplugin_don_button', 'posts_per_page' => -1);

		$posts = get_posts($args);

		$count = "0";
		foreach ($posts as $post) {
			$id = $posts[$count]->ID;
			$post_title = $posts[$count]->post_title;

			if ($post_title == "" || $post_title == " " || empty($post_title)) {
				$post_title = "(No Item Name)";
			}

			$shortcode = '<input readonly type="text" value="[wpedon id=' . $id . ']">';
			$price = esc_attr(get_post_meta($id, 'wpedon_button_price', true));
			$sku = esc_attr(get_post_meta($id, 'wpedon_button_id', true));

			if (empty($price)) {
				$price = "Customer enters amount";
			}


			$product = $post_title;

			$data[] = array(
				'ID' => $id,
				'product' => $product,
				'shortcode' => $shortcode,
				'price' => $price,
				'sku' => $sku
			);

			$count++;
		}

		if (empty($data)) {
			$data = array();
		}

		return $data;
	}

	/**
	 * column default
	 * @param array|object $item
	 * @param string $column_name
	 * @return bool|mixed|string|void
	 */
	function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'product':
			case 'shortcode':
			case 'price':
			case 'sku':
				return $item[$column_name];
			default:
				return print_r($item, true);
		}
	}

	/**
	 * column product
	 * @param $item
	 * @return string
	 */
	function column_product($item)
	{
		// edit
		$edit_bare = '?page=wpedon_buttons&action=edit&product=' . $item['ID'];
		$edit_url = wp_nonce_url($edit_bare, 'edit_' . $item['ID']);

		// delete
		$delete_bare = '?page=wpedon_buttons&action=delete&inline=true&product=' . $item['ID'];
		$delete_url = wp_nonce_url($delete_bare, 'bulk-' . $this->_args['plural']);

		$actions = array(
			'edit' => '<a href="' . esc_url($edit_url) . '">Edit</a>',
			'delete' => '<a href="' . esc_url($delete_url) . '">Delete</a>'
		);

		return sprintf('%1$s %2$s',
			esc_attr($item['product']),
			$this->row_actions($actions)
		);
	}

	/**
	 * column cb
	 * @param array|object $item
	 * @return string|void
	 */
	function column_cb($item)
	{
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			esc_attr($this->_args['singular']),
			esc_attr($item['ID'])
		);
	}

	/**
	 * get columns
	 * @return string[]
	 */
	function get_columns()
	{
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'product' => 'Name',
			'shortcode' => 'Shortcode',
			'price' => 'Amount',
			'sku' => 'ID'
		);
		return $columns;
	}

	/**
	 * no items message
	 */
	function no_items()
	{
		_e('No buttons found.');
	}

	/**
	 * get bulk actions
	 * @return string[]
	 */
	function get_bulk_actions()
	{
		$actions = array(
			'delete' => 'Delete'
		);
		return $actions;
	}

	/**
	 * process bulk action
	 */
	public function process_bulk_action()
	{
		if (isset($_GET['_wpnonce']) && !empty($_GET['_wpnonce'])) {
			$nonce = $_GET['_wpnonce'];
			$action = 'bulk-' . $this->_args['plural'];

			if (!wp_verify_nonce($nonce, $action)) {
				wp_die('Security check fail');
			}
		}
	}

	/**
	 * prepare items
	 */
	function prepare_items()
	{
		global $wpdb;

		$per_page = 10;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		$data = $this->get_data();

		usort($data, function ($a, $b) {
			$orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'product';
			$order = (!empty($_REQUEST['order'])) ? sanitize_text_field($_REQUEST['order']) : 'asc';
			$result = strcmp($a[$orderby], $b[$orderby]);
			return ($order === 'asc') ? $result : -$result;
		});


		$current_page = $this->get_pagenum();


		$total_items = count($data);

		$data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

		$this->items = $data;

		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page' => $per_page,
			'total_pages' => ceil($total_items / $per_page)
		));
	}
}