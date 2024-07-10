<?php
namespace BetterLinks\Tools;

class Export {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'export_data' ) );
	}
	public function export_data() {
		$can_access_settings = apply_filters( 'betterlinks/admin/' . BETTERLINKS_PLUGIN_SLUG . '-settings_menu_capability', 'manage_options' );
		$nonce               = isset( $_GET['nonce'] ) ? sanitize_text_field( wp_unslash( $_GET['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'betterlinks_admin_nonce' ) || ! is_user_logged_in() || ! current_user_can( $can_access_settings ) ) {
			return false;
		}
		$page   = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
		$export = isset( $_GET['export'] ) ? sanitize_text_field( wp_unslash( $_GET['export'] ) ) : false;
		if ( 'betterlinks-settings' === $page && true == $export ) {
			$type = isset( $_POST['content'] ) ? $_POST['content'] : '';
			$this->download_files( $type );
			exit();
		}
	}

	public function download_files( $type ) {
		$data     = array();
		$filename = 'betterlinks';
		if ( 'links' === $type ) {
			$links = $this->get_links();
			$data  = $this->prepare_csv_file_data( $links );
		} elseif ( 'clicks' === $type ) {
			$clicks    = $this->get_clicks();
			$data      = $this->prepare_csv_file_data( $clicks );
			$filename .= '-clicks';
		} else {
			$filename = 'Sample-file';
			$data     = $this->simple_file_download();
		}
		$filename .= '.' . gmdate( 'Y-m-d' ) . '.csv';
		$this->array_to_csv_download(
			$data,
			$filename
		);
	}

	public function array_to_csv_download( $arr, $filename = 'export.csv' ) {
		header( 'Content-Type: application/csv' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '";' );
		$f = fopen( 'php://output', 'w' );
		foreach ( $arr as $line ) {
			fputcsv( $f, $line );
		}
	}

	public function prepare_csv_file_data( $data ) {
		if ( is_array( $data ) && count( $data ) > 0 ) {
			return array_merge( array( array_keys( $data[0] ) ), $data );
		}
		return array();
	}

	public function get_links() {
		global $wpdb;
		$links   = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}betterlinks", ARRAY_A );
		$results = array();
		if ( is_array( $links ) && count( $links ) > 0 ) {
			foreach ( $links as $link ) {
				$terms     = $this->get_terms_from_link_id( $link['ID'] );
				$results[] = array_merge( $link, $terms );
			}
		}
		return $results;
	}

	public function simple_file_download() {
		$links        = array(
			'ID',
			'link_author',
			'link_date',
			'link_date_gmt',
			'link_title',
			'link_slug',
			'link_note',
			'link_status',
			'nofollow',
			'sponsored',
			'track_me',
			'param_forwarding',
			'param_struct',
			'redirect_type',
			'target_url',
			'short_url',
			'link_order',
			'link_modified',
			'link_modified_gmt',
			'wildcards',
			'expire',
			'dynamic_redirect',
			'favorite',
			'uncloaked',
		);
		$current_date = wp_date( 'Y-m-d H:i:s' );
		$sample_data  = array(
			'1',
			'1',
			$current_date,
			$current_date,
			'Example Title Here',
			'example-title-Here',
			'',
			'publish',
			'1',
			'',
			'1',
			'',
			'',
			'307',
			'https://your.site/example',
			'go/example',
			'0',
			$current_date,
			$current_date,
			'0',
			'{"status":0,"type":"date","clicks":"","date":"","redirect_status":0,"redirect_url":""}',
			'{"type":"","value":[],"extra":{"rotation_mode":"weighted","split_test":"","goal_link":""}}',
			'',
			'',
			'',
			'uncategorized',
		);

		if ( is_array( $links ) && count( $links ) > 0 ) {
			array_push( $links, 'tags', 'category' );
			return array( $links, $sample_data );
		}
		return array();
	}

	public function get_terms_from_link_id( $link_id = 0 ) {
		global $wpdb;
		$category = array();
		$tags     = array();
		$terms    = $wpdb->get_results( "SELECT *  FROM {$wpdb->prefix}betterlinks_terms  LEFT JOIN  {$wpdb->prefix}betterlinks_terms_relationships ON {$wpdb->prefix}betterlinks_terms.ID = {$wpdb->prefix}betterlinks_terms_relationships.term_id WHERE {$wpdb->prefix}betterlinks_terms_relationships.link_id = {$link_id}", ARRAY_A );
		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {
				if ( 'category' === $term['term_type'] ) {
					$category[] = $term['term_slug'];
				} elseif ( 'tags' === $term['term_type'] ) {
					$tags[] = $term['term_slug'];
				}
			}
		}
		return array(
			'tags'     => ( count( $tags ) > 0 ? implode( ',', $tags ) : '' ),
			'category' => ( count( $category ) > 0 ? implode( ',', $category ) : '' ),
		);
	}


	public function get_clicks() {
		global $wpdb;
		$options     = json_decode( get_option( BETTERLINKS_LINKS_OPTION_NAME ), true );
		$ip_tracking = ( isset( $options['is_disable_analytics_ip'] ) && ! $options['is_disable_analytics_ip'] ) ? "{$wpdb->prefix}betterlinks_clicks.ip," : '';
		$clicks      = $wpdb->get_results(
			"SELECT 
            {$wpdb->prefix}betterlinks.short_url,
            {$wpdb->prefix}betterlinks.target_url,
            {$ip_tracking}
            {$wpdb->prefix}betterlinks_clicks.browser, 
            {$wpdb->prefix}betterlinks_clicks.os, 
            {$wpdb->prefix}betterlinks_clicks.referer, 
            {$wpdb->prefix}betterlinks_clicks.host, 
            {$wpdb->prefix}betterlinks_clicks.uri, 
            {$wpdb->prefix}betterlinks_clicks.visitor_id, 
            {$wpdb->prefix}betterlinks_clicks.click_order, 
            {$wpdb->prefix}betterlinks_clicks.created_at, 
            {$wpdb->prefix}betterlinks_clicks.created_at_gmt
        FROM {$wpdb->prefix}betterlinks_clicks LEFT JOIN {$wpdb->prefix}betterlinks ON {$wpdb->prefix}betterlinks_clicks.link_id = {$wpdb->prefix}betterlinks.ID",
			ARRAY_A
		);
		return $clicks;
	}
}
