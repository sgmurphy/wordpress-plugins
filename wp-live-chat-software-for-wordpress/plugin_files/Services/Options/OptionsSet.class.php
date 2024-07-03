<?php
/**
 * Class OptionsSet
 *
 * @package LiveChat\Services\Options
 */

namespace LiveChat\Services\Options;

/**
 * Class OptionsSet
 *
 * @package LiveChat\Services\Options
 */
class OptionsSet {
	/**
	 * OptionsSet constructor.
	 *
	 * @param Array<Option|OptionsSet> $options Array of Options.
	 * @throws \Exception If property does not exist.
	 */
	public function __construct( $options ) {
		foreach ( $options as $key => $option ) {
			if ( !property_exists( $this, $key ) ) {
				throw new \Exception( 'Property ' . $key . ' does not exist in ' . get_class( $this ) );
			}

			$this->{$key} = $option;
		}
	}

	/**
	 * Clears all functions in set.
	 *
	 * @return bool
	 */
	public function remove() {
		$options = array_filter(
			get_object_vars( $this ),
			function ( $var ) {
				return $var instanceof ReadableOption || $var instanceof OptionsSet;
			}
		);

		return array_reduce(
			$options,
			function ( $acc, $option ) {
				return $option->remove() && $acc;
			},
			true
		);
	}

	/**
	 * Returns instance of OptionsSet (singleton pattern).
	 *
	 * @return static
	 */
	public static function get_instance() {
		return new static();
	}
}
