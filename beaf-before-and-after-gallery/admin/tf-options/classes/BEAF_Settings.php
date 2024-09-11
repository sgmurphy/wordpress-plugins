<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BEAF_Settings' ) ) {
	class BEAF_Settings {

		public $option_id = null;
		public $option_title = null;
		public $option_icon = null;
		public $option_position = null;
		public $option_sections = array();

		public $pre_tabs;
		public $pre_fields;
		public $pre_sections;

		public function __construct( $key, $params = array() ) {
			$this->option_id = $key;
			$this->option_title = ! empty( $params['title'] ) ? apply_filters( $key . '_title', $params['title'] ) : '';
			$this->option_icon = ! empty( $params['icon'] ) ? apply_filters( $key . '_icon', $params['icon'] ) : '';
			$this->option_position = ! empty( $params['position'] ) ? apply_filters( $key . '_position', $params['position'] ) : 5;
			$this->option_sections = ! empty( $params['sections'] ) ? apply_filters( $key . '_sections', $params['sections'] ) : array();

			// run only is admin panel options, avoid performance loss
			$this->pre_tabs = $this->pre_tabs( $this->option_sections );
			$this->pre_fields = $this->pre_fields( $this->option_sections );
			$this->pre_sections = $this->pre_sections( $this->option_sections );

			//options
			add_action( 'admin_menu', array( $this, 'beaf_options' ) );

			//save options
			add_action( 'admin_init', array( $this, 'save_options' ) );

			//ajax save options
			add_action( 'wp_ajax_tf_options_save', array( $this, 'tf_ajax_save_options' ) );
		}

		public static function option( $key, $params = array() ) {
			return new self( $key, $params );
		}

		public function pre_tabs( $sections ) {

			$result = array();
			$parents = array();

			foreach ( $sections as $key => $section ) {
				if ( ! empty( $section['parent'] ) ) {
					$parents[ $section['parent'] ][ $key ] = $section;
					unset( $sections[ $key ] );
				}
			}

			foreach ( $sections as $key => $section ) {
				if ( ! empty( $key ) && ! empty( $parents[ $key ] ) ) {
					$section['sub_section'] = $parents[ $key ];
				}
				$result[ $key ] = $section;
			}

			return $result;
		}

		public function pre_fields( $sections ) {

			$result = array();

			foreach ( $sections as $key => $section ) {
				if ( ! empty( $section['fields'] ) ) {
					foreach ( $section['fields'] as $field ) {
						$result[] = $field;
					}
				}
			}

			return $result;
		}

		public function pre_sections( $sections ) {

			$result = array();

			foreach ( $this->pre_tabs as $tab ) {
				if ( ! empty( $tab['subs'] ) ) {
					foreach ( $tab['subs'] as $sub ) {
						$sub['ptitle'] = $tab['title'];
						$result[] = $sub;
					}
				}
				if ( empty( $tab['subs'] ) ) {
					$result[] = $tab;
				}
			}

			return $result;
		}

		/**
		 * Options Page menu
		 * @author Foysal
		 */
		public function beaf_options() {
			//Setting submenu
			add_submenu_page(
				'edit.php?post_type=bafg',
				__( 'Beaf Settings', 'bafg' ),
				__( 'Settings', 'bafg' ),
				'manage_options',
				'beaf_settings',
				array( $this, 'beaf_options_page' ),
			);
		}


		/**
		 * Options Page
		 * @author Foysal
		 */
		public function beaf_options_page() {

			// Retrieve an existing value from the database.
			$tf_option_value = get_option( $this->option_id );
			$current_page_url = $this->get_current_page_url();
			$query_string = $this->get_query_string( $current_page_url );

			// Set default values.
			if ( empty( $tf_option_value ) ) {
				$tf_option_value = array();
			}


			$ajax_save_class = 'tf-ajax-save';

			if ( ! empty( $this->option_sections ) ) :
				?>
				<div class="tf-setting-dashboard">
					<!-- dashboard-header-include -->
					<?php echo esc_attr( beaf_dashboard_header() ); ?>
					<div class="tf-option-wrapper tf-setting-wrapper">
						<form method="post" action="" class="tf-option-form <?php echo esc_attr( $ajax_save_class ) ?>"
							enctype="multipart/form-data">
							<!-- Body -->
							<div class="tf-option">
								<div class="tf-admin-tab tf-option-nav">
									<?php
									$section_count = 0;
									foreach ( $this->pre_tabs as $key => $section ) :
										$parent_tab_key = ! empty( $section['fields'] ) ? $key : array_key_first( $section['sub_section'] );
										?>
										<div
											class="tf-admin-tab-item<?php echo ! empty( $section['sub_section'] ) ? ' tf-has-submenu' : '' ?>">

											<a href="#<?php echo esc_attr( $parent_tab_key ); ?>"
												class="tf-tablinks <?php echo $section_count == 0 ? 'active' : ''; ?>"
												data-tab="<?php echo esc_attr( $parent_tab_key ) ?>">
												<?php echo ! empty( $section['icon'] ) ? '<span class="tf-sec-icon"><i class="' . esc_attr( $section['icon'] ) . '"></i></span>' : ''; ?>
												<?php echo esc_attr( $section['title'] ); ?>
											</a>

											<?php if ( ! empty( $section['sub_section'] ) ) : ?>
												<ul class="tf-submenu">
													<?php foreach ( $section['sub_section'] as $sub_key => $sub ) : ?>
														<li>
															<a href="#<?php echo esc_attr( $sub_key ); ?>"
																class="tf-tablinks <?php echo $section_count == 0 ? 'active' : ''; ?>"
																data-tab="<?php echo esc_attr( $sub_key ) ?>">
																<span class="tf-tablinks-inner">
																	<?php echo ! empty( $sub['icon'] ) ? '<span class="tf-sec-icon"><i class="' . esc_attr( $sub['icon'] ) . '"></i></span>' : ''; ?>
																	<?php echo esc_attr( $sub['title'] ); ?>
																</span>
															</a>
														</li>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
										</div>
										<?php $section_count++; endforeach; ?>
								</div>

								<div class="tf-tab-wrapper">
									<div class="tf-mobile-setting">
										<a href="#" class="tf-mobile-tabs"><i class="fa-solid fa-bars"></i></a>
									</div>
									<?php
									$content_count = 0;
									foreach ( $this->option_sections as $key => $section ) : ?>
										<div id="<?php echo esc_attr( $key ) ?>"
											class="tf-tab-content <?php echo $content_count == 0 ? 'active' : ''; ?>">

											<?php
											if ( ! empty( $section['fields'] ) ) :
												foreach ( $section['fields'] as $field ) :

													$default = isset( $field['default'] ) ? $field['default'] : '';
													$value = isset( $tf_option_value[ $field['id'] ] ) ? $tf_option_value[ $field['id'] ] : $default;

													$tf_option = new BEAF_Options();
													$tf_option->field( $field, $value, $this->option_id );

												endforeach;
											endif; ?>

										</div>
										<?php $content_count++; endforeach; ?>

									<!-- Footer -->
									<div class="tf-option-footer">
										<button type="submit" class="tf-admin-btn tf-btn-secondary tf-submit-btn">
											<?php esc_attr_e( 'Save', 'bafg' ); ?>
										</button>
									</div>
								</div>
							</div>
							<?php wp_nonce_field( 'tf_option_nonce_action', 'tf_option_nonce' ); ?>
						</form>
					</div>
					<?php
			endif;
		}

		/**
		 * Save Options
		 * @author Foysal
		 */
		public function save_options() {

			// Add nonce for security and authentication. 
			// Check if a nonce is valid.
			if ( ! isset( $_POST['tf_option_nonce'] ) || ! wp_verify_nonce( $_POST['tf_option_nonce'], 'tf_option_nonce_action' ) ) {
				return;
			}

			$tf_option_value = array();
			$option_request = ( ! empty( $_POST[ $this->option_id ] ) ) ? $_POST[ $this->option_id ] : array();
			if ( ! empty( $option_request ) && ! empty( $this->option_sections ) ) {
				foreach ( $this->option_sections as $section ) {
					if ( ! empty( $section['fields'] ) ) {

						foreach ( $section['fields'] as $field ) {

							if ( ! empty( $field['id'] ) ) {

								$fieldClass = 'BEAF_' . $field['type'];

								if ( $fieldClass == 'BEAF_tab' ) {
									$data = isset( $option_request[ $field['id'] ] ) ? $option_request[ $field['id'] ] : '';
									foreach ( $field['tabs'] as $tab ) {
										foreach ( $tab['fields'] as $tab_fields ) {
											if ( $tab_fields['type'] == 'repeater' ) {
												foreach ( $tab_fields['fields'] as $key => $tab_field ) {
													if ( isset( $tab_field['validate'] ) && $tab_field['validate'] == 'no_space_no_special' ) {
														$sanitize_data_array = [];
														if ( ! empty( $data[ $tab_fields['id'] ] ) ) {
															foreach ( $data[ $tab_fields['id'] ] as $_key => $datum ) {
																//unique id 3 digit
																$unique_id = substr( uniqid(), -3 );
																$sanitize_data = sanitize_title( str_replace( ' ', '_', strtolower( $datum[ $tab_field['id'] ] ) ) );
																if ( in_array( $sanitize_data, $sanitize_data_array ) ) {
																	$sanitize_data = $sanitize_data . '_' . $unique_id;
																} else {
																	$sanitize_data_array[] = $sanitize_data;
																}

																$data[ $tab_fields['id'] ][ $_key ][ $tab_field['id'] ] = $sanitize_data;
															}
														}
													}
												}
											}
										}
									}
								} else {
									$data = isset( $option_request[ $field['id'] ] ) ? $option_request[ $field['id'] ] : '';
								}

								if ( $fieldClass != 'BEAF_file' ) {
									$data = $fieldClass == 'BEAF_repeater' || $fieldClass == 'BEAF_map' ? serialize( $data ) : $data;
								}
								if ( isset( $_FILES ) && ! empty( $_FILES['file'] ) ) {
									$tf_upload_dir = wp_upload_dir();
									if ( ! empty( $tf_upload_dir['basedir'] ) ) {
										$tf_itinerary_fonts = $tf_upload_dir['basedir'] . '/itinerary-fonts';
										if ( ! file_exists( $tf_itinerary_fonts ) ) {
											wp_mkdir_p( $tf_itinerary_fonts );
										}
										$tf_fonts_extantions = array( 'application/octet-stream' );
										for ( $i = 0; $i < count( $_FILES['file']['name'] ); $i++ ) {
											if ( in_array( $_FILES['file']['type'][ $i ], $tf_fonts_extantions ) ) {
												$tf_font_filename = $_FILES['file']['name'][ $i ];
												move_uploaded_file( $_FILES['file']['tmp_name'][ $i ], $tf_itinerary_fonts . '/' . $tf_font_filename );
											}
										}
									}
								}

								if ( class_exists( $fieldClass ) ) {
									$_field = new $fieldClass( $field, $data, $this->option_id );
									$tf_option_value[ $field['id'] ] = $_field->sanitize();
								}

							}
						}
					}
				}
			}

			if ( ! empty( $tf_option_value ) ) {
				//                tf_var_dump($tf_option_value);
//                die();
				update_option( $this->option_id, $tf_option_value );
			} else {
				delete_option( $this->option_id );
			}
		}

		/*
		 * Ajax Save Options
		 * @author Foysal
		 */
		public function tf_ajax_save_options() {
			$response = [ 
				'status' => 'error',
				'message' => __( 'Something went wrong!', 'bafg' ),
			];

			if ( ! empty( $_POST['tf_option_nonce'] ) && wp_verify_nonce( $_POST['tf_option_nonce'], 'tf_option_nonce_action' ) ) {
				$this->save_options();
				$response = [ 
					'status' => 'success',
					'message' => __( 'Options saved successfully!', 'bafg' ),
				];
			}

			echo json_encode( $response );
			wp_die();
		}

		/*
		 * Get current page url
		 * @return string
		 * @author Foysal
		 */
		public function get_current_page_url() {
			$page_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			return $page_url;
		}

		/*
		 * Get query string from url
		 * @return array
		 * @author Foysal
		 */
		public function get_query_string( $url ) {
			$url_parts = parse_url( $url );
			parse_str( $url_parts['query'], $query_string );

			return $query_string;
		}
	}
}
