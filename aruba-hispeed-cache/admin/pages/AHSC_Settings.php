<?php
include "AHSC_Page.php";
class AHSC_Settings extends \AHSC\Pages\AHSC_Page {

    public $fields;

	protected function draw(){
		global $pagenow;

        if ( ! \current_user_can( 'manage_options' ) ) {
			\wp_die(
				esc_html__( 'Sorry, you need to be an administrator to use HiSpeed Cache.', 'aruba-hispeed-cache' )
			);
		}
		ahsc_save_options();
		$this->add_fields();

		include_once AHSC_CONSTANT['ARUBA_HISPEED_CACHE_BASEPATH'] . 'admin' . DIRECTORY_SEPARATOR .'pages'.DIRECTORY_SEPARATOR .'views'.DIRECTORY_SEPARATOR .  'admin-settings.php';

	}

	/**
	 * This method add files to settings form.
	 *
	 * @return void
	 */
	private function add_fields() {
		$this->fields = array();

		$site_option=get_site_option( AHSC_CONSTANT['ARUBA_HISPEED_CACHE_OPTIONS_NAME'] );

		$option       = ($site_option)?$site_option: AHSC_OPTIONS_LIST;

		$this->fields['sections']['general']['general'] = array(
			'ids'   => array( 'ahsc_enable_purge' ),
			'name'  =>wp_kses( __( 'Cache purging options', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//esc_html__( 'Cache purging options', 'aruba-hispeed-cache' ),
			'class' => '',
		);

		$this->fields['ahsc_enable_purge'] = array(
			'name'    => wp_kses( __( 'Enable automatic purge of the cache', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Enable automatic purge of the cache', 'aruba-hispeed-cache' ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_enable_purge',
			'checked' => \checked( $option['ahsc_enable_purge'], true, false ),
		);

		$is_hidden = ! $option['ahsc_enable_purge' ];

		$this->fields['sections']['general']['settings_tittle'] = array(
			'title' =>  wp_kses( __( 'Automatically purge the entire cache when:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Automatically purge the entire cache when:', 'aruba-hispeed-cache' ),
			'type'  => 'title',
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['sections']['general']['homepage'] = array(
			'ids'   => array( 'ahsc_purge_homepage_on_edit', 'ahsc_purge_homepage_on_del' ),
			'name'  =>wp_kses( __( 'Home page:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Home page:', 'aruba-hispeed-cache' ),
			// 'legend' => \esc_html__( 'Home page:', 'aruba-hispeed-cache' ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['ahsc_purge_homepage_on_edit'] = array(
			'name'    => \wp_kses( __( 'A post (or page/custom post) is modified or added.', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_homepage_on_edit',
			'checked' => \checked( $option['ahsc_purge_homepage_on_edit'], 1, false ),
		);

		$this->fields['ahsc_purge_homepage_on_del'] = array(
			'name'    => wp_kses( __( 'a <strong>published post</strong> (or page/custom post) is <strong>cancelled</strong>.', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_homepage_on_del',
			'checked' => \checked( $option['ahsc_purge_homepage_on_del'], 1, false ),
		);

		$this->fields['sections']['general']['pages'] = array(
			'ids'   => array( 'ahsc_purge_page_on_mod', 'ahsc_purge_page_on_new_comment', 'ahsc_purge_page_on_deleted_comment' ),
			'name'  => wp_kses( __( 'Post/page/custom post:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Post/page/custom post:', 'aruba-hispeed-cache' ),
			// 'legend' => \esc_html__( 'Post/page/custom post type:', 'aruba-hispeed-cache' ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['ahsc_purge_page_on_mod'] = array(
			'name'    => wp_kses( __( 'A post is published', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_page_on_mod',
			'checked' => \checked( $option[ 'ahsc_purge_page_on_mod' ], 1, false ),
		);

		$this->fields['ahsc_purge_page_on_new_comment'] = array(
			'name'    => wp_kses( __( 'A comment is published', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_page_on_new_comment',
			'checked' => \checked( $option['ahsc_purge_page_on_new_comment' ], 1, false ),
		);

		$this->fields['ahsc_purge_page_on_deleted_comment'] = array(
			'name'    => wp_kses( __( 'A comment is not approved or is deleted', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_page_on_deleted_comment',
			'checked' => \checked( $option[ 'ahsc_purge_page_on_deleted_comment' ], 1, false ),
		);

		$this->fields['sections']['general']['archives'] = array(
			'ids'    => array( 'ahsc_purge_archive_on_edit', 'ahsc_purge_archive_on_del' ),
			'name'   => wp_kses( __( 'Archives:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Archives:', 'aruba-hispeed-cache' ),
			'legend' => wp_kses( __( '(date, category, tag, author, custom taxonomies)', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( '(date, category, tag, author, custom taxonomies)', 'aruba-hispeed-cache' ),
			'class'  => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['ahsc_purge_archive_on_edit'] = array(
			'name'    => wp_kses( __( 'a <strong>post</strong> (or page/custom post) is <strong>modified</strong> or <strong>added</strong>.', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_archive_on_edit',
			'checked' => \checked( $option['ahsc_purge_archive_on_edit' ], 1, false ),
		);

		$this->fields['ahsc_purge_archive_on_del'] = array(
			'name'    => wp_kses( __( 'A published post (or page/custom post) is deleted', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_archive_on_del',
			'checked' => \checked( $option['ahsc_purge_archive_on_del' ], 1, false ),
		);

		$this->fields['sections']['general']['comments'] = array(
			'ids'   => array( 'ahsc_purge_archive_on_new_comment', 'ahsc_purge_archive_on_deleted_comment' ),
			'name'  => wp_kses( __( 'Comments', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Comments', 'aruba-hispeed-cache' ),
			// 'legend' => \esc_html__( '(date, category, tag, author, custom taxonomies)', 'aruba-hispeed-cache' ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['ahsc_purge_archive_on_new_comment'] = array(
			'name'    => wp_kses( __( 'A comment is published', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_archive_on_new_comment',
			'checked' => \checked( $option[ 'ahsc_purge_archive_on_new_comment' ], 1, false ),
		);

		$this->fields['ahsc_purge_archive_on_deleted_comment'] = array(
			'name'    => wp_kses( __( 'A comment is not approved or is deleted', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_purge_archive_on_deleted_comment',
			'checked' => \checked( $option[ 'ahsc_purge_archive_on_deleted_comment' ], 1, false ),
		);


		$this->fields['sections']['cache_warmer']['settings_tittle'] = array(
			'title' => wp_kses( __( 'Cache Warming:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Cache Warming:', 'aruba-hispeed-cache' ),
			'type'  => 'title',
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

		$this->fields['sections']['cache_warmer']['general'] = array(
			'ids'   => array( 'ahsc_cache_warmer' ),
			'name'  =>  wp_kses( __( 'Cache Warming options', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Cache Warming options', 'aruba-hispeed-cache' ),
			'class' => ( $is_hidden ) ? 'ahsc_cache_warmer hidden' : 'ahsc_cache_warmer',
		);

		$this->fields['ahsc_cache_warmer'] = array(
			'name'    => "<strong>".wp_kses( __( 'Enables Cache Warming.', 'aruba-hispeed-cache' ), array( 'strong' => array() ) )."</strong>",
			'legend' => wp_kses( __( 'Cache Warming is the process through which webpages are preloaded in the cache so they can be displayed quicker.<br> When the cache is emptied, the homepage data and the last ten posts of the site are automatically renewed to guarantee faster page loading', 'aruba-hispeed-cache' ), array( 'strong' => array(), 'br' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_cache_warmer',
			'checked' => \checked( $option[ 'ahsc_cache_warmer' ], 1, false ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);


		$this->fields['sections']['general']['cache_static']['settings_tittle'] = array(
			'title' => wp_kses( __( 'Static File Cache:', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Static File Cache:', 'aruba-hispeed-cache' ),
			'type'  => 'title',
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);
		$this->fields['sections']['general']['cache_static'] = array(
			'ids'   => array( 'ahsc_static_cache' ),
			'name'  => wp_kses( __( 'Static File Cache options', 'aruba-hispeed-cache' ), array( 'strong' => array() ) ) ,
				//\esc_html__( 'Static File Cache options', 'aruba-hispeed-cache' ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);
		$this->fields['ahsc_static_cache'] = array(
			'name'    => "<strong>".wp_kses( __( 'Optimize static file cache.', 'aruba-hispeed-cache' ), array( 'strong' => array() ) )."</strong>",
			'legend' => wp_kses( __( 'Enable cache for static file such image file, css file js file etc.etc.', 'aruba-hispeed-cache' ), array( 'strong' => array(), 'br' => array() ) ),
			'type'    => 'checkbox',
			'id'      => 'ahsc_static_cache',
			'checked' => \checked( $option[ 'ahsc_static_cache' ], 1, false ),
			'class' => ( $is_hidden ) ? 'hidden' : '',
		);

	}


}