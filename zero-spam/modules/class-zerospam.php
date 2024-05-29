<?php // phpcs:ignore
/**
 * Zero Spam class for enhanced site protection.
 *
 * Handles the core functionality of interacting with the Zero Spam API,
 * managing site settings for spam prevention, and reporting detections.
 *
 * @package ZeroSpam
 */

namespace ZeroSpam\Modules;

defined( 'ABSPATH' ) || exit; // Prevent direct access.

/**
 * Core class for Zero Spam functionality.
 */
class Zero_Spam {
	/**
	 * Class constructor.
	 *
	 * Adds necessary hooks for initialization.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
	}

	/**
	 * Initialization.
	 *
	 * Fires after WordPress has finished loading but before any headers are sent.
	 * Registers plugin filters and actions.
	 */
	public function init() {
		add_filter( 'zerospam_setting_sections', [ $this, 'sections' ] );
		add_filter( 'zerospam_settings', [ $this, 'settings' ], 10, 1 );
		add_action( 'zerospam_share_detection', [ $this, 'share_detection' ], 10, 1 );

		if (
			'enabled' === \ZeroSpam\Core\Settings::get_settings( 'zerospam' ) &&
			\ZeroSpam\Core\Access::process()
		) {
			add_filter( 'zerospam_access_checks', [ $this, 'access_check' ], 10, 2 );
		}
	}

	/**
	 * Site access check.
	 *
	 * Determines if a visitor should be blocked based on the zerospam.org API query results.
	 *
	 * @param array  $access_checks Existing access check results.
	 * @param string $user_ip       Visitor's IP address.
	 * @return array Updated access checks with Zero Spam results.
	 */
	public function access_check( $access_checks, $user_ip ) {
		$settings = \ZeroSpam\Core\Settings::get_settings();

		$access_checks['zero_spam'] = [
			'blocked' => false,
		];

		$response = self::query( [ 'ip' => $user_ip ] );
		if ( $response && ! empty( $response['ip_addresses'][ $user_ip ] ) ) {
			$ip_data              = $response['ip_addresses'][ $user_ip ];
			$min_confidence_score = (float) $settings['zerospam_confidence_min']['value'];

			if ( ! empty( $ip_data['confidence'] ) ) {
				$confidence_score = (float) $ip_data['confidence'] * 100;

				if ( $confidence_score >= $min_confidence_score ) {
					$access_checks['zero_spam']['blocked'] = true;
					$access_checks['zero_spam']['type']    = 'blocked';
					$access_checks['zero_spam']['details'] = $ip_data;
				}
			}
		}

		return $access_checks;
	}

	/**
	 * Admin setting sections
	 *
	 * @param array $sections Array of admin setting sections.
	 */
	public function sections( $sections ) {
		$sections['zerospam'] = array(
			'title' => __( 'Enhanced Protection', 'zero-spam' ),
			'icon'  => 'assets/img/icon.svg',
		);

		return $sections;
	}

	/**
	 * Admin settings
	 *
	 * @param array $settings Array of available settings.
	 */
	public function settings( $settings ) {
		$options = get_option( 'zero-spam-zerospam' );

		$settings['zerospam'] = array(
			'title'       => __( 'Status', 'zero-spam' ),
			'section'     => 'zerospam',
			'module'      => 'zerospam',
			'type'        => 'checkbox',
			'options'     => array(
				'enabled' => __( 'Enabled', 'zero-spam' ),
			),
			'desc'        => sprintf(
				wp_kses(
					/* translators: %s: Replaced with the Zero Spam URL */
					__( 'Blocks visitor IPs &amp; supported submitted forms with an email address that meets the <a href="%s" target="_blank" rel="noopener noreferrer">Zero Spam</a> <em>Confidence Minimum</em> score.', 'zero-spam' ),
					array(
						'strong' => array(),
						'a'      => array(
							'target' => array(),
							'href'   => array(),
							'rel'    => array(),
						),
						'em'     => array(),
					)
				),
				esc_url( ZEROSPAM_URL )
			),
			'value'       => ! empty( $options['zerospam'] ) ? $options['zerospam'] : false,
			'recommended' => 'enabled',
		);

		$settings['zerospam_license'] = array(
			'title'       => __( 'License Key', 'zero-spam' ),
			'desc'        => sprintf(
				wp_kses(
					/* translators: 1: the zerospam.org URL 2: the zerospam.org premium product URL */
					__( 'Enter your <a href="%1$s" target="_blank" rel="noopener noreferrer">Zero Spam</a> license key or define it in <code>wp-config.php</code>, using the constant <code>ZEROSPAM_LICENSE_KEY</code> to enable enhanced protection. Don\'t have an license key? <a href="%2$s" target="_blank" rel="noopener noreferrer"><strong>Get one now!</strong></a>', 'zero-spam' ),
					array(
						'strong' => array(),
						'a'      => array(
							'target' => array(),
							'href'   => array(),
							'rel'    => array(),
						),
						'code'   => array(),
					)
				),
				esc_url( ZEROSPAM_URL ),
				esc_url( ZEROSPAM_URL . 'product/premium/' )
			),
			'section'     => 'zerospam',
			'module'      => 'zerospam',
			'type'        => 'text',
			'field_class' => 'regular-text',
			'placeholder' => __( 'Enter your Zero Spam license key.', 'zero-spam' ),
			'value'       => ! empty( $options['zerospam_license'] ) ? $options['zerospam_license'] : false,
		);

		if ( defined( 'ZEROSPAM_LICENSE_KEY' ) && ! $settings['zerospam_license']['value'] ) {
			$settings['zerospam_license']['value'] = ZEROSPAM_LICENSE_KEY;
		}

		$settings['zerospam_timeout'] = array(
			'title'       => __( 'API Timeout', 'zero-spam' ),
			'section'     => 'zerospam',
			'module'      => 'zerospam',
			'type'        => 'number',
			'field_class' => 'small-text',
			'suffix'      => __( 'seconds', 'zero-spam' ),
			'placeholder' => __( '5', 'zero-spam' ),
			'min'         => 0,
			'desc'        => __( 'Setting to high could result in degraded site performance, too low won\'t allow to API enough time to respond; recommended 5 seconds.', 'zero-spam' ),
			'value'       => ! empty( $options['zerospam_timeout'] ) ? $options['zerospam_timeout'] : 5,
			'recommended' => 5,
		);

		$settings['zerospam_cache'] = array(
			'title'       => __( 'Cache Expiration', 'zero-spam' ),
			'section'     => 'zerospam',
			'module'      => 'zerospam',
			'type'        => 'number',
			'field_class' => 'small-text',
			'suffix'      => __( 'day(s)', 'zero-spam' ),
			'placeholder' => WEEK_IN_SECONDS,
			'min'         => 0,
			'desc'        => __( 'Setting to high could result in outdated information, too low could cause a decrease in performance; recommended 14 days.', 'zero-spam' ),
			'value'       => ! empty( $options['zerospam_cache'] ) ? $options['zerospam_cache'] : 14,
			'recommended' => 14,
		);

		$settings['zerospam_confidence_min'] = array(
			'title'       => __( 'Confidence Minimum', 'zero-spam' ),
			'section'     => 'zerospam',
			'module'      => 'zerospam',
			'type'        => 'number',
			'field_class' => 'small-text',
			'suffix'      => __( '%', 'zero-spam' ),
			'placeholder' => __( '30', 'zero-spam' ),
			'min'         => 0,
			'max'         => 100,
			'step'        => 0.1,
			'desc'        => sprintf(
				wp_kses(
					/* translators: %s: Replaced with the Zero Spam API URL */
					__( 'Minimum <a href="%s" target="_blank" rel="noopener noreferrer">confidence score</a> an IP must meet before being blocked. Setting this too low could cause users to be blocked that shouldn\'t be; recommended 20%%.', 'zero-spam' ),
					array(
						'a' => array(
							'target' => array(),
							'href'   => array(),
							'rel'    => array(),
						),
					)
				),
				esc_url( ZEROSPAM_URL . 'spam-blacklist-api/?utm_source=' . site_url() . '&utm_medium=admin_confidence_score&utm_campaign=wpzerospam' )
			),
			'value'       => ! empty( $options['zerospam_confidence_min'] ) ? $options['zerospam_confidence_min'] : 30,
			'recommended' => 30,
		);

		return $settings;
	}

	/**
	 * Global API data.
	 */
	public function global_api_data() {
		$api_data                   = array();
		$api_data['reporter_email'] = sanitize_email( get_bloginfo( 'admin_email' ) );
		$api_data['app_key']        = \ZeroSpam\Core\Utilities::clean_domain( esc_url( site_url() ) );
		$api_data['app_type']       = 'WordPress';
		$api_data['app_details']    = array(
			'app_version'      => sanitize_text_field( get_bloginfo( 'version' ) ),
			'app_type_version' => sanitize_text_field( ZEROSPAM_VERSION ),
			'app_language'     => sanitize_text_field( strtolower( get_bloginfo( 'language' ) ) ),
			'app_email'        => sanitize_email( get_bloginfo( 'admin_email' ) ),
			'app_name'         => sanitize_text_field( get_bloginfo( 'name' ) ),
			'app_desc'         => sanitize_text_field( get_bloginfo( 'description' ) ),
		);

		return $api_data;
	}

	/**
	 * Shares detection details with zerospam.org.
	 *
	 * @param array $data Contains all detection details. Must include 'type' and may include 'failed'.
	 * @return true|WP_Error True on success, WP_Error on failure.
	 */
	public function share_detection( $data ) {
		if ( ! is_array( $data ) || empty( $data['type'] ) ) {
			\ZeroSpam\Core\Utilities::log( __( 'Invalid or incomplete detection data provided.', 'zero-spam' ) );
		}

		$last_api_report_submitted = get_site_option( 'zero_spam_last_api_request' );
		if ( $last_api_report_submitted ) {
			$last_api_report_submitted = new \DateTime( $last_api_report_submitted );
			$current_time              = new \DateTime();
			if ( $last_api_report_submitted->diff( $current_time )->i < 30 ) {
				\ZeroSpam\Core\Utilities::log( __( 'API requests are throttled to every 30 minutes.', 'zero-spam' ) );
			}
		}

		$endpoint = ZEROSPAM_URL . 'wp-json/v5.4/report/';
		$ip       = \ZeroSpam\Core\User::get_ip();
		if ( ! $ip ) {
			\ZeroSpam\Core\Utilities::log( __( 'IP address retrieval failed.', 'zero-spam' ) );
		}

		$api_data = [
			'report_type'   => 'ip_address',
			'report_module' => sanitize_text_field( $data['type'] ),
			'report_key'    => sanitize_text_field( $ip ),
			'report_failed' => isset( $data['failed'] ) ? sanitize_text_field( $data['failed'] ) : '',
		];

		$global_data = self::global_api_data();
		$api_data    = array_merge( $api_data, $global_data );

		$response = wp_remote_post( $endpoint, [ 'body' => [ 'data' => $api_data ] ] );
		if ( is_wp_error( $response ) ) {
			\ZeroSpam\Core\Utilities::log( __( 'API request failed.', 'zero-spam' ) );
		}

		// Process email fields.
		$valid_email_fields = [
			'comment_author_email', // Comments.
			'user_email',           // Registration.
			'email',                // WooCommerce Registration.
			'post' => [             // Mailchimp.
				'EMAIL',
			],
			'data' => [             // Give.
				'give_email',
			],
		];

		$valid_name_fields = [
			'comment_author', // Comment.
			'user_login',     // Register.
			'username',       // WooCommerce Registration.
			'data' => [       // Give.
				'give_first',
				'give_last',
			],
		];

		foreach ( $valid_email_fields as $key => $field ) {
			if ( is_array( $field ) ) {
				foreach ( $field as $f ) {
					if ( ! empty( $data[ $key ][ $f ] ) && \ZeroSpam\Core\Utilities::is_email( $data[ $key ][ $f ] ) ) {
						$email = sanitize_email( $data[ $key ][ $f ] );
						break 2; // Exit both loops.
					}
				}
			} elseif ( ! empty( $data[ $field ] ) && \ZeroSpam\Core\Utilities::is_email( $data[ $field ] ) ) {
				$email = sanitize_email( $data[ $field ] );
				break; // Exit the loop.
			}
		}

		if ( ! empty( $email ) ) {
			$report_details = [
				'report_type'   => 'email_address',
				'report_module' => sanitize_text_field( $data['type'] ),
				'report_key'    => $email,
				'report_failed' => isset( $data['failed'] ) ? sanitize_text_field( $data['failed'] ) : '',
				'email_details' => [
					'names'     => [],
					'companies' => [],
					'titles'    => [],
					'phones'    => [],
					'locations' => [],
				],
			];

			foreach ( $valid_name_fields as $key => $field ) {
				if ( is_array( $field ) ) {
					$names = array_map(
						function ( $f ) use ( $data, $key ) {
							return ! empty( $data[ $key ][ $f ] ) ? sanitize_text_field( $data[ $key ][ $f ] ) : '';
						},
						$field
					);
					$names = array_filter( $names ); // Remove empty values.
					if ( $names ) {
						$report_details['email_details']['names'][] = implode( ' ', $names );
					}
				} elseif ( ! empty( $data[ $field ] ) ) {
					$report_details['email_details']['names'][] = sanitize_text_field( $data[ $field ] );
				}
			}

			// Append global data and submit the email report.
			$response = wp_remote_post( $endpoint, [ 'body' => [ 'data' => array_merge( $report_details, $global_data ) ] ] );
			if ( is_wp_error( $response ) ) {
				\ZeroSpam\Core\Utilities::log( __( 'Email report submission failed.', 'zero-spam' ) );
			}
		}

		// Successfully updated the last API request time.
		update_site_option( 'zero_spam_last_api_request', current_time( 'mysql' ) );

		return true;
	}

	/**
	 * Returns license key data from the API
	 *
	 * @param string $license The license key.
	 */
	public static function get_license( $license ) {
		if ( strpos( $license, 'invalid' ) !== false ) {
			return false;
		}

		$cache_key    = sanitize_title( 'license_' . $license );
		$license_data = wp_cache_get( $cache_key );
		if ( false === $license_data ) {
			$endpoint = ZEROSPAM_URL . 'wp-json/v1/get-license';
			$args     = array(
				'body' => array( 'license_key' => $license ),
			);

			$license_data = \ZeroSpam\Core\Utilities::remote_post( $endpoint, $args );

			if ( $license_data ) {
				$license_data = json_decode( $license_data, true );

				if ( empty( $license_data['license_key'] ) ) {
					\ZeroSpam\Core\Utilities::log( 'Zero Spam License Check: ' . $license_data['response'] );
				}

				if ( ! empty( $license_data['license_key'] ) ) {
					$expiration = 1 * MONTH_IN_SECONDS;
					wp_cache_set( $cache_key, $license_data, 'zero_spam_store', $expiration );
				}
			}
		}

		return $license_data;
	}

	/**
	 * Query the Zero Spam Blacklist API
	 *
	 * @param array $params Array of query parameters.
	 */
	public static function query( $params ) {
		if (
			empty( $params['ip'] ) &&
			empty( $params['email'] )
		) {
			return false;
		}

		$settings = \ZeroSpam\Core\Settings::get_settings();

		if ( empty( $settings['zerospam_license']['value'] ) ) {
			return false;
		}

		$cache_array = array( 'zero_spam' );
		$cache_array = array_merge( $cache_array, $params );
		$cache_key   = \ZeroSpam\Core\Utilities::cache_key( $cache_array );

		$response = wp_cache_get( $cache_key );
		if ( false === $response ) {
			// Limit the number of requests.
			$last_query_option = get_site_option( 'zero_spam_last_api_query', false );

			if ( $last_query_option ) {
				list( $first_query_date, $num_queries) = explode( '*', $last_query_option );

				if ( gmdate( 'Y-m-d', strtotime( $first_query_date ) ) !== gmdate( 'Y-m-d' ) ) {
					// New day.
					update_site_option( 'zero_spam_last_api_query', current_time( 'mysql' ) . '*1' );
				} elseif ( $num_queries > 200 ) {
					return false;
				} else {
					update_site_option( 'zero_spam_last_api_query', $first_query_date . '*' . ( $num_queries + 1 ) );
				}
			} else {
				update_site_option( 'zero_spam_last_api_query', $first_query_date . '*' . ( $num_queries + 1 ) );
			}

			$endpoint = 'https://www.zerospam.org/wp-json/v2/query';

			$args = array(
				'body' => array(
					'license_key' => $settings['zerospam_license']['value'],
				),
			);

			if ( ! empty( $params['ip'] ) ) {
				$args['body']['ip'] = $params['ip'];
			}

			if ( ! empty( $params['email'] ) ) {
				$args['body']['email'] = $params['email'];
			}

			$args['timeout'] = 5;
			if ( ! empty( $settings['zerospam_timeout'] ) ) {
				$args['timeout'] = intval( $settings['zerospam_timeout']['value'] );
			}

			$response = \ZeroSpam\Core\Utilities::remote_post( $endpoint, $args );
			if ( $response ) {
				// Response should be a JSON string.
				$response = json_decode( $response, true );

				if (
					! is_array( $response ) ||
					empty( $response['status'] ) ||
					200 !== $response['status'] ||
					empty( $response['body_response'] )
				) {
					if ( ! empty( $response['response'] ) ) {
						\ZeroSpam\Core\Utilities::log( $response['response'] );
					} else {
						\ZeroSpam\Core\Utilities::log( __( 'There was a problem querying the Zero Spam Blacklist API.', 'zero-spam' ) );
					}

					return false;
				}

				$response = $response['body_response'];

				$expiration = 14 * DAY_IN_SECONDS;
				if ( ! empty( $settings['zerospam_confidence_min']['value'] ) ) {
					$expiration = $settings['zerospam_confidence_min']['value'] * DAY_IN_SECONDS;
				}

				wp_cache_set( $cache_key, $response, 'zerospam', $expiration );
			}
		}

		return $response;
	}
}
