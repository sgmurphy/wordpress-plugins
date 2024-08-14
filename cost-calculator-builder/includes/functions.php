<?php
/**
 * Update calculator
 *
 * @param array|mixed $data
 * @return boolean
 */
function ccb_update_calc_new_values( $data ) {
	if ( isset( $data['id'] ) ) {
		$title = ! empty( $data['title'] ) ? sanitize_text_field( $data['title'] ) : __( 'empty name', 'cost-calculator-builder' );
		wp_update_post(
			array(
				'ID'         => $data['id'],
				'post_title' => $title,
			)
		);

		update_option( 'stm_ccb_form_settings_' . sanitize_text_field( $data['id'] ), apply_filters( 'stm_ccb_sanitize_array', $data['settings'] ) );
		update_post_meta( $data['id'], 'stm-name', $title );
		update_post_meta( $data['id'], 'stm-formula', ! empty( $data['formula'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['formula'] ) : array() );

		if ( isset( $data['builder'] ) ) {
			foreach ( $data['builder'] as $idx => $builder ) {
				if ( isset( $builder['description'] ) ) {
					$data['builder'][ $idx ]['description'] = sanitize_text_field( $builder['description'] );
				}

				if ( isset( $builder['label'] ) ) {
					$data['builder'][ $idx ]['label'] = sanitize_text_field( $builder['label'] );
				}

				if ( isset( $builder['placeholder'] ) ) {
					$data['builder'][ $idx ]['placeholder'] = sanitize_text_field( $builder['placeholder'] );
				}
			}
		}

		update_post_meta( $data['id'], 'stm-fields', ! empty( $data['builder'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['builder'] ) : array() );
		update_post_meta( $data['id'], 'stm-conditions', ! empty( $data['conditions'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['conditions'] ) : array() );
		update_post_meta( $data['id'], 'calc_saved', true );

		if ( isset( $data['category'] ) ) {
			update_post_meta( $data['id'], 'category', sanitize_text_field( $data['category'] ) );
		}

		if ( isset( $data['preset_idx'] ) ) {
			update_post_meta( $data['id'], 'ccb_calc_preset_idx', apply_filters( 'stm_ccb_sanitize_value', $data['preset_idx'] ) );
		}

		$woo_products_enabled = isset( $data['settings']['woo_products']['enable'] ) && filter_var( $data['settings']['woo_products']['enable'], FILTER_VALIDATE_BOOLEAN );
		ccb_update_woocommerce_calcs( $data['id'], ! $woo_products_enabled );
		return true;
	}

	return false;
}

/**
 * Update calculator
 *
 * @param array|mixed $data
 * @return boolean
 */
function ccb_update_calc_old_values( $data ) {
	if ( isset( $data['id'] ) ) {
		$title = ! empty( $data['title'] ) ? sanitize_text_field( $data['title'] ) : __( 'empty name', 'cost-calculator-builder' );

		wp_update_post(
			array(
				'ID'         => $data['id'],
				'post_title' => $title,
			)
		);
		update_option( 'stm_ccb_form_settings_' . sanitize_text_field( $data['id'] ), apply_filters( 'stm_ccb_sanitize_array', $data['settings'] ) );

		update_post_meta( $data['id'], 'stm-name', $title );
		update_post_meta( $data['id'], 'stm-formula', ! empty( $data['formula'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['formula'] ) : array() );
		update_post_meta( $data['id'], 'stm-fields', ! empty( $data['builder'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['builder'] ) : array() );
		update_post_meta( $data['id'], 'stm-conditions', ! empty( $data['conditions'] ) ? apply_filters( 'stm_ccb_sanitize_array', $data['conditions'] ) : array() );

		$woo_products_enabled = isset( $data['settings']['woo_products']['enable'] ) && filter_var( $data['settings']['woo_products']['enable'], FILTER_VALIDATE_BOOLEAN );
		ccb_update_woocommerce_calcs( $data['id'], ! $woo_products_enabled );

		return true;
	}

	return false;
}

function ccb_update_calc_values( $data ) {
	$status = 'publish';
	if ( isset( $data['status'] ) ) {
		$status = $data['status'];
	}
	ccb_update_post_status( $data['id'], $status );
	return ccb_update_calc_new_values( $data );
}

function ccb_update_post_status( $id, $status = 'draft' ) {
	$data = array(
		'ID'          => $id,
		'post_status' => $status,
	);

	wp_update_post( $data );
}

/**
 * @param $calc_id
 * @param boolean $delete
 */
function ccb_update_woocommerce_calcs( $calc_id, $delete = false ) {
	$woocommerce_calcs = get_option( 'stm_ccb_woocommerce_calcs', array() );
	if ( $delete ) {
		$key = array_search( $calc_id, $woocommerce_calcs, true );
		if ( false !== $key ) {
			unset( $woocommerce_calcs[ $key ] );
		}
	} elseif ( ! in_array( $calc_id, $woocommerce_calcs, true ) ) {
		$woocommerce_calcs[] = $calc_id;
	}

	update_option( 'stm_ccb_woocommerce_calcs', apply_filters( 'stm_ccb_sanitize_array', $woocommerce_calcs ) );
}

/**
 *  Get All Calculators
 *
 * @param $post_type string
 * @return mixed|array
 */
function ccb_calc_get_all_posts( $post_type, $params = array() ) {
	$args = array(
		'offset'         => isset( $params['offset'] ) ? (int) $params['offset'] : 1,
		'posts_per_page' => isset( $params['limit'] ) ? (int) $params['limit'] : -1,
		'post_type'      => $post_type,
		'post_status'    => array( 'publish' ),
		'orderby'        => isset( $params['sort_by'] ) ? sanitize_text_field( $params['sort_by'] ) : 'id',
		'order'          => isset( $params['direction'] ) ? sanitize_text_field( $params['direction'] ) : 'desc',
	);
	if ( class_exists( 'Polylang' ) ) {
		$args['lang'] = '';
	}
	$resources = new WP_Query( $args );

	$resources_json = array();

	if ( $resources->have_posts() ) {
		while ( $resources->have_posts() ) {
			$resources->the_post();
			$id                    = get_the_ID();
			$resources_json[ $id ] = html_entity_decode( get_the_title(), ENT_QUOTES | ENT_HTML401, 'UTF-8' );
		}
	}

	return $resources_json;
}

function clearMetaData( $post_id ) {
	global $wpdb;
	$table = $wpdb->prefix . 'postmeta'; //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'stm-name', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'stm-formula', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'stm-fields', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'stm-conditions', 'post_id' => $post_id ) ); //phpcs:ignore
}

function clearTemplatesMetaData( $post_id ) {
	global $wpdb;
	$table = $wpdb->prefix . 'postmeta'; //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'type', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'access', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'category', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'calc_id', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'title', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'description', 'post_id' => $post_id ) ); //phpcs:ignore
}

function clearCategoriesMetaData( $post_id ) {
	global $wpdb;
	$table = $wpdb->prefix . 'postmeta'; //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'type', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'slug', 'post_id' => $post_id ) ); //phpcs:ignore
	$wpdb->delete( $table, array( 'meta_key' => 'title', 'post_id' => $post_id ) ); //phpcs:ignore
}


/**
 * Parse settings by $calc_id
 *
 * @param $settings
 * @return array
 */

function ccb_parse_settings( $settings ) {
	$currency = isset( $settings['currency']['currency'] ) ? sanitize_text_field( $settings['currency']['currency'] ) : '$';

	return array(
		'currency'            => $currency,
		'num_after_integer'   => isset( $settings['currency']['num_after_integer'] ) ? (int) $settings['currency']['num_after_integer'] : 2,
		'decimal_separator'   => isset( $settings['currency']['decimal_separator'] ) ? sanitize_text_field( $settings['currency']['decimal_separator'] ) : '.',
		'thousands_separator' => isset( $settings['currency']['thousands_separator'] ) ? sanitize_text_field( $settings['currency']['thousands_separator'] ) : ',',
		'currency_position'   => isset( $settings['currency']['currencyPosition'] ) ? sanitize_text_field( $settings['currency']['currencyPosition'] ) : 'left_with_space',
	);
}

/**
 * WooCommerce Products
 *
 * @return array
 */
function ccb_woo_products() {
	return get_posts(
		array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
		)
	);
}

/**
 * WooCommerce Categories
 *
 * @return array
 */
function ccb_woo_categories() {
	return get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		)
	);
}

/**
 * Contact Form 7 Forms
 *
 * @return array
 */
function ccb_all_available_pages() {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);

	$available_pages = array();
	if ( count( $pages ) ) {
		foreach ( $pages as $page ) {
			$available_pages[] = array(
				'id'      => $page->ID,
				'title'   => strlen( $page->post_title ) < 21 ? $page->post_title : substr( $page->post_title, 0, 20 ) . '...',
				'link'    => get_permalink( $page->ID ),
				'tooltip' => $page->post_title,
			);
		}
	}

	return $available_pages;
}

/**
 * Contact Form 7 Forms
 *
 * @return array
 */
function ccb_contact_forms() {
	$contact_forms = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => -1,
		)
	);

	$forms = array();
	if ( count( $contact_forms ) ) {
		foreach ( $contact_forms as $contact_form ) {
			$forms[] = array(
				'id'    => $contact_form->ID,
				'title' => $contact_form->post_title,
			);
		}
	}

	return $forms;
}

/**
 * Check active Add-on
 *
 * @return bool
 */
function ccb_pro_active() {
	return ( defined( 'CCB_PRO_VERSION' ) );
}

function ccb_all_calculators() {
	$lists = array( esc_html__( 'select', 'cost-calculator-builder' ) => 'Select' );
	$args  = array(
		'post_type'      => 'cost-calc',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
	);

	$data = new \WP_Query( $args );
	$data = $data->posts;

	if ( count( $data ) > 0 ) {
		foreach ( $data as $value ) {
			$lists[ $value->ID ] = $value->post_title;
		}
	}

	return $lists;
}

/**
 * Write to log
 *
 * @param $log
 * @return void
 */
function ccb_write_log( $log ) {
	if ( true === WP_DEBUG ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			error_log( print_r( $log, true ) ); // phpcs:ignore
		} elseif ( $log ) {
			error_log( $log ); // phpcs:ignore
		}
	}
}

/**
 * Return Support Ticket URL
 *
 * @return string
 */
function ccb_get_ticket_url() {
	$type = ccb_pro_active() ? 'support' : 'pre-sale';

	return "https://support.stylemixthemes.com/tickets/new/{$type}?item_id=29";
}

/** Base helper functions */


/**
 * @param string $json_string
 */
function is_json_string( $json_string ) {
	json_decode( $json_string );
	return ( json_last_error() === JSON_ERROR_NONE );
}


/**
 * sanitize_text_field without < replacement
 *
 * @param string $json_string
 */
function sanitize_without_tag_clean( $json_string ) {
	$result = str_replace( '<', '{less}', $json_string );
	$result = sanitize_text_field( $result );
	return str_replace( '{less}', '<', $result );
}

/**
 * @param $settings
 * @param $general_settings
 * @return array
 */
function ccb_sync_settings_from_general_settings( $settings, $general_settings, $render = false ) {
	$general_settings_cloned = $general_settings;

	if ( ! empty( $general_settings['currency']['use_in_all'] ) ) {
		$settings['currency'] = $general_settings['currency'];
		unset( $settings['currency']['use_in_all'] );
	}

	if ( ! empty( $general_settings_cloned['form_fields']['use_in_all'] ) ) {
		unset( $general_settings_cloned['form_fields']['use_in_all'] );
		foreach ( $general_settings_cloned['form_fields'] as $form_field_key => $form_field_value ) {
			if ( ! in_array( $form_field_key, array( 'terms_and_conditions', 'summary_display' ), true ) ) {
				$settings['formFields'][ $form_field_key ] = $form_field_value;
			}
		}
	}

	if ( ! empty( $general_settings['recaptcha'] ) ) {
		$enable                          = ! isset( $settings['recaptcha']['enable'] ) ? false : $settings['recaptcha']['enable'];
		$settings['recaptcha']           = $general_settings['recaptcha'];
		$settings['recaptcha']['enable'] = $enable;

		if ( empty( $settings['recaptcha'] ) ) {
			$settings['recaptcha'] = 'v2';
		}
	}

	if ( ! empty( $general_settings['paypal']['use_in_all'] ) ) {
		unset( $general_settings['use_in_all'] );
		foreach ( $general_settings['paypal'] as $paypal_field_key => $paypal_field_value ) {
			if ( 'enable' !== $paypal_field_key ) {
				$settings['paypal'][ $paypal_field_key ] = $paypal_field_value;
			}
		}
	}

	if ( ! empty( $general_settings['stripe']['use_in_all'] ) ) {
		unset( $general_settings['use_in_all'] );
		foreach ( $general_settings['stripe'] as $stripe_field_key => $stripe_field_value ) {
			if ( 'enable' !== $stripe_field_key ) {
				$settings['stripe'][ $stripe_field_key ] = $stripe_field_value;
			}
		}
	}

	if ( $render ) {
		unset( $settings['stripe']['secretKey'] );
		unset( $general_settings['stripe']['secretKey'] );
		unset( $settings['paypal']['paypal_email'] );
		unset( $general_settings['paypal']['paypal_email'] );
	}

	return array(
		'settings'         => $settings,
		'general_settings' => $general_settings,
	);
}

function ccb_invoice_logo( $settings ) {
	if ( empty( $settings['invoice']['companyLogo'] ) ) {
		return array();
	}

	$path = $settings['invoice']['companyLogo'];
	$type = pathinfo( $path, PATHINFO_EXTENSION );
	$data = file_get_contents( $path ); //phpcs:ignore
	if ( 'svg' === $type ) {
		return array(
			'key'  => 'svg',
			'data' => base64_encode( $data ), //phpcs:ignore
		);
	}

	return array(
		'key'  => 'image',
		'data' => 'data:image/' . $type . ';base64,' . base64_encode( $data ) //phpcs:ignore
	);
}

add_action( 'admin_bar_menu', 'my_admin_bar_menu', 50 );

function my_admin_bar_menu( $wp_admin_bar ) {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$wp_admin_bar->add_menu(
		array(
			'id'    => 'ccb-admin-menu',
			'title' => '<img class="ccb-icon-logo" src="' . CALC_URL . '/frontend/dist/img/ccb-logo.svg' . '"/>' . __( 'Cost Calculator', 'cost-calculator-builder' ), //phpcs:ignore
			'href'  => get_admin_url( null, 'admin.php?page=cost_calculator_builder' ),
		)
	);

	if ( defined( 'CCB_PRO_VERSION' ) ) {
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'ccb-admin-menu',
				'id'     => 'ccb-admin-menu-items-orders',
				'title'  => __( 'Orders', 'cost-calculator-builder' ),
				'href'   => get_admin_url( null, 'admin.php?page=cost_calculator_orders' ),
				'meta'   => array(
					'class' => 'ccb-admin-menu-item',
				),
			)
		);
	}

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'ccb-admin-menu',
			'id'     => 'ccb-admin-menu-items',
			'title'  => __( 'Calculators', 'cost-calculator-builder' ),
			'href'   => get_admin_url( null, 'admin.php?page=cost_calculator_builder' ),
			'meta'   => array(
				'class' => 'ccb-admin-menu-item',
			),
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'ccb-admin-menu',
			'id'     => 'ccb-admin-menu-items-create',
			'title'  => __( 'Create Calculator', 'cost-calculator-builder' ),
			'href'   => get_admin_url( null, 'admin.php?page=cost_calculator_builder&create-calc-from-menu=1' ),
			'meta'   => array(
				'class' => 'ccb-admin-menu-item',
			),
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'ccb-admin-menu',
			'id'     => 'ccb-admin-menu-items-settings',
			'title'  => __( 'Global Settings', 'cost-calculator-builder' ),
			'href'   => get_admin_url( null, 'admin.php?page=cost_calculator_builder&tab=settings' ),
			'meta'   => array(
				'class' => 'ccb-admin-menu-item',
			),
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'ccb-admin-menu',
			'id'     => 'ccb-admin-menu-items-community',
			'title'  => __( 'Community', 'cost-calculator-builder' ),
			'href'   => 'https://www.facebook.com/groups/costcalculator',
			'meta'   => array(
				'class'  => 'ccb-admin-menu-item',
				'target' => '_blank',
			),
		)
	);

	$wp_admin_bar->add_menu(
		array(
			'parent' => 'ccb-admin-menu',
			'id'     => 'ccb-admin-menu-items-documentation',
			'title'  => __( 'Documentation', 'cost-calculator-builder' ),
			'href'   => 'https://docs.stylemixthemes.com/cost-calculator-builder/',
			'meta'   => array(
				'class'  => 'ccb-admin-menu-item',
				'target' => '_blank',
			),
		)
	);

	if ( ! defined( 'CCB_PRO_VERSION' ) ) {
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'ccb-admin-menu',
				'id'     => 'ccb-admin-menu-items-upgrade',
				'title'  => __( 'Upgrade', 'cost-calculator-builder' ),
				'href'   => get_admin_url( null, 'admin.php?page=cost_calculator_gopro' ),
				'meta'   => array(
					'class' => 'ccb-admin-menu-item',
				),
			)
		);
	}
}

function override_admin_bar_css() {

	if ( is_admin_bar_showing() ) { ?>

		<style type="text/css">
		#wp-admin-bar-ccb-admin-menu {
			min-width: 168px;
		}
		#wp-admin-bar-ccb-admin-menu .ab-item {
			font-size: 14px;
			padding-left: 20px !important;
			padding-right: 20px !important;
			display: flex !important;
			align-items: center;
		}

		#wp-admin-bar-ccb-admin-menu .ab-item .ccb-icon-logo {
			margin-right: 10px;
			color: #1AB163;
			width: 20px;
		}

		#wp-admin-bar-ccb-admin-menu .ab-submenu {
			padding: 0 !important;
		}

		#wp-admin-bar-ccb-admin-menu-default {
			max-width: 170px;
			overflow: hidden;
		}

		.ccb-admin-menu-item .ab-item {
			height: 100% !important;
			font-size: 14px !important;
			line-height: 17px !important;
			padding: 6px 0 !important;
			transition: 200ms ease;
			color: rgba(255, 255, 255, 0.7);
		}

		#wp-admin-bar-ccb-admin-menu-items-upgrade .ab-item{
			background-color: #1AB163 !important;
			color: #fff !important;
		}

		#wp-admin-bar-ccb-admin-menu-items-upgrade .ab-item:hover {
			background-color: #148b5d !important;
		}

		.ccb-admin-menu-item:hover {
			background-color: #1AB163 !important;
		}

		.ccb-admin-menu-item:hover a {
			background-color: #1AB163 !important;
			color: #fff !important;
		}

		</style>

		<?php
	}
}

// on backend area
add_action( 'admin_head', 'override_admin_bar_css' );

// on frontend area
add_action( 'wp_head', 'override_admin_bar_css' );

function ccb_embed_popup_text() {
	return array(
		'title'                => esc_html__( 'Calculator embed options', 'cost-calculator-builder' ),
		'subtitle'             => esc_html__( 'We can help embed your calculator with just a few clicks!', 'cost-calculator-builder' ),
		'select_page'          => esc_html__( 'Select existing pages', 'cost-calculator-builder' ),
		'select_page_subtitle' => esc_html__( 'Embed your calculator into an existing page', 'cost-calculator-builder' ),
		'create_page'          => esc_html__( 'Create new page', 'cost-calculator-builder' ),
		'create_page_subtitle' => esc_html__( 'Insert your calculator on a newly created page', 'cost-calculator-builder' ),
		'insert'               => esc_html__( 'Insert manually', 'cost-calculator-builder' ),
		'insert_subtitle'      => esc_html__( 'Use WordPress shortcode to insert the Calculator in any place.', 'cost-calculator-builder' ),
		'create_button'        => esc_html__( 'Create Page', 'cost-calculator-builder' ),
		'create_placeholder'   => esc_html__( 'Enter page name' ),
		'apply'                => esc_html__( 'Apply', 'cost-calculator-builder' ),
		'pages_selected'       => esc_html__( 'pages selected', 'cost-calculator-builder' ),
		'page_select'          => esc_html__( 'Select Pages', 'cost-calculator-builder' ),
		'shortcode'            => esc_html__( 'Calculator Shortcode', 'cost-calculator-builder' ),
		'copyText'             => esc_html__( 'Shortcode copied successfully', 'cost-calculator-builder' ),
	);

}

function ccb_set_admin_url() {
	if ( empty( get_option( 'ccb_lock_templates_email', '' ) ) ) {
		$admin_email = get_option( 'admin_email' );
		update_option( 'ccb_lock_templates_email', sanitize_text_field( $admin_email ) );
		update_option( 'ccb_lock_templates', defined( 'CCB_PRO_VERSION' ) );
	}
}

function convertStdClassToArray( $data ) {
	if ( is_object( $data ) && get_class( $data ) === 'stdClass' ) {
		$data = json_decode( wp_json_encode( $data ), true );
	} elseif ( is_array( $data ) ) {
		foreach ( $data as &$value ) {
			$value = convertStdClassToArray( $value );
		}
	}

	return $data;
}

function ccb_array_merge_recursive_left_source( $array1, $array2 ) {
	$merged = $array1;

	foreach ( $array2 as $key => $value ) {
		if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) ) {
			$merged[ $key ] = ccb_array_merge_recursive_left_source( $merged[ $key ], $value );
		} elseif ( is_numeric( $key ) ) {
			if ( ! in_array( $value, $merged, true ) ) {
				$merged[] = $value;
			}
		} else {
			$merged[ $key ] = $value;
		}
	}

	return $merged;
}

function ccb_generate_random_string( $length = 10 ) {
	$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen( $characters );
	$randomString     = '';
	for ( $i = 0; $i < $length; $i++ ) {
		$randomString .= $characters[ random_int( 0, $charactersLength - 1 ) ];
	}

	return $randomString;
}

function ccb_format_history_created( $dateString ) {
	$now = new DateTime();

	list( $time, $date )        = explode( ' - ', $dateString );
	list( $day, $month, $year ) = sscanf( $date, '%d.%d.%d' );
	$inputDate                  = new DateTime( "$year-$month-$day $time" );
	$timeDifferenceInSeconds    = $now->getTimestamp() - $inputDate->getTimestamp();

	if ( $timeDifferenceInSeconds < 60 ) {
		return __( 'just now', 'cost-calculator-builder' );
	} elseif ( $timeDifferenceInSeconds < 3600 ) {
		$minutesAgo = floor( $timeDifferenceInSeconds / 60 );
		return $minutesAgo . ' ' . __( 'minute', 'cost-calculator-builder' ) . ( 1 === intval( $minutesAgo ) ? '' : 's' ) . ' ' . __( 'ago', 'cost-calculator-builder' );
	} elseif ( 86400 > $timeDifferenceInSeconds && $inputDate->format( 'Y-m-d' ) === $now->format( 'Y-m-d' ) ) {
		$hoursAgo = floor( $timeDifferenceInSeconds / 3600 );
		return $hoursAgo . ' ' . __( 'hour', 'cost-calculator-builder' ) . ( 1 === intval( $hoursAgo ) ? '' : 's' ) . ' ' . __( 'ago', 'cost-calculator-builder' );
	} elseif ( $timeDifferenceInSeconds < 172800 && $inputDate->format( 'Y-m-d' ) === $now->modify( '-1 day' )->format( 'Y-m-d' ) ) {
		return __( 'yesterday', 'cost-calculator-builder' );
	} else {
		$daysAgo = floor( $timeDifferenceInSeconds / 86400 );
		return $daysAgo . ' ' . __( 'day', 'cost-calculator-builder' ) . ( 1 === intval( $daysAgo ) ? '' : 's' ) . ' ' . __( 'ago', 'cost-calculator-builder' );
	}
}

function ccb_truncate_string( $input_string, $allowed_length = 40 ) {
	if ( strlen( $input_string ) > $allowed_length ) {
		return substr( $input_string, 0, $allowed_length - 3 ) . '...';
	} else {
		return $input_string;
	}
}

function ccb_pro_features_page_tab( $tabs ) {
	if ( ! defined( 'CCB_PRO_PATH' ) ) {
		$tabs['ccb_pro_features'] = __( 'Cost Calculator Pro Features', 'cost-calculator-builder' );
		wp_enqueue_style( 'ccb-admin-app-css', CALC_URL . '/frontend/dist/css/admin.css', array(), CALC_VERSION );
	}
	return $tabs;
}

add_filter( 'install_plugins_tabs', 'ccb_pro_features_page_tab' );

function ccb_pro_features_page_redirect( $tabs ) {
	if ( ! isset( $_GET['tab'] ) || 'ccb_pro_features' !== $_GET['tab'] ) {
		return;
	}
	wp_safe_redirect( admin_url( 'admin.php?page=cost_calculator_pro_features' ) );
	exit;
}

add_action( 'load-plugin-install.php', 'ccb_pro_features_page_redirect' );

function ccb_convert_from_btoa( $data, $convert_into_array = false ) {
	$jsonString = base64_decode( $data ); // phpcs:ignore
	$jsonString = urldecode( $jsonString );

	if ( $convert_into_array ) {
		$jsonString = str_replace( '\"', '"', $jsonString );
		$jsonString = str_replace( "\'", "'", $jsonString );
		$jsonString = str_replace( '\\\\', "\\", $jsonString ); //phpcs:ignore
		$jsonString = json_decode( $jsonString, true );
	}

	return $jsonString;
}

function ccb_is_convert_correct( $jsonString = '' ) {
	$data = json_decode( $jsonString, true );
	return ! empty( $data );
}

function ccb_remove_params_from_url( $url, $params_to_remove ) {
	$url_components = parse_url( $url ); // phpcs:ignore

	if ( ! isset( $url_components['query'] ) ) {
		return $url;
	}

	parse_str( $url_components['query'], $queryParams );

	foreach ( $params_to_remove as $param ) {
		unset( $queryParams[ $param ] );
	}

	$url_components['query'] = http_build_query( $queryParams );

	// Rebuild the final URL
	$finalUrl = $url_components['scheme'] . '://' . $url_components['host'];
	if ( isset( $url_components['path'] ) ) {
		$finalUrl .= $url_components['path'];
	}

	if ( $url_components['query'] ) {
		$finalUrl .= '?' . $url_components['query'];
	}

	return $finalUrl;
}
