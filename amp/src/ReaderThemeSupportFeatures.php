<?php
/**
 * Class ReaderThemeSupportFeatures.
 *
 * @package AmpProject\AmpWP
 */

namespace AmpProject\AmpWP;

use AmpProject\AmpWP\Infrastructure\Registerable;
use AmpProject\AmpWP\Infrastructure\Service;
use AMP_Options_Manager;
use Theme_Upgrader;

/**
 * Stores the primary theme's theme support features when Reader template mode is active and then adds the necessary styles to support them.
 *
 * Note that this service is not conditional based on whether Reader mode is selected because it needs to run logic
 * when transitioning from non-reader to Reader mode.
 *
 * @package AmpProject\AmpWP
 * @since 2.1
 * @internal
 */
final class ReaderThemeSupportFeatures implements Service, Registerable {

	/**
	 * Theme feature slug for editor-color-palette.
	 *
	 * @var string
	 */
	const FEATURE_EDITOR_COLOR_PALETTE = 'editor-color-palette';

	/**
	 * Theme feature slug for editor-gradient-presets.
	 *
	 * @var string
	 */
	const FEATURE_EDITOR_GRADIENT_PRESETS = 'editor-gradient-presets';

	/**
	 * Theme feature slug for editor-font-sizes.
	 *
	 * @var string
	 */
	const FEATURE_EDITOR_FONT_SIZES = 'editor-font-sizes';

	/**
	 * Key slug.
	 *
	 * @var string
	 */
	const KEY_SLUG = 'slug';

	/**
	 * Key size.
	 *
	 * @var string
	 */
	const KEY_SIZE = 'size';

	/**
	 * Key color.
	 *
	 * @var string
	 */
	const KEY_COLOR = 'color';

	/**
	 * Key gradient.
	 *
	 * @var string
	 */
	const KEY_GRADIENT = 'gradient';

	/**
	 * Key gradients.
	 *
	 * @var string
	 */
	const KEY_GRADIENTS = 'gradients';

	/**
	 * Key palette.
	 *
	 * @var string
	 */
	const KEY_PALETTE = 'palette';

	/**
	 * Key fontSizes.
	 *
	 * @var string
	 */
	const KEY_FONT_SIZES = 'fontSizes';

	/**
	 * Key typography.
	 *
	 * @var string
	 */
	const KEY_TYPOGRAPHY = 'typography';

	/**
	 * Key for `theme` presets in block editor.
	 * Key for `theme` context in `wp_get_global_settings()`.
	 *
	 * @var string
	 */
	const KEY_THEME = 'theme';

	/**
	 * Key for `default` presets in block editor.
	 *
	 * @var string
	 */
	const KEY_DEFAULT = 'default';

	/**
	 * Key for `spacing` presets in theme.json.
	 *
	 * @var string
	 */
	const KEY_SPACING = 'spacing';

	/**
	 * Key for `steps` presets in theme.json.
	 *
	 * @var string
	 */
	const KEY_STEPS = 'steps';

	/**
	 * Key for `spacingSizes` presets in theme.json.
	 *
	 * @var string
	 */
	const KEY_SPACING_SIZES = 'spacingSizes';

	/**
	 * Key for `spacingScale` presets in theme.json.
	 *
	 * @var string
	 */
	const KEY_SPACING_SCALE = 'spacingScale';

	/**
	 * Key for `customSpacingSize` presets in theme.json.
	 *
	 * @var string
	 */
	const KEY_CUSTOM_SPACING_SIZE = 'customSpacingSize';

	/**
	 * Key for `defaultSpacingSizes` boolean in theme.json (v3).
	 *
	 * @var string
	 */
	const KEY_DEFAULT_SPACING_SIZES = 'defaultSpacingSizes';

	/**
	 * Action fired when the cached primary_theme_support should be updated.
	 *
	 * @var string
	 */
	const ACTION_UPDATE_CACHED_PRIMARY_THEME_SUPPORT = 'amp_update_cached_primary_theme_support';

	/**
	 * Supported features.
	 *
	 * @var array[]
	 */
	const SUPPORTED_FEATURES = [
		self::FEATURE_EDITOR_COLOR_PALETTE    => [ self::KEY_SLUG, self::KEY_COLOR ],
		self::FEATURE_EDITOR_GRADIENT_PRESETS => [ self::KEY_SLUG, self::KEY_GRADIENT ],
		self::FEATURE_EDITOR_FONT_SIZES       => [ self::KEY_SLUG, self::KEY_SIZE ],
	];

	/**
	 * The theme.json paths mapping to be fetched using `wp_get_global_settings()`.
	 *
	 * @var array[]
	 */
	const SUPPORTED_THEME_JSON_FEATURES = [
		self::FEATURE_EDITOR_COLOR_PALETTE    => [ self::KEY_COLOR, self::KEY_PALETTE ],
		self::FEATURE_EDITOR_GRADIENT_PRESETS => [ self::KEY_COLOR, self::KEY_GRADIENTS ],
		self::FEATURE_EDITOR_FONT_SIZES       => [ self::KEY_TYPOGRAPHY, self::KEY_FONT_SIZES ],
	];

	/**
	 * Reader theme loader.
	 *
	 * @var ReaderThemeLoader
	 */
	private $reader_theme_loader;

	/**
	 * ReaderThemeLoader constructor.
	 *
	 * @param ReaderThemeLoader $reader_theme_loader Reader theme loader.
	 */
	public function __construct( ReaderThemeLoader $reader_theme_loader ) {
		$this->reader_theme_loader = $reader_theme_loader;
	}

	/**
	 * Register the service with the system.
	 *
	 * @return void
	 */
	public function register() {
		add_filter( 'amp_options_updating', [ $this, 'filter_amp_options_updating' ] );
		add_action( 'after_switch_theme', [ $this, 'handle_theme_update' ] );
		add_action( self::ACTION_UPDATE_CACHED_PRIMARY_THEME_SUPPORT, [ $this, 'update_cached_theme_support' ] );
		add_action(
			'upgrader_process_complete',
			function ( $upgrader ) {
				if ( $upgrader instanceof Theme_Upgrader ) {
					$this->update_cached_theme_support();
				}
			}
		);

		add_action( 'amp_post_template_head', [ $this, 'print_theme_support_styles' ] );
		add_action(
			'wp_head',
			[ $this, 'print_theme_support_styles' ],
			9 // Because wp_print_styles happens at priority 8, and we want the primary theme's colors to override any conflicting theme color assignments.
		);
	}

	/**
	 * Check whether all the required props are present for a given feature item.
	 *
	 * @param string $feature Feature name.
	 * @param array  $props   Props to check.
	 *
	 * @return bool Whether all are present.
	 */
	public function has_required_feature_props( $feature, $props ) {
		if ( empty( $props ) || ! is_array( $props ) ) {
			return false;
		}
		foreach ( self::SUPPORTED_FEATURES[ $feature ] as $required_prop ) {
			if ( ! array_key_exists( $required_prop, $props ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Filter the AMP options when they are updated to add the primary theme's features.
	 *
	 * @param array $options Options.
	 * @return array Options.
	 */
	public function filter_amp_options_updating( $options ) {
		if ( $this->reader_theme_loader->is_enabled( $options ) ) {
			$options[ Option::PRIMARY_THEME_SUPPORT ] = $this->get_theme_support_features( true );
		} else {
			$options[ Option::PRIMARY_THEME_SUPPORT ] = null;
		}
		return $options;
	}

	/**
	 * Handle updating the cached primary_theme_support after updating/switching theme.
	 *
	 * In the case of switching the theme via WP-CLI, it could be that the next request is for an AMP page and
	 * the `check_theme_switched()` function will run in the context of a Reader theme being loaded. In that case,
	 * the added theme support won't be for the primary theme and we need to schedule an immediate event in WP-Cron to
	 * try again in the context of a cron request in which a Reader theme will never be overriding the primary theme.
	 */
	public function handle_theme_update() {
		if ( $this->reader_theme_loader->is_theme_overridden() ) {
			wp_schedule_single_event( time(), self::ACTION_UPDATE_CACHED_PRIMARY_THEME_SUPPORT );
		} else {
			$this->update_cached_theme_support();
		}
	}

	/**
	 * Update primary theme's cached theme support.
	 */
	public function update_cached_theme_support() {
		if ( $this->reader_theme_loader->is_enabled() ) {
			AMP_Options_Manager::update_option( Option::PRIMARY_THEME_SUPPORT, $this->get_theme_support_features( true ) );
		} else {
			AMP_Options_Manager::update_option( Option::PRIMARY_THEME_SUPPORT, null );
		}
	}

	/**
	 * Get the theme support features.
	 *
	 * @param bool $reduced Whether to reduce the feature props down to just what is required.
	 * @return array Theme support features.
	 */
	public function get_theme_support_features( $reduced = false ) {
		$features = [];

		foreach ( array_keys( self::SUPPORTED_FEATURES ) as $feature_key ) {
			if ( wp_theme_has_theme_json() ) {
				$feature_value   = [];
				$global_settings = wp_get_global_settings( self::SUPPORTED_THEME_JSON_FEATURES[ $feature_key ], self::KEY_THEME );

				if ( isset( $global_settings[ self::KEY_THEME ] ) ) {
					$feature_value = array_merge( $feature_value, $global_settings[ self::KEY_THEME ] );
				}

				if ( isset( $global_settings[ self::KEY_DEFAULT ] ) ) {
					$feature_value = array_merge( $feature_value, $global_settings[ self::KEY_DEFAULT ] );
				}
			} else {
				$feature_value = current( (array) get_theme_support( $feature_key ) );
			}

			if ( ! is_array( $feature_value ) || empty( $feature_value ) ) {
				continue;
			}

			// Avoid reducing font sizes if theme.json is used for the sake of fluid typography.
			if ( wp_theme_has_theme_json() && self::FEATURE_EDITOR_FONT_SIZES === $feature_key ) {
				$reduced = false;
			}

			if ( $reduced ) {
				$features[ $feature_key ] = [];

				foreach ( $feature_value as $item ) {
					if ( $this->has_required_feature_props( $feature_key, $item ) ) {
						$features[ $feature_key ][] = wp_array_slice_assoc( $item, self::SUPPORTED_FEATURES[ $feature_key ] );
					}
				}
			} else {
				$features[ $feature_key ] = $feature_value;
			}
		}

		return $features;
	}

	/**
	 * Determines whether the request is for an AMP page in Reader mode.
	 *
	 * @return bool Whether AMP Reader request.
	 */
	public function is_reader_request() {
		return (
			( amp_is_legacy() || $this->reader_theme_loader->is_theme_overridden() )
			&&
			amp_is_request()
		);
	}

	/**
	 * Print theme support styles.
	 */
	public function print_theme_support_styles() {
		if ( ! $this->is_reader_request() ) {
			return;
		}

		$features = [];
		if ( $this->reader_theme_loader->is_enabled() ) {
			$features = AMP_Options_Manager::get_option( Option::PRIMARY_THEME_SUPPORT );
		} elseif ( amp_is_legacy() ) {
			$features = $this->get_theme_support_features();
		}

		if ( empty( $features ) ) {
			return;
		}

		foreach ( array_keys( self::SUPPORTED_FEATURES ) as $feature ) {
			if ( empty( $features[ $feature ] ) || ! is_array( $features[ $feature ] ) ) {
				continue;
			}
			$value = $features[ $feature ];
			switch ( $feature ) {
				case self::FEATURE_EDITOR_COLOR_PALETTE:
					$this->print_editor_color_palette_styles( $value );
					break;
				case self::FEATURE_EDITOR_FONT_SIZES:
					$this->print_editor_font_sizes_styles( $value );
					break;
				case self::FEATURE_EDITOR_GRADIENT_PRESETS:
					$this->print_editor_gradient_presets_styles( $value );
					break;
			}
		}

		// Print the custom properties for the spacing sizes.
		if ( wp_theme_has_theme_json() ) {
			$this->print_spacing_sizes_custom_properties();
		}
	}

	/**
	 * Print editor-color-palette styles.
	 *
	 * @param array $color_palette Color palette.
	 */
	private function print_editor_color_palette_styles( array $color_palette ) {
		echo '<style id="amp-wp-theme-support-editor-color-palette">';
		foreach ( $color_palette as $color_option ) {
			if ( ! $this->has_required_feature_props( self::FEATURE_EDITOR_COLOR_PALETTE, $color_option ) ) {
				continue;
			}

			// If not a valid hex color, skip it.
			if ( ! preg_match( '/^[0-9a-f]{3}[0-9a-f]{3}?$/i', ltrim( $color_option[ self::KEY_COLOR ], '#' ) ) ) {
				continue;
			}

			// There is no standard way to retrieve or derive the `color` style property when the editor color is being used
			// for the background, so the best alternative at the moment is to guess a good default value based on the
			// luminance of the editor color.
			$text_color = 127 > $this->get_relative_luminance_from_hex( $color_option[ self::KEY_COLOR ] ) ? '#fff' : '#000';

			printf(
				':root .has-%1$s-background-color { background-color: %2$s; color: %3$s; }',
				sanitize_key( $color_option[ self::KEY_SLUG ] ),
				$color_option[ self::KEY_COLOR ], // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$text_color // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		foreach ( $color_palette as $color_option ) {
			if ( ! isset( $color_option[ self::KEY_SLUG ], $color_option[ self::KEY_COLOR ] ) ) {
				continue;
			}

			printf(
				':root .has-%1$s-color { color: %2$s; }',
				sanitize_key( $color_option[ self::KEY_SLUG ] ),
				$color_option[ self::KEY_COLOR ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</style>';
	}

	/**
	 * Print editor-font-sizes styles.
	 *
	 * @param array $font_sizes Font sizes.
	 */
	private function print_editor_font_sizes_styles( array $font_sizes ) {
		echo '<style id="amp-wp-theme-support-editor-font-sizes">';
		foreach ( $font_sizes as $font_size ) {
			if ( ! $this->has_required_feature_props( self::FEATURE_EDITOR_FONT_SIZES, $font_size ) ) {
				continue;
			}

			// Just in case the font size is not in the expected format.
			$font_size[ self::KEY_SIZE ] = wp_get_typography_value_and_unit( $font_size[ self::KEY_SIZE ] );

			if ( ! is_array( $font_size[ self::KEY_SIZE ] ) || empty( $font_size[ self::KEY_SIZE ] ) ) {
				continue;
			}

			// Normalize the font size value to a string.
			$font_size[ self::KEY_SIZE ] = $font_size[ self::KEY_SIZE ]['value'] . $font_size[ self::KEY_SIZE ]['unit'];

			if ( ! is_string( $font_size[ self::KEY_SIZE ] ) ) {
				continue;
			}

			printf(
				':root .is-%1$s-text, :root .has-%1$s-font-size { font-size: %2$s; }',
				sanitize_key( $font_size[ self::KEY_SLUG ] ),
				esc_html( wp_strip_all_tags( wp_get_typography_font_size_value( $font_size ) ) )
			);
		}
		echo '</style>';
	}

	/**
	 * Print editor-gradient-presets styles.
	 *
	 * @param array $gradient_presets Gradient presets.
	 */
	private function print_editor_gradient_presets_styles( array $gradient_presets ) {
		echo '<style id="amp-wp-theme-support-editor-gradient-presets">';
		foreach ( $gradient_presets as $gradient_preset ) {
			if ( ! $this->has_required_feature_props( self::FEATURE_EDITOR_GRADIENT_PRESETS, $gradient_preset ) ) {
				continue;
			}
			printf(
				'.has-%s-gradient-background { background: %s; }',
				sanitize_key( $gradient_preset[ self::KEY_SLUG ] ),
				$gradient_preset[ self::KEY_GRADIENT ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}
		echo '</style>';
	}

	/**
	 * Print spacing sizes custom properties.
	 */
	private function print_spacing_sizes_custom_properties() {
		$custom_properties   = [];
		$spacing             = wp_get_global_settings( [ self::KEY_SPACING ], self::KEY_THEME );
		$spacing_sizes       = $spacing[ self::KEY_SPACING_SIZES ] ?? [];
		$custom_spacing_size = $spacing[ self::KEY_CUSTOM_SPACING_SIZE ] ?? false;
		$spacing_scale       = $spacing[ self::KEY_SPACING_SCALE ] ?? [];

		/**
		 * By default check for `defaultSpacingSizes` boolean introduced in theme.json (v3)
		 * and if it's false, then check for `steps` in `spacingScale` which is v2 default.
		 *
		 * @see <https://github.com/WordPress/gutenberg/pull/58409#issuecomment-2078077477>.
		 */
		$is_wp_generating_spacing_sizes = $spacing[ self::KEY_DEFAULT_SPACING_SIZES ] ?? false;

		if ( array_key_exists( self::KEY_STEPS, $spacing_scale ) ) {
			$is_wp_generating_spacing_sizes = 0 !== $spacing_scale[ self::KEY_STEPS ];
		}

		if ( ! $is_wp_generating_spacing_sizes && $custom_spacing_size ) {
			if ( isset( $spacing_sizes[ self::KEY_THEME ] ) ) {
				$custom_properties = array_merge( $custom_properties, $spacing_sizes[ self::KEY_THEME ] );
			}
		} else {
			if ( isset( $spacing_sizes[ self::KEY_DEFAULT ] ) ) {
				$custom_properties = array_merge( $custom_properties, $spacing_sizes[ self::KEY_DEFAULT ] );
			}
		}

		if ( empty( $custom_properties ) ) {
			return;
		}

		echo '<style id="amp-wp-theme-support-spacing-sizes-custom-properties">';
		echo ':root {';
		foreach ( $custom_properties as $custom_property ) {
			if ( ! isset( $custom_property[ self::KEY_SIZE ], $custom_property[ self::KEY_SLUG ] ) ) {
				continue;
			}

			printf(
				'--wp--preset--spacing--%1$s: %2$s;',
				sanitize_key( $custom_property[ self::KEY_SLUG ] ),
				// phpcs:disable WordPressVIPMinimum.Functions.StripTags.StripTagsOneParameter
				strip_tags( $custom_property[ self::KEY_SIZE ] ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				// phpcs:enable WordPressVIPMinimum.Functions.StripTags.StripTagsOneParameter
			);
		}
		echo '}';
		echo '</style>';
	}

	/**
	 * Get relative luminance from color hex value.
	 *
	 * Copied from `\Twenty_Twenty_One_Custom_Colors::get_relative_luminance_from_hex()`.
	 *
	 * @see https://github.com/WordPress/wordpress-develop/blob/acbbbd18b32b5429264622141a6d058b64f3a5ad/src/wp-content/themes/twentytwentyone/classes/class-twenty-twenty-one-custom-colors.php#L138-L156
	 *
	 * @param string $hex Color hex value.
	 * @return int Relative luminance value.
	 */
	public function get_relative_luminance_from_hex( $hex ) {

		// Remove the "#" symbol from the beginning of the color.
		$hex = ltrim( $hex, '#' );

		// Make sure there are 6 digits for the below calculations.
		if ( 3 === strlen( $hex ) ) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}

		// Get red, green, blue.
		$red   = hexdec( substr( $hex, 0, 2 ) );
		$green = hexdec( substr( $hex, 2, 2 ) );
		$blue  = hexdec( substr( $hex, 4, 2 ) );

		// Calculate the luminance.
		$lum = ( 0.2126 * $red ) + ( 0.7152 * $green ) + ( 0.0722 * $blue );
		return (int) round( $lum );
	}
}
