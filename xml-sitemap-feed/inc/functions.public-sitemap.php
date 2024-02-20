<?php
/**
 * Public Sitemap Functions
 *
 * @package XML Sitemap & Google News
 */

/**
 * Get root pages data
 *
 * @return array
 */
function xmlsf_get_root_data() {

	// language roots
	global $sitepress;

	// Polylang and WPML compat
	if ( function_exists('pll_languages_list') && function_exists('pll_home_url') ) {
		$languages = pll_languages_list();
		if ( is_array($languages) ) {
			foreach ( $languages as $language ) {
				$url = pll_home_url( $language );
				$data[$url] = array(
					'priority' => '1.0',
					'lastmod' => get_date_from_gmt( get_lastpostdate('GMT'), DATE_W3C )
					// TODO make lastmod date language specific
				);
			}
		}
	} elseif ( is_object($sitepress) && method_exists($sitepress, 'get_languages') && method_exists($sitepress, 'language_url') ) {
		foreach ( array_keys ( $sitepress->get_languages(false,true) ) as $term ) {
			$url = $sitepress->language_url($term);
			$data[$url] = array(
				'priority' => '1.0',
				'lastmod' => get_date_from_gmt( get_lastpostdate('GMT'), DATE_W3C )
				// TODO make lastmod date language specific
			);
		}
	} else {
		// single site root
		$data = array(
			trailingslashit( home_url() ) => array(
				'priority' => '1.0',
				'lastmod' => get_date_from_gmt( get_lastpostdate('GMT'), DATE_W3C )
			)
		);
	}

	return apply_filters( 'xmlsf_root_data', $data );

}

/**
 * User Priority
 *
 * @since 5.4
 *
 * @param int $user User ID
 * @return float
 */
function xmlsf_get_user_priority( $user ) {

	$author_settings = get_option( 'xmlsf_author_settings' );

	$priority = isset( $author_settings['priority'] ) && is_numeric( $author_settings['priority'] ) ? floatval( $author_settings['priority'] ) : 0.5 ;

	// TODO dynamic priority calculation?

	$priority = apply_filters( 'xmlsf_user_priority', $priority, $user );

	// a final check for limits and round it
	return xmlsf_sanitize_priority( $priority );
}

/**
 * User Modified
 *
 * @since 5.4
 *
 * @param WP_User $user
 * @return string|false GMT date
 */
function xmlsf_get_user_modified( $user ) {

	if ( function_exists( 'get_metadata_raw' ) ) {
		/**
		 * Use get_metadata_raw if it exists (since WP 5.5) because it will return null if the key does not exist.
		 */
		$lastmod = get_metadata_raw( 'user', $user->ID, 'user_modified', true );
	} else {
		/**
		 * Getting ALL meta here because if checking for single key, we cannot
		 * distiguish between empty value or non-exisiting key as both return ''.
		 */
		$meta = get_user_meta( $user->ID );
		$lastmod = array_key_exists( 'user_modified', $meta ) ? get_user_meta( $user->ID, 'user_modified', true ) : null;
	}

	if ( null === $lastmod ) {
		/**
		 * Filters the post types present in the author archive. Must return an array of one or multiple post types.
		 * Allows to add or change post type when theme author archive page shows custom post types.
		 *
		 * @since 0.1
		 *
		 * @param array Array with post type slugs. Default array('post').
		 *
		 * @return array
		 */
		$post_type_array = apply_filters( 'xmlsf_author_post_types', array( 'post' ) );

		// Get lastmod from last publication date.
		$posts = get_posts(
			array(
				'author' => $user->ID,
				'post_type' => $post_type_array,
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'numberposts' => 1,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'update_cache' => false,
				'lang' => '' // TODO make multilanguage compatible
			)
		);
		$lastmod = ! empty( $posts ) ? get_post_field( 'post_date', $posts[0] ) : '';
		// Cache lastmod as user_modified meta data.
		add_user_meta( $user->ID, 'user_modified', $lastmod );
	}

	/*
	* Getting ALL meta here because if checking for single key, we cannot
	* distiguish between empty value or non-exisiting key as both return ''.
	*/
	$meta = get_user_meta( $user->ID );

	if ( ! array_key_exists( 'user_modified', $meta ) ) {
		// Last publication date.


	} else {

		$lastmod = get_user_meta( $user->ID, 'user_modified', true );

	}

	return ! empty( $lastmod ) ? mysql2date( DATE_W3C, $lastmod, false ) : false;
}

/**
 * Do image tag
 *
 * @param string $type
 * @uses WP_Post $post
 * @return void
 */
function xmlsf_image_tag( $type ) {
	if ( 'post_type' !== $type ) {
		return;
	}
	global $post;
	$post_types = (array) get_option( 'xmlsf_post_types' );
	if (
		isset( $post_types[$post->post_type] ) &&
		is_array( $post_types[$post->post_type] ) &&
		isset( $post_types[$post->post_type]['tags'] ) &&
		is_array( $post_types[$post->post_type]['tags'] ) &&
		! empty( $post_types[$post->post_type]['tags']['image'] )  &&
		is_string( $post_types[$post->post_type]['tags']['image'] )
	) {
		$images = get_post_meta( $post->ID, '_xmlsf_image_'.$post_types[$post->post_type]['tags']['image'] );
		foreach ( $images as $img ) {
			if ( empty($img['loc']) ) continue;

			echo '		<image:image>
			<image:loc>' . utf8_uri_encode( $img['loc'] ) . '</image:loc>';
			if ( !empty($img['title']) ) {
				echo '
			<image:title><![CDATA[' . str_replace(']]>', ']]&gt;', $img['title']) . ']]></image:title>';
			}
			if ( !empty($img['caption']) ) {
				echo '
			<image:caption><![CDATA[' . str_replace(']]>', ']]&gt;', $img['caption']) . ']]></image:caption>';
			}
			do_action( 'xmlsf_image_tags_inner', 'post_type' );
			echo '
		</image:image>
';
		}
	}
}
add_action( 'xmlsf_tags_after', 'xmlsf_image_tag' );


function xmlsf_image_schema( $type ) {
	if ( 'post_type' !== $type ) {
		return;
	}
	global $post;
	$post_types = (array) get_option( 'xmlsf_post_types' );
	if (
		isset( $post_types[$post->post_type] ) &&
		is_array( $post_types[$post->post_type] ) &&
		isset( $post_types[$post->post_type]['tags'] ) &&
		is_array( $post_types[$post->post_type]['tags'] ) &&
		! empty( $post_types[$post->post_type]['tags']['image'] )
	) {
		echo 'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"';
	}
}
add_action( 'xmlsf_urlset', 'xmlsf_image_schema' );


/**
 * Do authors
 *
 * @return bool
 */
function xmlsf_do_authors() {

	$settings = get_option( 'xmlsf_author_settings', xmlsf()->defaults('author_settings') );

	return is_array( $settings ) && ! empty( $settings['active'] );
}

/**
 * Get front pages
 *
 * @return array
 */
function xmlsf_get_frontpages() {

	if ( null === xmlsf()->frontpages ) :

		$frontpages = array();
		if ( 'page' == get_option('show_on_front') ) {
			$frontpage = (int) get_option('page_on_front');
			$frontpages = (array) apply_filters( 'xmlsf_frontpages', $frontpage );
		}
		xmlsf()->frontpages = $frontpages;

	endif;

	return xmlsf()->frontpages;

}

/**
 * Get blog_pages
 *
 * @return array
 */
function xmlsf_get_blogpages() {

	if ( null === xmlsf()->blogpages ) :
		$blogpages = array();
		if ( 'page' == get_option('show_on_front') ) {
			$blogpage = (int) get_option('page_for_posts');
			$blogpages = (array) apply_filters( 'xmlsf_blogpages', $blogpage );
		}
		xmlsf()->blogpages = $blogpages;
	endif;

	return xmlsf()->blogpages;

}

/**
 * Post Modified
 *
 * @param WP_Post $post
 * @return string|false GMT date
 */
function xmlsf_get_post_modified( $post ) {

	// if blog or home page then simply look for last post date
	if ( $post->post_type == 'page' && ( in_array( $post->ID, xmlsf_get_blogpages() ) || in_array( $post->ID, xmlsf_get_frontpages() ) ) ) {

		$lastmod = get_lastpostdate( 'GMT', 'post' );

	} else {

		$lastmod = $post->post_modified_gmt;

		// make sure lastmod is not older than publication date (happens on scheduled posts)
		if ( isset( $post->post_date_gmt ) && strtotime( $post->post_date_gmt ) > strtotime( $lastmod ) ) {
			$lastmod = $post->post_date_gmt;
		};

		// maybe update lastmod to latest comment
		$options = (array) get_option( 'xmlsf_post_types', array() );

		if ( !empty($options[$post->post_type]['update_lastmod_on_comments']) ) {
			// assuming post meta data has been primed here
			$lastcomment = get_post_meta( $post->ID, '_xmlsf_comment_date_gmt', true ); // only get one

			if ( ! empty( $lastcomment ) && strtotime( $lastcomment ) > strtotime( $lastmod ) )
				$lastmod = $lastcomment;
		}

	}

	return ! empty( $lastmod ) ? get_date_from_gmt( $lastmod, DATE_W3C ) : false;
}

/**
 * Term Modified
 *
 * @param WP_Term|int $term
 * @return string|false
 */
function xmlsf_get_term_modified( $term ) {

	if ( is_numeric($term) ) {
		$term = get_term( $term );
	}

	if ( function_exists( 'get_metadata_raw' ) ) {
		/**
		* Use get_metadata_raw if it exists (since WP 5.5) because it will return null if the key does not exist.
		*/
		$lastmod = get_metadata_raw( 'term', $term->term_id, 'term_modified', true );
	} else {
		/**
		* Getting ALL meta here because if checking for single key, we cannot
		* distiguish between empty value or non-exisiting key as both return ''.
		*/
		$meta = get_term_meta( $term->term_id );
		$lastmod = array_key_exists( 'term_modified', $meta ) ? get_term_meta( $term->term_id, 'term_modified', true ) : null;
	}

	if ( null === $lastmod ) {
		// Get lastmod from last publication date.
		$posts = get_posts (
			array(
				'post_type' => 'any',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'update_cache' => false,
				'lang' => '',
				'tax_query' => array(
					array(
						'taxonomy' => $term->taxonomy,
						'field' => 'slug',
						'terms' => $term->slug
					)
				)
			)
		);
		$lastmod = isset($posts[0]->post_date) ? $posts[0]->post_date : '';
		// Cache lastmod as term_modified meta data.
		add_term_meta( $term->term_id, 'term_modified', $lastmod );
	}

	return ! empty( $lastmod ) ? mysql2date( DATE_W3C, $lastmod, false ) : false;
}

/**
 * Taxonomy Modified
 *
 * @param string $taxonomy
 * @return string
 */
function xmlsf_get_taxonomy_modified( $taxonomy ) {

	$obj = get_taxonomy( $taxonomy );

	$lastmodified = array();
	foreach ( (array)$obj->object_type as $object_type ) {
		$lastmodified[] = get_lastpostdate( 'GMT', $object_type );
	}

	sort( $lastmodified );
	$lastmodified = array_filter( $lastmodified );
	$lastmod = end( $lastmodified );

	return get_date_from_gmt( $lastmod, DATE_W3C );
}

/**
 * Get post priority
 *
 * @param WP_Post $post
 * @return float
 */
function xmlsf_get_post_priority( $post ) {
	// locale LC_NUMERIC should be set to C for these calculations
	// it is assumed to be done once at the request filter
	//setlocale( LC_NUMERIC, 'C' );

	$options = get_option( 'xmlsf_post_types' );
	$priority = isset($options[$post->post_type]['priority']) && is_numeric($options[$post->post_type]['priority']) ? floatval($options[$post->post_type]['priority']) : 0.5;

	if ( in_array( $post->ID, xmlsf_get_frontpages() ) ) {

		$priority = 1;

	} elseif ( $priority_meta = get_post_meta( $post->ID, '_xmlsf_priority', true ) ) {

		$priority = floatval(str_replace(',','.',$priority_meta));

	} elseif ( ! empty($options[$post->post_type]['dynamic_priority']) ) {

		$post_modified = mysql2date('U',$post->post_modified);

		// Reduce by age.
		// NOTE : home/blog page gets same treatment as sticky post, i.e. no reduction by age
		if ( xmlsf()->timespan > 0 && ! is_sticky( $post->ID ) && ! in_array( $post->ID, xmlsf_get_blogpages() ) ) {
			$priority -= $priority * ( xmlsf()->lastmodified - $post_modified ) / xmlsf()->timespan;
		}

		// Increase by relative comment count.
		if ( $post->comment_count > 0 && $priority < 1 && xmlsf()->comment_count > 0 ) {
			$priority += 0.1 + ( 1 - $priority ) * $post->comment_count / xmlsf()->comment_count;
		}

	}

	$priority = apply_filters( 'xmlsf_post_priority', $priority, $post->ID );

	// A final check for limits and round it.
	return xmlsf_sanitize_priority( $priority );
}

/**
 * Get taxonomy priority
 *
 * @param WP_Term|int $term
 *
 * @return float
 */
function xmlsf_get_term_priority( $term ) {
	// locale LC_NUMERIC should be set to C for these calculations
	// it is assumed to be done at the request filter
	//setlocale( LC_NUMERIC, 'C' );

	$options = get_option( 'xmlsf_taxonomy_settings' );

	$priority = isset( $options['priority'] ) && is_numeric( $options['priority'] ) ? floatval( $options['priority'] ) : 0.5 ;

	if ( is_numeric($term) ) {
		$term = get_term( $term );
	}

	if ( !empty($options['dynamic_priority']) && $priority > 0.1 ) {
		// set first and highest term post count as maximum
		if ( null == xmlsf()->taxonomy_termmaxposts ) {
			xmlsf()->taxonomy_termmaxposts = $term->count;
		}

		$priority -= ( xmlsf()->taxonomy_termmaxposts - $term->count ) * ( $priority - 0.1 ) / xmlsf()->taxonomy_termmaxposts;
	}

	$priority = apply_filters( 'xmlsf_term_priority', $priority, $term->slug );

	// a final check for limits and round it
	return xmlsf_sanitize_priority( $priority );

}
