<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Load general assets for our blocks.
 *
 * @since 1.0.0
 */
class StructuredContent_Shortcodes {


	/**
	 * This plugin's instance.
	 *
	 * @var StructuredContent_Shortcodes
	 */
	private static $instance;
	/**
	 * The base URL path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_url;
	/**
	 * The plugin version.
	 *
	 * @var string $_version
	 */
	private $_version;
	/**
	 * The plugin version.
	 *
	 * @var string $_slug
	 */
	private $_slug;

	/**
	 * The Constructor.
	 */
	private function __construct() {

		$this->_version = STRUCTURED_CONTENT_VERSION;
		$this->_slug    = 'structured-content';
		$this->_url     = untrailingslashit( plugins_url( '/', dirname( __FILE__ ) ) );

		add_shortcode( 'sc_fs_faq', array( $this, 'faq' ) );
		add_shortcode( 'sc_fs_multi_faq', array( $this, 'multi_faq' ) );
		add_shortcode( 'sc_fs_job', array( $this, 'job' ) );
		add_shortcode( 'sc_fs_event', array( $this, 'event' ) );
		add_shortcode( 'sc_fs_person', array( $this, 'person' ) );
		add_shortcode( 'sc_fs_course', array( $this, 'course' ) );
		add_shortcode( 'sc_fs_local_business', array( $this, 'local_business' ) );
		add_shortcode( 'sc_fs_recipe', array( $this, 'recipe' ) );

		if ( apply_filters( 'structured_content_fix_shortcodes', true ) ) {
			add_filter( 'the_content', array( $this, 'fix_shortcodes' ) );
			add_filter( 'category_description', array( $this, 'fix_shortcodes' ) );
		}
	}

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new StructuredContent_Shortcodes();
		}
	}

	public static function multi_faq( $atts, $content = null ) {

		$merged_atts = shortcode_atts(
			array(
				'css_class' => '',
				'count'     => '1',
				'html'      => true,
				'elements'  => array(),
			),
			$atts
		);

		foreach ( $atts as $key => $merged_att ) {
			$condition = strpos( $key, 'headline' ) !== false
			             || strpos( $key, 'question' ) !== false
			             || strpos( $key, 'answer' ) !== false
			             || strpos( $key, 'image' ) !== false;
			if ( $condition ) {
				$merged_atts['elements'][ explode( '-', $key )[1] ][ substr( $key, 0, strpos( $key, '-' ) ) ] = $merged_att;
			}
		}

		foreach ( $merged_atts['elements'] as $key => $element ) {
			if ( ! empty( $element['image'] ) ) {
				$image_id       = intval( $element['image'] );
				$image_url      = wp_get_attachment_url( $image_id );
				$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
				$image_meta     = wp_get_attachment_metadata( $image_id );
				if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
					$merged_atts['elements'][ $key ]['img_url']       = $image_url;
					$merged_atts['elements'][ $key ]['thumbnail_url'] = $image_thumburl;
					$merged_atts['elements'][ $key ]['img_size']      = array(
						$image_meta['width'],
						$image_meta['height'],
					);
					if ( empty( $merged_atts['elements'][ $key ]['img_alt'] ) ) {
						$merged_atts['elements'][ $key ]['img_alt'] = get_post_meta(
							$image_id,
							'_wp_attachment_image_alt',
							true
						);
					}
				} else {
					$merged_atts['elements'][ $key ]['image'] = 0;
				}
			}
		}

		$atts = $merged_atts;

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/multi-faq.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function faq_item( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'className'         => '',
				'custom_title_id'   => '',
				'imageAlt'          => '',
				'imageID'           => '',
				'open'              => false,
				'question'          => '',
				'thumbnailImageUrl' => '',
				'visible'           => true,
			),
			$atts
		);

		$json = json_encode(
			array(
				'atts'    => $atts,
				'content' => $content,
			)
		);

		return $json;
	}

	public static function faq( $atts, $content = null ) {

		if ( ! array_key_exists( 'version', $atts ) ) {
			$merged_atts = shortcode_atts(
				array(
					'css_class'    => '',
					'question_tag' => 'h2',
					'elements'     => '',
				),
				$atts
			);

			if ( $merged_atts['elements'] === '' ) {
				$merged_atts = shortcode_atts(
					array(
						'css_class' => '',
						'headline'  => 'h2',
						'img'       => 0,
						'img_alt'   => '',
						'question'  => '',
						'answer'    => '',
						'html'      => 'true',
						'elements'  => '',
					),
					$atts
				);

				if ( ! empty( $merged_atts['img'] ) ) {
					$image_id       = intval( $merged_atts['img'] );
					$image_url      = wp_get_attachment_url( $image_id );
					$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
					$image_meta     = wp_get_attachment_metadata( $image_id );
					if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
						$merged_atts['img_url']       = $image_url;
						$merged_atts['thumbnail_url'] = $image_thumburl;
						$merged_atts['img_size']      = array( $image_meta['width'], $image_meta['height'] );
						if ( empty( $merged_atts['img_alt'] ) ) {
							$merged_atts['img_alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						}
					} else {
						$merged_atts['img'] = 0;
					}
				}
				$merged_atts['headline_open_tag']  = '<' . $merged_atts['headline'] . '>';
				$merged_atts['headline_close_tag'] = '</' . $merged_atts['headline'] . '>';

				$atts = $merged_atts;

				if ( isset( $atts['description'] ) && $atts['description'] !== '' ) {
					$content = $atts['description'];
				}

				ob_start();
				include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/faq-deprecated.php';
				$output = ob_get_contents();
				ob_end_clean();

				return $output;
			} else {
				foreach ( $merged_atts['elements'] as $key => $element ) {
					if ( ! empty( $element['imageID'] ) ) {
						$image_id       = intval( $element['imageID'] );
						$image_url      = wp_get_attachment_url( $image_id );
						$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
						$image_meta     = wp_get_attachment_metadata( $image_id );
						if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
							$merged_atts['elements'][ $key ]['img_url']       = $image_url;
							$merged_atts['elements'][ $key ]['thumbnail_url'] = $image_thumburl;
							$merged_atts['elements'][ $key ]['img_size']      = array(
								$image_meta['width'],
								$image_meta['height'],
							);
							if ( empty( $merged_atts['elements'][ $key ]['img_alt'] ) ) {
								$merged_atts['elements'][ $key ]['img_alt'] = get_post_meta(
									$image_id,
									'_wp_attachment_image_alt',
									true
								);
							}
						} else {
							$merged_atts['elements'][ $key ]['img'] = 0;
						}
					}
				}

				$atts = $merged_atts;

				ob_start();
				include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/faq.php';
				$output = ob_get_contents();
				ob_end_clean();

				return $output;
			}
		} else {
			$temp_content = preg_split( "/(\r\n|\r|\n)/", $content, - 1, PREG_SPLIT_NO_EMPTY );
			$elements     = array();

			foreach ( $temp_content as $key => $value ) {
				$elements[] = json_decode( $value );
			}

			$atts = shortcode_atts(
				array(
					'className'         => '',
					'css_class'         => '',
					'title_tag'         => 'h2',
					'generate_title_id' => false,
					'summary'           => false,
					'animate_summary'   => false,
					'elements'          => $elements,
				),
				$atts
			);

			ob_start();
			include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/blocks/faq.php';
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}

	public static function job( $atts, $content = null ) {

		$merged_atts = shortcode_atts(
			array(
				'className'          => '',
				'css_class'          => '',
				'title_tag'          => 'h2',
				'generate_title_id'  => false,
				'custom_title_id'    => '',
				'html'               => true,
				'title'              => '',
				'description'        => '',
				'valid_through'      => '',
				'employment_type'    => '',
				'company_name'       => '',
				'same_as'            => '',
				'logo_id'            => '',
				'street_address'     => '',
				'address_locality'   => '',
				'address_region'     => '',
				'postal_code'        => '',
				'address_country'    => '',
				'currency_code'      => '',
				'quantitative_value' => '',
				'base_salary'        => '',
				'job_location_type'  => false,
			),
			$atts
		);

		if ( ! empty( $merged_atts['logo_id'] ) ) {
			$image_id       = intval( $merged_atts['logo_id'] );
			$image_url      = wp_get_attachment_url( $image_id );
			$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
			$image_meta     = wp_get_attachment_metadata( $image_id );
			if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
				$merged_atts['logo_url']      = $image_url;
				$merged_atts['thumbnail_url'] = $image_thumburl;
				$merged_atts['logo_size']     = array( $image_meta['width'], $image_meta['height'] );
				if ( empty( $merged_atts['logo_alt'] ) ) {
					$merged_atts['logo_alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				}
			} else {
				$merged_atts['logo'] = 0;
			}
		}

		$atts = $merged_atts;

		if ( isset( $atts['description'] ) && $atts['description'] !== '' ) {
			$content = $atts['description'];
		}

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/job.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function event( $atts, $content = null ) {

		$merged_atts = shortcode_atts(
			array(
				'className'         => '',
				'css_class'         => '',
				'title_tag'         => 'h2',
				'generate_title_id' => false,
				'elements'          => '',
			),
			$atts
		);

		if ( $merged_atts['elements'] === '' ) {
			$single_atts            = shortcode_atts(
				array(
					'className'             => '',
					'css_class'             => '',
					'html'                  => 'true',
					'title'                 => '',
					'custom_title_id'       => '',
					'description'           => $content,
					'event_location'        => '',
					'status'                => 'EventScheduled',
					'online_url'            => '',
					'prev_start_date'       => '',
					'event_attendance_mode' => '',
					'start_date'            => '',
					'end_date'              => '',
					'street_address'        => '',
					'address_locality'      => '',
					'address_region'        => '',
					'postal_code'           => '',
					'address_country'       => '',
					'currency_code'         => '',
					'price'                 => '',
					'image_id'              => '',
					'performer'             => '',
					'performer_name'        => '',
					'offer_availability'    => '',
					'offer_url'             => '',
					'offer_valid_from'      => '',
				),
				$atts
			);
			$single_atts['visible'] = $single_atts['html'] === 'true' ? true : false;
			unset( $single_atts['html'] );
			$merged_atts['elements'] = array( $single_atts );
		}

		if ( ! empty( $merged_atts['image_id'] ) ) {
			$image_id       = intval( $merged_atts['image_id'] );
			$image_url      = wp_get_attachment_url( $image_id );
			$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
			$image_meta     = wp_get_attachment_metadata( $image_id );
			if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
				$merged_atts['img_url']       = $image_url;
				$merged_atts['thumbnail_url'] = $image_thumburl;
				$merged_atts['img_size']      = array( $image_meta['width'], $image_meta['height'] );
				if ( empty( $merged_atts['img_alt'] ) ) {
					$merged_atts['img_alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				}
			} else {
				$merged_atts['img'] = 0;
			}
		}

		foreach ( $merged_atts['elements'] as $key => $element ) {
			$merged_atts['elements'][ $key ]['status']                = isset( $element['status'] ) && $element['status'] !== '' ? $element['status'] : __( 'EventScheduled' );
			$merged_atts['elements'][ $key ]['event_attendance_mode'] = isset( $element['event_attendance_mode'] ) && $element['event_attendance_mode'] != '' ? $element['event_attendance_mode'] : __( 'MixedEventAttendanceMode' );

			if ( ! empty( $element['image_id'] ) ) {
				$image_id       = intval( $element['image_id'] );
				$image_url      = wp_get_attachment_url( $image_id );
				$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
				$image_meta     = wp_get_attachment_metadata( $image_id );
				if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
					$merged_atts['elements'][ $key ]['img_url']       = $image_url;
					$merged_atts['elements'][ $key ]['thumbnail_url'] = $image_thumburl;
					$merged_atts['elements'][ $key ]['img_size']      = array(
						$image_meta['width'],
						$image_meta['height'],
					);
					if ( empty( $merged_atts['elements'][ $key ]['img_alt'] ) ) {
						$merged_atts['elements'][ $key ]['img_alt'] = get_post_meta(
							$image_id,
							'_wp_attachment_image_alt',
							true
						);
					}
				} else {
					$merged_atts['elements'][ $key ]['img'] = 0;
				}
			}
		}

		$atts = $merged_atts;

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/event.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function person( $atts, $content = null ) {

		$merged_atts = shortcode_atts(
			array(
				'className'         => '',
				'css_class'         => '',
				'html'              => true,
				'person_name'       => '',
				'generate_title_id' => false,
				'custom_title_id'   => '',
				'alternate_name'    => '',
				'job_title'         => '',
				'image_id'          => '',
				'birthdate'         => '',
				'email'             => '',
				'telephone'         => '',
				'url'               => '',
				'colleague'         => '',
				'street_address'    => '',
				'address_locality'  => '',
				'address_region'    => '',
				'postal_code'       => '',
				'address_country'   => '',
				'same_as'           => '',
				'works_for_name'    => '',
				'works_for_alt'     => '',
				'works_for_url'     => '',
				'works_for_logo'    => '',
			),
			$atts
		);

		if ( ! empty( $merged_atts['image_id'] ) ) {
			$image_id       = intval( $merged_atts['image_id'] );
			$image_url      = wp_get_attachment_url( $image_id );
			$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
			$image_meta     = wp_get_attachment_metadata( $image_id );

			if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
				$merged_atts['image_url']     = $image_url;
				$merged_atts['thumbnail_url'] = $image_thumburl;
				$merged_atts['image_size']    = array( $image_meta['width'], $image_meta['height'] );
				if ( empty( $merged_atts['image_alt'] ) ) {
					$merged_atts['image_alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				}
			} else {
				$merged_atts['image'] = 0;
			}
		}

		if ( isset( $atts['description'] ) && $atts['description'] !== '' ) {
			$content = $atts['description'];
		}
		if ( isset( $atts['homepage'] ) && $atts['homepage'] !== '' ) {
			$merged_atts['url'] = $atts['homepage'];
		}

		if ( isset( $atts['colleague'] ) ) {
			$merged_atts['links'] = explode( ',', $atts['colleague'] );
		}

		if ( isset( $atts['colleagues'] ) ) {
			foreach ( $atts['colleagues'] as $colleague ) {
				$merged_atts['links'][] = $colleague['url'];
			}
		}

		if ( isset( $atts['same_as'] ) ) {
			if ( is_array( $atts['same_as'] ) ) {
				$same_as = array();
				foreach ( $merged_atts['same_as'] as $same ) {
					$same_as[] = $same['url'];
				}
				$merged_atts['same_as'] = $same_as;
			} else {
				$merged_atts['same_as'] = explode( ',', $atts['same_as'] );
			}
		} else {
			$merged_atts['same_as'] = array();
		}

		$atts = $merged_atts;

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/person.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function course( $atts, $content = null ) {
		$merged_atts = shortcode_atts(
			array(
				'className'         => '',
				'css_class'         => '',
				'title_tag'         => 'h2',
				'generate_title_id' => false,
				'elements'          => '',
			),
			$atts
		);

		if ( $merged_atts['elements'] === '' ) {
			$single_atts = shortcode_atts(
				array(
					'className'        => '',
					'css_class'        => '',
					'html'             => 'true',
					'title'            => '',
					'custom_title_id'  => '',
					'description'      => $content,
					'provider_name'    => '',
					'provider_same_as' => '',
				),
				$atts
			);

			$single_atts['visible'] = $single_atts['html'] === 'true' ? true : false;
			unset( $single_atts['html'] );
			$merged_atts['elements'] = array( $single_atts );
		}

		$atts = $merged_atts;

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/course.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function local_business( $atts, $content = null ) {
		$merged_atts = shortcode_atts(
			array(
				'className'           => '',
				'custom_title_id'     => '',
				'generate_title_id'   => false,
				'html'                => true,
				'title_tag'           => 'h2',
				'address_country'     => '',
				'address_locality'    => '',
				'address_region'      => '',
				'align'               => '',
				'business_name'       => '',
				'contact_email'       => '',
				'contact_telephone'   => '',
				'contact_type'        => '',
				'contact_url'         => '',
				'currencies_accepted' => '',
				'description'         => '',
				'email'               => '',
				'founding_date'       => '',
				'has_map'             => '',
				'image_thumbnail'     => '',
				'image_id'            => '',
				'logo_thumbnail'      => '',
				'logo_id'             => '',
				'latitude'            => '',
				'longitude'           => '',
				'opening_hours'       => array(),
				'postal_code'         => '',
				'price_range'         => '',
				'same_as'             => array(),
				'street_address'      => '',
				'telephone'           => '',
				'textAlign'           => '',
				'website'             => '',
			),
			$atts
		);

		if ( $merged_atts['image_id'] !== '' ) {
			$image_id       = intval( $merged_atts['image_id'] );
			$image_url      = wp_get_attachment_url( $image_id );
			$image_thumburl = wp_get_attachment_image_url( $image_id, array( 150, 150 ) );
			$image_meta     = wp_get_attachment_metadata( $image_id );

			if ( $image_thumburl !== false && $image_meta !== false && $image_url !== false ) {
				$merged_atts['image_url']       = $image_url;
				$merged_atts['image_thumbnail'] = $image_thumburl;
				$merged_atts['image_size']      = array( $image_meta['width'], $image_meta['height'] );
				if ( empty( $merged_atts['image_alt'] ) ) {
					$merged_atts['image_alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				}
			} else {
				$merged_atts['image'] = 0;
			}
		}

		if ( $merged_atts['logo_id'] !== '' ) {
			$logo_id       = intval( $merged_atts['logo_id'] );
			$logo_url      = wp_get_attachment_url( $logo_id );
			$logo_thumburl = wp_get_attachment_image_url( $logo_id, array( 150, 150 ) );
			$logo_meta     = wp_get_attachment_metadata( $logo_id );

			if ( $logo_thumburl !== false && $logo_meta !== false && $logo_url !== false ) {
				$merged_atts['logo_url']       = $logo_url;
				$merged_atts['logo_thumbnail'] = $logo_thumburl;
				$merged_atts['logo_size']      = array( $logo_meta['width'], $logo_meta['height'] );
				if ( empty( $merged_atts['logo_alt'] ) ) {
					$merged_atts['logo_alt'] = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
				}
			} else {
				$merged_atts['logo'] = 0;
			}
		}

		$atts = $merged_atts;

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/shortcodes/local-business.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public static function recipe( $atts ) {

		$atts = shortcode_atts(
			[
				"className"                => "",
				"title"                    => "",
				"titleTag"                 => "h2",
				"generateTitleId"          => false,
				"showPrintButton"          => true,
				"printButtonText"          => _x( 'Print Recipe', 'Print Recipe Button Text', 'structured-content' ),
				"thumbnailImageUrl"        => "",
				"description"              => "",
				"prepTime"                 => "",
				"cookTime"                 => "",
				"totalTime"                => "",
				"keywords"                 => [],
				"nutrition"                => [],
				"recipeYield"              => "",
				"recipeCategory"           => "",
				"recipeCuisine"            => "",
				"recipeIngredient"         => [],
				"recipeInstructions"       => [],
				"hasVideo"                 => false,
				"video"                    => [],
				"version"                  => 1,
				"visible"                  => true,
				"randomBlockId"            => "",
				"ingredientsAsChecklist"   => false,
				"instructionImageSize"     => "medium",
				"instructionImageLightbox" => false,
			],
			$atts
		);

		$nutritions = [
			'calories'           => [
				'label'        => __( 'Calories', 'structured-content' ),
				'unit'         => "grams",
				'abbreviation' => 'kcal',
				'json'         => 'calories'
			],
			'carbohydrates'      => [
				'label'        => __( 'Carbohydrates', 'structured-content' ),
				'unit'         => 'kilocalorie',
				'abbreviation' => 'kcal',
				'json'         => 'carbohydrateContent'
			],
			'protein'            => [
				'label'        => __( 'Protein', 'structured-content' ),
				'unit'         => 'grams',
				'abbreviation' => 'g',
				'json'         => 'proteinContent'
			],
			'fat'                => [
				'label'        => __( 'Fat', 'structured-content' ),
				'unit'         => 'grams',
				'abbreviation' => 'g',
				'json'         => 'fatContent'
			],
			'saturatedFat'       => [
				'label'        => __( 'Saturated Fat', 'structured-content' ),
				'unit'         => 'grams',
				'abbreviation' => 'g',
				'json'         => 'saturatedFatContent'
			],
			'monounsaturatedFat' => [
				'label'        => __( 'Monounsaturated Fat', 'structured-content' ),
				'unit'         => 'grams',
				'abbreviation' => 'g',
				'json'         => 'monounsaturatedFatContent'
			],
			'polyunsaturatedFat' => [
				'label'        => __( 'Polyunsaturated Fat', 'structured-content' ),
				'unit'         => 'grams',
				'abbreviation' => 'g',
				'json'         => 'polyunsaturatedFatContent'
			],
		];

		$nutritions = apply_filters( 'structured_content_recipe_nutritions', $nutritions );

		// add nutritionJson to $atts

		if ( isset( $atts['nutrition'] ) && is_array( $atts['nutrition'] ) ) {
			$atts['nutritionJson'] = [
				'@type' => 'NutritionInformation',
			];

			foreach ( $atts['nutrition'] as $nutri ) {
				$atts['nutritionJson'][ $nutritions[ $nutri['type'] ]['json'] ] = $nutri['value'];
			}

			$atts['nutritionJson'] = apply_filters( 'structured_content_recipe_nutrition_json', $atts['nutritionJson'] );
		}

		// convert prepTime, cookTime and totalTime from PDT0H20M to prepTimeReadable, cookTimeReadable and totalTimeReadable
		foreach ( [ 'prepTime', 'cookTime', 'totalTime' ] as $time ) {
			if ( $atts[ $time ] !== null && $atts[ $time ] !== '' ) {
				$atts[ $time . 'Readable' ] = self::convert_duration_to_readable( $atts[ $time ] );
			}
		}

		/**
		 * Check if $atts['video]['contentUrl'] is a valid URL and if it is, check if it is a YouTube or Vimeo URL
		 */
		if ( isset( $atts['video']['contentUrl'] ) && $atts['video']['contentUrl'] !== '' ) {
			$atts['video']['contentUrl'] = esc_url( $atts['video']['contentUrl'] );
			if ( strpos( $atts['video']['contentUrl'], get_site_url() ) !== false ) {
				$atts['video']['provider'] = 'local';
			} else {
				$atts['video']['provider']     = 'oembed';
				$atts['video']['oembed']       = wp_oembed_get( $atts['video']['contentUrl'] );
				$atts['video']['thumbnailUrl'] = self::get_oembed_thumbnail_url( $atts['video']['contentUrl'] );
			}
		}

		/**
		 * Build a VideoObject from the video shortcode attributes
		 */

		if ( $atts['hasVideo'] === true ) {
			$video = [
				'@type'       => 'VideoObject',
				'name'        => $atts['video']['name'],
				'description' => $atts['video']['description'],
				'contentUrl'  => $atts['video']['contentUrl'],
				'thumbnail'   => $atts['video']['thumbnailUrl'],
			];

			if ( isset( $atts['video']['mediaVideo'] ) ) {
				$video['description'] = $atts['video']['mediaVideo']['description'];
				$video['contentUrl']  = $atts['video']['mediaVideo']['url'];
				$video['thumbnail']   = $atts['video']['mediaVideo']['thumb']['src'] ?? $atts['video']['mediaVideo']['image']['src'];
			}

			$atts['videoJson'] = apply_filters( 'structured_content_recipe_video_json', $video );
		}

		if ( isset( $atts['video']['settings'] ) ) {
			/**
			 * convert video settings from booleans to a attribute string
			 */
			$atts['video']['settings'] = array_filter( $atts['video']['settings'] );
			$atts['video']['settings'] = array_map(
				function ( $value, $key ) {
					return $value ? $key : null;
				},
				$atts['video']['settings'],
				array_keys( $atts['video']['settings'] )
			);

			$atts['video']['settings'] = implode( ' ', $atts['video']['settings'] );
		}

		if ( isset( $atts['recipeInstructions'] ) ) {
			$recipeInstructionsJson = [];

			foreach ( $atts['recipeInstructions'] as $recipeInstruction ) {
				$instruction = [
					'@type' => 'HowToStep',
					'text'  => $recipeInstruction['text'],
				];

				if ( isset( $recipeInstruction['image'] ) ) {
					$instruction['image'] = $recipeInstruction['image']['url'];
				}

				$recipeInstructionsJson[] = $instruction;
			}

			$atts['recipeInstructionsJson'] = apply_filters( 'structured_content_recipe_instructions_json', $recipeInstructionsJson );
		}

		$atts['video'] = apply_filters( 'structured_content_recipe_video', $atts['video'] );

		$atts['identifier'] = apply_filters( 'structured_content_recipe_identifier', "sc_recipe-" . esc_attr( $atts["randomBlockId"] ) );

		ob_start();
		include STRUCTURED_CONTENT_PLUGIN_DIR . 'templates/blocks/recipe.php';
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}


	/**
	 * Returns the thumbnail URL of a video URL
	 *
	 * @param $video_uri
	 *
	 * @return mixed
	 */
	private static function get_oembed_thumbnail_url( $video_uri ) {

		//get wp_oEmed object, not a public method. new WP_oEmbed() would also be possible
		$oembed = _wp_oembed_get_object();
		//get provider
		$provider = $oembed->get_provider( $video_uri );
		//fetch oembed data as an object
		$oembed_data = $oembed->fetch( $provider, $video_uri );

		return $oembed_data->thumbnail_url;
	}

	/**
	 * Converts a duration string like P0DT0H20M to a readable string like 20 minutes
	 *
	 * @param $duration
	 *
	 * @return string|null
	 */
	public static function convert_duration_to_readable( $duration = null ) {

		if ( $duration === null || trim( $duration ) === '' ) {
			return null;
		}

		try {
			$duration = new DateInterval( $duration );
		} catch ( Exception $e ) {
			// The duration string is not valid
			return null;
		}

		$days    = $duration->format( '%d' );
		$hours   = $duration->format( '%h' );
		$minutes = $duration->format( '%i' );

		$duration_readable = '';

		if ( $days > 0 ) {
			$duration_readable .= $days . ' ' . _n( 'day', 'days', $days, 'structured-content' ) . ' ';
		}
		if ( $hours > 0 ) {
			$duration_readable .= $hours . ' ' . _n( 'hour', 'hours', $hours, 'structured-content' ) . ' ';
		}
		if ( $minutes > 0 ) {
			$duration_readable .= $minutes . ' ' . _n( 'minute', 'minutes', $minutes, 'structured-content' ) . ' ';
		}

		$duration_readable = trim( $duration_readable );

		return $duration_readable === '' ? null : $duration_readable;
	}


	/**
	 * Fixes empty Tags in Content of Shortcodes without using wp_autotop
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function fix_shortcodes( $content ) {
		$array   = array(
			'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']',
		);
		$content = strtr( $content, $array );

		return $content;
	}
}

StructuredContent_Shortcodes::register();
