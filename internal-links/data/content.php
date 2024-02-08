<?php

namespace ILJ\Data;

use ILJ\Backend\Editor;
use ILJ\Database\Postmeta;
use ILJ\Enumeration\Content_Type;
use ILJ\Type\KeywordList;

/**
 * Class to encapsulate post or term.
 *
 * @package ILJ\Data
 * @since   2.23.5
 */
final class Content {

	/**
	 * The numerical identifier.
	 *
	 * @var int $id;
	 */
	private $id;

	/**
	 * The type of content, which can be  {@link Content_Type::POST} or {@link Content_Type::TERM}
	 *
	 * @var string $type
	 */
	private $type;

	private function __construct($id, $type) {
		$this->id = $id;
		$this->type = $type;
	}

	/**
	 * Get the numerical identifier of the object.
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set keywords for content
	 *
	 * @param KeywordList $keyword_list The keyword list.
	 *
	 * @return Content
	 */
	public function set_keywords($keyword_list) {
		update_metadata(
			$this->get_type(),
			$this->get_id(),
			Postmeta::ILJ_META_KEY_LINKDEFINITION,
			$keyword_list->getKeywords(),
			get_metadata($this->get_type(), $this->get_id(), Postmeta::ILJ_META_KEY_LINKDEFINITION, true)
		);
		return $this;
	}

	/**
	 * Set whether the limit for incoming links to a content needs to be enabled.
	 *
	 * @param bool $is_limit_enabled State to denote if the limit is enabled
	 *
	 * @return Content
	 */
	public function set_limit_incoming_links($is_limit_enabled) {
		update_metadata(
			$this->get_type(),
			$this->get_id(),
			Editor::ILJ_META_KEY_LIMITINCOMINGLINKS,
			$is_limit_enabled,
			get_metadata($this->get_type(), $this->get_id(), Editor::ILJ_META_KEY_LIMITINCOMINGLINKS, true)
		);
		return $this;
	}

	/**
	 * Set the number of incoming links to a content, this will be applied only when link is enabled.
	 *
	 * @param int $max_incoming_links The incoming links limit.
	 *
	 * @return Content
	 */
	public function set_max_incoming_links($max_incoming_links) {
		update_metadata(
			$this->get_type(),
			$this->get_id(),
			Editor::ILJ_META_KEY_MAXINCOMINGLINKS,
			$max_incoming_links,
			get_metadata($this->get_type(), $this->get_id(), Editor::ILJ_META_KEY_MAXINCOMINGLINKS, true)
		);
		return $this;
	}


	/**
	 * Get the type of the identifier.
	 *
	 * @return string The type of content, which can be  {@link Content_Type::POST} or {@link Content_Type::TERM}
	 */
	public function get_type() {
		return $this->type;
	}


	/**
	 * Creates instance of content from post id.
	 *
	 * @param int $post_id The post id.
	 * @return Content
	 */
	public static function from_post_id($post_id) {
		return new self($post_id, Content_Type::POST);
	}

	/**
	 * Creates instance of content from term id.
	 *
	 * @param int $term_id The post id.
	 * @return Content
	 */
	public static function from_term_id($term_id) {
		return new self($term_id, Content_Type::TERM);
	}


	/**
	 * Creates instance of content from {@link \WP_Post}
	 *
	 * @param \WP_Post $post The post instance.
	 * @return Content
	 */
	public static function from_post($post) {
		return new self($post->ID, Content_Type::POST);
	}

	/**
	 * Creates instance of content from {@link \WP_Term}
	 *
	 * @param \WP_Term $term The term instance.
	 * @return Content
	 */
	public static function from_term($term) {
		return new self($term->term_id, Content_Type::TERM);
	}
}
