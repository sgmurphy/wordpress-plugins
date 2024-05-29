<?php
namespace SlimSEO\Migration\Sources;

use SlimSEO\Redirection\Database\Redirects as DbRedirects;
use SlimSEO\Redirection\Helper as RedirectionHelper;

class Yoast extends Source {
	protected $constant = 'WPSEO_VERSION';

	protected function get_post_title( $post_id ) {
		$post  = get_post( $post_id, ARRAY_A );
		$title = get_post_meta( $post_id, '_yoast_wpseo_title', true );
		return wpseo_replace_vars( $title, $post );
	}

	protected function get_post_description( $post_id ) {
		$post        = get_post( $post_id, ARRAY_A );
		$description = get_post_meta( $post_id, '_yoast_wpseo_metadesc', true );
		return wpseo_replace_vars( $description, $post );
	}

	protected function get_post_facebook_image( $post_id ) {
		return get_post_meta( $post_id, '_yoast_wpseo_opengraph-image', true );
	}

	protected function get_post_twitter_image( $post_id ) {
		return get_post_meta( $post_id, '_yoast_wpseo_twitter-image', true );
	}

	protected function get_post_noindex( $post_id ) {
		return (int) get_post_meta( $post_id, '_yoast_wpseo_meta-robots-noindex', true );
	}

	protected function get_term_title( $term_id ) {
		$term = $this->get_term( $term_id );
		if ( ! $term ) {
			return '';
		}
		$title = $term['wpseo_title'] ?? '';
		return wpseo_replace_vars( $title, $term );
	}

	protected function get_term_description( $term_id ) {
		$term = $this->get_term( $term_id );
		if ( ! $term ) {
			return '';
		}
		$description = $term['wpseo_desc'] ?? '';
		return wpseo_replace_vars( $description, $term );
	}

	protected function get_term_facebook_image( $term_id ) {
		$term = $this->get_term( $term_id );
		return $term['wpseo_opengraph-image'] ?? '';
	}

	protected function get_term_twitter_image( $term_id ) {
		$term = $this->get_term( $term_id );
		return $term['wpseo_twitter-image'] ?? '';
	}

	protected function get_term_noindex( $term_id ) {
		$term = $this->get_term( $term_id );
		return intval( isset( $term['wpseo_noindex'] ) && $term['wpseo_noindex'] === 'noindex' );
	}

	/**
	 * Get terms value from option table.
	 */
	private function get_terms() {
		$terms = get_option( 'wpseo_taxonomy_meta' );
		if ( empty( $terms ) ) {
			return [];
		}
		$terms       = array_values( $terms );
		$terms_array = [];
		foreach ( $terms as $term ) {
			$terms_array = $terms_array + $term;
		}
		return $terms_array;
	}

	private function get_term( $term_id ) {
		$terms = $this->get_terms();
		return $terms[ $term_id ] ?? null;
	}

	public function migrate_redirects() {
		$count   = 0;
		$results = get_option( 'wpseo-premium-redirects-base' ) ?: [];

		if ( empty( $results ) ) {
			return $count;
		}

		$db_redirects   = new DbRedirects();
		$redirect_types = RedirectionHelper::redirect_types();

		foreach ( $results as $result ) {
			// Ignore if From URL exists
			if ( $db_redirects->exists( $result['origin'] ) ) {
				continue;
			}

			$type     = $result['type'];
			$redirect = [
				'type'             => isset( $redirect_types[ $type ] ) ? $type : 301,
				'condition'        => 'regex' === $result['format'] ? 'regex' : 'exact-match',
				'from'             => $result['origin'],
				'to'               => $result['url'],
				'note'             => '',
				'enable'           => 1,
				'ignoreParameters' => 0,
			];

			$db_redirects->update( $redirect );

			++$count;
		}

		return $count;
	}
}
