<?php

class BWFAN_Api_Get_Products extends BWFAN_API_Base {

	public static $ins;
	public $total_count = 0;
	public $count_data = [];
	protected $stock_status = '';
	protected array $categories = [];
	protected array $p_ids = [];

	protected $category_in = [];
	protected $category_not_in = [];

	protected $exclude_ids = [];

	protected $sortby = '';
	protected $serach_title = '';

	public static function get_instance() {
		if ( null === self::$ins ) {
			self::$ins = new self();
		}

		return self::$ins;
	}

	public function __construct() {
		parent::__construct();
		$this->method       = WP_REST_Server::READABLE;
		$this->route        = '/bwf-products';
		$this->public_api   = true;
		$this->request_args = array(
			'search' => array(
				'description' => __( 'Search from name', 'wp-marketing-automations' ),
				'type'        => 'string',
			),
		);
	}

	public function default_args_values() {
		return array( 'ids' => '', 'search' => '' );
	}

	public function process_api_call() {
		/** if isset search param then get the tag by name **/
		$search       = $this->get_sanitized_arg( 'search', 'text_field' );
		$type         = $this->get_sanitized_arg( 'type', 'text_field' );
		$limit        = $this->get_sanitized_arg( 'limit', 'text_field' );
		$page         = $this->get_sanitized_arg( 'page', 'text_field' );
		$stock_status = $this->get_sanitized_arg( 'stock_status', 'text_field' );
		$category_in  = $this->args['category_in'] ?? [];
		$category_not_in  = $this->args['category_not_in'] ?? [];
		$ids          = $this->args['ids'] ?? [];
		$sortby       = $this->get_sanitized_arg( 'sortby', 'text_field' );
		$exclude_ids  = $this->args['exclude_ids'] ?? [];

		if ( ! empty( $search ) ) {
			$this->serach_title = $search;
		}
		if ( ! empty( $category_in ) ) {
			if ( is_array( $category_in ) ) {
				$this->category_in = $category_in;
			} else {
				$this->category_in = [ $category_in ];
			}
		}
		if ( ! empty( $category_not_in ) ) {
			if ( is_array( $category_not_in ) ) {
				$this->category_not_in = $category_not_in;
			} else {
				$this->category_not_in = [ $category_not_in ];
			}
		}

		if ( ! empty( $exclude_ids ) ) {
			if ( is_array( $exclude_ids ) ) {
				$this->exclude_ids = $exclude_ids;
			} else {
				$this->exclude_ids = [ $exclude_ids ];
			}
		}

		if ( ! empty( $sortby ) ) {
			$this->sortby = $sortby;
		}

		if ( ! empty( $stock_status ) ) {
			$this->stock_status = $stock_status;
		}

		if ( ! empty( $ids ) ) {
			$this->p_ids = explode( ',', $ids );
		}

		$result              = $this->get_data( $type, $limit, $page );
		$products            = $result['products'];
		$this->response_code = 200;
		$this->total_count   = $result['total'];

		$this->response_code = 200;

		return $this->success_response( $products );
	}

	/**
	 * Get product data by type, limit and page
	 *
	 * @param $type
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_data( $type = '', $limit = 10, $page = 1 ) {
		switch ( $type ) {
			case 'on_sale':
				$products = $this->get_sale_products( $limit, $page );
				break;
			case 'featured':
				$products = $this->get_featured_products( $limit, $page );
				break;
			case 'top_rated':
				$products = $this->get_top_rated_products( $limit, $page );
				break;
			case 'best_selling':
			case 'best_selling_store':
				$products = $this->get_best_selling_product( $limit, $page );
				break;
			case 'latest':
				$products = $this->get_recent_products( $limit, $page );
				break;
			case 'category':
				$products = $this->get_products_by_category( $limit, $page );
				break;
			default:
				$products = $this->get_products( $limit, $page );
		}

		return $products;
	}

	/**
	 * Returns best-selling products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_best_selling_product( $limit, $page ) {
		$param = array(
			'post_type'      => 'product',
			'meta_key'       => 'total_sales',
			'orderby'        => 'meta_value_num',
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Returns products by category
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_products_by_category( $limit, $page ) {
		$param = array(
			'post_type'      => 'product',
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		if ( ! empty( $this->category_in ) ) {
			$param['tax_query'] = [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $this->category_in,
					'operator' => 'IN',
				]
			];
		}

		if ( ! empty( $this->category_not_in ) ) {
			$param['tax_query'] = [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $this->category_not_in,
					'operator' => 'NOT IN',
				]
			];
		}

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Returns on sale products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_sale_products( $limit, $page ) {
		$param = array(
			'post_type'      => array( 'product', 'product_variation' ),
			'meta_query'     => array(
				'relation' => 'OR',
				array( // Simple products type
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				),
				array( // Variable products type
					'key'     => '_min_variation_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				)
			),
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Returns featured products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_featured_products( $limit, $page ) {
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN', // or 'NOT IN' to exclude feature products
		);
		$param       = array(
			'post_type'      => 'product',
			'tax_query'      => $tax_query,
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids',
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Returns recent added products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_recent_products( $limit, $page ) {
		$param = array(
			'post_type'      => 'product',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Returns top-rated products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_top_rated_products( $limit, $page ) {
		$param = array(
			'post_type'      => 'product',
			'meta_key'       => '_wc_average_rating',
			'orderby'        => 'meta_value_num',
			'order'          => 'DESC',
			'meta_query'     => WC()->query->get_meta_query(),
			'tax_query'      => WC()->query->get_tax_query(),
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Return all products
	 *
	 * @param $limit
	 * @param $page
	 *
	 * @return array
	 */
	public function get_products( $limit, $page ) {
		$param = array(
			'post_type'      => 'product',
			'posts_per_page' => $limit,
			'paged'          => $page,
			'fields'         => 'ids'
		);

		return $this->get_formatted_product_data( $param );
	}

	/**
	 * Add stock status query to argument for WP_Query
	 *
	 * @param $args
	 *
	 * @return array
	 */
	public function append_stock_query_args( $args ) {
		$filter_key = '';
		switch ( $this->stock_status ) {
			case 'instock':
				$filter_key = 'instock';
				break;
			case 'outofstock':
				$filter_key = 'outofstock';
				break;
			case 'backorder':
				$filter_key = 'onbackorder';
				break;
		}

		if ( ! empty( $filter_key ) ) {
			$args['meta_query'] = [
				[
					'key'     => '_stock_status',
					'value'   => $filter_key,
					'compare' => '=',
				]
			];
		}

		return $args;
	}

	/**
	 * Returns formatted product data after fetching
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function get_formatted_product_data( $data ) {
		$products = [];
		$currency = get_woocommerce_currency_symbol();

		/** Add category argument **/
		if ( ! empty( $this->categories ) ) {
			$data['tax_query'] = [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => implode( ',', $this->categories ),
					'operator' => 'IN',
				]
			];
		}

		/** Add stock status argument **/
		if ( ! empty( $this->stock_status ) ) {
			$data = $this->append_stock_query_args( $data );
		}

		/** Add search argument **/
		if ( ! empty( $this->serach_title ) ) {
			$data['s'] = $this->serach_title;
		}

		/** Add post__in argument **/
		if ( ! empty( $this->p_ids ) ) {
			$data['post__in'] = $this->p_ids;
		}

		/** Add exclude_ids argument **/
		if ( ! empty( $this->exclude_ids ) ) {
			$data['post__not_in'] = $this->exclude_ids;
		}

		/** Add sort by argument **/
		if ( ! empty( $this->sortby ) ) {
			$data = $this->get_sort_arg( $data );
		}

		$wp_query    = new WP_Query( $data );
		$product_ids = $wp_query->get_posts();
		foreach ( $product_ids as $pid ) {
			$product    = wc_get_product( $pid );
			$products[] = [
				'id'                => $product->get_id(),
				'name'              => strip_tags( $product->get_name() ),
				'short_description' => strip_tags( $product->get_short_description() ),
				'type'              => $product->get_type(),
				'status'            => $product->get_status(),
				'downloadable'      => $product->is_downloadable(),
				'virtual'           => $product->is_virtual(),
				'product_url'       => $product->get_permalink(),
				'sku'               => $product->get_sku(),
				'price'             => wc_format_decimal( $product->get_price(), 2 ),
				'regular_price'     => wc_format_decimal( $product->get_regular_price(), 2 ),
				'sale_price'        => $product->get_sale_price() ? wc_format_decimal( $product->get_sale_price(), 2 ) : '',
				'parent_id'         => $product->get_parent_id(),
				'image'             => wp_get_attachment_image_url( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' ),
				'price_html'        => $product->get_price_html(),
				'stock_status'      => $product->is_in_stock(),
				'currency_prefix'   => html_entity_decode( $currency )
			];
		}

		return [
			'products' => $products,
			'total'    => $wp_query->found_posts
		];
	}

	/**
	 * Get sort argument
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function get_sort_arg( $args = [] ) {
		switch ( $this->sortby ) {
			case 'created':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
			case 'modified':
				$args['orderby'] = 'modified';
				$args['order']   = 'DESC';
				break;
			case 'sales':
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				$args['order']    = 'DESC';
				break;
			case 'lowest_price':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_price';
				$args['order']    = 'ASC';
				break;
			case 'highest_price':
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_price';
				$args['order']    = 'DESC';
				break;
			case 'random':
				$args['orderby'] = 'rand';
				$args['order']   = 'DESC';
		}

		if ( empty( $args['post__in'] ) ) {
			unset( $args['post__in'] );
		}

		return $args;
	}

	public function get_result_count_data() {
		return $this->count_data;
	}
}

BWFAN_API_Loader::register( 'BWFAN_Api_Get_Products' );